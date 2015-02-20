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
        /*return $this->pharmacy->getOutPatientQueue();*/
        return $this->getPatientQueue();
    }

    public function getPrescription($treatmentId){
        return $this->pharmacy->getPrescription($treatmentId);
    }

    public function clearPrescription($data){
        /* This function loops through the prescriptions sent in
           the dataArray and updates their prescription appropriately
           and also sets their treatment status to cleared.
        */
        $drugIdStore = array();

        foreach($data as $dataItem){
            $drugId = $dataItem['drugId'];
            if(!$drugId){
                $drug = $dataItem['drug'];

                if(!in_array($drug, $drugIdStore)){
                    $drugIdStore[$drug] = $this->pharmacy->getDrugId($drug);
                }

                $drugId = $drugIdStore[$drug];
            }

            $this->pharmacy->matchPrescriptionToDrug($dataItem['prescriptionId'], $drugId);

            $this->pharmacy->updatePrescription($dataItem['prescriptionId'], CLEARED);
        }

        return true;
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

}