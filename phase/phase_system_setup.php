<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'BillingModel', 'SystemSetupModel', 'HospitalDetailsModel', 'PharmacistModel'));
Crave::requireFiles(CONTROLLER, array('BillingController', 'SystemSetupController', 'HospitalDetailsController', 'PharmacistController'));


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
    $regNo = isset($_REQUEST['regNo']) ? $_REQUEST['regNo'] : "";
    $passcode = isset($_REQUEST['passcode']) ? $_REQUEST['passcode'] : "";
    $confirm_passcode = isset($_REQUEST['confirmPasscode']) ? $_REQUEST['confirmPasscode'] : "";

    if($passcode && $passcode == $confirm_passcode){

        $response = $setup->setup($regNo, $passcode);

        if($response['result']){
            echo JsonResponse::success($response['message']);
            exit;
        } else {
            echo JsonResponse::error($response['message']);
            exit;
        }

    } else {
        echo JsonResponse::error('Admin password do not match');
        exit;
    }
} elseif ($intent == 'createAdmin') {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $confirm_password = $_REQUEST['confirmPassword'];
    $result = $setup->createAdminUser($username, $password, $confirm_password);

    if($result){
        echo JsonResponse::success('Successfully created admin user');
        exit;
    } else {
        echo JsonResponse::error('Error creating admin user');
        exit;
    }
} elseif($intent == 'addHospitalInfoAndUnits'){
    $hospital_name = $_REQUEST['name'];
    $hospital_address = $_REQUEST['address'];
    $values = $_REQUEST['values'];
    $hospital = new HospitalDetailsController();
    $result = $hospital->createHospitalDetails($hospital_name, $hospital_address);

    if($result){
        $units = new PharmacistController();
        $units_added = $units->addDrugUnits($values);

        if($units_added){
            echo JsonResponse::success('Successfully added hospital information and drug units');
            exit;
        } else {
            echo JsonResponse::error('Could not add drug units');
            exit;
        }
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
} elseif($intent == 'addDrugUnits'){
    $values = $_REQUEST['values'];
    $units = new PharmacistController();
    $result = $units->addDrugUnits($values);

    if($result){
        echo JsonResponse::success('Successfully added drug units.');
        exit;
    } else {
        echo JsonResponse::error('Adding of drug units unsuccessful.');
        exit;
    }
} elseif($intent == 'addBillingItems'){
    $values = $_REQUEST['billItems'];
    $bills = new BillingController();
    $result = $bills->addBillingItems($values);

    if($result){
        echo JsonResponse::success('Successfully added billing items.');
        exit;
    } else {
        echo JsonResponse::error('Adding of billing items unsuccessful.');
        exit;
    }
} elseif($intent == 'setupComplete'){
    $result = $setup->setupComplete();

    if($result){
        echo JsonResponse::success('Setup Successful');
        exit;
    } else {
        echo JsonResponse::error('Setup unsuccessful');
        exit;
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}