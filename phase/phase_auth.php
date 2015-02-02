<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));
Crave::requireFiles(CONTROLLER, array('AuthenticationController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'login') {
    if (isset($_REQUEST['regNo'], $_REQUEST['passcode'])) {
        $credentials = array();
        $credentials[UserAuthTable::regNo] = $_REQUEST['regNo'];
        $credentials[UserAuthTable::passcode] = $_REQUEST['passcode'];

        $authenticator = new AuthenticationController();
        $verify = $authenticator->verify($credentials);

        if (is_array($verify)) {
            if ($verify[P_STATUS] == STATUS_OK) {

                //SET SESSION VARIABLES
                $user_credentials = $verify[P_DATA];
                foreach ($user_credentials as $key => $value) {
                    CxSessionHandler::setItem($key, $value);
                }

                //CONSTRUCT RESPONSE
                $response = array();
                $response[UserAuthTable::status] = $user_credentials[UserAuthTable::status];
                $response[P_MESSAGE] = $verify[P_MESSAGE];
                //ECHO RESPONSE
                echo JsonResponse::success($response);
                exit();

            } else {
                //ECHO RESPONSE
                echo JsonResponse::error($verify[P_MESSAGE]);
                exit();
            }
        } else {
            echo JsonResponse::error('Invalid combination of registration number and passcode!');
            exit();
        }
    } else {
        echo JsonResponse::error('Registration number or passcode not set!');
        exit();
    }
} elseif ($intent == "changePassword") {
    if (isset($_REQUEST['userid'], $_REQUEST['passcode'])) {
        # code...
        $status = ($_REQUEST['status'] == INACTIVE) ? PROCESSING : $_REQUEST['status'];
        $authenticator = new AuthenticationController();
        $change = $authenticator->changePassword($_REQUEST['userid'], $_REQUEST['passcode'], $status);
        if($change) {
            //DESTROY SESSION TO LOG USER OUT
            CxSessionHandler::destroy();

            //CONSTRUCT RESPONSE
            $response = array();
            $response[P_MESSAGE] = "Password change successful!";

            //SET MESSAGE FOR USER ON NEXT LOGIN
            CxSessionHandler::setViewBag("You just changed your password. Log in again with your new password.");

            //ECHO RESPONSE
            echo JsonResponse::success($response);
            exit();
        } else {
            echo JsonResponse::error("Unable to change password! Please try again.");
            exit();
        }
    } else {
        echo JsonResponse::error('Incomplete request parameters!');
        exit();
    }
} elseif ($intent == "logout") {
    $authenticator = new AuthenticationController();

    $userid = CxSessionHandler::getItem(UserAuthTable::userid);

    $authenticator->flagUserOffline($userid);

    CxSessionHandler::destroy();
    echo JsonResponse::message(STATUS_OK, "Logout successful");
    exit();
} else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}