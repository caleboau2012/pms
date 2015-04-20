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
        $sql = PatientSqlStatement::ADD;
        $result = $this->conn->execute($sql, $PatientData);
       // $result = $this->conn->getLastInsertedId();

        return $result;
        //return $PatientData;
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

    public function  getPatientDetails ($patient_id){
        $sql = PatientSqlStatement::GET;
        $result =$this->conn->fetch($sql, array(PatientTable::patient_id => $patient_id));
        return $result;
    }

    public function  getAllPatientDetails (){
        $sql = PatientSqlStatement::GET_ALL;
        $result =$this->conn->fetchAll($sql, array());
        return $result;
    }

    public function searchPatient($parameter) {
        $stmt = PatientSqlStatement::SEARCH;
        $data = array();
        $data[PARAMETER] = $parameter;
        $data[WILDCARD] = "%" . $parameter . "%";

        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getExistingPatientRegNos(){
        return $this->conn->fetchAll(PatientSqlStatement::GET_EXISTING_PATIENT_REG_NO, array());
    }

    public function isRegNumExisting($regNo){
        $data = array(PatientTable::regNo => strtoupper($regNo));
        $response = $this->conn->fetch(PatientSqlStatement::IS_REG_EXISTING, $data);
        if($response['result'] > 0){
            return true;
        } else {
            return false;
        }
    }
}