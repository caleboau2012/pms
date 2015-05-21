<?php

class HospitalDetailsModel extends BaseModel{
    public function createHospitalDetails($name, $address){
        $data = array(HospitalInfoTable::name => $name, HospitalInfoTable::address => $address);
        return $this->conn->execute(HospitalInfoSqlStatement::ADD, $data);
    }

    public function updateHospitalDetails($name, $address){
        return true;
    }
}