<?php

require_once "modules_class.php";

class CartContent extends Modules {

    protected function getContent() {
        print_r($_SESSION['added_items']);
        if (count($_SESSION['added_items']) > 0) {
            $this->template->set('products', $this->getListOfProductsInCart($_SESSION['added_items']));
            $this->template->set('show_items', '1');              // showing item block in cart
        }
        else $this->template->set('show_items', '0');             // hiding items block in cart
        $this->template->set('title', 'Корзина');
        $this->template->set('keywords', 'Корзина');
        $this->template->set('description', 'Корзина');
        $this->template->set('tpl_name', 'cart');                 // Setting template file from tmpl directory
        $this->template->set('cart_comprice_discount', $this->getCartComPriceDisc());   // Final price of the purchase considering promocode discount
        $this->template->set('del_cart_url', $this->url->getDelCartUrl());              // Link to delete the item
        $this->template->set('order_url', $this->url->getOrderUrl());                   // Link to checkout
        $this->template->set('discount', $_SESSION['discount_num']);
    }

    private function getListOfProductsInCart($id_list) {
        /**
        * When adding item to cart its id is saving into $_SESSION['added_items']. Example of this array: ( [0] => 1 [1] => 1 [2] => 1 [3] => 12 [4] => 12 [5] => 13 [6] => 12 ).
        * Function getUniqIDs() called below is helping to sort $_SESSION['added_items'] array to come up with associative array,
        * where key is id of the item and value is qunatity of items with same id added into the cart.
        **/
        $ids = $this->getUniqIDs($id_list);
        $i = 0;
        foreach ($ids as $id => $quant) {
            $product = $this->product->getStringOnID($id);         // getting all information about item
            $product['quant'] = $quant;                            // adding quantity of items to item information
            $product['full_price'] = $quant * $product['price'];   // adding final price of current item according to quantity of units added
            $products[$i] = $product;
            $i++;
        }
        return $products;
    }

    private function getCartComPriceDisc() {
        $final_price = $this->getCommonPriceCart();
        if (isset($_SESSION['discount_val'])) return floor($final_price * (1 - $_SESSION['discount_val']));  // calculating final price with promocode
        else return $final_price;
    }

    private function getUniqIDs($id_list) {
        $ids = array();
        foreach ($id_list as $old_id) {
            if (count($ids) == 0) {
                $ids[$old_id] = 1;
            }
            else {
                $k = 0;
                foreach ($ids as $new_id => $value ) {
                    if ($old_id == $new_id) {
                        $ids[$old_id]++;
                        $k = 1;
                    }
                }
                if ($k != 1) $ids[$old_id] = 1;
            }
        }
        $_SESSION['cart_uniq_ids'] = $ids;
        return $ids;
    }

}








 ?>