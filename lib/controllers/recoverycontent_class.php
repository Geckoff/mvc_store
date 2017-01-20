<?php

require_once "modules_class.php";

class RecoveryContent extends Modules {

    protected function getContent() {
        $this->template->set('title', 'Восстановление пароля');
        $this->template->set('keywords', 'Восстановление пароля');
        $this->template->set('description', 'Восстановление пароля');
        $this->template->set('tpl_name', 'recovery');
    }
}








 ?>