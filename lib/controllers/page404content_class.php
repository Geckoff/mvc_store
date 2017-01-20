<?php

require_once "modules_class.php";

class Page404Content extends Modules {

    protected function getContent() {

        $this->template->set('title', 'Page Does Not Exist');
        $this->template->set('keywords', 'Page Does Not Exist');
        $this->template->set('description', 'Page Does Not Exist');
        $this->template->set('tpl_name', '404');
    }
}








 ?>