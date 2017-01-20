<?php

require_once "modules_class.php";

class OrderContent extends Modules {

    protected function getContent() {
        if (count($_SESSION['added_items']) == 0) {
            $_SESSION['air_message'] = 'Корзина пуста!';
            $this->url->prevPage();
        }
        $this->template->set('title', 'Оформление заказа');
        $this->template->set('keywords', 'Оформление заказа');
        $this->template->set('description', 'Оформление заказа');
        $this->template->set('tpl_name', 'order');           // Setting template file from tmpl directory
        $this->template->set('name', $_SESSION['name']);
        $this->template->set('phone', $_SESSION['phone']);
        $this->template->set('email', $_SESSION['email']);
        if ($_SESSION['delivery'] == 0) $this->template->set('shipping', 'selected="selected"'); 
        else $this->template->set('selfshipping', 'selected="selected"');
        $this->template->set('address', $this->setAddress());
        $this->template->set('notice', $_SESSION['notice']);
    }

    private function setAddress() {
        if (isset($_SESSION['login'])) return $this->user->getUserAddress();   // setting addres from address field of registered user account
        return $_SESSION['address'];                                           // setting addres from session if user is not registered
    }

}








 ?>