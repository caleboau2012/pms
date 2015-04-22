<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 1/27/15
 * Time: 8:20 AM
 * To change this template use File | Settings | File Templates.
 */


//require_once '../_core/global/_require.php';


//Crave::requireAll(GLOBAL_VAR);
//Crave::requireAll(UTIL);
//Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'PatientModel'));



class PatientController {

    private $patient;

    public function __construct (){
        $this->patient = new PatientModel();
    }

//VALUES (LOWER(:surname), LOWER(:firstname), LOWER(:middlename), :regNo, :home_address, :telephone, :sex, :height, :weight, :birth_date, :nok_firstname,
//:nok_middlename, :nok_surname, :nok_address, :nok_telephone, :nok_relationship, NOW(), NOW() )';

    public function  addPatient (
        $surname, $firstname, $middlename, $regNo,
        $home_address, $telephone, $sex, $height, $weight,
        $birth_date, $nok_firstname, $nok_middlename,
        $nok_surname, $nok_address, $nok_telephone, $nok_relationship,$citizenship, $religion, $family_position,
        $mother_status, $father_status, $marital_status, $no_of_children )
    {


        //$patient = new PatientModel();
        $data = array(

            PatientTable::surname => $surname,
            PatientTable::firstname => $firstname,
            PatientTable::middlename => $middlename,
            PatientTable::regNo => $regNo,
            PatientTable::home_address => $home_address,
            PatientTable::telephone => $telephone,
            PatientTable::sex => $sex,
            PatientTable::height => $height,
            PatientTable::weight => $weight,
            PatientTable::birth_date => $birth_date,
            PatientTable::nok_firstname => $nok_firstname,
            PatientTable::nok_middlename => $nok_middlename,
            PatientTable::nok_surname => $nok_surname,
            PatientTable::nok_address => $nok_address,
            PatientTable::nok_telephone => $nok_telephone,
            PatientTable::nok_relationship => $nok_relationship,
            PatientTable::citizenship => $citizenship,
            PatientTable::religion => $religion,
            PatientTable::family_position => $family_position,
            PatientTable::mother_status => $mother_status,
            PatientTable::father_status=> $father_status,
            PatientTable::marital_status => $marital_status,
            PatientTable::no_of_children =>$no_of_children


        );

        // var_dump($data);

        $result = $this->patient->InsertPatient($data);
//        var_dump($result);

        //var_dump($result);

        return $result;

    }

    public function addEmergencyPatient(){

        return $this->patient->addEmergencyPatient();

    }

    public function addEmergencyPatientList($addEmerPat){

        return $this->patient->RegEmergencyPatient($addEmerPat);

    }

    public function checkEmergencyStatus($patient_id){
        return $this->patient->verifyEmergencyStatus ($patient_id);
    }

    public function changeEmergencyStatus($emergency, $status){
        return $this->patient->changeStatus($emergency, $status);
    }

    public function  EditPatientInfo (
        $surname, $firstname, $middlename, $regNo,
        $home_address, $telephone, $sex, $height, $weight,
        $birth_date, $nok_firstname, $nok_middlename,
        $nok_surname, $nok_address, $nok_telephone, $nok_relationship,$citizenship, $religion, $family_position,
        $mother_status, $father_status, $marital_status, $no_of_children, $patient_id  ){

        $data = array(

            PatientTable::surname => $surname,
            PatientTable::firstname => $firstname,
            PatientTable::middlename => $middlename,
            PatientTable::regNo => $regNo,
            PatientTable::home_address => $home_address,
            PatientTable::telephone => $telephone,
            PatientTable::sex => $sex,
            PatientTable::height => $height,
            PatientTable::weight => $weight,
            PatientTable::birth_date => $birth_date,
            PatientTable::nok_firstname => $nok_firstname,
            PatientTable::nok_middlename => $nok_middlename,
            PatientTable::nok_surname => $nok_surname,
            PatientTable::nok_address => $nok_address,
            PatientTable::nok_telephone => $nok_telephone,
            PatientTable::nok_relationship => $nok_relationship,
            PatientTable::citizenship => $citizenship,
            PatientTable::religion => $religion,
            PatientTable::family_position => $family_position,
            PatientTable::mother_status => $mother_status,
            PatientTable::father_status=> $father_status,
            PatientTable::marital_status => $marital_status,
            PatientTable::no_of_children =>$no_of_children,
            PatientTable::patient_id =>$patient_id
        );

        //$patient = new PatientModel();
        return $this->patient->UpdatePatientInfo($data);

    }

    public function  EditPatientBasicInfo ($data ){

        $patient = new PatientModel();
        return $patient->UpdatePatientBasicInfo($data);

    }

    public function  retrievePatientInfo ($patient_id ){

        return $this->patient->getPatientDetails($patient_id);

    }

    public function  retrieveAllPatientInfo ( ){

        return $this->patient->getAllPatientDetails();

    }

    public function  getExistingPatientRegNos(){
        return $this->patient->getExistingPatientRegNos();
    }

    public function regNoExists($regNo){
        return $this->patient->isRegNumExisting($regNo);
    }
}
