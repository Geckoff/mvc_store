<?php

/**
* Core controller class according to MVC architecture
**/

require_once "url_class.php";
require_once "check_class.php";
require_once "discount_class.php";
require_once "order_class.php";
require_once "product_class.php";
require_once "user_class.php";
require_once "config_class.php";

class Manage {

    private $url;
    private $check;
    private $discount;
    private $product;
    private $order;
    private $user;
    private $config;

    public function __construct(){
        session_start();
        $this->url = new Url();
        $this->check = new Check();
        $this->discount = new Discount();
        $this->order = new Order();
        $this->product = new Product();
        $this->user = new User();
        $this->config = new Config();
    }

    public function addCartItem($id) {          // adding item to cart
        if(!isset($_SESSION['added_items'])) $_SESSION['added_items'] = array();
        if (!$this->check->checkID($id))  $this->url->prevPage();          // if item id is not valid redirect is activating
        array_push($_SESSION['added_items'], $id);
    }

    public function getCommonPriceCart() {
        if (count($_SESSION['added_items']) > 0) return $this->product->getCommonPrice($_SESSION['added_items']);
        return 0;
    }

    public function useCoupon($discount_num) {   // getting a discount code
        if (!$discount = $this->discount->getDiscount($discount_num)) {
            $_SESSION['air_message'] = 'Неверный код!';
        }
        else {
            $_SESSION['air_message'] = 'Код активирован!';
            $_SESSION['discount_val'] = $discount[0]['value'];
            $_SESSION['discount_num'] = $discount_num;
        }
        $this->url->prevPage();
    }

    public function recalcItems($data) {        // recalculating price and quantity of items in the cart
        unset($_SESSION['added_items']);
        $_SESSION['added_items'] = array();
        foreach ($_SESSION['cart_uniq_ids'] as $id => $quant) {       // ids of added items with no quantity data
            $quant = $data[$id];                                      // quantity is saved in submited text field named after item id
            for ($i = 0; $i < $quant; $i++) {
                array_push($_SESSION['added_items'], $id);
            }
        }
        $this->url->prevPage();
    }

    public function delCartItem($id) {                  // deleting item from the cart
        $count = count($_SESSION['added_items']);
        for ($i = 0; $i < $count; $i++) {
            if ($_SESSION['added_items'][$i] == $id) unset($_SESSION['added_items'][$i]);
        }
        $ids = array();
        foreach ($_SESSION['added_items'] as $id) {
            $ids[] = $id;
        }
        $_SESSION['added_items'] = $ids;
        $this->url->prevPage();
    }

    public function goToMessagePage($msg) {    // redirect to message page
        $_SESSION['msg_title'] = $msg;         // message titles are saved in messages.ini file
        $this->url->messagePage();
    }

    private function putAirMessage($message) {
        $_SESSION['air_message'] = $message;
        $this->url->prevPage();
    }

    public function addOrder($data) {                    // checkout
        $_SESSION['name'] = $data['name'];
        $_SESSION['phone'] = $data['phone'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['delivery'] = $data['delivery'];
        $_SESSION['address'] = $data['address'];
        $_SESSION['notice'] = $data['notice'];
        if (!$this->check->checkZeroLength($data['phone'])) $this->putAirMessage('Введите номер телефона');
        if ($this->check->checkZeroLength($data['email'])) {
           if (!$this->check->checkEmail($data['email'])) $this->putAirMessage('Неверный формат email');
        }
        if (!$this->check->checkZeroLength($data['delivery'])) $this->putAirMessage('Выберите вариант доставки');
        $products_ids = implode(',', $_SESSION['added_items']);
        $price = $this->product->getCommonPrice($_SESSION['added_items']);
        $fields = array('delivery', 'product_ids', 'price', 'name', 'phone', 'email', 'address', 'notice', 'date_order');
        $values = array($data['delivery'], $products_ids, $price, $data['name'], $data['phone'], $data['email'], $data['address'], $data['notice'], time());
        if ($this->order->insert($fields, $values)) {
            unset($_SESSION['added_items']);
            $this->goToMessagePage('ADD_ORDER');
        }
        else $this->goToMessagePage('ADD_ORDER_ERROR');
    }

    public function authorization($data) {
        $password = $this->user->getFieldOnField('login', $data['login'], 'password');
        $password = $password[0]['password'];
        if (md5($data['password']) == $password) {
            $_SESSION['login'] = $data['login'];
            $_SESSION['password'] = $data['password'];
        }
        else {
            $_SESSION['main_air_message'] = 'Неверный логин/пароль!';
        }
        $this->url->prevPage();
    }

    public function exitProfile() {
        unset($_SESSION['login'], $_SESSION['password']);
        $this->url->prevPage();
    }

    public function changeProfileAddress($address) {
        if ($this->user->changeUserFieldByName('address', $address, $_SESSION['login'])) {
            $_SESSION['air_message'] = 'Адрес изменен!';
        }
        else {
            $_SESSION['air_message'] = 'Не удалось изменить адрес';
        }
        $this->url->prevPage();
    }

    public function userRegistration($data) {
        $_SESSION['reg_login'] = $data['login'];     // saving registration login into session to it into relevant field if registration fails
        $_SESSION['reg_email'] = $data['email'];     // saving registration email into session to it into relevant field if registration fails
        if ($data['code'] !== $_SESSION['captcha']) {
            $this->putAirMessage('Неверный проверочный код');
        }
        if (!$this->check->checkLogin($data['login'])) {
            $this->putAirMessage('Неверный формат логина');
        }
        if (!$this->check->checkEmail($data['email'])) {
            $this->putAirMessage('Неверный формат емэйла');
        }
        if (!$this->check->checkPassword($data['nm_password'])) {
            $this->putAirMessage('Длина пароля должна быть не менее 4 символов');
        }
        if ($this->user->getStringOnField('login', $data['login'])) {
            $this->putAirMessage('Логин уже существует');
        }
        if ($this->user->getStringOnField('email', $data['email'])) {
            $this->putAirMessage('Email уже используется');
        }
        if ($this->user->addUser($data['login'], $data['email'], $data['nm_password'])) {
            $code = md5($data['nm_password'].$data['login'].$this->config->secret_word);     // setting code for registration verification
            $body = $data['login'].', спасибо за регистрацию на '.$this->config->sitename.'.<br>Для подтвержения регистрации пройдите по ссылке: '.$this->url->getFunctionUrl()."?code=$code";
            mail($data['email'], 'Регистрация на '.$this->config->sitename, $body);          // email with verification link
            $this->goToMessagePage('REGISTRATION');
        }
        else {
            $this->goToMessagePage('REGISTRATION_ERROR');
        }

    }

    public function verifyAccount($code) {          // registration code virification
        $where = "`code` = '$code'";
        if ($this->user->getStringOnField('code', $code) && $this->user->updateUniqueField('code', '', $where)) {    // verifying code and deleting it if verified
            $this->goToMessagePage('VERIFYING');
        }
        else {
            $this->goToMessagePage('VERIFYING_ERROR');
        }
    }

    public function recoveryPassword($email) {         // recovering user's password
        $code = md5($email.$this->config->secret_word);
        $where = "`email` = '$email'";                                 // checking if user with current email exists
        if ($this->user->getStringOnField('email', $email)) {
            if ($this->user->updateUniqueField('recover_code', $code, $where)) {
                $link = $this->url->getNewPasswordUrl().$code;         // building recovery url containing recovery code
                $body = "Вы отправили запрос на восстановление пароля.<br>Чтобы задать новый пароль, перейдите по ссылке: ".$link;
                mail($rmail, 'Восстановление пароля на '.$this->config->sitename, $body);
                $this->goToMessagePage('RECOVERY');
            }
            else {
                $this->goToMessagePage('RECOVERY_ERROR');
            }
        }
        else {
            $this->putAirMessage('Данного email нет в базе');
        }
    }

    public function setNewPassword($data) {            // setting up new user's password
        if ($this->user->getStringOnField('recover_code', $data['recover_code'])) {      // validating recovery code
            $where = "`recover_code` = '".$data['recover_code']."'";
            $password = md5($data['nm_password']);
            $fields = array('password', 'recover_code');
            $values = array($password, '');
            $this->user->update($fields, $values, $where);                               // updating password and deleteing recovery code
            $this->goToMessagePage('NEWPAS');
        }
        else {
            if ($this->user->getStringOnField('email', $email))
            $this->goToMessagePage('NEWPAS_ERROR');
        }
    }

    public function refreshPassword($data) {                                             // Updating password from signed in user account page
        if (!$this->check->checkPassword($data['nm_password'])) {
            $this->putAirMessage('Длина пароля должна быть не менее 4 символов');
        }
        if (!$this->check->checkZeroLength($data['cur_password'])) {
            $this->putAirMessage('Введите текущий пароль');
        }          
        if (md5($data['cur_password']) == $this->user->getUserPassword()) {
            if ($this->user->updatePasswordByLogin($data['nm_password']) > 0) {
                $this->goToMessagePage('UPDATE');
            }
            else {
                $this->goToMessagePage('RECOVERY_ERROR');
            }
        }
        else {
                $this->putAirMessage('Неверный текущий пароль');
        }
    }

}



 ?>