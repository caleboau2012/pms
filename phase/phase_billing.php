<?php

require_once '../_core/global/_require.php';

Crave::requireAll(GLOBAL_VAR);
Crave::requireAll(UTIL);
Crave::requireFiles(MODEL, array('BillingModel', 'BaseModel'));
Crave::requireFiles(CONTROLLER, array('BillingController'));

if (isset($_REQUEST['intent'])) {
    $intent = $_REQUEST['intent'];
} else {
    echo JsonResponse::error('Intent not set!');
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
} elseif ($intent == 'post_bills') {
    $bill = new BillingController();
    if (isset($_REQUEST['treatment_id']) && isset($_REQUEST['item']) && isset($_REQUEST['amount'])) {
        $data['item'] = $_REQUEST[ConstantBillsTable::item];
        $data['amount'] = $_REQUEST[ConstantBillsTable::amount];
        $data['treatment_id'] = $_REQUEST[ConstantBillsTable::treatment_id];

        $post = $bill->postBills($data);

        if ($post) {
            echo JsonResponse::success("Billing is Successful");
        } else {
            echo JsonResponse::error('Billing is not Successful');
        }

    } else {
        echo JsonResponse::error('Bills are not completely set');
        exit();
    }

}
