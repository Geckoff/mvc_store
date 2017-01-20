<?php

require_once "modules_class.php";

class MessageContent extends Modules {

    protected function getContent() {
        if (!isset($_SESSION['msg_title'])) $this->url->mainPage();          // if there is no any info message user is redirected to main page
        $this->template->set('title', $this->getMessageTitle($_SESSION['msg_title']));
        $this->template->set('keywords', $this->getMessageTitle($_SESSION['msg_title']));
        $this->template->set('message_title', $this->getMessageTitle($_SESSION['msg_title']));   // getting message title
        $this->template->set('message_text', $this->getMessageText($_SESSION['msg_title']));     // getting message body
        unset($_SESSION['msg_title']);
        $this->template->set('tpl_name', 'message');
    }

    private function getMessage($name) {
        $file = parse_ini_file($this->config->dir_text."messages.ini");   // message texts are located in messages.ini file
        return $file[$name];
    }

    private function getMessageTitle($name) {
        return $this->getMessage($name.'_TITLE');
    }

    private function getMessageText($name) {
        return $this->getMessage($name.'_TEXT');
    }

}








 ?>