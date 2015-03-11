<?php
class AdmissionModel extends BaseModel {
    public function requestAdmission($treatment_id) {
        $stmt = AdmissionReqSqlStatement::REQUEST_ADMISSION;
        
        $data = array();
        $data[AdmissionReqTable::treatment_id] = $treatment_id;

        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function getAdmissionRequests() {
        $stmt = AdmissionReqSqlStatement::GET_ALL_REQUESTS;

        $data = array();

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
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
            
            $result = $this->conn->execute($stmt, $admission_data, true);

            var_dump($result);

            if ($result) {
                // Flag assigned patient bed as occupied
                $bed_model = new BedModel($admission_data[AdmissionTable::bed_id], $this->conn);
                $occupied = $bed_model->occupy();

                if ($occupied) {
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
            return false;
        }
    }

    public function isAdmitted($patient_id) {
        $stmt = AdmissionSqlStatement::IS_ADMITTED;

        $data = array();
        $data[AdmissionTable::patient_id] = $patient_id;

        $result = $this->conn->fetch($stmt, $data);

        return $result[COUNT] > 0 ? true : false;
    }
}