<?php

class PharmacistController{
    private $pharmacy;

    public function __construct(){
        $this->pharmacy = new PharmacyModel();
    }

    public function getPatientQueue(){
        return $this->pharmacy->getPatientQueue(DRUG_UNCLEARED);
    }

    public function getInPatientQueue(){
        return $this->pharmacy->getInPatientQueue();
    }

    public function getOutPatientQueue(){
        return $this->pharmacy->getOutPatientQueue();
    }

    public function getPrescription($treatmentId){
        return $this->pharmacy->getPrescription($treatmentId);
    }

    public function clearPrescription($pharmacist_id, $data){
        return $this->pharmacy->clearPrescription($pharmacist_id, $data);
    }

    public function addDrug($drug){
        return $this->pharmacy->addDrug($drug);
    }

    public function getDrugs(){
        return $this->pharmacy->getDrugs();
    }

    public function isInPatient($patientId){
        return $this->pharmacy->isInPatient($patientId);
    }

    public function isOutPatient($patientId){
        return $this->pharmacy->isOutPatient($patientId);
    }

    public function getUnits(){
        return $this->pharmacy->getUnits();
    }
}