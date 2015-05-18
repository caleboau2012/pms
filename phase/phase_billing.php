<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BillingModel', 'BaseModel'));
Crave::requireFiles(CONTROLLER, array('BillingController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent no set!');
    exit();
}

if ($intent == 'unbilled_treatments') {
    $unbilled = new BillingController();
    $response = $unbilled->unbilledTreatment();

    if (is_array($response) && !empty($response)){
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error('There are no unbilled treatments');
        exit();
    }
} elseif ($intent == 'details') {
    $details = new BillingController();
    $id = isset($_REQUEST['treatment_id']) ? $_REQUEST['treatment_id'] : null;

    $response = $details->getDetails($id);

    if (is_array($response) || !empty($response)) {
        echo JsonResponse::success($response);
        exit();
    } else {
        echo JsonResponse::error('Details Unavailable');
        exit();
    }
}
