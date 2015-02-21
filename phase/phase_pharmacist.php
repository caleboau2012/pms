<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'PatientModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('PharmacistController'));


if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getPatientQueue') {
    // Retrieve Out Patient Queue
    $queue = (new PharmacistController())->getPatientQueue();

    if (is_array($queue) && !empty($queue)) {
        echo JsonResponse::success($queue);
        exit();
    } else {
        echo JsonResponse::error("No patient on queue");
        exit();
    }
} elseif ($intent == 'getPrescription') {
    if($treatmentId = isset($_REQUEST['treatmentId']) ? $_REQUEST['treatmentId'] : null){         // Please check if this works correctly

        // Retrieve Patient Prescription
        $prescription = (new PharmacistController())->getPrescription($treatmentId);

        if (is_array($prescription) && !empty($prescription)) {
            echo JsonResponse::success($prescription);
            exit();
        } else {
            echo JsonResponse::error("No prescription for this patient");
            exit();
        }
    } else {
        echo JsonResponse::error("There was no treatment session with this patient");
        exit();
    }
} elseif($intent == 'getDrugs'){

    $drugs = (new PharmacistController())->getDrugs();

    if(is_array($drugs) && !empty($drugs)){
        echo JsonResponse::success($drugs);
        exit();
    } else {
        echo JsonResponse::error("No drug");
    }

} elseif($intent == 'getUnits'){

    $units = (new PharmacistController())->getUnits();

    if(is_array($units) && !empty($units)){
        echo JsonResponse::success($drugs);
        exit();
    } else {
        echo JsonResponse::error("No unit available");
    }

} elseif ($intent == 'clearPrescription') {
    $pharmacist_id = isset($_REQUEST['userId']) ? $_REQUEST['userid'] : null;
    $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;

    if($pharmacist_id && $data){

        $isCleared = (new PharmacistController())->clearPrescription($pharmacist_id, $data);

        if ($isCleared){
            echo JsonResponse::success("Successfully cleared!");
            exit();
        } else {
            echo JsonResponse::error("Clearing Unsuccessful. Retry.");
            exit();
        }
    } elseif(!$data) {
        echo JsonResponse::error("There are no prescriptions to clear");
        exit();
    } else {
        echo JsonResponse::accessDenied();
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent");
    exit();
}


/*elseif ($intent == 'getInPatientQueue') {
    // Retrieve In-Patient Queue
    $queue = (new PharmacistController())->getInPatientQueue();

    if (is_array($queue)) {
        echo JsonResponse::success($queue);
        exit();
    } else {
        echo JsonResponse::error("No in-patient on queue");
        exit();
    }
}*/