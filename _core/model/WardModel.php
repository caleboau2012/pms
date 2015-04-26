<?php
class WardModel extends BaseModel {
    public function __construct($ward_id = NULL) {
        parent::__construct();
        $this->ward_id = $ward_id;
    }

    public function create($description) {
        $stmt = WardRefSqlStatement::NEW_WARD;
        $data = array(WardRefTable::description =>  $description);

        $result = $this->conn->execute($stmt, $data, true);

        if ($result) {
            $this->ward_id = $this->conn->getLastInsertedId();
        }

        return $result;
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

    public static function wardExists($ward_description) {
        $ward_model = new WardModel();

        $stmt = WardRefSqlStatement::WARD_EXISTS;
        $data =array(WardRefTable::description  =>  $ward_description);

        $result = $ward_model->conn->fetch($stmt, $data);

        return $result[COUNT] > 0;
    }

    public static function isValidWard($ward_id) {
        $ward_model = new WardModel();

        $stmt = WardRefSqlStatement::IS_VALID_WARD;
        $data = array(WardRefTable::ward_ref_id =>  $ward_id);

        $result = $ward_model->conn->fetch($stmt, $data);

        return $result[COUNT] > 0;
    }
}