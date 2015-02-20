<?php 

require_once '../../_core/global/_require.php';

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
    if (isset($_REQUEST[VitalsTable::patient_id])) {
        $added_by = CxSessionHandler::getItem(UserAuthTable::userid);

        $vitals_data = array();
        $empty = true;
        foreach ($vitals_array as $vital) {
            if (isset($_REQUEST[$vital])) {
                $vitals_data[$vital] = $_REQUEST[$vital];
                $empty = false;
            } else {
                $vitals_data[$vital] = null;
            }
        }

        if ($empty) {
            echo JsonResponse::error("Cannot add empty vitals data!");
            exit();
        }

        $vitals_data[VitalsTable::patient_id] = $_REQUEST[VitalsTable::patient_id];

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
            echo JsonResponse::success($response);
            exit();
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