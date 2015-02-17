<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
//Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
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
} elseif($intent == 'getUsers') {
    $userController = new UserController();
    $list_of_staff = $userController->getAllUsers();

    if (is_array($list_of_staff)) {
        echo JsonResponse::success($list_of_staff);
        exit();
    } else {
        echo JsonResponse::error('No staff found!');
        exit();
    }
} elseif($intent == 'assignTask') {
    $createdBy = CxSessionHandler::getItem('userid');

    if (isset($_REQUEST['data'])) {
        $data = $_REQUEST['data'];

        $userId = $data['user_id'];
        $deptId = $data['dept_id'];
        $duty   = $data['duty'];
        $dutyDate = $data['duty_date'];

        $controller = new StaffRosterController();
        $result = $controller->assignTask($userId, $deptId, $duty, $dutyDate, $createdBy);

        if ($result) {
            echo JsonResponse::success("Task successfully assigned");
            exit();
        } else {
            echo JsonResponse::error('Could not assign task, try again!');
            exit();
        }
    }  else {
        echo JsonResponse::error('Cannot fetch details of the staff to assign a task to');
        exit();
    }
}else {
    echo JsonResponse::error("Invalid intent!");
}