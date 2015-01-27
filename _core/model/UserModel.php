<?php
class UserModel extends BaseModel {
    //public function verify($data) {
    //    //die(var_dump($this->conn));
    //    $stmt = UserAuthSqlStatement::VERIFY_USER;
    //    $result = $this->conn->fetch($stmt, $data);
    //    /*die(var_dump($result['count']));*/
    //    return intval($result['count']) == 1 ? true : false;
    //}
    public function verify($data) {
        $stmt = UserAuthSqlStatement::VERIFY_USER;
        $result = $this->conn->fetch($stmt, $data);
        /*die(var_dump($result['count']));*/
        //return intval($result['count']) == 1 ? true : false;
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

    public function getUserDetails($userid) {
        $stmt = UserAuthSqlStatement::GET_USER_BY_ID;
        $data = array();
        $data[UserAuthTable::userid] = $userid;
        $result = $this->conn->fetch($stmt, $data);
        return $result;
    }

    public function getUserRoles($userid) {
        $stmt = PermissionRoleSqlStatement::GET_STAFF_ROLE;
        $data = array();
        $data[PermissionRoleTable::userid] =  $userid;
        $result = $this->conn->fetchAll($stmt, $data);

        $user_role_array = array();
        foreach ($result as $role) {
            array_push($user_role_array, $role[PermissionRoleTable::staff_role_id]);
        }

        return $user_role_array;
    }
}