<?php
class RadiologyModel extends BaseModel{

    public function radiologyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();

            $data = array(RadiologyTable::doctor_id => $doctorId, RadiologyTable::treatment_id => $treatmentId);
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

    public function getTestDetails($treatmentId){
        $result = array();
        $data = array(RadiologyTable::treatment_id => $treatmentId);
        $result['details'] = $this->conn->fetch(RadiologyRequestSqlStatement::GET_DETAILS, $data);
        $result['radiology'] = $this->conn->fetch(RadiologyRequestSqlStatement::GET_RADIOLOGY_VALS, $data);
        return $result;
    }

    public function setTestDetails($data){
        return $this->updateTestDetails($data);
    }

    public function updateTestDetails($data){
        try{
            $this->conn->beginTransaction();
            if(!$this->conn->checkParams(RadiologyRequestSqlStatement::UPDATE_DETAILS, $data['details']))
                throw new Exception("Incomplete radiology details params");
            if(!$this->conn->execute(RadiologyRequestSqlStatement::UPDATE_DETAILS, $data['details']))
                throw new Exception("Could not update radiology details");
            if(!$this->conn->checkParams(RadiologySqlStatement::UPDATE, $data['details']))
                throw new Exception("Incomplete radiology params");
            if(!$this->conn->execute(RadiologySqlStatement::UPDATE, $data['radiology']))
                throw new Exception("Could not update radiology values");
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return array('status'=>false, 'message'=>$e->getMessage());
        }

        return array('status'=>true);
    }

}