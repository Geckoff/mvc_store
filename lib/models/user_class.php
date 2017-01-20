<?php

require_once "global_class.php";

class User extends GlobalClass {

    public function __construct() {
        parent::__construct('users');
    }

    public function getUserAddress() {
        $address = $this->getFieldOnField('login', $_SESSION['login'], 'address');
        return $address[0]['address'];
    }

    public function changeUserFieldByName($field, $value, $username)  {
        $fields = array($field);
        $values = array($value);
        $where = "`login` = '$username'";
        return $this->update($fields, $values, $where);
    }

    public function addUser($login, $email, $password) {
        $fields = array('login', 'email', 'password', 'regdate', 'code');
        $code = md5($password.$login.$this->config->secret_word);
        $password = md5($password);
        $regdate = time();
        $values = array($login, $email, $password, $regdate, $code);
        return $this->insert($fields, $values);
    }

    public function getUserPassword() {
        $password = $this->getFieldOnField('login', $_SESSION['login'], 'password');
        return $password[0]['password'];
    }

    public function updatePasswordByLogin($password) {
        $password = md5($password);
        $where = "`login` = '".$_SESSION['login']."'";
        return $this->updateUniqueField('password', $password, $where);
    }

    public function getUsersOrderDesc($order, $desc, $n) {                                 // getting users in certain order
        return $this->getNStringsOrder($order, $desc, $n);
    }

    public function getUserLogin($id) {
        $login = $this->getFieldOnID($id, 'login');
        return $login['login'];
    }

    public function getUserEmail($id) {
        $email = $this->getFieldOnID($id, 'email');
        return $email['email'];
    }

}

 ?>