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

        //ECHO RESPONSE
        echo JsonResponse::message($verify[P_STATUS], $verify[P_MESSAGE]);
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
} else {
  echo JsonResponse::error('Invalid intent!');
  exit();
}