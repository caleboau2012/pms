<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel', 'StaffRosterModel'));
Crave::requireFiles(CONTROLLER, array('UserController', 'StaffRosterController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'getDepartments') {
    $controller = new StaffRosterController();
    $dept = $controller->getDepartments();

    if (is_array($dept) && !empty($dept)) {
        echo JsonResponse::success($dept);
        exit();
    } else {
        echo JsonResponse::error('No department found!');
        exit();
    }

    /*if (isset($_REQUEST['userid'])) {
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
    }*/
} elseif($intent == getUsers) {
    $userController = new UserController();
    $list_of_staff = $userController->getAllUsers();

    if (is_array($list_of_staff)) {
        echo JsonResponse::success($list_of_staff);
        exit();
    } else {
        echo JsonResponse::error('No staff found!');
        exit();
    }
} else {
    echo JsonResponse::error("Invalid intent!");
}