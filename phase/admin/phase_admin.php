<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffController'));

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
    }
} elseif($intent == 'getAllStaff'){
        $staffController = new StaffController();
        $list_of_staff = $staffController->getAllStaff();

        if (is_array($list_of_staff)) {
            echo JsonResponse::success($list_of_staff);
            exit();
        } else {
            echo JsonResponse::error('No staff found!');
            exit();
        }
} elseif($intent == 'registerStaff'){
    if(isset($_REQUEST['authInfo'])){
        $staffAuthInfo = $_REQUEST['authInfo'];
        $staffController = new StaffController();

        if($staffController->addStaff($staffAuthInfo)){
            echo JsonResponse::success("Successfully created!");
            exit();
        } else {
            echo JsonResponse::error("Failed! Please retry");
            exit();
        }
    }
} elseif($intent == 'updateStaff'){
    if(isset($_REQUEST['profileInfo'])){
        $profileInfo = $_REQUEST['profileInfo'];
        $staffController = new StaffController();

        if($staffController->updateStaff($profileInfo)){
            echo JsonResponse::success("Profile Successfully Added!");
            exit();
        } else {
            echo JsonResponse::error("Could not update Profile. Please try again!");
            exit();
        }
    }
} else{
    echo JsonResponse::error('No details found!');
    exit();
}
