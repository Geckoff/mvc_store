<?php

require_once "global_class.php";

class Page extends GlobalClass {

    public function __construct() {
        parent::__construct('pages');
    }

    public function isPage($link_title) {           
        return $this->getStringOnField('title_link', $link_title);
    }

}

 ?>