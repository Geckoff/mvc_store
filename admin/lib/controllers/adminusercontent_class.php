<?php

require_once "adminmodules_class.php";

class AdminUserContent extends AdminModules {

    protected $table;

    protected function getContent() {
        $this->table = 'user';
        $this->template->set('title', 'Пользователи');
        $this->template->set('keywords', 'Пользователи');
        $this->template->set('description', 'Пользователи');
        $this->template->set('right_tpl_name', array($this->setTable()));
        $this->template->set('left_tpl_string', array($this->setAddButton('edituser', 'Пользователя')));
        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('login', 'email', 'admin', 'regdate', '', '');
        $column_params['name'] = array('Логин', 'Емэйл', 'Админ. права', 'Дата регистрации', 'Адрес', 'Действие');
        $column_params['width'] = array('150', '200', '', '', '200', '150');
        return $column_params;
    }

    protected function getColumnData($user) {
        if ($user['admin'] == 0) $admin = 'Нет';
        else $admin = 'Да';
        $columns_data = array(
            $user['login'],
            $user['email'],
            $admin,
            date("d.m.y H:i", $user['regdate']),
            $user['address'],
            $this->getActionTableLinks($user['id'], 'user')
        );
        return $columns_data;
    }

}








 ?>