<?php
class UserModel extends BaseModel {

    public function getUser($regNo){
        return $this->conn->fetch(ProfileSqlStatement::GET, array(UserAuthTable::regNo => $regNo));
    }

    public function getAllUsers(){
        return $this->conn->fetchAll(UserAuthSqlStatement::GET_ALL, array());
    }

    /*$userId, $surname, $firstName, $middleName,
    $workAddress, $homeAddress, $telephone,
    $birthDate, $sex, $height, $weight*/
    public function addProfile($profileData){
        return $this->conn->execute(ProfileSqlStatement::ADD, $profileData);
    }

    public function updateProfile($profileData){
        return $this->conn->execute(ProfileSqlStatement::UPDATE, $profileData);
    }

    public function getProfile($regNo){
        return $this->conn->fetch(ProfileSqlStatement::GET_PROFILE, array(UserAuthTable::regNo => $regNo));
    }

    public function getUserProfile($userid){
        return $this->conn->fetch(ProfileSqlStatement::GET_USER_PROFILE, array(UserAuthTable::userid => $userid));
    }

    public function deleteUser($userid){
        return $this->conn->execute(UserAuthSqlStatement::DELETE, array(UserAuthTable::userid => $userid));
    }

    public function restoreUser($userid){
        return $this->conn->execute(UserAuthSqlStatement::RESTORE_USER, array(UserAuthTable::userid => $userid));
    }

    /*$regNo, $passcode, $status*/
    public function addAuthInfo($authData){
        return $this->conn->execute(UserAuthSqlStatement::ADD, $authData);
    }

    public function getUserId($regNo){
        return $this->conn->fetch(UserAuthSqlStatement::GET_BY_REGNO, array(UserAuthTable::regNo => $regNo));
    }

    public function userExists($regNo){
        if($this->getUserId($regNo))
            return true;
        return false;
    }

    public function getDoctorNameById($doctorId){
        $data = array(UserAuthTable::userid => $doctorId);
        $result = $this->conn->fetchAll(ProfileSqlStatement::GET_DOCTOR_NAME_BY_ID, $data);
        if(is_array($result)){
            return $result[ProfileTable::surname] + " " + $result[ProfileTable::firstname] + " " + $result[ProfileTable::middlename];
        } else {
            return "No name";
        }
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

    public function autoLogout($inactive_users) {
        $stmt = UserAuthSqlStatement::AUTO_LOGOUT;
        $_inactive = '';
        foreach ($inactive_users as $userid) {
            $_inactive = $_inactive . $userid . ', ';
        }

        // remove the last ', ' from the end of the string
        $_inactive = substr($_inactive, 0, -2);

        $data = array(
            'inactive_users'    =>  $_inactive
        );

        $status = $this->conn->execute($stmt, $data);
//        die(var_dump("logged out user" , $status));
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

    public function updateStatus($userid, $status){
        $data = array();
        $data[UserAuthTable::userid] = $userid;
        $data[UserAuthTable::status] = $status;

        return $this->conn->execute(UserAuthSqlStatement::UPDATE_STATUS, $data);
    }

    public function searchByName($userid, $name) {
        $stmt = ProfileSqlStatement::SEARCH_BY_NAME;

        $name = "%" . $name . "%";
        $data = array();
        $data[NAME] = $name;
        $data[ProfileTable::userid] = $userid;

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }
}