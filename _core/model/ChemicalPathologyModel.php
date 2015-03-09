<?php
class ChemicalPathologyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(ChemicalPathologyRequestTable::status_id => $status, ChemicalPathologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(ChemicalPathologyRequestTable::treatment_id => $treatmentId);
        return $this->conn->fetch(ChemicalPathologyRequestSqlStatement::GET_DETAILS, $data);
    }

    public function setTestDetails($cPreqId, $cPrefId){
        $query = "";
        foreach($cPrefId as $key => $value){
            $query .= "({$cPreqId}, {$key}, {$value}, NOW(), NOW()), ";
        }
    }

    public function updateTestDetails(){

    }

}