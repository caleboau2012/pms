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
            $response_data = array(
                WardRefTable::ward_ref_id   =>  $this->ward_id
            );

            return $response_data;
        }

        return $result;
    }

    public function delete() {
        $data = array(BedTable::ward_id =>  $this->ward_id);

        if (!$this->isEmpty()) {
            // Ward contains occupied beds, delete fails!
            return false;
        }


        $begin = $this->conn->beginTransaction();
        if ($begin) {
            $ward_empty = true;

            if ($this->hasBeds()) {
                // Delete all beds in the ward
                $stmt = WardRefSqlStatement::DELETE_WARD_BEDS;
                $ward_empty = $this->conn->execute($stmt, $data, true);
            }

            if ($ward_empty) {
                // Delete ward
                $stmt = WardRefSqlStatement::DELETE_WARD;
                $ward_deleted = $this->conn->execute($stmt, $data, true);
                if ($ward_deleted) {
                    $this->conn->commit();
                    return true;
                } else {
                    $this->conn->rollBack();
                }
            } else {
                $this->conn->rollBack();
            }
        }

        return false;
    }

    public function isEmpty() {
        $stmt = WardRefSqlStatement::IS_EMPTY_WARD;
        $data = array(BedTable::ward_id =>  $this->ward_id);

        $result = $this->conn->fetch($stmt, $data);

        return ($result[COUNT] == 0);
    }

    public function hasBeds() {
        $stmt = WardRefSqlStatement::HAS_BEDS;
        $data = array(BedTable::ward_id =>  $this->ward_id);

        $result = $this->conn->fetch($stmt, $data);

        return ($result[COUNT] > 0);
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

    public function wardBedCounter() {
        $stmt = WardRefSqlStatement::WARDS_COUNT;
        $stmt2 = BedSqlStatement::BEDS_COUNT;

        $num_of_wards = $this->conn->fetch($stmt, array());
        $num_of_beds = $this->conn->fetchAll($stmt2, array());

        return array("wards"=>$num_of_wards, "beds" => $num_of_beds);
    }
}