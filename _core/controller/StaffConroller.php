<?php

class StaffController{

    private $staff;

    public function __construct(){
        $this->staff = new StaffModel();
    }

    public function addStaff($authData, $profileData){
        $this->staff->addStaff($authData, $profileData);
    }

    public function getStaff($data){
        $this->staff->getStaff($data);
    }

}