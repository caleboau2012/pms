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
        $userid = $profileInfo['userid'];

//        echo JsonResponse::error($profileInfo);
        $userController = new UserController();

        if($userController->addProfile($profileInfo) && $userController->updateStatus($userid, ACTIVE)){
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
} elseif ($intent == 'updateProfile') {
    if(isset($_REQUEST['profile'])){
        $profileInfo = $_REQUEST['profile'];

        $userController = new UserController();
        $response = $userController->updateProfile($profileInfo);

        if($response){
            echo JsonResponse::success("Profile Successfully Updated!");
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
} elseif ($intent == 'getProfile') {
    if(isset($_REQUEST['userid'])){
        $userid = $_REQUEST['userid'];

        $userController = new UserController();
        $profile = $userController->getUserProfile($userid);

        if($profile && is_array($profile)){
            echo JsonResponse::success($profile);
            exit();
        } else {
            echo JsonResponse::error("Could not fetch user profile. Please try again later.");
            exit();
        }
    }
    else{
        echo JsonResponse::error("Expected parameter not set");
        exit();
    }
} else {
    echo JsonResponse::error('Invalid intent!');
    exit();
}