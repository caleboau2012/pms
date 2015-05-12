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

if ($intent == 'getFiles') {
//    $backup = new BackupAndRestoreModel();
    $backup = new BackupAndRestoreController();
    $response = $backup->getFiles();

    if(is_array($response)){
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error('No backup files');
        exit();
    }

} elseif ($intent == 'backup') {
//    $backup = new BackupAndRestoreModel();
    $backup = new BackupAndRestoreController();
    $response = $backup->backupDB();

    if($response){
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error('Could not backup database');
        exit();
    }

} elseif($intent == 'restore'){
    $dumpFileName = isset($_FILES['fileToUpload']['name']) ? $_FILES['fileToUpload']['name'] : NULL;
    $dumpFileTmpName = isset($_FILES['fileToUpload']['tmp_name']) ? $_FILES['fileToUpload']['tmp_name'] : NULL;
    var_dump($_FILES);
    if($dumpFileName){
//        $restore = new BackupAndRestoreModel();
        $restore = new BackupAndRestoreController();
        $response = $restore->restoreDB($dumpFileName, $dumpFileTmpName);

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