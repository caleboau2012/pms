<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 2/11/15
 * Time: 3:19 PM
 */

class StaffRoster extends BaseModel {
    /* There is a method in UserModel that does this */
    /*public function getUsersAndDepartment() {
        $stmt = ProfileSqlStatement::GET_USER_AND_DEPT;
        $data = array();
        return $this->conn->fetchAll($stmt, $data);
    }*/

    public function getDepartments(){
        return $this->conn->fetchAll(DepartmentSqlStatment::GET_ALL, array());
    }

    public function assignTask($data) {
        return $this->conn->execute(RosterSqlStatement::ADD, $data);
//        return $data;
    }

    public function allStaffRoster(){
        return $this->conn->fetchAll(RosterSqlStatement::GET_ALL, array());
    }
} 