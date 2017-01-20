<?php

require_once "global_class.php";

class Order extends GlobalClass {

    public function __construct() {
        parent::__construct('orders');
    }

    public function getOrdersOrderDesc($order, $desc, $n) {             // getting orders sorted by asc/desc  
        return $this->getNStringsOrder($order, $desc, $n);
    }

}

?>