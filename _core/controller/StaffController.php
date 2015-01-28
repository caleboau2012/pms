<?php

class StaffController{

    private $staff;

    public function __construct(){
        $this->staff = new StaffModel();
    }

    public function addStaff($authData){
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
        $result = array();

        $params = array('usertype'=> STAFF);
        $result["staff"] = $this->staff->getAllStaff($params);
        unset($params['usertype']);

        $params = array('usertype'=> ADMIN);
        $result["admin"] = $this->staff->getAllStaff($params);

        return $result;
    }

}