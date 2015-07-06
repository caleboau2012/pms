<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'RoleModel'));
Crave::requireFiles(CONTROLLER, array('RoleController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == "assignRole") {
    if (isset($_REQUEST['userid'], $_REQUEST['role_id'], $_REQUEST['permission_id'])) {
        $role_array = array();
        $role_array[PermissionRoleTable::userid] = $_REQUEST['userid'];
        $role_array[PermissionRoleTable::staff_role_id] = $_REQUEST['role_id'];
        $role_array[PermissionRoleTable::staff_permission_id] = $_REQUEST['permission_id'];

        $conductor = new RoleController();
        $response = $conductor->addRole($role_array);
        if ($response[P_STATUS] == STATUS_OK) {
            echo JsonResponse::message(STATUS_OK, 'Role added successfully!');
            exit();
        } else {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
} elseif ($intent == "dismissRole") {
    if (isset($_REQUEST['permission_role_id'])) {
        $conductor = new RoleController();
        $response = $conductor->dismissRole($_REQUEST['permission_role_id']);
        if ($response[P_STATUS] == STATUS_OK) {
            echo JsonResponse::message(STATUS_OK, 'Role assignment removed successfully!');
            exit();
        } else {
            //die(var_dump($response));
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
} elseif ($intent == "updatePermission") {
    if (isset($_REQUEST['permission_role_id'], $_REQUEST['staff_permission_id'])) {
        $conductor = new RoleController();
        $response = $conductor->updatePermission($_REQUEST['permission_role_id'], $_REQUEST['staff_permission_id']);
        if ($response[P_STATUS] == STATUS_OK) {
            echo JsonResponse::message(STATUS_OK, 'Permission update successful!');
            exit();
        } else {
            echo JsonResponse::error($response[P_MESSAGE]);
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
}