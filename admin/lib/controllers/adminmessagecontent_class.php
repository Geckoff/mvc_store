<?php

require_once "adminmodules_class.php";

class AdminMessageContent extends AdminModules {


    protected function getContent() {
        if (!isset($_SESSION['msg_title'])) $this->url->mainAdminPage();
        $this->template->set('description', 'Сообщение');
        $this->template->set('title', $this->getMessageTitle($_SESSION['msg_title']));
        $this->template->set('keywords', $this->getMessageTitle($_SESSION['msg_title']));
        $this->template->set('right_tpl_string', array($this->setMessage()));
        unset($_SESSION['msg_title']);
    }

    private function getMessage($name) {
        $file = parse_ini_file($this->config->dir_admin_text."adminmessages.ini");
        return $file[$name];
    }

    private function getMessageTitle() {
        return $this->getMessage($_SESSION['msg_title'].'_TITLE');
    }

    private function getMessageText() {
        return $this->getMessage($_SESSION['msg_title'].'_TEXT');
    }

    private function setMessage() {
        $message = '<h1>'.$this->getMessageTitle().'</h1><h3>'.$this->getMessageText().'</h3>';
        return $message;
    }

}







 ?>