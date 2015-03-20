<?php
class VisualModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(VisualSkillsProfileTable::status_id => $status, VisualSkillsProfileTable::active_fg => $activeFg);
        return $this->conn->fetchAll(VisualRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(VisualSkillsProfileTable::active_fg => $activeFg);
        return $this->conn->fetchAll(VisualRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(VisualSkillsProfileTable::treatment_id => $treatmentId);
        return $this->conn->fetch(VisualRequestSqlStatement::GET_DETAILS, $data);
    }

    public function updateTestDetails($data){
        return $this->conn->execute(VisualRequestSqlStatement::UPDATE_DETAILS, $data);
    }

}

