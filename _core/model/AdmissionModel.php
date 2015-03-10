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
}