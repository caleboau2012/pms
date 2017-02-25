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
    $treatment_id = isset($_REQUEST['treatment_id']) ? $_REQUEST['treatment_id'] : null;
    $encounter_id = isset($_REQUEST['encounter_id']) ? $_REQUEST['encounter_id'] : null;

    $response = $details->getDetails($treatment_id, $encounter_id);

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
                $data['encounter_id'] = ($_REQUEST[ConstantBillsTable::encounter_id] == "")?null:$_REQUEST[ConstantBillsTable::encounter_id];

                $post = $bill->postBills($data);
            }

            if ($post) {
                if($data['encounter_id'] == null){
                    $bill->billTreatment(array('treatment_id' => $data['treatment_id']));
                }
                else{
                    $bill->billEncounter(array('encounter_id' => $data['encounter_id']));
                }
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
}  elseif ($intent == 'deleteBillItem'){
    $id = isset($_REQUEST[BillablesTable::billables_id]) ? $_REQUEST[BillablesTable::billables_id] : null;

    if($id){
        $billItems = new BillingController();
        $result = $billItems->deleteBillItem($id);

        if($result){
            echo JsonResponse::success('Successfully deleted bill item.');
            exit;
        } else {
            echo JsonResponse::error("Could not delete bill item");
            exit;
        }
    } else {
        echo JsonResponse::error('Error! Bill item id not set');
        exit;
    }
}  elseif ($intent == 'editBillItem'){
    $id = isset($_REQUEST[BillablesTable::billables_id]) ? $_REQUEST[BillablesTable::billables_id] : null;
    $bill = isset($_REQUEST[BillablesTable::bill]) ? $_REQUEST[BillablesTable::bill] : "";
    $amount = isset($_REQUEST[BillablesTable::amount]) ? $_REQUEST[BillablesTable::amount] : 0;

    if($id){
        $billItems = new BillingController();
        $result = $billItems->editBillItem($id, $bill, $amount);

        if($result){
            echo JsonResponse::success('Successfully edited bill item.');
            exit;
        } else {
            echo JsonResponse::error("Could not edit bill item");
            exit;
        }
    } else {
        echo JsonResponse::error('Error! Bill item id not set');
        exit;
    }
} else {
    echo JsonResponse::error("Invalid intent!");
    exit();
}

