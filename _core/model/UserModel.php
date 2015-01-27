<?php
class UserModel extends BaseModel {

  public function verify($data) {
    $stmt = UserAuthSqlStatement::VERIFY_USER;
    $result = $this->conn->fetch($stmt, $data);
    /*die(var_dump($result['count']));*/
    return intval($result['count']) == 1 ? true : false;
  }
}