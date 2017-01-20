<?php

require_once "adminmodules_class.php";

class AdminPageContent extends AdminModules {

    protected $table;

    protected function getContent() {
        $this->table = 'page';
        $this->template->set('title', 'Страницы');
        $this->template->set('keywords', 'Страницы');
        $this->template->set('description', 'Страницы');
        $this->template->set('right_tpl_name', array($this->setTable()));
        $this->template->set('left_tpl_string', array($this->setAddButton('editpage', 'Страницу')));

        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('title', '');
        $column_params['name'] = array('Название', 'Действие');
        $column_params['width'] = array('', '');
        return $column_params;
    }

    protected function getColumnData($page) {
        $columns_data = array(
            $page['title'],
            $this->getActionTableLinks($page['id'], 'page')
        );
        return $columns_data;
    }



}








 ?>