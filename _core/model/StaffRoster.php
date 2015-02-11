<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 2/11/15
 * Time: 3:19 PM
 */

class StaffRoster extends BaseModel {
    public function getUsersAndDepartment() {
        $stmt = ProfileSqlStatement::GET_USER_AND_DEPT;
        $data = array();
        return $this->conn->fetchAll($stmt, $data);
    }

    public function assignTask() {

    }
} 