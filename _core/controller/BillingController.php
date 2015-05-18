<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 5/18/15
 * Time: 11:21 AM
 */

class BillingController {
    private $systemBilling;

    public function __construct() {
        $this->systemBilling = new BillingModel();
    }

    public function unbilledTreatment() {
        return $this->systemBilling->unbilledTreatment();
    }

    public function getDetails($treatment_id) {
        return $this->systemBilling->getDetails($treatment_id);
    }
}