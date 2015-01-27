<?php

class StaffModel extends BaseModel{

    public function getStaff($regNo){
        return $this->conn->execute(ProfileSqlStatement::GET, $regNo);  /*Note: this uses 'userid' as the sql condition*/
    }

    public function getAllStaff($userType){
        return $this->conn->execute(ProfileSqlStatement::GET, array());  /*Note: this uses 'userid' as the sql condition*/
    }

    /*$userId, $surname, $firstName, $middleName,
    $workAddress, $homeAddress, $telephone,
    $birthDate, $sex, $height, $weight*/
    public function addProfile($profileData){
        return $this->conn->execute(ProfileSqlStatement::ADD, $profileData);
    }

    public function getProfile($regNo){
        return $this->conn->execute(ProfileSqlStatement::GET_PROFILE, $regNo);
    }

    /*$regNo, $passcode, $userType, $status*/
    public function addAuthInfo($authData){
        return $this->conn->execute(UserAuthSqlStatement::ADD, $authData);
    }

}