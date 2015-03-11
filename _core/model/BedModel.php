<?php
class BedModel extends BaseModel {
    public function __construct($bed_id, $conn=NULL) {
        parent::__construct();
        $this->bed_id = $bed_id;
        $this->conn = ($conn == NULL) ? $this->conn : $conn;
    }

    public function occupy() {
        $stmt = BedSqlStatement::OCCUPY;
        
        $data = array();
        $data[BedTable::bed_id] = $this->bed_id;

        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function vacate() {
        $stmt = BedSqlStatement::VACATE;

        $data = array();
        $data[BedTable::bed_id] = $this->bed_id;

        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function getStatus() {
        $stmt = BedSqlStatement::BED_STATUS;

        $data = array();
        $data[BedTable::bed_id] = $this->bed_id;

        $result = $this->conn->fetch($stmt, $data);

        return $result[BedTable::bed_status];
    }
}