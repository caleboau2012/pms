<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel'));
Crave::requireFiles(CONTROLLER, array());

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'search') {
    //Search and retrieve patient details if patient is not already on queue
    if (isset($_REQUEST['parameter'])) {
        $usher = new ArrivalController();
        $patient_details = $usher->searchPatient($_REQUEST['parameter']);
        if (is_array($patient_details)) {
            echo JsonResponse::success($patient_details);
            exit();
        } else {
            echo JsonResponse::error("No patient matches your search request!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
    }
} else {
    echo JsonResponse::error("Invalid intent");
    exit();
}