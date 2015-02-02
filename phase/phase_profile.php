<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BaseModel', 'UserModel'));
Crave::requireFiles(CONTROLLER, array('AuthenticationController', 'UserController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'addProfile') {
    if(isset($_REQUEST['profile'])){
        $profileInfo = $_REQUEST['profile'];

//        echo JsonResponse::error($profileInfo);
        $userController = new UserController();

        if($userController->addProfile($profileInfo)){
            echo JsonResponse::success("Profile Successfully Added!");
            exit();
        } else {
            echo JsonResponse::error("Could not update Profile. Please try again!");
            exit();
        }
    }
    else{
        echo JsonResponse::error("Profile data not set");
        exit();
    }
} else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}