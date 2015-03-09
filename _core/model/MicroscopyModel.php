<?php
class MicroscopyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(MicroscopyTable::status_id => $status, MicroscopyTable::active_fg => $activeFg);
        return $this->conn->fetchAll(MicroscopyRequestSqlStatment::GET_PATIENT_QUEUE, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(UrineTable::treatment_id => $treatmentId);
        return $this->conn->fetch(MicroscopyRequestSqlStatment::GET_DETAILS, $data);
    }

    public function setTestDetails($treatmentId){

    }

    public function geUrinalysisDetails($urineId){
        $data = array(UrinalysisTable::urine_id => $urineId);
        return $this->conn->fetch(UrinalysisSqlStatement::GET, $data);
    }

    public function setUrinalysisDetails($data){
        return $this->conn->execute(UrinalysisSqlStatement::ADD, $data);
    }

    public function updateUrinalysisDetails($data){
        return $this->conn->execute(BloodTestSqlStatement::UPDATE, $data);
    }

    public function getMicroscopyDetails($urineId){
        $data = array(MicroscopyTable::urine_id => $urineId);
        return $this->conn->fetch(MicroscopySqlStatement::GET, $data);
    }

    public function setMicroscopyDetails($data){
        return $this->conn->execute(MicroscopySqlStatement::ADD, $data);
    }

    public function updateMicroscopyDetails($data){
        return $this->conn->execute(MicroscopySqlStatement::UPDATE, $data);
    }

    public function getUrineSensitivityDetails($urineId){
        $data = array(UrineSensitivityTable::urine_id => $urineId);
        return $this->conn->fetch(UrineSensitivitySqlStatement::GET, $data);
    }

    public function setUrineSensitivityDetails($data){
        return $this->conn->execute(UrineSensitivitySqlStatement::ADD, $data);
    }

    public function updateUrineSensitivityDetails($data){
        return $this->conn->execute(UrineSensitivitySqlStatement::UPDATE, $data);
    }
}