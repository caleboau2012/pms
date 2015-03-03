<?php
class TreatmentModel extends BaseModel{

    /* This fetches the patient queue assigned to a particular  */
    public function getPatientQueue($doctorId){

    }

    /* This fethces the list of admitted patients */
    public function getInPatientQueue(){

    }

    public function getAdmittedPatientQueue(){

    }

    public function requestAdmission($treatmentId){

    }

    public function addTreatment($treatmentInfo){

    }

    public function getTreatmentHistory($patientId){

    }

    private function radiologyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(RadiologyTable::doctor_id => $doctorId, RadiologyTable::treatment_id => $treatmentId);
            $this->conn->execute(RadiologyRequestSqlStatement::ADD_RAD_INFO, $data);

            unset($data);
            $lastInsertId = $this->conn->getLastInsertedId();
            $data = array(RadiologyRequestTable::radiology_id => $lastInsertId, RadiologyRequestTable::clinical_diagnosis_details => $description);

            $this->conn->execute(RadiologyRequestSqlStatement::ADD_RAD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    private function haematologyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(HaematologyTable::doctor_id => $doctorId, HaematologyTable::treatment_id => $treatmentId, HaematologyTable::clinical_diagnosis_details => $description);
            $this->conn->execute(HaematologyRequestSqlStatement::ADD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    private function microscopyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(UrineTable::doctor_id => $doctorId, UrineTable::treatment_id => $treatmentId, UrineTable::clinical_diagnosis_details => $description);
            $this->conn->execute(MicroscopyRequestSqlStatment::ADD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    private function visualRequest($doctorId, $treatmentId){
        try{
            $this->conn->beginTransaction();
            $data = array(VisualSkillsProfileTable::doctor_id => $doctorId, VisualSkillsProfileTable::treatment_id => $treatmentId);
            $this->conn->execute(VisualRequestSqlStatement::ADD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    private function chemicalPathologyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(ChemicalPathologyRequestTable::doctor_id => $doctorId, ChemicalPathologyRequestTable::treatment_id => $treatmentId,
                          ChemicalPathologyRequestTable::clinical_diagnosis => $description);
            $this->conn->execute(ChemicalPathologyRequestSqlStatement::ADD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    private function parasitologyRequest($doctorId, $treatmentId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(ParasitologyRequestTable::doctor_id => $doctorId, ParasitologyRequestTable::treatment_id => $treatmentId,
                          ParasitologyRequestTable::diagnosis => $description);
            $this->conn->execute(ParasitologyRequestSqlStatement::ADD_REQ_INFO, $data);
            $this->conn->commit();
        } catch(Exception $e){
            $this->conn->rollBack();
            return false;
        }

        return true;
    }

    public function requestLabTest($doctorId, $treatmentId, $description, $labTestType){
        switch($labTestType){
            case 'radiology':
                return $this->radiologyRequest($doctorId, $treatmentId, $description);

            case 'haematology':
                return $this->haematologyRequest($doctorId, $treatmentId, $description);

            case 'microscopy':
                return $this->microscopyRequest($doctorId, $treatmentId, $description);

            case 'visual':
                return $this->visualRequest($doctorId, $treatmentId);

            case 'chemical':
                return $this->chemicalPathologyRequest($doctorId, $treatmentId, $description);

            case 'parasitology':
                return $this->parasitologyRequest($doctorId, $treatmentId, $description);

            default:
                return false;
        }
    }

    public function getLabHistory($patientId, $labTestType){
        $data = array(PatientTable::patient_id => $patientId);

    }

    public function searchPatient($patientNameOrRegNo){
        $data = array('wildcard' => '%'.$patientNameOrRegNo.'%', PatientTable::regNo => $patientNameOrRegNo);
        return $this->conn->fetchAll(PatientSqlStatement::SEARCH_BY_NAME_OR_REG_NO, $data);
    }

    public function getEncounterHistory($admissionId){
        return $this->conn->fetchAll(EncounterSqlStatement::GET_HISTORY, array(AdmissionTable::admission_id => $admissionId));
    }

    /*
     * $encounterData is an assoc array of $doctorId, $patientId, $admissionId, $comments
     * */
    public function logEncounter($encounterData){
        return $this->conn->execute(EncounterSqlStatement::ADD, $encounterData);
    }

}