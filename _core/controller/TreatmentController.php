<?php

class TreatmentController{
    private $treatmentModel;

    public function __construct(){
        $this->treatmentModel = new TreatmentModel();
    }

    public function getPatientQueue($doctorId){
        return $this->treatmentModel->getInPatientQueue($doctorId);
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

    public function addTreatment($doctorId, $patientId, $consultation, $symptoms, $diagnosis, $comments){
        $treatmentInfo = array(TreatmentTable::doctor_id => $doctorId, TreatmentTable::patient_id => $patientId,
                               TreatmentTable::consultation => $consultation, TreatmentTable::symptoms => $symptoms,
                               TreatmentTable::diagnosis => $diagnosis, TreatmentTable::comments => $comments);
        return $this->treatmentModel->addTreatment($treatmentInfo);
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

    public function logEncounter($doctorId, $patientId, $admissionId, $comments){
        $data = array(EncounterTable::personnel_id => $doctorId, EncounterTable::patient_id => $patientId,
                      EncounterTable::admission_id => $admissionId, EncounterTable::comments => $comments);
        return $this->treatmentModel->logEncounter($data);
    }
}