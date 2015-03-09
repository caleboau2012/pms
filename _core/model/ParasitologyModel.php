<?php
class ParasitologyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(ParasitologyRequestTable::status_id => $status, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getParasites($treatmentId, $activeFg = ACTIVE){
        $data = array(ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PARASITES, $data);
    }

    public function getDetails($treatmentId, $activeFg = ACTIVE){
        $data = array(ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetch(ParasitologyRequestSqlStatement::GET_DETAILS, $data);
    }

    public function getTestDetails($treatmentId, $activeFg = ACTIVE){
        $result = array();
        $data = array(ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::active_fg => $activeFg);
        $result['details'] = $this->conn->fetch(ParasitologyRequestSqlStatement::GET_DETAILS, $data);
        $result['parasites'] = $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PARASITES, $data);

        return $result;
    }

    public function updateDetails($data){
        return $this->conn->execute(ParasitologyRequestSqlStatement::UPDATE_DETAILS, $data);
    }

    public function updateParasites($pReqId, $pRefIds){
        $data = array(ParasitologyDetailsTable::preq_id => $pReqId, 'ids' => implode(',', $pRefIds));
        $this->conn->execute(ParasitologyDetailsSqlStatement::UPDATE_PARASITE_STATUS, $data);
        $this->conn->execute(ParasitologyDetailsSqlStatement::ADD_IF_NEW, $data);
    }

    public function updateTestDetails($data){

    }

}