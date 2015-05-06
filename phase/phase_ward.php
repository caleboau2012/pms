<?php
error_reporting(0);
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'RoleModel', 'BedModel', 'WardModel'));
Crave::requireFiles(CONTROLLER, array('WardController', 'RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'loadWards') {
    $warden = new WardController();
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
        $warden = new WardController();
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
} elseif ($intent == 'newWard') {
    if (isset($_POST[WardRefTable::description])) {
        $warden = new WardController();
        $response = $warden->createWard($_POST[WardRefTable::description]);
        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::message(STATUS_OK, "Ward successfully created!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'newBed') {
    if (isset($_POST[BedTable::ward_id], $_POST[BedTable::bed_description])) {
        $warden = new WardController();
        $response = $warden->createBed($_POST[BedTable::ward_id], $_POST[BedTable::bed_description]);
        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::message(STATUS_OK, "Bed successfully created!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
} elseif ($intent == 'deleteBed') {
    // die(var_dump($_POST));
    if (isset($_POST[BedTable::bed_id])) {
        $warden = new WardController();
        $response = $warden->deleteBed($_POST[BedTable::bed_id]);
        if (is_array($response)) {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        } else {
            echo JsonResponse::message(STATUS_OK, "Bed successfully deleted!");
            exit();
        }
    } else {
        echo JsonResponse::error("Incomplete request parameters!");
        exit();
    }
}else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}