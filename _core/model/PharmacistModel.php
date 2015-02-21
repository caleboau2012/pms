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


    public function updatePrescriptionStatus($prescription_id, $status){
        return $this->conn->execute(PrescriptionSqlStatement::UPDATE_STATUS,
            array(PrescriptionTable::prescription_id => $prescription_id, PrescriptionTable::status => $status));
    }


    public function mapPharmacistToOutgoingDrug($pharmacistId, $outgoingDrugId){
        $data = array(PharmacistOutgoingDrugTable::pharmacist_id => $pharmacistId, PharmacistOutgoingDrugTable::outgoing_drug_id => $outgoingDrugId);
        return $this->conn->execute(DrugSqlStatement::MAP_PHARMACIST_OUTGOING_DRUG, $data);
    }


    public function mapPrescriptionToOutgoingDrug($prescriptionId, $outgoingDrugId){

    }


    public function setOutgoingDrug($drugId, $qty, $unitId){
        $data = array(OutgoingDrugsTable::drug_id => $drugId, OutgoingDrugsTable::quantity => $qty, OutgoingDrugsTable::unit_id => $unitId);
        return $this->conn->execute(DrugSqlStatement::ADD_OUTGOING_DRUG, $data);
    }


    // Get the last id inserted into the outgoing_drugs table
    // map pharmacist_id with outgoing_drug_id gotten from above on pharmacist_outgoing_drug table
    /*Loop thro' all the prescriptions{
    map the prescription_ids to outgoing_drug_id on prescription_outgoing_drug_id table
    Change the status as appropriate
    }*/
    public function clearPrescription($pharmacistId, $data){
        // Get the drug_id, qty and unit_id and insert it into the outgoing_drugs table
        foreach($data as $prescriptionList){
            $drugId = $prescriptionList['drugId'];
            $drugName = $prescriptionList['drugName'];
            $quantity = $prescriptionList['quantity'];
            $unitId = $prescriptionList['unitId'];
            $outgoingDrugId = null;

            if($drugName){
                if(!$drugId){
                    try{
                        $this->conn->beginTransaction();
                        $this->addDrug($drugName);
                        $drugId = $this->conn->getLastInsertedId();
                        $this->conn->commit();
                    } catch(Exception $e){
                        return false;
                    }
                }

                if($quantity && $unitId && $drugId){
                    try{
                        $this->conn->beginTransaction();
                        $this->setOutgoingDrug($drugId, $quantity, $unitId);
                        $outgoingDrugId = $this->conn->getLastInsertedId();
                        $this->conn->commit();
                    } catch(Exception $e){
                        return false;
                    }
                }

                if(!$this->mapPharmacistToOutgoingDrug($pharmacistId, $outgoingDrugId)) return false;
            }

            foreach($prescriptionList as $prescription){
                $id = $prescription['prescription_id'];
                if(!$this->mapPrescriptionToOutgoingDrug($id, $outgoingDrugId)) return false;
                if(!$this->updatePrescriptionStatus($id, $prescription['status'])) return false;
            }

        }

        return true;
    }


    public function isOutPatient($patientId){
        return true;
    }

    public function isInPatient($patientId){
        return true;
    }

    public function getUnits(){
        return $this->conn->fetchAll(UnitsSqlStatement::GET, array());
    }
}