<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 1/27/15
 * Time: 6:13 AM
 * To change this template use File | Settings | File Templates.
 */

class PatientModel extends BaseModel {

    /*Insert Operations*/

    public function  InsertPatient ($PatientData){
        $sql = ProfileSqlStatement::ADD;
        $result = $this->conn->execute($sql, $PatientData);
        return $result;
    }

    public function  UpdatePatientInfo ($newPatientData){
        $sql = ProfileSqlStatement::UPDATE;
        $result = $this->conn->execute($sql, $newPatientData);
        return $result;
    }

    public function UpdatePatientBasicInfo ($newPatientData){
        $sql =ProfileSqlStatement::UPDATE_BASIC_INFO;
        $result = $this->conn->execute($sql, $newPatientData);
        return $result;
    }


    /*Fetch Operation*/

    public function  GetPatientDetails ($Patient_data){
        $sql = ProfileSqlStatement::GET;
        $result =$this->conn->fetch($sql, $Patient_data);
        return $result;
    }

    public function  GetAllPatientDetails ($Patient_data){
        $sql = ProfileSqlStatement::GET
        $result =$this->conn->fetch($sql, $Patient_data);
        return $result;
    }


}