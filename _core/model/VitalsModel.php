<?php
class VitalsModel extends BaseModel {
    public function __construct($vitals_data, $conn=NULL, $vitals_id=NULL) {
        parent::__construct();
        $this->vitals_data = $vitals_data;
        $this->conn = ($conn == NULL) ? $this->conn : $conn;
        $this->vitals_id = $vitals_id;
    }

    public function add() {
        $stmt = VitalsSqlStatement::ADD;

        $data = $this->vitals_data;

        $result = $this->conn->execute($stmt, $data, true);

        if ($result) {
            $this->vitals_id = $this->conn->getLastInsertedId();
        }

        return $result;
    }

    public function getVitals($patient_id) {
        $stmt = VitalsSqlStatement::GET_VITALS;

        $data = array();
        $data[VitalsTable::patient_id] = $patient_id;

        $result = $this->conn->fetchAll($stmt, $data);

        return sizeof($result) > 0 ? $result : false;
    }
}