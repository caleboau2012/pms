<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'RoleModel', 'ChemicalPathologyModel', 'HaematologyModel', 'MicroscopyModel', 'ParasitologyModel', 'VisualModel', 'RadiologyModel'));
Crave::requireFiles(CONTROLLER, array('RoleController', 'LaboratoryController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

/* This array maps the labType to the role_id for that labType */
$labType_Role = array(
                          CHEMICAL_PATHOLOGY => CHEMICAL_PATHOLOGY_CONDUCTOR,
                          HAEMATOLOGY => HAEMATOLOGY_CONDUCTOR,
                          PARASITOLOGY => PARASITOLOGY_CONDUCTOR,
                          MICROSCOPY => URINE_CONDUCTOR,
                          VISUAL => VISUAL_CONDUCTOR,
                          RADIOLOGY => XRAY_CONDUCTOR
                     );

$status_id = (isset($_REQUEST['status'])) ? $_REQUEST['status'] : null;

$lab_attendant_id = CxSessionHandler::getItem('userid');
$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : array();
$labType = $_REQUEST['labType'];

if($data && $labType != 'radiology'){
    $data['details']['lab_attendant_id'] = $lab_attendant_id;
    $data['details']['status_id'] = $status_id;
} elseif ($labType == 'radiology'){
    $data['radiology']['lab_attendant_id'] = $lab_attendant_id;
    $data['radiology']['status_id'] = $status_id;
}


if ($intent == 'getPatientQueue') {
    if (isset($_REQUEST['labType'])) {
        $labType = $_REQUEST['labType'];
        $role = isset($labType_Role[$labType]) ? $labType_Role[$labType] : null;

        if($role && RoleController::hasRole($lab_attendant_id, $role)){
            $lab = new LaboratoryController();
            $queue = $lab->getPatientQueue($labType);
            if (is_array($queue) && !empty($queue)) {
                echo JsonResponse::success($queue);
                exit();
            } else {
                echo JsonResponse::error("No patient on queue");
                exit();
            }
        } else {
            echo JsonResponse::accessDenied();
            exit();
        }
    } else {
        echo JsonResponse::error("No lab type chosen");
        exit();
    }
} elseif ($intent == 'getAllTest') {
    if (isset($_REQUEST['labType'])) {
        $labType = $_REQUEST['labType'];
        $role = (isset($labType_Role[$labType])) ? $labType_Role[$labType] : null;

        if($role && RoleController::hasRole($lab_attendant_id, $role)){
            $lab = new LaboratoryController();
            $queue = $lab->getAllTest($labType);
            if (is_array($queue) && !empty($queue)) {
                echo JsonResponse::success($queue);
                exit();
            } else {
                echo JsonResponse::error("No test found!");
                exit();
            }
        } else {
            echo JsonResponse::accessDenied();
            exit();
        }
    } else {
        echo JsonResponse::error("No lab type chosen");
        exit();
    }
} elseif ($intent == 'getLabDetails') {
    if (isset($_REQUEST['labType']) && isset($_REQUEST['treatmentId'])) {
        $labType = $_REQUEST['labType'];
        $treatmentId = $_REQUEST['treatment_id'];
        $role = isset($labType_Role[$labType]) ? $labType_Role[$labType] : null;

        if($role && RoleController::hasRole($lab_attendant_id, $role)){
            $lab = new LaboratoryController();
            $details = $lab->getLabDetails($labType, $treatmentId);
            if (is_array($details) && !empty($details)) {
                echo JsonResponse::success($details);
                exit();
            } else {
                echo JsonResponse::error("This patient has no lab data yet!");
                exit();
            }
        } else {
            echo JsonResponse::accessDenied();
            exit();
        }
    } else {
        echo JsonResponse::error("No lab type or treatment id chosen");
        exit();
    }
} elseif ($intent == 'setLabDetails') {
    if (isset($_REQUEST['labType']) && isset($_REQUEST['data'])) {
        $labType = $_REQUEST['labType'];
        $role = isset($labType_Role[$labType]) ? $labType_Role[$labType] : null;

        if($role && RoleController::hasPermission($lab_attendant_id, $role, READ_WRITE)){
            $lab = new LaboratoryController();
            $response = $lab->setLabDetails($labType, $data);
            if ($response['status']) {
                echo JsonResponse::success("Successfully added");
                exit();
            } else {
                echo JsonResponse::error("Could not add the lab details");
                exit();
            }
        } else {
            echo JsonResponse::accessDenied();
            exit();
        }
    } else {
        echo JsonResponse::error("No lab type or data to add");
        exit();
    }
} elseif ($intent == 'updateLabDetails') {
    if (isset($_REQUEST['labType']) && $data) {
        $labType = $_REQUEST['labType'];
        $role = isset($labType_Role[$labType]) ? $labType_Role[$labType] : null;

        if($role && RoleController::hasPermission($lab_attendant_id, $role, READ_WRITE)){
            $lab = new LaboratoryController();
            $response = $lab->updateLabDetails($labType, $data);
            /*echo JsonResponse::success($data);
            exit();*/
            if ($response['status']) {
                echo JsonResponse::success("Successfully updated");
                exit();
            } else {
                echo JsonResponse::error($response['message']);
                exit();
            }
        } else {
            echo JsonResponse::accessDenied();
            exit();
        }
    } else {
        echo JsonResponse::error("No lab type or data to update");
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}