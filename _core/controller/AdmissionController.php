<?php
class AdmissionController {
    public static function requestAdmission($treatment_id) {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->requestAdmission($treatment_id);

        return $feedback;
    }

    public static function admissionRequests() {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->getAdmissionRequests();

        if (!is_array($feedback)) {
            return false;
        } else {
            $response = array();

            $response[P_STATUS] = STATUS_OK;

            if (sizeof($feedback) > 0) {
                $response[P_DATA] = $feedback;
            } else {
                $response[P_MESSAGE] = "No pending admission requests!";
            }

            return $response;
        }

    }

    public function searchAdmissionRequests($parameter) {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->searchAdmissionRequests($parameter);

        return $feedback;
    }

    public function loadWards() {
        $feedback = WardModel::getAll();

        return $feedback;
    }

    public function getWardBeds($ward_id) {
        $ward_model = new WardModel($ward_id);

        $feedback = $ward_model->getWardBeds();

        return $feedback;
    }

    public function admitPatient($patient_id, $treatment_id, $admitted_by, $bed_id, $comments) {

        $feedback = array();

        $admitted = AdmissionController::isAdmitted($patient_id);
        if ($admitted) {
            $feedback[P_STATUS] = STATUS_ERROR;
            $feedback[P_MESSAGE] = "Patient already admitted!";

            return $feedback;
        }

        $occupied = WardController::isOccupied($bed_id);
        if ($occupied) {
            $feedback[P_STATUS] = STATUS_ERROR;
            $feedback[P_MESSAGE] = "Bed already occupied!";

            return $feedback;
        }

        $admission_model = new AdmissionModel();

        $admission_data = array();
        $admission_data[AdmissionTable::patient_id] = $patient_id;
        $admission_data[AdmissionTable::treatment_id] = $treatment_id;
        $admission_data[AdmissionTable::admitted_by] = $admitted_by;
        $admission_data[AdmissionTable::comments] = $comments;
        $admission_data[AdmissionBedTable::bed_id] = $bed_id;

        $response = $admission_model->admitPatient($admission_data);

        if ($response) {
            $feedback[P_STATUS] = STATUS_OK;
            $feedback[P_MESSAGE] = "Patient admission successful!";
        } else {
            $feedback[P_STATUS] = STATUS_ERROR;
            $feedback[P_MESSAGE] = "Unable to complete patient admission!";
        }

        return $feedback;
    }

    public function switchBed($admission_id, $bed_id) {
        $admission_model = new AdmissionModel();

        $bed = new BedModel($bed_id);
        $bed_status = $bed->getStatus();
        if ($bed_status == OCCUPIED) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Cannot assign bed that is currently occupied!"
            );
            return $response;
        }

        $feedback = $admission_model->switchBed($admission_id, $bed_id);
        if (!$feedback) {
            $response = array(
                P_STATUS    =>  STATUS_ERROR,
                P_MESSAGE   =>  "Unable to assign bed!"
            );
            return $response;
        }

        return $feedback;
    }

    public function logEncounter($personnel_id, $treatment_id, $patient_id, $admission_id, $vitals_data) {
        $admission_model = new AdmissionModel();

        $encounter_data = array();
        $encounter_data[EncounterTable::personnel_id] = $personnel_id;
        $encounter_data[EncounterTable::patient_id] = $patient_id;
        $encounter_data[EncounterTable::admission_id] = $admission_id;
        $encounter_data[EncounterTable::treatment_id] = $treatment_id;

        if ($vitals_data) {
            $encounter_data[VITALS] = $vitals_data;
        }

        $feedback = $admission_model->logEncounter($encounter_data);

        return $feedback;
    }


    public function dischargePatient($patient_id, $discharged_by) {
        $admission_model = new AdmissionModel();

        $discharge_data = array();
        $discharge_data[AdmissionTable::patient_id] = $patient_id;
        $discharge_data[AdmissionTable::discharged_by] = $discharged_by;

        $feedback = $admission_model->dischargePatient($discharge_data);

        return $feedback;
    }

    public static function isAdmitted($patient_id) {
        $admission_model = new AdmissionModel();

        $feedback = $admission_model->isAdmitted($patient_id);

        return $feedback;
    }

    public function searchPatients($parameter) {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->searchPatients($parameter);

        return $feedback;
    }

    public static function getPatients() {
        $admission_model = new AdmissionModel();
        $feedback = $admission_model->getPatients();

        return $feedback;
    }
}