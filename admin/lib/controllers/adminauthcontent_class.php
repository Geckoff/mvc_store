<?php

require_once "template_class.php";
require_once "url_class.php";
require_once "user_class.php";
require_once "page_class.php";


class AdminAuthContent {

    protected $template;
    protected $url;
    protected $user;
    protected $data;

    public function __construct() {
        session_start();

        $this->template = new Template('adminauth');
        $this->url = new Url();
        $this->user = new User();
        if ($this->comparePassword()) {
            $this->url->adminSection();
        }
        $this->data = $this->xss($_REQUEST);
        $this->template->set('air_message', $_SESSION['air_message']);
        $this->template->set('title', 'Authorization');
        $this->template->set('main_url', $this->url->getMainPage());
        $this->template->set('adminfunction_url', $this->url->getAdminFunctionUrl());
        $this->template->set('adminauth_login', $_SESSION['adminauth_login']);


        unset($_SESSION['air_message']);
        $this->template->display('admin/');
    }


    protected function xss($data) {
        foreach($data as $key => $value) {
            if (is_array($value)) $this->xss($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function comparePassword() {
        $password = $this->user->getFieldOnField('login', $_SESSION['login'], 'password');
        $password = $password[0]['password'];
        $admin = $this->user->getFieldOnField('login', $_SESSION['login'], 'admin');
        if ($admin[0]['admin'] !== '1') {
            return false;
        }
        if (md5($_SESSION['password']) == $password) {
            return true;
        }
        else {
            unset ($_SESSION['login'], $_SESSION['password']);
            return false;
        }
    }



}


?>