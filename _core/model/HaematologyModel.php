<?php
class HaematologyModel extends BaseModel{

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(HaematologyTable::status_id => $status, HaematologyTable::active_fg => $activeFg);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getTestDetails($treatmentId){
        $result = array();
        $data = array(HaematologyTable::treatment_id => $treatmentId);
        $result['details'] = $this->conn->fetch(HaematologyRequestSqlStatement::GET_DETAILS, $data);
        $result['blood_test'] = $this->getBloodTestDetails($treatmentId);
        $result['differential_count'] = $this->getDifferentialCountTestDetails($treatmentId);
        $result['film_appearance'] = $this->getFilmAppearanceTestDetails($treatmentId);

        return $result;
    }

    public function setTestDetails($data){
        return $this->updateTestDetails($data);
    }

    public function updateTestDetails($data){
        try{
            $this->conn->beginTransaction();
            $this->updateDetails($data['details']);
            $this->updateBloodTestDetails($data['blood_test']);
            $this->updateDifferentialCountTestDetails($data['differential_count']);
            $this->updateFilmAppearanceTestDetails($data['film_appearance']);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            echo $e->getMessage();
            return false;
        }

        return true;
    }

    private function updateDetails($data){
        if(!$this->conn->execute(HaematologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception('Could not update haematology details');
        return true;
    }


/*------------------------------------------ Blood Test Section -----------------------------------------*/

    private function getBloodTestDetails($treatmentId){
        $data = array(HaematologyTable::treatment_id => $treatmentId);
        return $this->conn->fetch(BloodTestSqlStatement::GET, $data);
    }

    private function setBloodTestDetails($data){
        if(!$this->conn->execute(BloodTestSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set blood test details');
        return true;
    }

    private function updateBloodTestDetails($data){
        if(!$this->conn->execute(BloodTestSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update blood test details');
        return true;
    }


/*------------------------------------- Film Appearance Section ----------------------------------------*/

    private function getFilmAppearanceTestDetails($treatmentId){
        $data = array(HaematologyTable::treatment_id => $treatmentId);
        return $this->conn->fetch(FilmAppearanceSqlStatement::GET, $data);
    }

    private function setFilmAppearanceTestDetails($data){
        if (!$this->conn->execute(FilmAppearanceSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set film appearance details');
        return true;
    }

    private function updateFilmAppearanceTestDetails($data){
        if (!$this->conn->execute(FilmAppearanceSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update film appearnce test details');
        return true;
    }


/*------------------------------- Differential Count Section --------------------------------------------*/
    private function getDifferentialCountTestDetails($treatmentId){
        $data = array(HaematologyTable::treatment_id => $treatmentId);
        return $this->conn->fetch(DifferentialCountSqlStatement::GET, $data);
    }

    private function setDifferentialCountTestDetails($data){
        if(!$this->conn->execute(DifferentialCountSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set differential count details');
        return true;
    }

    private function updateDifferentialCountTestDetails($data){
        if(!$this->conn->execute(DifferentialCountSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update differential count details');
        return true;
    }
}