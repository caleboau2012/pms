<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'SystemSetupModel', 'HospitalDetailsModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('SystemSetupController', 'HospitalDetailsController', 'PharmacistController'));


if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

$rootUser = isset($_REQUEST['rootUser']) ? $_REQUEST['rootUser'] : "";
$rootPass = isset($_REQUEST['rootPass']) ? $_REQUEST['rootPass'] : "";
$setup = new SystemSetupController($rootUser, $rootPass);


if ($intent == 'initialSetup') {
    $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : "";
    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
    $confirm_password = isset($_REQUEST['confirmPassword']) ? $_REQUEST['confirmPassword'] : "";
    $response = $setup->setup($username, $password, $confirm_password);

    if($response['result']){
        echo JsonResponse::success($response['message']);
        exit;
    } else {
        echo JsonResponse::error($response['message']);
        exit;
    }
} elseif($intent == 'addHospitalInfo'){
    $hospital_name = $_REQUEST['name'];
    $hospital_address = $_REQUEST['address'];
    $hospital = new HospitalDetailsController();
    $result = $hospital->createHospitalDetails($hospital_name, $hospital_address);

    if($result){
        echo JsonResponse::success('Successfully added hospital information');
        exit;
    } else {
        echo JsonResponse::error('Adding hospital information unsuccessful');
        exit;
    }
} elseif($intent == 'updateHospitalInfo'){
    $hospital_name = $_REQUEST['name'];
    $hospital_address = $_REQUEST['address'];
    $hospital = new HospitalDetailsController();
    $result = $hospital->updateHospitalDetails($hospital_name, $hospital_address);

    if($result){
        echo JsonResponse::success('Successfully updated hospital information');
        exit;
    } else {
        echo JsonResponse::error('Updating hospital information unsuccessful');
        exit;
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}