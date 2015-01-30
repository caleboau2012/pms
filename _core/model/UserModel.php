<?php
class UserModel extends BaseModel {

    public function getStaff($regNo){
        return $this->conn->fetch(ProfileSqlStatement::GET, array(UserAuthTable::regNo => $regNo));
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
        return $this->conn->fetch(ProfileSqlStatement::GET_PROFILE, array(UserAuthTable::regNo => $regNo));
    }

    /*$regNo, $passcode, $status*/
    public function addAuthInfo($authData){
        return $this->conn->execute(UserAuthSqlStatement::ADD, $authData);
    }

    public function getUserId($regNo){
        return $this->conn->fetch(UserAuthSqlStatement::GET_BY_REGNO, array(UserAuthTable::regNo => $regNo));
    }

    public function staffExists($regNo){
        if($this->getUserId($regNo))
            return true;
        return false;
    }

    public function getByCredentials($data) {
        $stmt = UserAuthSqlStatement::GET_USER_BY_CREDENTIALS;
        $result = $this->conn->fetch($stmt, $data);
        return $result;
    }

    public function flagUserOnline($userid) {
        $stmt = UserAuthSqlStatement::FLAG_USER_ONLINE;
        $data = array();
        $data[UserAuthTable::userid] = $userid;

        $result = $this->conn->execute($stmt, $data);
        return $result;
    }

    public function flagUserOffline($userid) {
        $stmt = UserAuthSqlStatement::FLAG_USER_OFFLINE;
        $data = array();
        $data[UserAuthTable::userid] = $userid;

        $result = $this->conn->execute($stmt, $data);
        return $result;
    }

    public function getUserDetails($userid) {
        $stmt = UserAuthSqlStatement::GET_USER_BY_ID;
        $data = array();
        $data[UserAuthTable::userid] = $userid;
        $result = $this->conn->fetch($stmt, $data);
        return $result;
    }

    public function changePassword($data) {
        $stmt = UserAuthSqlStatement::CHANGE_PASSCODE;
        $result = $this->conn->execute($stmt, $data, true);

        return $result;
    }

    public function getUserRoles($userid) {
        $stmt = PermissionRoleSqlStatement::GET_STAFF_ROLE;
        $data = array();
        $data[PermissionRoleTable::userid] =  $userid;
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getAllRoles() {
        $stmt = PermissionRoleSqlStatement::GET_ALL_ROLES;
        $data = array();
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getStatus($userid) {
        $stmt = UserAuthSqlStatement::GET_STATUS;
        $data = array();
        $data[UserAuthSqlStatement::GET_STATUS] = $userid;

        $result = $this->conn->fetch($stmt, $data);

        return $result;
    }
}