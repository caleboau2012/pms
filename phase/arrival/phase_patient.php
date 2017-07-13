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
else if ($intent == 'getAllEmergencyPatient') {
    $patientController = new PatientController();
    $result = $patientController->getEmergencyPatients();
    if(is_array($result)){
        echo JsonResponse::success($result);
        exit();
    } else {
        echo JsonResponse::error("Could not Find Emergency Patient. Please try again!");
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

else if ($intent == 'addPatient') { //working
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
//    $family_position="";
//    $mother_status="";
//    $father_status="";
    $marital_status="";
//    $no_of_children="";
    $occupation="";
    $allergies = "";
    $medical_history ="";
    $alcohol_usage ="";
    $tobacco_usage = "";
    $family_history = "";
    $surgical_history = "";

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
        $hmo=$_REQUEST[PatientTable::hmo];
        $registrationDate = $_REQUEST[PatientTable::registration_date];
        $marital_status=$_REQUEST[PatientTable::marital_status];
        $occupation =$_REQUEST[PatientTable::occupation];
        $allergies =$_REQUEST[PatientTable::allergies];
        $medical_history =$_REQUEST[PatientTable::medical_history];
        $alcohol_usage =$_REQUEST[PatientTable::alcohol_usage];
        $tobacco_usage =$_REQUEST[PatientTable::tobacco_usage];
        $family_history =$_REQUEST[PatientTable::family_history];
        $surgical_history =$_REQUEST[PatientTable::surgical_history];

    }
    else {
        echo JsonResponse::error(" Patient is not set");
        exit();
    }

    $patientadd = null;

    if (empty($surname) ||empty($firstname) || empty($middlename)||empty($regNo)||empty($home_address)|| empty($telephone)||empty($birth_date)||empty($nok_firstname)||empty($nok_middlename)||empty($nok_surname)||empty($nok_address)||empty($nok_telephone)
        ||empty($citizenship)||empty($religion)|| empty($marital_status) || empty ($occupation)
        || empty($allergies) || empty($medical_history) || empty($alcohol_usage) || empty($tobacco_usage) || empty($family_history) || empty($surgical_history)
    ){

//        print_r($_REQUEST);
        echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
        exit();
    }
    else{
        $patientadd = $patientController->addPatient (
            $surname, $firstname, $middlename, $regNo,
            $home_address, $telephone, $sex, $height, $weight,
            $birth_date, $nok_firstname, $nok_middlename,
            $nok_surname, $nok_address, $nok_telephone, $nok_relationship, $citizenship, $religion, $marital_status, $occupation, $hmo, $registrationDate,
            $allergies, $surgical_history, $family_history, $tobacco_usage, $medical_history, $alcohol_usage);
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
////////////Used to add emergency patient
else if ($intent == 'addEmergencyPatient') {  //working
    $patientController = new PatientController();



    $addEmerPat = $patientController->addEmergencyPatient();

    if($addEmerPat){

        $addEmerList = $patientController->addEmergencyPatientList( $addEmerPat);

        if ($addEmerList){


            $emergency_reg = EMER. $addEmerList;
            $emergencydata = array(PatientTable::patient_id=>$addEmerPat, PatientTable::regNo=>$emergency_reg);

            echo JsonResponse::success($emergencydata);
            exit();
        }
        else{
            echo  JsonResponse::error("Error registering to emergency list");
        }
    }
    else {
//        print_r($_REQUEST);
        JsonResponse::error("Error registering to patient list");
        exit();
    }
}

////////////////// upgrade emergency patient to Real patient
else if ($intent == 'ManagePatient') { //working

    $patientController = new PatientController();

    $patient_id = "";
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
    $hmo = "";
    $religion="";
//    $family_position="";
//    $mother_status="";
//    $father_status="";
    $marital_status="";
//    $no_of_children="";
    $occupation="";
    $allergies = "";
    $medical_history ="";
    $alcohol_usage ="";
    $tobacco_usage = "";
    $family_history = "";
    $surgical_history = "";

    if (isset($_REQUEST[PatientTable::patient_id])) {  // change surname to what you thin should be set.

        // var_dump($_REQUEST);

        $patient_id = $_REQUEST[PatientTable::patient_id];

        //check if the emergency patient has not been previously upgraded.

        $result = $patientController->checkEmergencyStatus($patient_id); // return  the status, 1 active, 2 upgraded, 3 treatment...

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
        $hmo=$_REQUEST[PatientTable::hmo];
        $registrationDate = $_REQUEST[PatientTable::registration_date];
        $marital_status=$_REQUEST[PatientTable::marital_status];
        $occupation =$_REQUEST[PatientTable::occupation];
        $allergies =$_REQUEST[PatientTable::allergies];
        $medical_history =$_REQUEST[PatientTable::medical_history];
        $alcohol_usage =$_REQUEST[PatientTable::alcohol_usage];
        $tobacco_usage =$_REQUEST[PatientTable::tobacco_usage];
        $family_history =$_REQUEST[PatientTable::family_history];
        $surgical_history =$_REQUEST[PatientTable::surgical_history];

        if (empty($surname) ||empty($firstname) || empty($middlename)||empty($regNo)||empty($home_address)|| empty($telephone)||empty($birth_date)||empty($nok_firstname)||empty($nok_middlename)||empty($nok_surname)||empty($nok_address)||empty($nok_telephone)
            ||empty($citizenship)||empty($religion)|| empty($marital_status) || empty ($occupation) || empty($hmo)
            || empty($allergies) || empty($medical_history) || empty($alcohol_usage) || empty($tobacco_usage) || empty($family_history) || empty($surgical_history)
        ){
            print_r($_REQUEST);
            echo JsonResponse::error("Some fields are not filled, Ensure All fields are filled");
            exit();
        } else {
            $patientUp = $patientController->EditPatientInfo(
                $surname, $firstname, $middlename, $regNo,
                $home_address, $telephone, $sex, $height, $weight,
                $birth_date, $nok_firstname, $nok_middlename,
                $nok_surname, $nok_address, $nok_telephone, $nok_relationship, $citizenship, $religion, $marital_status, $occupation, $patient_id, $hmo, $registrationDate,
                $allergies, $surgical_history, $family_history, $tobacco_usage, $medical_history, $alcohol_usage);
        }

        if ($patientUp) {
            if($result[EmergencyTable::emergency_status_id] == 1){
                // change status of emergency table of emergency patient from 1 to 2;

                //create new Editinfo for updating emergency to enable rollback functionality.
                $status = 2;
                $emergencyreg = $patient_id;

                $change = $patientController->changeEmergencyStatus($emergencyreg, 2);

                if($change){
                    echo JsonResponse::message(1, "Emergency Patient sucessfully upgraded");
                    exit();
                }

            }

            echo JsonResponse::message(1, "Patient sucessfully updated");
            exit();
        } else {
            echo JsonResponse::error("Error upgrading patient.");
            exit();
        }


    } else {
        echo JsonResponse::error("Patient not set");
    }
}
//
//Edit patient info


//



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
} elseif($intent == 'verifyRegNo') {
    $regNo = $_REQUEST['regNo'];
    if($regNo){
        $patientController = new PatientController();
        if(!$patientController->regNoExists($regNo)){
            echo JsonResponse::success("Registration number does not exist");
            exit();
        } else {
            echo JsonResponse::error("Registration number already exists.");
            exit();
        }
    } else {
        echo JsonResponse::error("No registration number entered");
        exit();
    }
} else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}