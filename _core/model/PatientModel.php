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
//        print_r($this->conn->execute($sql, $PatientData)->errorInfo());
//        (var_dump($PatientData));
        $result = $this->conn->getLastInsertedId();

        return $result;
        //return $PatientData;
    }

    public function  UpdatePatientInfo ($newPatientData){
        $sql = PatientSqlStatement::UPDATE;
        $result = $this->conn->execute($sql, $newPatientData);
        return $result;
    }

    public function UpdatePatientBasicInfo ($newPatientData){
        $sql = PatientSqlStatement::UPDATE_BASIC_INFO;
        $result = $this->conn->execute($sql, $newPatientData);
        return $result;
    }
///////////////////

    public function addEmergencyPatient (){
        $sql = PatientSqlStatement::ADD_EMERGENCY;
        $result = $this->conn->execute($sql, array());

        $data2 = $this->conn->getLastInsertedId();

        if ($data2){
            $sql = PatientSqlStatement::UPDATE_EMER_REGNO;
            $data3 = array(PatientTable::regNo=> EMER.$data2, PatientTable::patient_id =>$data2);
            $this->conn->execute($sql, $data3);
            return $data2;
        }

    }

    public function getEmergencyPatients (){
        $sql = EmergencySqlStatement::GET_EMERGENCY;
        $result = $this->conn->fetchAll($sql, array());
        return $result;
    }

    public function RegEmergencyPatient ($data){
        $sql = EmergencySqlStatement::REG_EMERGENCY;
        $result = $this->conn->execute($sql, array(PatientTable::patient_id=>$data));
        return $this->conn->getLastInsertedId();
    }

    public function verifyEmergencyStatus ($data){
        $sql = EmergencySqlStatement::VERIFY_EMERGENCY;
        $result = $this->conn->fetch($sql,array(PatientTable::patient_id=>$data));
        return $result;
    }

    public function changeStatus($emergency, $status){
        $sql = EmergencySqlStatement::CHANGE_STATUS;
       // echo 'status' . $status;
        $result = $this->conn->execute($sql,array(EmergencyTable::emergency_status_id=>$status, EmergencyTable::patient_id=>$emergency));
        return $result;
    }

/////////////////


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

        //die(var_dump($data));
        $result = $this->conn->fetchAll($stmt, $data);

        return $result;
    }

    public function getExistingPatientRegNos(){
        return $this->conn->fetchAll(PatientSqlStatement::GET_EXISTING_PATIENT_REG_NO, array());
    }

    public function isRegNumExisting($regNo){
        $data = array(PatientTable::regNo => strtoupper($regNo));
        $response = $this->conn->fetch(PatientSqlStatement::IS_REG_EXISTING, $data);
        return $response['result'] > 0;
    }

    public function getPatientByTreatmentId($treatmentId){
        $data = array(TreatmentTable::treatment_id => $treatmentId);
        return $this->conn->fetch(PatientSqlStatement::GET_BY_TMT_ID, $data);
    }

    public function getAvailableHMO(){
        return $this->conn->fetchAll(PatientSqlStatement::GET_AVAILABLE_HMO, array());
    }
}
