<?php
class UserModel extends BaseModel {
    public function verify($data) {
        //die(var_dump($this->conn));
        $stmt = UserAuthSqlStatement::VERIFY_USER;
        $result = $this->conn->fetch($stmt, $data);
        /*die(var_dump($result['count']));*/
        return intval($result['count']) == 1 ? true : false;
    }
    public function verify($data) {
        $stmt = UserAuthSqlStatement::VERIFY_USER;
        $result = $this->conn->fetch($stmt, $data);
        /*die(var_dump($result['count']));*/
        return intval($result['count']) == 1 ? true : false;
    }

    public function getByCredentials($data) {
        $stmt = UserAuthSqlStatement::GET_BY_CREDENTIALS;
        $result = $this->conn->fetch($stmt, $data);

        return $result;
    }

    public function flagUserOnline($userid) {
        $stmt = UserAuthSqlStatement::FLAG_USER_ONLINE;
        $result = $this->conn->execute($stmt, $userid);
    }

    public function getUserDetails($userid) {
        $stmt = UserAuthSqlStatement::GET_DETAILS_BY_ID;
        $result = $this->conn->fetch($stmt, $userid);

        return $result;
    }
}