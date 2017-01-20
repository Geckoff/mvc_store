<?php

require_once "config_class.php";      

class Template {

    private $config;
    private $tmpl_name;
    private $data = array();

    public function __construct($tmpl_name) {    // $tmpl_name - template file which is loading in certain spot in base template
        $this->config = new Config();
        $this->tmpl_name = $tmpl_name;
    }

    public function set($name, $value) {    // setting variable
        $this->data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->data[$name])) return $this->data[$name];
        return "";
    }

    public function display($admin = '') {       // displaying base .tpl file.
        ob_start();
        include ($admin.$this->config->tmpl_dir.$this->tmpl_name.'.tpl');
        echo ob_get_clean();
    }


}

 ?>