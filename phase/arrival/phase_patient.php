<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 1/30/15
 * Time: 6:00 AM
 * To change this template use File | Settings | File Templates.
 */

require_once '../../_core/global/_require.php';
Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'PatientModel'));
Crave::requireFiles(CONTROLLER, array('AuthenticationController'));
Crave::requireFiles(CONTROLLER, array('PatientController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getAllPatients') {
        $patientController = new PatientController();
        $patient_list = $patientController->retrieveAllPatientInfo();

        if(is_array($patient_list)){
            echo JsonResponse::success($patient_list);
            exit();
        } else {
            echo JsonResponse::error("Could not Find any Patient. Please try again!");
            exit();
        }

}
else if ($intent == 'getPatient') {
    $patientController = new PatientController();
    if (isset($_REQUEST['patientId'])){
        $patient_id = $_REQUEST['patientId'];
    }
    else{
        echo JsonResponse::error("Patient Id not Set");
        exit();
    }
    $patient_list = $patientController->retrievePatientInfo($patient_id);

    if(is_array($patient_list)){
        echo JsonResponse::success($patient_list);
        exit();
    } else {
        echo JsonResponse::error("Could not Find any Patient. Please try again!");
        exit();
    }


}

else if ($intent == 'addPatient') {
    $patientController = new PatientController();

    $surname ="";
    $firstname ="";
    $middlename ="";
    $regNo ="";
    $home_address= "";
    $telephone ="";
    $sex ="";
    $height ="";
    $weight ="";
    $birth_date = "";
    $nok_firstname ="";
    $nok_middlename = "";
    $nok_surname = "";
    $nok_address = "";
    $nok_telephone = "";
    $nok_relationship  ="";
    $citizenship ="";
    $religion="";
    $family_position="";
    $mother_status="";
    $father_status="";
    $marital_status="";
    $no_of_children="";

    if (isset($_REQUEST['surname'])){  // change surname to what you thin should be set.

       // var_dump($_REQUEST);

        $surname =$_REQUEST[PatientTable::surname];
        $firstname =$_REQUEST[PatientTable::firstname];
        $middlename =$_REQUEST[PatientTable::middlename];
        $regNo =$_REQUEST[PatientTable::regNo];
        $home_address= $_REQUEST[PatientTable::home_address];
        $telephone =$_REQUEST[PatientTable::telephone];
        $sex =$_REQUEST[PatientTable::sex];
        $height =$_REQUEST[PatientTable::height];
        $weight =$_REQUEST[PatientTable::weight];
        $birth_date = $_REQUEST[PatientTable::birth_date];
        $nok_firstname = $_REQUEST[PatientTable::nok_firstname];
        $nok_middlename = $_REQUEST[PatientTable::nok_middlename];
        $nok_surname = $_REQUEST[PatientTable::nok_surname];
        $nok_address = $_REQUEST[PatientTable::nok_address];
        $nok_telephone = $_REQUEST[PatientTable::nok_telephone];
        $nok_relationship  = $_REQUEST[PatientTable::nok_relationship];
        $citizenship =$_REQUEST[PatientTable::citizenship];
        $religion=$_REQUEST[PatientTable::religion];
        $family_position=$_REQUEST[PatientTable::family_position];
        $mother_status=$_REQUEST[PatientTable::mother_status];
        $father_status=$_REQUEST[PatientTable::father_status];
        $marital_status=$_REQUEST[PatientTable::marital_status];
        $no_of_children=$_REQUEST[PatientTable::no_of_children];

    }
    else {
        echo JsonResponse::error(" Patient is not set");
        exit();
    }

    $patientadd = null;

    if (empty($surname) ||empty($firstname) || empty($middlename)||empty($regNo)||empty($home_address)|| empty($telephone)||empty($birth_date)||empty($nok_firstname)||empty($nok_middlename)||empty($nok_surname)||empty($nok_address)||empty($nok_telephone)
        ||empty($citizenship)||empty($religion)||empty($mother_status)||empty($father_status)||empty($marital_status)){

        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{
        $patientadd = $patientController->addPatient (
            $surname, $firstname, $middlename, $regNo,
            $home_address, $telephone, $sex, $height, $weight,
            $birth_date, $nok_firstname, $nok_middlename,
            $nok_surname, $nok_address, $nok_telephone, $nok_relationship,$citizenship, $religion, $family_position,
            $mother_status, $father_status, $marital_status, $no_of_children );
    }

    if($patientadd){
        echo JsonResponse::success($patientadd);
        exit();
    } else {
//        print_r($_REQUEST);
        echo JsonResponse::error("Error adding patient info");
        exit();
    }

}
elseif($intent == 'getRegNos'){
    $patientController = new PatientController();
    $regNos = $patientController->getExistingPatientRegNos();
    if(is_array($regNos)){
        echo JsonResponse::success($regNos);
        exit();
    } else {
        echo JsonResponse::error("Not available");
        exit();
    }
}
elseif($intent == 'verifyRegNo'){
    $regNo = $_REQUEST['regNo'];
    $patientController = new PatientController();

    if($regNo){
        if(!$patientController->regNoExists($regNo)){
            echo JsonResponse::success("Registration number does not exist");
            exit();
        } else {
            echo JsonResponse::error("Registration number already exists.");
            exit();
        }
    } else {
        echo JsonResponse::error("No registration number entered");
    }

}

else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}