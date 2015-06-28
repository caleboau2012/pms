<?php

class HospitalDetailsController{
    private $hospitalDetails;

    public function __construct(){
        $this->hospitalDetails = new HospitalDetailsModel();
    }

    public function getHospitalDetails(){
        return $this->hospitalDetails->getHospitalDetails();
    }

    public function createHospitalDetails($name, $address){
        return $this->hospitalDetails->createHospitalDetails($name, $address);
    }

    public function updateHospitalDetails($id, $name, $address){
        return $this->hospitalDetails->updateHospitalDetails($id, $name, $address);
    }
}