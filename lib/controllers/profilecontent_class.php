<?php

require_once "modules_class.php";;

class ProfileContent extends Modules {

    protected function getContent() {
        $this->template->set('title', 'Настройки профиля');
        $this->template->set('keywords', 'Настройки профиля');
        $this->template->set('description', 'Настройки профиля');
        $this->template->set('tpl_name', 'profile');
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            $this->template->set('address', $this->user->getUserAddress());  
        }


    }



}








 ?>