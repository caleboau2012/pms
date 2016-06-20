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
    }
    public function periodAvailable($data) {
        return $this->conn->fetch(RosterSqlStatement::PERIOD_AVAILABLE, $data);
    }
   public function updateTask($data) {
        return $this->conn->execute(RosterSqlStatement::UPDATE, $data);
    }
    public function deleteTask($data) {
        return $this->conn->execute(RosterSqlStatement::DELETE_ROSTER, $data);
    }

    public function allStaffsRoster(){
        return $this->conn->fetchAll(RosterSqlStatement::GET_ALL, array());
    }
    public function allStaffRoster($params){
        return $this->conn->fetchAll(RosterSqlStatement::GET_BY_STAFF_ID, $params);
    }
} 