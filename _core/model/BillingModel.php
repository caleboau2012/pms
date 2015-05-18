<?php

class BillingModel extends BaseModel {

    public function unbilledTreatment() {
        return $this->conn->fetchAll(TreatmentSqlStatement::UNBILLED_TREATMENT, array());
    }

    public function treatmentDetails($treatment_id){
        $data = array(TreatmentTable::treatment_id => $treatment_id);
        return $this->conn->fetchAll(TreatmentSqlStatement::TREATMENT_DETAILS, $data);
    }
}
