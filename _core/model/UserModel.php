<?php
class UserModel extends BaseModel {
    public function verify($data) {
//        die(var_dump($this->conn));
        $stmt = UserAuthSqlStatement::VERIFY_USER;
        $result = $this->conn->fetch($stmt, $data);
        /*die(var_dump($result['count']));*/
        return intval($result['count']) == 1 ? true : false;
    }
}