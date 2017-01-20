<?php

require_once "global_class.php";

class Discount extends GlobalClass {

    public function __construct() {
        parent::__construct('discounts');
    }

    public function getDiscount($discount) {
        return $this->getStringOnField('code', $discount);
    }

}

 ?>