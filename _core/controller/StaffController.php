<?php

class StaffController{

    private $staff;

    public function __construct(){
        $this->staff = new StaffModel();
    }

    public function addStaff($regNo, $passcode, $usertype, $status = 1){
        if (!($regNo && $passcode)){
            return false;
        }

        if ($this->staff->staffExists(array(UserAuthTable::regNo => $regNo))){
            return false;
        }

        $authData = array(UserAuthTable::regNo => $regNo, UserAuthTable::passcode => $passcode, UserAuthTable::usertype => $usertype, UserAuthTable::status => $status);
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