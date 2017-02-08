<?php
class AdmissionModel extends BaseModel {
    public function requestAdmission($treatment_id) {
        $stmt = AdmissionReqSqlStatement::REQUEST_ADMISSION;

        $data = array();
        $data[AdmissionReqTable::treatment_id] = $treatment_id;

        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function dismissRequest($treatment_id) {
        $stmt = AdmissionReqSqlStatement::DISMISS_REQUEST;

        $data = array();
        $data[AdmissionReqTable::treatment_id] = $treatment_id;

        $dismissed = $this->conn->execute($stmt, $data, true);

        return $dismissed;
    }

    public function getAdmissionRequests() {
        $stmt = AdmissionReqSqlStatement::GET_ALL_REQUESTS;

        $data = array();

        $result = $this->conn->fetchAll($stmt, $data);

        return (is_array($result)) ? $result : false;
    }

    public function searchAdmissionRequests($parameter) {
        $stmt = AdmissionReqSqlStatement::SEARCH_REQUESTS;

        $data = array();
        $data[PARAMETER] = $parameter;
        $data[WILDCARD] = "%" . $parameter . "%";

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function admitPatient($admission_data) {

        $begin = $this->conn->beginTransaction();

        if ($begin) {
            // Admit patient (Insert patient details in admission table)
            $stmt = AdmissionSqlStatement::ADMIT;

            $data = $admission_data;
            unset($data[AdmissionBedTable::bed_id]);

            $admitted = $this->conn->execute($stmt, $data, true);

            $admission_id = $this->conn->getLastInsertedId();

            if ($admitted) {
                // Assign patient bed
                $stmt = AdmissionSqlStatement::ASSIGN_BED;

                $data = array();
                $data[AdmissionBedTable::bed_id] = $admission_data[AdmissionBedTable::bed_id];
                $data[AdmissionBedTable::admission_id] = $admission_id;

                $bed_assigned = $this->conn->execute($stmt, $data, true);

                if ($bed_assigned) {
                    //Occupy bed
                    $bed_model = new BedModel($admission_data[AdmissionBedTable::bed_id], $this->conn);
                    $occupied = $bed_model->occupy();

                    if ($occupied) {
                        //Dismiss admission request
                        $request_dismissed = $this->dismissRequest($admission_data[AdmissionTable::treatment_id]);
                        if ($request_dismissed) {
                            # code...
                            $this->conn->commit();
                            return true;
                        } else {
                            $this->conn->rollBack();
                            return false;
                        }
                    } else {
                        $this->conn->rollBack();
                        return false;
                    }
                } else {
                    $this->conn->rollBack();
                    return false;
                }
            } else {
                $this->conn->rollBack();
                return false;
            }
        } else {
            return false;
        }
    }

    public function switchBed($admission_id, $bed_id) {
        $begin = $this->conn->beginTransaction();
        if ($begin) {
            // Vacate previous admission bed
            $stmt = AdmissionSqlStatement::VACATE_ADMISSION_BED;
            $data = array(AdmissionBedTable::admission_id =>  $admission_id);

            $vacated = $this->conn->execute($stmt, $data, true);
            if ($vacated) {
                // Remove admission bed assignment
                $stmt = AdmissionSqlStatement::REMOVE_BED_ASSIGNMENT;
                $data = array(AdmissionBedTable::admission_id =>  $admission_id);

                $removed = $this->conn->execute($stmt, $data, true);
                if ($removed) {
                    // Make new admission bed assignment
                    $stmt = AdmissionSqlStatement::ASSIGN_BED;
                    $data = array(
                        AdmissionBedTable::admission_id =>  $admission_id,
                        AdmissionBedTable::bed_id       =>  $bed_id
                    );

                    $assigned = $this->conn->execute($stmt, $data);
                    if ($assigned) {
                        // Occupy new admission bed
                        $bed = new BedModel($bed_id, $this->conn);
                        $occupied = $bed->occupy();
                        if ($occupied) {
                            $this->conn->commit();
                            return true;
                        } else {
                            $this->conn->rollBack();
                        }
                    } else {
                        $this->conn->rollBack();
                    }
                } else {
                    $this->conn->rollBack();
                }
            } else {
                $this->conn->rollBack();
            }
        }
        return false;
    }

    public function logEncounter($encounter_data) {
        $begin = $this->conn->beginTransaction();

        if ($begin) {
                $vitals_data = $encounter_data[VITALS];
                if (is_array($vitals_data)) {
                    //Add vitals
                    $vitals_data[VitalsTable::added_by] = $encounter_data[EncounterTable::personnel_id];
                    $vitals_data[VitalsTable::patient_id] = $encounter_data[EncounterTable::patient_id];

                    $vitals_model = new VitalsModel($vitals_data, $this->conn);
                    $vitals_added = $vitals_model->add();

                    if ($vitals_added) {
                        //Vitals added successfully...Commit database transactions
                        $this->conn->commit();
                        return true;
                    } else {
                        //Unable to add vitals...Roll back!
                        $this->conn->rollBack();
                        return false;
                    }
            } else {
                //Unable to insert encounter details...Roll back!
                $this->conn->rollBack();
                return false;
            }
        } else {
            //Could not begin database transaction...return!
            return false;
        }
    }

    public function dischargePatient($discharge_data) {
        $admission_details = AdmissionModel::getAdmissionDetails($discharge_data[AdmissionTable::patient_id]);
        $admission_id = $admission_details[AdmissionTable::admission_id];
        $bed_id = $admission_details[AdmissionBedTable::bed_id];

        $begin = $this->conn->beginTransaction();

        if ($begin) {
            // Discharge patient...Set admission active flag to INACTIVE
            $stmt = AdmissionSqlStatement::DISCHARGE;

            $data = array();
            $data[AdmissionTable::admission_id] = $admission_id;
            $data[AdmissionTable::discharged_by] = $discharge_data[AdmissionTable::discharged_by];

            $discharged = $this->conn->execute($stmt, $data, true);

            if ($discharged) {
                //Remove bed assignments
                $stmt = AdmissionSqlStatement::REMOVE_FROM_BED;
                $data = array();
                $data[AdmissionBedTable::admission_id] = $admission_details[AdmissionTable::admission_id];
                $data[AdmissionBedTable::bed_id] = $bed_id;

                $removed = $this->conn->execute($stmt, $data, true);

                if ($removed) {
                    $bed_model = new BedModel($bed_id, $this->conn);
                    $vacated = $bed_model->vacate();

                    if ($vacated) {
                        $this->conn->commit();
                        return true;
                    } else {
                        $this->conn->rollBack();
                        return false;
                    }
                } else {
                    $this->conn->rollBack();
                    return false;
                }
            } else {
                $this->conn->rollBack();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getAdmissionDetails($patient_id) {
        $admission_model = new AdmissionModel();

        $stmt = AdmissionSqlStatement::GET_ADMISSION_DETAILS;

        $data = array();
        $data[AdmissionTable::patient_id] = $patient_id;

        $result = $admission_model->conn->fetch($stmt, $data);

        return $result;
    }

    public function isAdmitted($patient_id) {
        $stmt = AdmissionSqlStatement::IS_ADMITTED;

        $data = array();
        $data[AdmissionTable::patient_id] = $patient_id;

        $result = $this->conn->fetch($stmt, $data);

        return $result[COUNT] > 0 ? true : false;
    }

    public function searchPatients($parameter) {
        $stmt = AdmissionSqlStatement::SEARCH_PATIENTS;

        $data = array();
        $data[PARAMETER] = $parameter;
        $data[WILDCARD] = "%" . $parameter . "%";

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getPatients() {
        $stmt = AdmissionSqlStatement::GET_PATIENTS;

        $data = array();

        $result = $this->conn->fetchAll($stmt, $data);

        return sizeof($result) > 0 ? $result : false;
    }
}