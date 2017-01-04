<?php
class RadiologyModel extends BaseModel{
    /*The arrays below contains columns whose values should be numbers*/
    private $rad = array('xray_case_id', 'xray_size_id');
    private $rad_req = array('previous_xray', 'xray_number');

    public function radiologyRequest($doctorId, $treatmentId, $encounterId, $description){
        try{
            $this->conn->beginTransaction();

            $data = array(RadiologyTable::doctor_id => $doctorId, RadiologyTable::treatment_id => $treatmentId,
                          RadiologyTable::encounter_id => $encounterId);
            if(!$this->conn->execute(RadiologyRequestSqlStatement::ADD_RAD_INFO, $data))
                throw new Exception("Error requesting xray test1");

            unset($data);
            $lastInsertId = $this->conn->getLastInsertedId();
            $data = array(RadiologyRequestTable::radiology_id => $lastInsertId, RadiologyRequestTable::clinical_diagnosis_details => $description);
            if(!$this->conn->execute(RadiologyRequestSqlStatement::ADD_RAD_REQ_INFO, $data))
                throw new Exception("Error requesting xray test2");

            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(RadiologyRequestSqlStatement::GET_HISTORY, $data);
    }

    public function getPatientQueue($status = PENDING, $activeFg = 1){
        $data = array(RadiologyTable::status_id => $status, RadiologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(RadiologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(RadiologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(RadiologyRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($testId, $treatmentId, $encounterId){
        $result = array();
        $data = array(RadiologyTable::radiology_id => $testId, RadiologyTable::treatment_id => $treatmentId, RadiologyTable::encounter_id => $encounterId);
        $result['details'] = $this->conn->fetch(RadiologyRequestSqlStatement::GET_DETAILS, $data);
        $result['radiology'] = $this->conn->fetch(RadiologyRequestSqlStatement::GET_RADIOLOGY_VALS, $data);
        $result['xray_no'] = $this->conn->fetch(RadiologyRequestSqlStatement::GET_XRAY_NO_VALS, $data);
        return $result;
    }

    public function setTestDetails($data){
        return $this->updateTestDetails($data);
    }

    private function updateDetails($data){
        $this->checkDecimalColumns($this->rad_req, $data);
        if(!$this->conn->checkParams(RadiologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception("Incomplete radiology details params");
        if(!$this->conn->execute(RadiologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception("Could not update radiology details");
    }

    private function updateRadiology($data){
        $this->checkDecimalColumns($this->rad, $data);
        if(isset($data['encounter_id'])) unset($data['encounter_id']);
        if(!isset($data['lmp'])) $data['lmp'] = null;

        if(!$this->conn->checkParams(RadiologySqlStatement::UPDATE, $data))
            throw new Exception("Incomplete radiology params");
        if(!$this->conn->execute(RadiologySqlStatement::UPDATE, $data))
            throw new Exception("Could not update radiology values");
    }

    private function updateXRayNo($data){
        if(!$this->conn->checkParams(XRaySqlStatement::UPDATE, $data))
            throw new Exception("Check XRay No Parameters");
        if(!$this->conn->execute(XRaySqlStatement::UPDATE, $data))
            throw new Exception("Could not update xray");
    }

    public function updateTestDetails(&$data){
        $data['radiology']['radiology_id'] = $data['details']['radiology_id'];
        $data['xray']['radiology_id'] = $data['details']['radiology_id'];
        try{
            $this->conn->beginTransaction();
            $this->updateDetails($data['details']);
            $this->updateRadiology($data['radiology']);
            $this->updateXRayNo($data['xray']);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return array('status'=>false, 'message'=>$e->getMessage());
        }

        return array('status'=>true);
    }

}