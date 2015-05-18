<?php

class HospitalDetailsController{
    private $hospitalDetails;

    public function __construct(){
        $this->hospitalDetails = new HospitalDetailsModel();
    }

    public function createHospitalDetails($name, $address){
        return $this->hospitalDetails->createHospitalDetails($name, $address);
    }

    public function updateHospitalDetails($name, $address){
        return $this->hospitalDetails->updateHospitalDetails($name, $address);
    }
}