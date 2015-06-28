<?php

class HospitalDetailsModel extends BaseModel{

    public function getHospitalDetails(){
        return $this->conn->fetch(HospitalInfoSqlStatement::GET, array());
    }

    public function createHospitalDetails($name, $address){
        $data = array(HospitalInfoTable::name => $name, HospitalInfoTable::address => $address);
        return $this->conn->execute(HospitalInfoSqlStatement::ADD, $data);
    }

    public function updateHospitalDetails($id, $name, $address){
        $data = array(HospitalInfoTable::hospital_info_id => $id, HospitalInfoTable::name => $name,
                      HospitalInfoTable::address => $address);
        return $this->conn->execute(HospitalInfoSqlStatement::UPDATE, $data);
    }
}