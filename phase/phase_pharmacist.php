<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'RoleModel', 'PatientModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('RoleController', 'PharmacistController'));


$pharm_id = CxSessionHandler::getItem('userid');
if(RoleController::hasRole($pharm_id, PHARMACIST));

if(isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if($intent == 'getPatientQueue') {
    // Retrieve Out Patient Queue
    $queue = (new PharmacistController())->getPatientQueue();

    if (is_array($queue) && !empty($queue)) {
        echo JsonResponse::success($queue);
        exit();
    } else {
        echo JsonResponse::error("No patient on queue");
        exit();
    }
} elseif($intent == 'getPrescription') {
    $treatmentId = isset($_REQUEST['treatmentId']) ? $_REQUEST['treatmentId'] : null;
    $encounterId = isset($_REQUEST['encounterId']) ? $_REQUEST['encounterId'] : 0;

    if($treatmentId){
        // Retrieve Patient Prescription
        $prescription = (new PharmacistController())->getPrescription($treatmentId, $encounterId);

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
        echo JsonResponse::success($units);
        exit();
    } else {
        echo JsonResponse::error("No unit available");
    }

} elseif ($intent == 'clearPrescription') {
    $pharmacist_id = CxSessionHandler::getItem(UserAuthTable::userid);
    $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;

    /*$data = array(array("drugId" => 1, "drugName" => "Paracetamol", "quantity" => 20, "unitId" => 1, "prescription" => array(5, 6)),
        array("drugId" => 3, "drugName" => "ampiclox", "quantity" => 20, "unitId" => 1, "prescription" => array(7)),
        array("drugId" => null, "drugName" => null, "quantity" => 20, "unitId" => 1, "prescription" => array(8)));*/

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
} elseif($intent == 'addDrugUnits'){
    $values = $_REQUEST['values'];
    $units = new PharmacistController();
    $result = $units->addDrugUnits($values);

    if($result){
        echo JsonResponse::success('Successfully added drug units!');
        exit;
    } else {
        echo JsonResponse::error('Adding of drug units unsuccessful!');
        exit;
    }
} elseif($intent == 'removeDrugUnit'){
    $unitRefId = $_REQUEST['id'];
    $units = new PharmacistController();
    $result = $units->removeDrugUnit($unitRefId);

    if($result){
        echo JsonResponse::success('Successfully removed drug unit!');
        exit;
    } else {
        echo JsonResponse::error('Removal of drug unit unsuccessful!');
        exit;
    }
} else {
    echo JsonResponse::error("Invalid intent");
    exit();
}

