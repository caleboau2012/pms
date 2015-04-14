<?php
class ChemicalPathologyModel extends BaseModel{

    public function chemicalPathologyRequest($doctorId, $treatmentId, $description){
            $data = array(ChemicalPathologyRequestTable::doctor_id => $doctorId, ChemicalPathologyRequestTable::treatment_id => $treatmentId,
                ChemicalPathologyRequestTable::clinical_diagnosis => $description);
            return $this->conn->execute(ChemicalPathologyRequestSqlStatement::ADD_REQ_INFO, $data);
    }

    public function getLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_HISTORY, $data);
    }

    public function getPatientQueue($status = PENDING, $activeFg = ACTIVE){
        $data = array(ChemicalPathologyRequestTable::status_id => $status, ChemicalPathologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_PATIENT_QUEUE, $data);
    }

    public function getAllTest($activeFg = 1){
        $data = array(ChemicalPathologyRequestTable::active_fg => $activeFg);
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_ALL_TEST, $data);
    }

    public function getTestDetails($treatmentId){
        $data = array(ChemicalPathologyRequestTable::treatment_id => $treatmentId);
        return $this->conn->fetch(ChemicalPathologyRequestSqlStatement::GET_DETAILS, $data);
    }

    public function setTestDetails($cPReqId, $data){
        return $this->updateTestDetails($cPReqId, $data);
    }


    public function updateTestDetails($data){
        try{
            $this->conn->beginTransaction();
            $this->updateDetails($data['details']);
            $this->updateTestRefIdsDetails($data['details']['cpreq_id'], $data['values']);
            $this->conn->commit();
        } catch (Exception $e){
            $this->conn->rollBack();
            echo $e->getMessage();
            return false;
        }

        return true;
    }


    /*
     * Get all cpref_id for this particular cpreq_id
     * Check for all cpref_id already in table that is not the new list
     *   If present, delete them
     *   Else, do nothing
     * Check for all cpref_id in the new list that is not already in the table
     *   If present, add them
     *   Else, do nothing
     * Check for all cpref_id in the new list that is already in the table and update them
     * */
    private function updateTestRefIdsDetails($cPReqId, $data){  //$data is an associative array of cpref_ids and their values
        $existingIds = $this->extractIds('cpref_id', $this->getExistingIds($cPReqId));
        $cPRefIds = array_keys($data);
        $diff = array_diff($existingIds, $cPRefIds);

        if($diff){
            $this->deleteTestValues($cPReqId, $diff);    // delete from ref table (i.e, set active_fg = 0)
        }

        unset($diff);
        $diff = array_diff($cPRefIds, $existingIds);

        if($diff){
            $subRefIds = array_intersect_key($data, array_flip($diff));     // Add to ref table
            $this->addTestValues($cPReqId, $subRefIds);
        }

        unset($subRefIds);
        $intersect = array_intersect($existingIds, $cPRefIds);
        if($intersect){
            $subRefIds = array_intersect_key($data, array_flip($intersect));
            $this->updateTestValues($cPReqId, $subRefIds, 1);
        }
    }

    private function updateDetails($data){
        if(!$this->conn->execute(ChemicalPathologyRequestSqlStatement::UPDATE_DETAILS, $data))
            throw new Exception("Error updating chemical pathology details");
        return true;
    }

    private function getExistingIds($cPReqId){
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_IDS, array(ChemicalPathologyDetailsTable::cpreq_id => $cPReqId));
    }

    /* This method simple sets their active_fg to INACTIVE i.e 0 */
    private function deleteTestValues($cPReqId, $cPRefIds){
        foreach($cPRefIds as $key => $id){
            $data = array(ChemicalPathologyDetailsTable::cpreq_id => $cPReqId, ChemicalPathologyDetailsTable::cpref_id => $id);
            if(!$this->conn->execute(ChemicalPathologyRequestSqlStatement::DELETE, $data))
                throw new Exception("Could not delete values in chemical pathology");
        }

        return true;
    }


    /* $cPRefIds is an associative array of cpef_id and result */
    private function addTestValues($cPReqId, $cPRefIds){
        $vals = '';
        foreach($cPRefIds as $id => $val){
            $vals .= "($cPReqId, $id, $val, NOW(), NOW()), ";
        }

        $vals = rtrim($vals, ' ,');
        $query = str_replace(':vals', $vals, ChemicalPathologyRequestSqlStatement::ADD_VALUES);
        if(!$this->conn->execute($query, array()))
            throw new Exception("Error adding chemical pathology values");

        return true;
    }

    private function updateTestValues($cPReqId, $cPRefIds, $activeFg){
        foreach($cPRefIds as $cpref_id => $result){
            $data = array(ChemicalPathologyDetailsTable::cpreq_id => $cPReqId, ChemicalPathologyDetailsTable::cpref_id => $cpref_id,
                          ChemicalPathologyDetailsTable::result => $result, ChemicalPathologyDetailsTable::active_fg => $activeFg);
            if(!$this->conn->execute(ChemicalPathologyRequestSqlStatement::UPDATE_VALUES, $data))
                throw new Exception('Could not update test values in chemical pathology');
        }

        return true;
    }

    private function extractIds($key, $array){
        $arr = array();
        foreach($array as $val){
            array_push($arr, $val[$key]);
        }

        return $arr;
    }

}