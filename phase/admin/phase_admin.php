<?php

require_once '../../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));
Crave::requireFiles(CONTROLLER, array('UserController'));

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
  } else {
    echo JsonResponse::error('No details found!');
    exit();
  }
}