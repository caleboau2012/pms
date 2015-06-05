<?php
class TreatmentModel extends BaseModel{


    /* This fetches the patient queue assigned to a particular  */
    public function getPatientQueue($doctorId){

        try {

            $this->conn->beginTransaction();

            $sql = PatientQueueSqlStatement::DOCTOR_QUEUE;
            $data = array(PatientQueueTable::doctor_id => $doctorId );
            $result = $this->conn->fetchAll($sql, $data);

            $this->conn->commit();

            return $result;

        }
        catch (Exception $e){

            $this->conn->rollBack();
            return false;

        }

    }

    public function checkForExistingTreatment ($patientInfo){
        $sql = TreatmentSqlStatement::CHECK_TREATMENT;
        $data = $patientInfo;
        $result = $this->conn->fetch($sql, $data);
        return $result;   // returns the number of time patient id has been registred for trreament.

    }

    public function terminateTreatment ($treatmentinfo){
        $sql = TreatmentSqlStatement::END_TREATMENT;
        $data = $treatmentinfo;
        $result = $this->conn->fetch($sql, $data);
        return $result;   // returns the number of time patient id has been registred for trreament.

    }

    /* This fethces the list of admitted patients */
    public function getInPatientQueue(){

        try {
            $this->conn->beginTransaction();
            $sql = AdmissionSqlStatement::GET_PATIENTS;
            $data = array ();
            $result = $this->conn->fetchAll($sql, $data);
            $this->conn->commit();
            return $result;

        }


        catch (Exception $e){

            $this->conn->rollBack();
            return false;

        }

    }

    public function getAdmittedPatientQueue(){
        try {
            $this->conn->beginTransaction();
            $sql = AdmissionSqlStatement::GET_PATIENTS;
            $data = array();
            $result = $this->conn->fetchAll($sql, $data);
            $this->conn->commit();
            return $result;

        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    public function requestAdmission($treatmentId){

        try {
            $this->conn->beginTransaction();
            $sql = AdmissionReqSqlStatement::REQUEST_ADMISSION;
            $data = array (AdmissionReqTable::treatment_id => $treatmentId);
            $result = $this->conn->execute($sql, $data);
            $this->conn->commit();
            return $result;

        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    public function addTreatment2($treatmentInfo){

        try {
            $this->conn->beginTransaction();
            $sql = TreatmentSqlStatement::UPDATE_TREATMENT;

            $data = $treatmentInfo;

            $result = $this->conn->execute($sql, $data);

//            echo($result);

            if ($result){

                //               $last_id = $this->conn->getLastInsertedId();
                $this->conn->commit();
                return $result;
            }

        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    public function addTreatment1($treatmentInfo){

        try {
            $this->conn->beginTransaction();
            $sql = TreatmentSqlStatement::ADD_TREATMENT1;
            $data = $treatmentInfo;
            $result = $this->conn->execute($sql, $data);

//            echo'last result';
//            var_dump($result);

            if ($result){

                $last_id = $this->conn->getLastInsertedId();
                $this->conn->commit();


//                echo'last id';
//                var_dump($last_id);
                return $last_id;
            }


        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    public function updateTreatment($treatmentInfo){

        try {
            $this->conn->beginTransaction();
            $sql = TreatmentSqlStatement::UPDATE_TREATMENT;
            $data = array ($treatmentInfo);
            $result = $this->conn->execute($sql, $data);
            $this->conn->commit();
            return $result;

        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }


    }

    public function getTreatmentHistory($patientId){

        try {
            $this->conn->beginTransaction();
            $sql = TreatmentSqlStatement::GET_TREATMENT;
            $data = array (TreatmentTable::patient_id=>$patientId);
            $result = $this->conn->fetch($sql, $data);
            $this->conn->commit();
            return $result;

        }

        catch (Exception $e){
            $this->conn->rollBack();
            return false;
        }

    }

    private function radiologyRequest($doctorId, $treatmentId, $encounterId, $description){
        try{
            $this->conn->beginTransaction();
            $data = array(RadiologyTable::doctor_id => $doctorId, RadiologyTable::treatment_id => $treatmentId,
                          RadiologyTable::encounter_id => $encounterId);
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

    public function requestLabTest($doctorId, $treatmentId, $encounterId, $description, $labTestType){
        switch($labTestType){
            case RADIOLOGY:
                return $this->radiologyRequest($doctorId, $treatmentId, $encounterId, $description);

            case HAEMATOLOGY:
                return $this->haematologyRequest($doctorId, $treatmentId, $encounterId, $description);

            case MICROSCOPY:
                return $this->microscopyRequest($doctorId, $treatmentId, $description);

            case VISUAL:
                return $this->visualRequest($doctorId, $treatmentId);

            case CHEMICAL_PATHOLOGY:
                return $this->chemicalPathologyRequest($doctorId, $treatmentId, $description);

            case PARASITOLOGY:
                return $this->parasitologyRequest($doctorId, $treatmentId, $description);

            default:
                return false;
        }
    }

    private function getRadiologyLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(RadiologyRequestSqlStatement::GET_HISTORY, $data);
    }

    private function getHaematologyLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(HaematologyRequestSqlStatement::GET_HISTORY, $data);
    }

    private function getMicroscopyLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(MicroscopyRequestSqlStatment::GET_HISTORY, $data);
    }

    private function getChemicalPathologyLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(ChemicalPathologyRequestSqlStatement::GET_HISTORY, $data);
    }

    private function getParasitologyLabHistory($patientId){
        $data = array(TreatmentTable::patient_id => $patientId);
        return $this->conn->fetchAll(ParasitologyRequestSqlStatement::GET_HISTORY, $data);
    }

    public function getLabHistory($patientId, $labTestType){
        switch($labTestType){
            case RADIOLOGY:
                return $this->getRadiologyLabHistory($patientId);

            case HAEMATOLOGY:
                return $this->getHaematologyLabHistory($patientId);

            case MICROSCOPY:
                return $this->getMicroscopyLabHistory($patientId);

            //   case VISUAL:
            //     return $this->getVisualLabHistory($patientId);

            case CHEMICAL_PATHOLOGY:
                return $this->getChemicalPathologyLabHistory($patientId);

            case PARASITOLOGY:
                return $this->getParasitologyLabHistory($patientId);

            default:
                return array();
        }
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
        return $this->conn->execute(EncounterSqlStatement::UPDATE, $encounterData);
    }

    public function createNewEncounter($treatmentId, $patientId, $admissionId, $doctorId){
        $data = array(EncounterTable::treatment_id => $treatmentId, EncounterTable::patient_id => $patientId,
                      EncounterTable::admission_id => $admissionId, EncounterTable::personnel_id => $doctorId);

        try{
            $this->conn->beginTransaction();
            /* Other things come here! */
            $id = $this->getUnclosedEncounterSession($treatmentId, $admissionId);
            if(!$id){
                if($this->conn->execute(EncounterSqlStatement::ADD, $data))
                    throw new Exception('Could not add a new encounter session');
                $id = $this->conn->getLastInsertedId();
            }
            $this->conn->commit();
            return $id;
        } catch(Exception $ex) {
            $this->conn->rollBack();
            return 0;
        }
    }

    public function closeEncounter($treatmentId, $encounterId){
        $data = array(EncounterTable::treatment_id => $treatmentId, EncounterTable::encounter_id => $encounterId, EncounterTable::status => 2);
        return $this->conn->execute(EncounterSqlStatement::CLOSE_SESSION, $data);
    }

    public function getEncounters($treatmentId){
        $data = array(EncounterTable::treatment_id => $treatmentId);
        return $this->conn->fetchAll(EncounterSqlStatement::GET_ENCOUNTERS, $data);
    }

    private function getUnclosedEncounterSession($treatmentId, $admissionId){
        $data = array(EncounterTable::treatment_id => $treatmentId, EncounterTable::admission_id => $admissionId);
        $result = $this->conn->fetch(EncounterSqlStatement::GET_UNCLOSED_SESSION,
                                     $data);

        if($result[EncounterTable::encounter_id]){
            return $result[EncounterTable::encounter_id];
        }

        return 0;
    }


}
