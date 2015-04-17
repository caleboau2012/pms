<?php
class MicroscopyModel extends BaseModel{

    public function microscopyRequest($doctorId, $treatmentId, $description){
        $data = array(UrineTable::doctor_id => $doctorId, UrineTable::treatment_id => $treatmentId, UrineTable::clinical_diagnosis_details => $description);
        return $this->conn->execute(MicroscopyRequestSqlStatment::ADD_REQ_INFO, $data);
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(MicroscopyRequestSqlStatment::GET_HISTORY, $data);
    }

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(UrineTable::status_id => $status, UrineTable::active_fg => $activeFg);
        return $this->conn->fetchAll(MicroscopyRequestSqlStatment::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(UrineTable::active_fg => $activeFg);
        return $this->conn->fetchAll(MicroscopyRequestSqlStatment::GET_ALL_TEST, $data);
    }

    public function getTestDetails($treatmentId){
        $result = array();
        $data = array(UrineTable::treatment_id => $treatmentId);
        $result['details'] = $this->conn->fetch(MicroscopyRequestSqlStatment::GET_DETAILS, $data);
        $result['urinalysis'] = $this->getUrinalysisDetails($treatmentId);
        $result['microscopy'] = $this->getMicroscopyDetails($treatmentId);
        $result['urine_sensitivity'] = $this->getUrineSensitivityDetails($treatmentId);

        return $result;
    }

    public function setTestDetails($data){
        return $this->updateTestDetails($data);
    }

    public function updateTestDetails(&$data){
        $data['urinalysis']['urine_id'] = $data['details']['urine_id'];
        $data['microscopy']['urine_id'] = $data['details']['urine_id'];

        try{
            $this->conn->beginTransaction();
            $this->updateDetails($data['details']);
            $this->updateUrinalysisDetails($data['urinalysis']);
            $this->updateMicroscopyDetails($data['microscopy']);
            $this->updateUrineSensitivityDetails($data['details'][UrineSensitivityTable::urine_id], $data['urine_sensitivity']);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return array('status' => false, 'message' => $e->getMessage());
        }

        return array('status' => true);
    }

    private function updateDetails($data){
        if(!$this->conn->checkParams(UrineSqlStatement::UPDATE, $data))
            throw new Exception('Check urine details params');
        if(!$this->conn->execute(UrineSqlStatement::UPDATE, $data))
            throw new Exception('Error updating details in microscopy');

        return true;
    }


/*--------------------------------------- Urinalysis Section -------------------------------------------*/

    private function getUrinalysisDetails($treatmentId){
        $data = array(UrineTable::treatment_id => $treatmentId);
        return $this->conn->fetch(UrinalysisSqlStatement::GET, $data);
    }

    private function setUrinalysisDetails($urineId, $data){
        return $this->conn->execute(UrinalysisSqlStatement::ADD_UPDATE, $data);
    }

    private function updateUrinalysisDetails($data){
        if(!$this->conn->checkParams(UrinalysisSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Check urinalysis details params');
        if(!$this->conn->execute(UrinalysisSqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update urinalysis');

        return true;
    }


/*----------------------------------------Microscopy Section -------------------------------------------*/

    private function getMicroscopyDetails($treatmentId){
        $data = array(UrineTable::treatment_id => $treatmentId);
        return $this->conn->fetch(MicroscopySqlStatement::GET, $data);
    }

    private function setMicroscopyDetails($data){
        return $this->conn->execute(MicroscopySqlStatement::ADD_UPDATE, $data);
    }

    private function updateMicroscopyDetails($data){
        if(!$this->conn->checkParams(MicroscopySqlStatement::ADD_UPDATE, $data))
            throw new Exception('Check microscopy details params');
        if(!$this->conn->execute(MicroscopySqlStatement::ADD_UPDATE, $data))
            throw new Exception('Could not update microscopy');

        return true;
    }


/*------------------------------------- Urine Sensitivity Section --------------------------------------*/

    private function formatUrineSensitivityValues($isolatesArray){
        $result = array();

        foreach($isolatesArray as $obj){
            $result[$obj['isolates']] = $obj['isolates_degree'];
        }

        return $result;     // An array of isolates as key and isolates_degree as value
    }

    private function getUrineSensitivityDetails($treatmentId){
        $data = array(UrineTable::treatment_id => $treatmentId);
        return $this->formatUrineSensitivityValues($this->conn->fetchAll(UrineSensitivitySqlStatement::GET, $data));
    }

    private function setUrineSensitivityDetails($urineId, $isolateDegreeIds){
        return $this->updateUrineSensitivityDetails($urineId, $isolateDegreeIds);
    }

    private function updateUrineSensitivityDetails($urineId, $isolateDegreeIds){
        $existingIds = $this->extractIds('isolates', $this->getExistingIds($urineId));
        $ids = array_keys($isolateDegreeIds);;
        $diff = array_diff($existingIds, $ids);
        if($diff){
            // Delete ids in $diff
            $this->deleteIds($urineId, $diff);
        }

        unset($diff);
        $diff = array_diff($ids, $existingIds);
        if($diff){
            // Add ids in $diff
            $this->addIds($urineId, array_intersect_key($isolateDegreeIds, array_flip($diff)));
        }

        $intersect = array_intersect($existingIds, $ids);
        if($intersect){
            // Update ids in intersect
            $this->updateIds($urineId, array_intersect_key($isolateDegreeIds, array_flip($intersect)), 1);
        }

        return true;
    }

    private function deleteIds($urineId, $isolateIds, $activeFg = 0){
        $data = array(UrineSensitivityTable::urine_id => $urineId, UrineSensitivityTable::active_fg => $activeFg);
        foreach($isolateIds as $id){
            $data[UrineSensitivityTable::isolates] = $id;
            if(!$this->conn->execute(UrineSensitivitySqlStatement::DELETE_ISOLATE, $data))
                throw new Exception('Error deleting isolates from urine sensitivity');
            unset($data[UrineSensitivityTable::isolates]);
        }

        return true;
    }

    private function addIds($urineId, $isolateDegreeIds){
        $vals = "";
        foreach($isolateDegreeIds as $isolate => $degree){
            $vals .= "($urineId, $isolate, $degree, NOW(), NOW()), ";
        }

        $vals = rtrim($vals, ", ");
        $query = str_replace(':vals', $vals, UrineSensitivitySqlStatement::ADD_ISOLATES);
        if(!$this->conn->execute($query, array()))
            throw new Exception('Could not add new isolates');

        return true;
    }

    private function updateIds($urineId, $ids, $activeFg = 1){
        $data = array(UrineSensitivityTable::urine_id => $urineId, UrineSensitivityTable::active_fg => $activeFg);
        foreach($ids as $isolate => $degree){
            $data[UrineSensitivityTable::isolates] = $isolate;
            $data[UrineSensitivityTable::isolates_degree] = $degree;
            if(!$this->conn->execute(UrineSensitivitySqlStatement::UPDATE_ISOLATES, $data))
                throw new Exception('Error updating isolates in urine sensitivity');
            unset($data[UrineSensitivityTable::isolates]);
            unset($data[UrineSensitivityTable::isolates_degree]);
        }

        return true;
    }

    private function getExistingIds($urineId){
        $data = array(UrineSensitivityTable::urine_id => $urineId);
        return $this->conn->fetchAll(UrineSensitivitySqlStatement::GET_ISOLATES, $data);
    }

    private function extractIds($key, $array){
        $arr = array();
        foreach($array as $val){
            array_push($arr, $val[$key]);
        }

        return $arr;
    }
}