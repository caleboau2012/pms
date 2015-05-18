<?php

class PharmacistController{
    private $pharmacy;

    public function __construct(){
        $this->pharmacy = new PharmacistModel();
    }

    public function addDrugUnits($unit, $symbol){
        return $this->pharmacy->addDrugUnits($unit);
    }

    public function getPatientQueue(){
        return $this->pharmacy->getPatientQueue(DRUG_UNCLEARED);
    }

    public function getPrescription($treatmentId){
        return $this->pharmacy->getPrescription($treatmentId);
    }

    public function AddPrescription ($somepre, $treatment_id, $status, $mod){
            return $this->pharmacy->AddPrescription($somepre, $treatment_id, $status, $mod);
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