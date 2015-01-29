<?php

class StaffController{

    private $staff;

    public function __construct(){
        $this->staff = new StaffModel();
    }

    public function addStaff($regNo, $passcode, $status = INACTIVE){
        if (!($regNo && $passcode)){
            return false;
        }

        if ($this->staff->staffExists(array(UserAuthTable::regNo => $regNo))){
            return false;
        }

        $authData = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::status => $status);
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