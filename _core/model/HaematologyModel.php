<?php
class HaematologyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(HaematologyTable::status_id => $status, HaematologyTable::active_fg => $activeFg);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(HaematologyTable::treatment_id => $treatmentId);
        return $this->conn->fetch(HaematologyRequestSqlStatement::GET_DETAILS, $data);
    }

    public function setTestDetails($treatmentId){

    }

    public function getBloodTestDetails($haematology_id){
        $data = array(BloodTestTable::haematology_id => $haematology_id);
        return $this->conn->fetch(BloodTestSqlStatement::GET, $data);
    }

    public function setBloodTestDetails($data){
        return $this->conn->execute(BloodTestSqlStatement::ADD, $data);
    }

    public function updateBloodTestDetails($data){
        return $this->conn->execute(BloodTestSqlStatement::UPDATE, $data);
    }

    public function getFilmAppearanceTestDetails($haematology_id){
        $data = array(BloodTestTable::haematology_id => $haematology_id);
        return $this->conn->fetch(FilmAppearanceSqlStatement::GET, $data);
    }

    public function setFilmAppearanceTestDetails($data){
        return $this->conn->execute(FilmAppearanceSqlStatement::ADD, $data);
    }

    public function updateFilmAppearanceTestDetails($data){
        return $this->conn->execute(FilmAppearanceSqlStatement::UPDATE, $data);
    }

    public function getDifferentialCountTestDetails($haematologyId){
        $data = array(BloodTestTable::haematology_id => $haematologyId);
        return $this->conn->fetch(DifferentialCountSqlStatement::GET, $data);
    }

    public function setDifferentialCountTestDetails($data){
        return $this->conn->execute(DifferentialCountSqlStatement::ADD, $data);
    }

    public function updateDifferentialCountTestDetails($data){
        return $this->conn->execute(DifferentialCountSqlStatement::UPDATE, $data);
    }
}