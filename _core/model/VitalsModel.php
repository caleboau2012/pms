<?php
class VitalsModel extends BaseModel {
    public function add($vitals_data) {
        $stmt = VitalsSqlStatement::ADD;

        $result = $this->conn->execute($stmt, $vitals_data, true);

        return $result;
    }

    public function getVitals($patient_id) {
        $stmt = VitalsSqlStatement::GET_VITALS;
        
        $data = array();
        $data[VitalsTable::patient_id] = $patient_id;

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }
}