<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 2/11/15
 * Time: 3:19 PM
 */

class StaffRoster extends BaseModel {

    public function getDepartments(){
        return $this->conn->fetchAll(DepartmentSqlStatment::GET_ALL, array());
    }

    public function assignTask($data) {
        return $this->conn->execute(RosterSqlStatement::ADD, $data);
    }

    public function modifyTask($data){
        return $this->conn->execute(RosterSqlStatement::UPDATE, $data);
    }
} 