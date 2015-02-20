<?php

class PharmacyModel extends BaseModel{

    public function getPatientQueue($status){
        return $this->conn->fetchAll(PrescriptionSqlStatement::GET_QUEUE, array(PrescriptionTable::status => $status));
    }


    public function getInPatientQueue(){
        return;
    }


    public function getOutPatientQueue(){
        return;
    }


    public function getPrescription($treatmentId){
        return $this->conn->fetchAll(PrescriptionSqlStatement::GET_PRESCRIPTION, array(PrescriptionTable::treatment_id => $treatmentId));
    }


    /*
     * This method accepts an array of data including the pharmacist id and status.
     */
    public function updatePrescription($prescriptionId, $status){
        $data = array(PrescriptionTable::prescription_id => $prescriptionId, PrescriptionTable::status =>  $status);
        return $this->conn->execute(PrescriptionSqlStatement::UPDATE, $data);
    }


    /*
     * This method adds a drug to the drug_name_ref if does not already exist.
     */
    public function addDrug($drug){
        return $this->conn->execute(DrugSqlStatement::ADD_DRUG, array(DrugNameRefTable::description => $drug));
    }


    public function getDrugs(){
        return $this->conn->fetchAll(DrugSqlStatement::GET, array());
    }


    /* This returns the drug_ref_id from the drug_ref table of a particular drug */
    public function getDrugId($drugName){
        return $this->conn->fetch(DrugSqlStatement::GET_DRUG_ID, array(DrugRefTable::name => $drugName));
    }


    /*
     * This method adds the drug given for a certain prescription item to the drug
     * inventory table. The method expects and array containing th
     */
    public function updateDrugInventory(){
        return 'Drug inventory updated.\n';
    }


    public function updatePrescriptionStatus($status){
        return $this->conn->execute(PrescriptionSqlStatement::UPDATE_STATUS, array(PrescriptionTable::status => $status));
    }


    public function matchPrescriptionToDrug($prescriptionId, $drugId){

    }


    public function isOutPatient($patientId){
        return true;
    }

    public function isInPatient($patientId){
        return true;
    }

}