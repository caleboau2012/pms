<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireFiles(UTIL, array('SqlClient', 'JsonResponse', 'CxSessionHandler'));
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));
Crave::requireFiles(CONTROLLER, array('LookoutController', 'AuthenticationController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error("Intent not set!");
    exit();
}

if ($intent == 'markPresence') {
    $userid = CxSessionHandler::getItem(UserAuthTable::userid);
    if ($userid == NULL) {
        echo JsonResponse::error("User not logged in!");
        exit();
    }

    $inspector = new LookoutController();
    $marked = $inspector->markPresence($userid);

    if ($marked) {
        echo JsonResponse::message(STATUS_OK, "User marked present!");
        exit();
    } else {
        echo JsonResponse::error("Unable to mark user present!");
        exit();
    }
} elseif ($intent == 'sweep') {
    LookoutController::sweep();
}