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
    if (isset($_REQUEST['treatment_id'])) {
        if (isset($_REQUEST['item']) && isset($_REQUEST['amount'])) {
            for ($i = 0; $i < count($_REQUEST['item']); $i++){
                $data['item'] = $_REQUEST[ConstantBillsTable::item][$i];
                $data['amount'] = $_REQUEST[ConstantBillsTable::amount][$i];
                $data['treatment_id'] = $_REQUEST[ConstantBillsTable::treatment_id];

                $post = $bill->postBills($data);
            }
            if ($post) {
                $bill->billTreatment(array('treatment_id' => $data['treatment_id']));
                echo JsonResponse::success("Billing is Successful");
                exit();
            } else {
                echo JsonResponse::error('Billing is not Successful');
                exit();
            }

        } else {
            echo JsonResponse::error("Either item or amount is not entered or both");
            exit();
        }

    } else {
        echo JsonResponse::error('Treatment Id is not set');
        exit();
    }

} elseif ($intent == 'getBillItems'){
    $billItems = new BillingController();
    $result = $billItems->getBillItems();

    if($result && is_array($result)){
        echo JsonResponse::success($result);
        exit;
    } else {
        echo JsonResponse::error("Could not fetch bill items");
        exit;
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}

