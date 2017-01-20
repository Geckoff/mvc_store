<?php

require_once "adminmodules_class.php";

class AdminMainContent extends AdminModules {


    protected function getContent() {

        $this->template->set('title', 'Admin Panel');
        $this->template->set('keywords', 'Admin Panel');
        $this->template->set('description', 'Admin Panel');
        $this->template->set('left_tpl_string', array('<p>Понравилась ли вам наша система?</p>'));
        $this->template->set('right_tpl_string', array('<h1>Welcome to Админ панель</h1>'));
        //$this->template->set('tpl_name', 'products');
    }

}








 ?>