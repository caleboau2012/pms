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

if ($intent == 'addProfile') {
    if(isset($_REQUEST['profileInfo'])){
        $profileInfo = $_REQUEST['profileInfo'];
        $userController = new UserController();

        if($userController->updateStaff($profileInfo)){
            echo JsonResponse::success("Profile Successfully Added!");
            exit();
        } else {
            echo JsonResponse::error("Could not update Profile. Please try again!");
            exit();
        }
    }
    else{
        echo JsonResponse::error("Profile data not set");
    }
} else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}