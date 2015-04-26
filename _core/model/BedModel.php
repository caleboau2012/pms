<?php
class BedModel extends BaseModel {
    public function __construct($bed_id, $conn=NULL) {
        parent::__construct();
        $this->bed_id = $bed_id;
        $this->conn = ($conn == NULL) ? $this->conn : $conn;
    }

    public function create($ward_id, $bed_description) {
        $stmt = BedSqlStatement::NEW_BED;
        $data = array(
            BedTable::bed_description   =>  $bed_description,
            BedTable::ward_id           =>  $ward_id
        );

        $result = $this->conn->execute($stmt, $data, true);
        if ($result) {
            $this->bed_id = $this->conn->getLastInsertedId();
        }

        return $result;
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

    public static function bedExists($bed_description) {
        $bed_model = new BedModel();

        $stmt = BedSqlStatement::BED_EXISTS;
        $data = array(BedTable::bed_description  =>  $bed_description);

        $result = $bed_model->conn->fetch($stmt, $data);

        return $result[COUNT] > 0;
    }
}