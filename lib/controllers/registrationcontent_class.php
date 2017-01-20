<?php

require_once "modules_class.php";

class RegistrationContent extends Modules {

    protected function getContent() {
        $this->template->set('title', 'Регистрация');
        $this->template->set('keywords', 'Регистрация');
        $this->template->set('description', 'Регистрация');
        $this->template->set('captcha', $this->url->getCaptcha());    // depicting captcha code
        $this->template->set('reg_email', $_SESSION['reg_email']);    
        $this->template->set('reg_login', $_SESSION['reg_login']);
        $this->template->set('tpl_name', 'registration');
    }

}








 ?>