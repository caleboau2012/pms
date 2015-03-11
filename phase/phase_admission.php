<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'AdmissionModel', 'RoleModel', 'BedModel', 'WardModel'));
Crave::requireFiles(CONTROLLER, array('AdmissionController', 'RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'admitPatient') {
    if (isset($_REQUEST[AdmissionTable::bed_id], $_REQUEST[AdmissionTable::patient_id], $_REQUEST[AdmissionTable::treatment_id])) {
        $admitted_by = CxSessionHandler::getItem(UserAuthTable::userid);
        $comments = isset($_REQUEST[AdmissionTable::comments]) ? $_REQUEST[AdmissionTable::comments] : NULL;

        $warden = new AdmissionController();
        $response = $warden->admitPatient($_REQUEST[AdmissionTable::patient_id], $_REQUEST[AdmissionTable::treatment_id], $admitted_by, $_REQUEST[AdmissionTable::bed_id], $comments);
        if ($response[P_STATUS] == STATUS_OK) {
            echo JsonResponse::message($response[STATUS_OK], $response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'loadWards') {
    $warden = new AdmissionController();
    $response = $warden->loadWards();
    if (is_array($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error("Unable to load wards!");
        exit();
    }
} elseif ($intent == 'loadBeds') {
    if (isset($_REQUEST[BedTable::ward_id])) {
        $warden = new AdmissionController();
        $response = $warden->getWardBeds($_REQUEST[BedTable::ward_id]);
        if (is_array($response)) {
            echo JsonResponse::success($response);
            exit();
        } else {
            echo JsonResponse::error("No beds in this ward!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
}