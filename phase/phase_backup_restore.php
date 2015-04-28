<?php
require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BackupAndRestoreModel'));
Crave::requireFiles(CONTROLLER, array('BackupAndRestoreController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
    exit();
}

if ($intent == 'backup') {
    $backup = new BackupAndRestoreModel();
    $response = $backup->backupDB();

    if($response){
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error('Could not backup database');
        exit();
    }

} elseif($intent == 'restore'){
    $dumpFile = isset($_FILES['fileToUpload']['tmp_name']) ? $_FILES['fileToUpload']['tmp_name'] : NULL;

    if($dumpFile){
        $restore = new BackupAndRestoreModel();
        $response = $restore->restoreDB($dumpFile);

        if($response){
            echo JsonResponse::success("System Restore Successful!");
            exit();
        } else {
            echo JsonResponse::error("Could Not Restore System. Try Again Later!");
            exit();
        }
    } else {
        echo JsonResponse::error("Please select a .sql file!");
        exit();
    }

} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}