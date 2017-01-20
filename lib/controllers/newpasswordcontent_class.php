<?php

require_once "modules_class.php";
require_once "manage_class.php";

class NewPasswordContent extends Modules {

    private $manage;

    public function __construct() {
        $this->manage = new Manage();
        parent::__construct();
    }

    protected function getContent() {
        $this->checkRecoveryCode();            // validating recovery code
        $this->template->set('title', 'Задайте новый пароль');
        $this->template->set('keywords', 'Задайте новый пароль');
        $this->template->set('description', 'Задайте новый пароль');
        $this->template->set('recover_code', $this->data['code']);
        $this->template->set('tpl_name', 'newpassword');                 // Setting template file from tmpl directory
    }

    private function checkRecoveryCode() {
        /**
        * When recovery request is submitted, recovery code is inserting to recover_code field in User table in DB.
        * Mail with link containing this code as a get parameter is sent to user's email.
        * Only following the link with right code will cause following password recovery page.
        **/
        if (!$this->user->getStringOnField('recover_code', $this->data['code'])) { // validating recovery code parameter
            $this->manage->goToMessagePage('RECOVERY_ATTEMPT_ERROR');
        }
    }
}








 ?>