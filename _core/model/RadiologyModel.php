<?php
class RadiologyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(RadiologyRequestTable::status_id => $status, RadiologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(RadiologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(RadiologyTable::treatment_id => $treatmentId);
        return $this->conn->fetch(RadiologyRequestSqlStatement::GET_DETAILS, $data);
    }

    public function setTestDetails(){

    }

    public function updateTestDetails($data){
        return $this->conn->execute(VisualRequestSqlStatement::UPDATE_DETAILS, $data);
    }

}