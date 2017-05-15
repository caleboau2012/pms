<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'Licence'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'HospitalDetailsModel', 'RoleModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'HospitalDetailsController', 'AuthenticationController', 'RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getStaffDetails') {
    if (isset($_REQUEST['userid'])) {
        $userid = $_REQUEST['userid'];
        $controller = new UserController();
        $staff_details = $controller->getStaffDetails($userid);

        if (is_array($staff_details)) {
            echo JsonResponse::success($staff_details);
            exit();
        } else {
            echo JsonResponse::error('No details found!');
            exit();
        }
    }  else {
        echo JsonResponse::error('User ID not set!');
        exit();
    }
} elseif($intent == 'getAllUsers'){
    $userController = new UserController();
    $list_of_staff = $userController->getAllUsers();

    if (is_array($list_of_staff)) {
        echo JsonResponse::success($list_of_staff);
        exit();
    } else {
        echo JsonResponse::error('No staff found!');
        exit();
    }
} elseif($intent == 'addNewStaff'){
    $regNo = isset($_REQUEST['regNo']) ? $_REQUEST['regNo'] : null;
    $passcode = isset($_REQUEST['passcode']) ? $_REQUEST['passcode'] : null;

    $userController = new UserController();

    $feedback = $userController->addUser($regNo, $passcode);

    if(is_array($feedback) && $feedback[JsonResponse::P_STATUS] == STATUS_ERROR){
        echo JsonResponse::error($feedback[JsonResponse::P_MESSAGE]);
        exit();
    }
    if($feedback) {
        echo JsonResponse::message(STATUS_OK, "Successfully created user!");
        exit();
    } else {
        echo JsonResponse::error("Failed! User already exist");
        exit();
    }
} elseif($intent == 'viewLicence') {
    $userController = new UserController();
    $feedback = $userController->viewLicence();

    if($feedback) {
        echo JsonResponse::message(STATUS_OK, $feedback);
        exit();
    } else {
        echo JsonResponse::error("Failed! User already exist");
        exit();
    }
}elseif ($intent == 'deleteStaff'){
    // check that userid of staff to be deleted is specified
    if (!isset($_POST['userid'])) {
        echo JsonResponse::error("Incomplete parameters for delete user intent");
        exit();
    }

    $userid = $_POST['userid'];

    $userController = new UserController();

    $feedback = $userController->deleteUser($userid);

    if(is_array($feedback) && $feedback[JsonResponse::P_STATUS] == STATUS_ERROR){
        echo JsonResponse::error($feedback[JsonResponse::P_MESSAGE]);
        exit();
    }

    if ($feedback) {
        // log user out, if they delete themself
        $loggedInUser = CxSessionHandler::getItem(UserAuthTable::userid);
        if ($loggedInUser == $userid) {
            CxSessionHandler::destroy();
            header("Location: ../../index.php");
        }

        echo JsonResponse::message(STATUS_OK, "Successfully deleted user!");
        exit();
    } else {
        echo JsonResponse::error("Could not delete this user. Try again!");
        exit();
    }
} elseif ($intent == 'restoreStaff') {
    // check that userid of staff to be deleted is specified
    if (!isset($_POST['userid'])) {
        echo JsonResponse::error("Incomplete parameters for restoring user!");
        exit();
    }

    $userid = $_POST['userid'];
    $userController = new UserController();
    $feedback = $userController->restoreUser($userid);

    if(is_array($feedback) && $feedback[JsonResponse::P_STATUS] == STATUS_ERROR){
        echo JsonResponse::error($feedback[JsonResponse::P_MESSAGE]);
        exit();
    }
    if ($feedback) {
        echo JsonResponse::message(STATUS_OK, "Successfully restored user!");
        exit();
    } else {
        echo JsonResponse::error("Could not restore this user. Try again!");
        exit();
    }
} elseif($intent == 'addProfile'){
    if(isset($_REQUEST['profileInfo'])){
        $profileInfo = $_REQUEST['profileInfo'];
        $userController = new UserController();

        if($userController->addProfile($profileInfo)){
            echo JsonResponse::success("Profile Successfully Added!");
            exit();
        } else {
            echo JsonResponse::error("Could not update Profile. Please try again!");
            exit();
        }
    } else {
        echo JsonResponse::error('No profile info to add.');
        exit();
    }
} elseif($intent == 'getHospitalDetails'){
    $hospitalDetailsController = new HospitalDetailsController();
    $hospitalInfo = $hospitalDetailsController->getHospitalDetails();

    if($hospitalInfo){
        echo JsonResponse::success($hospitalInfo);
        exit();
    } else {
        echo JsonResponse::error("Could not fetch hospital details.");
        exit();
    }
}  elseif($intent == 'updateHospitalDetails'){
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "";

    $hospitalDetailsController = new HospitalDetailsController();
    if($id){
        $hospitalInfo = $hospitalDetailsController->updateHospitalDetails($id, $name, $address);
    } else {
        $hospitalInfo = $hospitalDetailsController->createHospitalDetails($name, $address);
    }

    if($hospitalInfo){
        CxSessionHandler::setItem(HOSPITAL_NAME, $name);    // RESETS THE HOSPITAL NAME IN SESSION
        echo JsonResponse::success("Successfully updated  hospital details");
        exit();
    } else {
        echo JsonResponse::error("Could not update hospital details.");
        exit();
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
} else {
    echo JsonResponse::error("Invalid intent!");
}