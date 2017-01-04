<?php
class VisualModel extends BaseModel{

    public function visualRequest($doctorId, $treatmentId, $encounterId, $description){
        $data = array(VisualSkillsProfileTable::doctor_id => $doctorId, VisualSkillsProfileTable::treatment_id => $treatmentId,
                      VisualSkillsProfileTable::encounter_id => $encounterId, VisualSkillsProfileTable::description => $description);
        return $this->conn->execute(VisualRequestSqlStatement::ADD_REQ_INFO, $data);
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        $result = $this->conn->fetchAll(VisualRequestSqlStatement::GET_HISTORY, $data);
        foreach($result as &$obj){
            $obj['diagnosis'] = 'No diagnosis';
        }
        return $result;
    }

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(VisualSkillsProfileTable::status_id => $status, VisualSkillsProfileTable::active_fg => $activeFg);
        return $this->conn->fetchAll(VisualRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(VisualSkillsProfileTable::active_fg => $activeFg);
        return $this->conn->fetchAll(VisualRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($testId, $treatmentId, $encounterId){
        $data = array(VisualSkillsProfileTable::id => $testId, VisualSkillsProfileTable::treatment_id => $treatmentId, VisualSkillsProfileTable::encounter_id => $encounterId);
        return $this->conn->fetch(VisualRequestSqlStatement::GET_DETAILS, $data);
    }

    public function updateTestDetails($data){
        if(!$this->conn->checkParams(VisualRequestSqlStatement::UPDATE_DETAILS, $data['details']))
            return array('status'=>false, 'message'=>'check visual params');
        if(!$this->conn->execute(VisualRequestSqlStatement::UPDATE_DETAILS, $data['details']))
            return array('status'=>false, 'message'=>'Could not update visual details');
        return array('status'=>true);
    }

}

