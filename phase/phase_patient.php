<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ODUGUWA A
 * Date: 1/30/15
 * Time: 6:00 AM
 * To change this template use File | Settings | File Templates.
 */

require_once '../_core/global/_require.php';
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
        $patient_list = $patientController->RetrieveAllPatientInfo();

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
    $patient_list = $patientController->RetrievePatientInfo($patient_id);

    if(is_array($patient_list)){
        echo JsonResponse::success($patient_list);
        exit();
    } else {
        echo JsonResponse::error("Could not Find any Patient. Please try again!");
        exit();
    }

}

else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}