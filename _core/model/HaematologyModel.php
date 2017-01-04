<?php
class HaematologyModel extends BaseModel{
    /*The following arrays include columns to be checked for decimal type in the different tables*/
    private $diff_count = array(DifferentialCountTable::polymorphs_neutrophils, DifferentialCountTable::lymphocytes,
                                DifferentialCountTable::monocytes, DifferentialCountTable::eosinophils,
                                DifferentialCountTable::basophils, DifferentialCountTable::widals_test);

    private $blood_test = array(BloodTestTable::pcv, BloodTestTable::hb, BloodTestTable::hchc, BloodTestTable::wbc,
                                BloodTestTable::eosinophils, BloodTestTable::platelets, BloodTestTable::rectis,
                                BloodTestTable::rectis_index, BloodTestTable::e_s_r);

    public function haematologyRequest($doctorId, $treatmentId, $encounterId, $description){
        $data = array(HaematologyTable::doctor_id => $doctorId, HaematologyTable::treatment_id => $treatmentId,
                      HaematologyTable::encounter_id => $encounterId, HaematologyTable::clinical_diagnosis_details => $description);
        return $this->conn->execute(HaematologyRequestSqlStatement::ADD_REQ_INFO, $data);
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_HISTORY, $data);
    }

    public function getPatientQueue($status = PENDING, $activeFg = 1){
        $data = array(HaematologyTable::status_id => $status, HaematologyTable::active_fg => $activeFg);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(HaematologyTable::active_fg => $activeFg);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($testId, $treatmentId, $encounterId){
        $result = array();
        $data = array(HaematologyTable::haematology_id => $testId, HaematologyTable::treatment_id => $treatmentId, HaematologyTable::encounter_id => $encounterId);
        $result['details'] = $this->conn->fetch(HaematologyRequestSqlStatement::GET_DETAILS, $data);
        $result['blood_test'] = $this->getBloodTestDetails($testId, $treatmentId, $encounterId);
        $result['differential_count'] = $this->getDifferentialCountTestDetails($testId, $treatmentId, $encounterId);
        $result['film_appearance'] = $this->getFilmAppearanceTestDetails($testId, $treatmentId, $encounterId);

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
            return array('status'=>false, 'message'=>$e->getMessage());
        }

        return array('status'=>true);
    }

    private function updateDetails($data){
        if(!$this->conn->checkParams(HaematologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception('Incomplete haematology details params');
        if(!$this->conn->execute(HaematologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception('Could not update haematology details');
        return true;
    }


/*------------------------------------------ Blood Test Section -----------------------------------------*/

    private function getBloodTestDetails($testId, $treatmentId, $encounterId){
        $data = array(HaematologyTable::haematology_id => $testId, HaematologyTable::treatment_id => $treatmentId, HaematologyTable::encounter_id => $encounterId);
        return $this->conn->fetch(BloodTestSqlStatement::GET, $data);
    }

    private function setBloodTestDetails($data){
        if(!$this->conn->execute(BloodTestSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set blood test details');
        return true;
    }

    private function updateBloodTestDetails($data){
        if(!$this->conn->checkParams(BloodTestSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Incomplete blood test params');

        if($this->checkDecimalColumns($this->blood_test, $data)){
            if(!$this->conn->execute(BloodTestSqlStatement::ADD_UPDATE, $data))
                throw new Exception('Could not update blood test details');
        }

        return true;
    }


/*------------------------------------- Film Appearance Section ----------------------------------------*/

    private function getFilmAppearanceTestDetails($testId, $treatmentId, $encounterId){
        $data = array(HaematologyTable::haematology_id => $testId, HaematologyTable::treatment_id => $treatmentId, HaematologyTable::encounter_id => $encounterId);
        return $this->conn->fetch(FilmAppearanceSqlStatement::GET, $data);
    }

    private function setFilmAppearanceTestDetails($data){
        if (!$this->conn->execute(FilmAppearanceSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set film appearance details');
        return true;
    }

    private function updateFilmAppearanceTestDetails($data){
        if(!$this->conn->checkParams(FilmAppearanceSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Incomplete film appearance params');
        if (!$this->conn->execute(FilmAppearanceSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update film appearnce test details');
        return true;
    }


/*------------------------------- Differential Count Section --------------------------------------------*/
    private function getDifferentialCountTestDetails($testId, $treatmentId, $encounterId){
        $data = array(HaematologyTable::haematology_id => $testId, HaematologyTable::treatment_id => $treatmentId, HaematologyTable::encounter_id => $encounterId);
        return $this->conn->fetch(DifferentialCountSqlStatement::GET, $data);
    }

    private function setDifferentialCountTestDetails($data){
        if(!$this->conn->execute(DifferentialCountSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not set differential count details');
        return true;
    }

    private function updateDifferentialCountTestDetails($data){
        if(!$this->conn->checkParams(DifferentialCountSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Incomplete differential count params');

        if($this->checkDecimalColumns($this->diff_count, $data)){
            if(!$this->conn->execute(DifferentialCountSqlStatement::ADD_UPDATE, $data))
                throw new Exception('Could not update differential count details');
        }

        return true;
    }



/*------------------------------------------------------------------------------------------------------*/

    private function validateData(&$data){
        foreach($data as $obj){
            if(!$obj)
                $obj = null;
        }
    }


}