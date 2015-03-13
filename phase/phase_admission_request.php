<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'AdmissionModel', 'RoleModel'));
Crave::requireFiles(CONTROLLER, array('AdmissionController', 'RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'requestAdmission') {
    $userid = CxSessionHandler::getItem(UserAuthTable::userid);
    if (!RoleController::hasRole($userid, DOCTOR)) {
        echo JsonResponse::error("User does not have privilege to request admission.");
        exit();
    }

    if (isset($_REQUEST[TreatmentTable::treatment_id])) {
        $response = AdmissionController::requestAdmission($_REQUEST[TreatmentTable::treatment_id]);
        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Admission request successful!");
            exit();
        } else {
            echo JsonResponse::error("Unable to request admission!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'getAdmissionRequests') {
    $response = AdmissionController::admissionRequests();
    
    if (is_array($response)) {
        if (isset($response[P_MESSAGE])) {
            echo JsonResponse::message($response[P_STATUS], $response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::success($response[P_DATA]);
            exit();            
        }
    } else {
        echo JsonResponse::error("Unable to get pending admission requests!");
        exit();
    }
} elseif ($intent == 'searchAdmissionRequests') {
    if (isset($_REQUEST[TERM])) {
        $warden = new AdmissionController();
        $patient_details = $warden->searchAdmissionRequests($_REQUEST[TERM]);      
        if (is_array($patient_details)) {
            echo json_encode($patient_details);
            exit();
        } else {
            echo JsonResponse::error("No patients match the search parameter!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
}