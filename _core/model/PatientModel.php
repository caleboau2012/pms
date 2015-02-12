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

    public function  GetPatientDetails ($patient_id){
        $sql = PatientSqlStatement::GET;
        $result =$this->conn->fetch($sql, array(PatientTable::patient_id => $patient_id));
        return $result;
    }

    public function  GetAllPatientDetails (){
        $sql = PatientSqlStatement::GET_ALL;
        $result =$this->conn->fetchAll($sql, array());
        return $result;
    }

    public function searchPatient($parameter) {
        $stmt = PatientSqlStatement::SEARCH;
        $data = array();
        $data[PARAMETER] = $parameter;
        $data[WILDCARD] = "%" . $parameter . "%";

        //die(var_dump($data));
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }
}