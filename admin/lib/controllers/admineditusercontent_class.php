<?php

require_once "adminmodules_class.php";

class AdminEditUserContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'user';
        $this->template->set('title', $this->getHeaderTitle('Пользователи'));
        $this->template->set('keywords', $this->getHeaderTitle('Пользователи'));
        $this->template->set('description', $this->getHeaderTitle('Пользователи'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Пользователи'));
        $this->template->set('edit_form_string', $this->setEditFormString());
        $this->template->set('right_tpl_name', array('editform'));
    }

    protected function getHeaderTitleItemName() {
        $title = $this->user->getUserLogin($this->data['id']);
        return $title;
    }

    protected function setDataAdd() {
        if (isset($this->data['id'])) {
            $newpas = 'edit-new-pas';
            $reppas = 'edit-rep-pas';
            $newpas_title = 'Установить новый пароль';
        }
        else {
            $newpas = 'add-new-pas';
            $reppas = 'add-rep-pas';
            $newpas_title = 'Пароль';
        }
        $dataset = array(
            array('text', 'Логин', 'login'),
            array('text', 'Емэйл', 'email'),
            array('textarea', 'Адрес', 'address'),
            array('checkbox', 'Админ. права', 'admin'),
            array('password', $newpas_title, $newpas),
            array('password', 'Повторите пароль', $reppas)
        );
        return $dataset;
    }

}








 ?>