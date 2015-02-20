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

        if (!empty($prescription['data'])) {
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
} elseif ($intent == 'clearPrescription') {
    if($data = isset($_REQUEST['data']) ? $_REQUEST['data'] : null){         // Please check if this works correctly

        $isCleared = (new PharmacistController())->clearPrescription($data);

        if ($isCleared){
            echo JsonResponse::success("Successfully cleared!");
            exit();
        } else {
            echo JsonResponse::error("Clearing Unsuccessful. Try again Later.");
            exit();
        }
    } else {
        echo JsonResponse::error("There are no prescriptions to clear");
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