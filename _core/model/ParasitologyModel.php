<?php
class ParasitologyModel extends BaseModel{

    public function parasitologyRequest($doctorId, $treatmentId, $encounterId, $description){
            $data = array(ParasitologyRequestTable::doctor_id => $doctorId, ParasitologyRequestTable::treatment_id => $treatmentId,
                          ParasitologyRequestTable::encounter_id => $encounterId, ParasitologyRequestTable::diagnosis => $description);
            return $this->conn->execute(ParasitologyRequestSqlStatement::ADD_REQ_INFO, $data);
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_HISTORY, $data);
    }

    public function getPatientQueue($status = PENDING, $activeFg = 1){
        $data = array(ParasitologyRequestTable::status_id => $status, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($testId, $treatmentId, $encounterId, $activeFg = 1){
        $result = array();
        $data = array(ParasitologyRequestTable::preq_id => $testId, ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::encounter_id => $encounterId,
                      ParasitologyRequestTable::active_fg => $activeFg);
        $result['details'] = $this->conn->fetch(ParasitologyRequestSqlStatement::GET_DETAILS, $data);
        $result['parasites'] = $this->formatValues($this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PARASITES, array(ParasitologyRequestTable::preq_id => $testId, ParasitologyRequestTable::active_fg => $activeFg)));
//        $result['parasites'] = $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PARASITES, $data);

        return $result;
    }

    public function setTestDetails($data){
        return $this->updateTestDetails($data);
    }

    public function updateTestDetails($data){
        try{
            $this->conn->beginTransaction();
            $this->updateDetails($data['details']);
            $this->updateParasiteDetails($data['details'][ParasitologyDetailsTable::preq_id], array_keys($data['parasites']));
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return array('status'=>false, 'message'=>$e->getMessage());
        }

        return array('status'=>true);
    }


    private  function getParasites($treatmentId, $activeFg = 1){
        $data = array(ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_PARASITES, $data);
    }

    private function getDetails($treatmentId, $activeFg = 1){
        $data = array(ParasitologyRequestTable::treatment_id => $treatmentId, ParasitologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetch(ParasitologyRequestSqlStatement::GET_DETAILS, $data);
    }

    private function updateDetails($data){
        if(!$this->conn->checkParams(ParasitologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception("Check parasitology params");
        if(!$this->conn->execute(ParasitologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception('Could not update parasitology details');

        return true;
    }

    private function updateParasites($pReqId, $pRefIds){
        $data = array(ParasitologyDetailsTable::preq_id => $pReqId, 'ids' => implode(',', $pRefIds));
        $this->conn->execute(ParasitologyDetailsSqlStatement::UPDATE_PARASITE_STATUS, $data);
        $this->conn->execute(ParasitologyDetailsSqlStatement::ADD_IF_NEW, $data);
    }

    private  function updateParasiteDetails($pReqId, $data){
        $existingIds = $this->extractIds('pref_id', $this->getAllTestValues($pReqId));
        $ids = $data;
        $diff = array_diff($existingIds, $ids);

        if($diff){
            // delete ids in diff (i.e set active flags to INACTIVE)
            $this->updateIds($pReqId, $diff, 0);
        }

        unset($diff);
        $diff = array_diff($ids, $existingIds);

        if($diff){
            // insert ids in diff
            $this->insertIds($pReqId, $diff);
        }

        $intersect = array_intersect($data, $ids);

        if($intersect){
            // update ids (i.e set active flags to ACTIVE)
            $this->updateIds($pReqId, $intersect, 1);
        }
    }

    private function getAllTestValues($pReqId){
        return $this->conn->fetchAll(ParasitologyDetailsSqlStatement::GET_IDS, array(ParasitologyDetailsTable::preq_id => $pReqId));
    }

    private function updateIds($pReqId, $ids, $activeFg){
        foreach($ids as $id){
            $data = array(ParasitologyDetailsTable::preq_id => $pReqId, ParasitologyDetailsTable::pref_id => $id,ParasitologyDetailsTable::active_fg => $activeFg);
            if(!$this->conn->execute(ParasitologyDetailsSqlStatement::UPDATE_IDS, $data))
                throw new Exception('Could not update parasite IDs');
        }

        return true;
    }

    private function insertIds($pReqId, $ids){
        $vals = "";
        foreach($ids as $id){
            $vals .= "($pReqId, $id, NOW(), NOW()), ";
        }
        $vals = rtrim($vals, ", ");

        $query = str_replace(':vals', $vals, ParasitologyDetailsSqlStatement::ADD_VALUES);
        if(!$this->conn->execute($query, array()))
            throw new Exception('Could not insert parasite IDs');

        return true;
    }

    private function extractIds($key, $array){
        $arr = array();
        foreach($array as $val){
            array_push($arr, $val[$key]);
        }

        return $arr;
    }

    private function formatValues($cprefidResultArray){
        $result = array();
        foreach ($cprefidResultArray as $obj){
            array_push($result, $obj['pref_id']);
        }

        return array_flip($result);
    }
}