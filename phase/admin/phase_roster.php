<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler', 'Event'));
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
    $createdBy = CxSessionHandler::getItem(UserAuthTable::userid);
//    $modifiedBy = CxSessionHandler::getItem(UserAuthTable::userid);

    $userId = $_REQUEST['user_id'];
    $deptId = $_REQUEST['dept_id'];
    $duty   = $_REQUEST['duty'];
    $dutyDate = $_REQUEST['duty_date'];


    $controller = new StaffRosterController();
    $result = $controller->assignTask($userId, $deptId, $duty, $dutyDate, $createdBy);
    if ($result) {
        echo JsonResponse::success("Successfully added");
        exit();
    } else {
        echo JsonResponse::error('Could not assign task, try again!');
        exit();
    }

}elseif($intent == 'updateTask'){
    $modifiedBy = CxSessionHandler::getItem(UserAuthTable::userid);
    $rosterId = $_REQUEST['roster_id'];
    $dutyDate = $_REQUEST['duty_date'];

    $controller = new StaffRosterController();
    $request = $controller->updateTask($rosterId, $dutyDate, $modifiedBy);

    if ($request) {
        echo JsonResponse::success("Successfully updated");
        exit();
    } else {
        echo JsonResponse::error('Could not update task, try again!');
        exit();
    }
}elseif($intent == 'deleteTask'){
    $modifiedBy = CxSessionHandler::getItem(UserAuthTable::userid);
    $rosterId = $_REQUEST['roster_id'];

    $controller = new StaffRosterController();
    $request = $controller->deleteTask($rosterId, $modifiedBy);

    if ($request) {
        echo JsonResponse::success("Successfully deleted");
        exit();
    } else {
        echo JsonResponse::error('Could not update task, try again!');
        exit();
    }
}elseif($intent == 'getAllEvents'){
    $staffs = new StaffRosterController();
    $staffRoster = $staffs->getAllStaffsRoster();

// Accumulate an output array of event data arrays.
    $output_arrays = array();
    foreach ($staffRoster as $array) {
        $params['title'] = ucwords($array['firstname'] ." ".$array['middlename'] . " " .$array['lastname']);
        $params['start'] = $array['duty_date'];
        $params['roster_id'] = $array['roster_id'];

        if($array['duty'] == 9){
            $params['color'] = "#4CA618";
        }else if($array['duty'] == 10){
            $params['color'] = "#3F3C3C";
        }else{
            $params['color'] = "#3A87AD";
        }
        // Convert the input array into a useful Event object
        $event = new Event($params, null);
        $output_arrays[] = $event->toArray();
    }

// Send JSON to the client.
    echo json_encode($output_arrays);
}
else {
    echo JsonResponse::error("Invalid intent!");
}