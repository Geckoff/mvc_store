<?php

require_once "global_class.php";

class Product extends GlobalClass {

    public function __construct() {
        parent::__construct('products');
    }

    public function getNProductsDate($n, $id ='') {                                // getting n items sorted by date
        return $this->getNStringsOrder('date', true, $n);
    }

    public function getMainProductsOrderDesc($order, $desc, $n) {                  // getting n items sorted by asc/desc
        return $this->getNStringsOrder($order, $desc, $n);
    }

    public function getNSectionProductsDate($n, $id='') {                          // getting n items from certain category sorted by date
        return $this->getNStringsOrder('date', true, $n, $id);
    }

    public function getSectionProductsOrderDesc($order, $desc, $n, $id='') {       // getting n items from certain category sorted by asc/desc
        return $this->getNStringsOrder($order, $desc, $n, $id);
    }

    public function getTheProduct($title_link) {
        $string = $this->getStringOnField('title_link', $title_link);
        return $string[0];
    }

    public function getProductsOnSection($section_id) {
        $string = $this->getStringOnField('section_id', $section_id, 6);
        return $string;
    }

    public function getCommonPrice($items){
        $price = 0;
        foreach ($items as $value) {
            $cur_price = $this->getFieldOnID($value, 'price');
            $price += $cur_price['price'];
        }
        return $price;
    }

    public function getProductTitle($id) {
        return $this->getFieldOnID($id, 'title');
    }



}

 ?>