<?php
class WardModel extends BaseModel {
    public function __construct($ward_id = NULL) {
        parent::__construct();
        $this->ward_id = $ward_id;
    }

    public static function getAll() {
        $ward_model = new WardModel();
        
        $stmt = WardRefSqlStatement::GET_ALL;
        $data = array();

        $result =  $ward_model->conn->fetchAll($stmt, $data);

        return sizeof($result) > 0 ? $result : false;
    }

    public function getWardBeds() {
        $stmt = WardRefSqlStatement::GET_WARD_BEDS;
        
        $data = array();
        $data[BedTable::ward_id] = $this->ward_id;

        $result = $this->conn->fetchAll($stmt, $data);

        return sizeof($result) > 0 ? $result : false;
    }
}