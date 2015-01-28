<?php

class StaffModel extends BaseModel{

    public function getStaff($regNo){
        return $this->conn->fetch(ProfileSqlStatement::GET, $regNo);  /*Note: this uses 'userid' as the sql condition*/
    }

    public function getAllStaff(){
        return $this->conn->fetchAll(UserAuthSqlStatement::GET_ALL, array());
    }

    /*$userId, $surname, $firstName, $middleName,
    $workAddress, $homeAddress, $telephone,
    $birthDate, $sex, $height, $weight*/
    public function addProfile($profileData){
        return $this->conn->execute(ProfileSqlStatement::ADD, $profileData);
    }

    public function getProfile($regNo){
        return $this->conn->fetch(ProfileSqlStatement::GET_PROFILE, $regNo);
    }

    /*$regNo, $passcode, $userType, $status*/
    public function addAuthInfo($authData){
        return $this->conn->execute(UserAuthSqlStatement::ADD, $authData);
    }

    public function getUserId($regNo){
        return $this->conn->fetch(UserAuthSqlStatement::GET_BY_REGNO, $regNo);
    }

    public function staffExists($regNo){
        if($this->getUserId($regNo))
            return true;
        return false;
    }
}