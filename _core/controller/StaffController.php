<?php

class StaffController{

    private $staff;

    public function __construct(){
        $this->staff = new StaffModel();
    }

    public function addStaff($regNo, $passcode, $status = 1){
        if (!($regNo && $passcode)){
            return false;
        }
        $authData = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => $status);
        die(var_dump($authData));
        return $this->staff->addAuthInfo($authData);
    }

    public function updateStaff($profileInfo){
        $profile = $profileInfo;
        $profile[UserAuthTable::userid] = $this->getUserId($profileInfo[UserAuthTable::regNo]);
        return $this->staff->addProfile($profile);
    }

    public function getStaff($regNo){
        $this->staff->getStaff($regNo);
    }

    public function getAllStaff(){
        return $this->staff->getAllStaff();
    }

}