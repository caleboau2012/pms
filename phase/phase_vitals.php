<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'VitalsModel'));
Crave::requireFiles(CONTROLLER, array('VitalsController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error("Intent not set!");
    exit();
}

if ($intent == 'addVitals') {
    if (isset($_POST[VitalsTable::patient_id], $_POST[VITALS])) {
        $added_by = CxSessionHandler::getItem(UserAuthTable::userid);

        $vitals_data = $_POST[VITALS];
        $valid_vitals = VitalsController::validateVitals($vitals_data);


        if (is_array($valid_vitals)) {
            $vitals_data = $valid_vitals;
        } else {
            echo JsonResponse::error("Invalid vitals data!");
            exit();
        }

        $vitals_data[VitalsTable::patient_id] = $_POST[VitalsTable::patient_id];

        $nurse = new VitalsController();

        $response = $nurse->addVitals($vitals_data, $added_by);

        if ($response) {
            echo JsonResponse::message(STATUS_OK, "Vitals added successfully!");
            exit();
        } else {
            echo JsonResponse::error("Unable to add vitals!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'getVitals') {
    if (isset($_REQUEST[VitalsTable::patient_id])) {
        $nurse = new VitalsController();
        $response = $nurse->getVitals($_REQUEST[VitalsTable::patient_id]);

        if (is_array($response)) {
            if (isset($response[P_STATUS])) {
                echo JsonResponse::error($response[P_MESSAGE]);
                exit();
            } else {
                array_reverse($response);
                echo JsonResponse::success($response);
                exit();
            }
        } else {
            echo JsonResponse::error("Unable to retrieve vitals!");
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}