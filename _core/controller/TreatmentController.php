<?php

class TreatmentController{
    private $treatmentModel;

    public function __construct(){
        $this->treatmentModel = new TreatmentModel();

    }

    public function getPatientQueue($doctorId){
        return $this->treatmentModel->getPatientQueue($doctorId);

    }

    public function getInpatientQueue(){
        return $this->treatmentModel->getInpatientQueue();
    }

    public function getAdmittedPatientQueue(){
        return $this->treatmentModel->getAdmittedPatientQueue();
    }

    public function requestAdmission($treatmentId){
        return $this->treatmentModel->requestAdmission($treatmentId);
    }

    public function addTreatment1($doctorId, $patientId, $consultation, $symptoms, $diagnosis, $comments){
//    public function addTreatment1($doctorId, $patientId){

        $treatmentInfo = array(TreatmentTable::doctor_id => $doctorId, TreatmentTable::patient_id => $patientId,
            TreatmentTable::consultation => $consultation, TreatmentTable::symptoms => $symptoms,
            TreatmentTable::diagnosis => $diagnosis, TreatmentTable::comments => $comments);

//var_dump($treatmentInfo);

        return $this->treatmentModel->addTreatment1($treatmentInfo);
    }

    public function addTreatment2($doctorId, $patientId, $consultation, $symptoms, $diagnosis, $comments, $treatment_id){
        $treatmentInfo = array(TreatmentTable::doctor_id => $doctorId, TreatmentTable::patient_id => $patientId,
            TreatmentTable::consultation => $consultation, TreatmentTable::symptoms => $symptoms,
            TreatmentTable::diagnosis => $diagnosis, TreatmentTable::comments => $comments, TreatmentTable::treatment_id => $treatment_id);

        return $this->treatmentModel->addTreatment2($treatmentInfo);
    }

    public function doesTreatmentExist ($patientId){
        $data = array(TreatmentTable::patient_id => $patientId );
        return $this->treatmentModel->checkForExistingTreatment ($data);
    }

    public function endTreatment ($treatmentinfo){
        $data = array(TreatmentTable::treatment_id => $treatmentinfo );
        return $this->treatmentModel->terminateTreatment($data);
    }

    public function getTreatmentHistory($patientId){
        return $this->treatmentModel->getTreatmentHistory($patientId);
    }

    public function requestLabTest($doctorId, $treatmentId, $labTestType, $comment){
        return $this->treatmentModel->requestLabTest($doctorId, $treatmentId, $labTestType, $comment);
    }

    public function getLabHistory($patientId, $labTestType){
        return $this->treatmentModel->getLabHistory($patientId, $labTestType);
    }

    public function searchPatient($patientName){
        return $this->treatmentModel->searchPatient($patientName);
    }

    public function getEncounterHistory($admissionId){
        return $this->treatmentModel->getEncounterHistory($admissionId);
    }

    /*public function logEncounter($doctorId, $patientId, $admissionId, $comments){
        $data = array(EncounterTable::personnel_id => $doctorId, EncounterTable::patient_id => $patientId,
            EncounterTable::admission_id => $admissionId, EncounterTable::comments => $comments);
        return $this->treatmentModel->logEncounter($data);
    }*/

    public function logEncounter($doctorId, $patientId, $admissionId, $treatmentId, $encounterId, $consultation, $symptoms, $diagnosis, $comments){
        $data = array(EncounterTable::personnel_id => $doctorId, EncounterTable::patient_id => $patientId,
                      EncounterTable::admission_id => $admissionId, EncounterTable::treatment_id => $treatmentId,
                      EncounterTable::encounter_id => $encounterId, EncounterTable::consultation => $consultation,
                      EncounterTable::symptoms => $symptoms, EncounterTable::diagnosis => $diagnosis,
                      EncounterTable::comments => $comments);

        return $this->treatmentModel->logEncounter($data);
    }

    public function getEncounterId($treatmentId, $patientId, $admissionId, $doctorId){
        return $this->treatmentModel->createNewEncounter($treatmentId, $patientId, $admissionId, $doctorId);
    }

    public function closeEncounter($treatmentId, $encounterId){
        return $this->treatmentModel->closeEncounter($treatmentId, $encounterId);
    }

    public function getEncounters($treatmentId){
        return $this->treatmentModel->getEncounters($treatmentId);
    }
}
