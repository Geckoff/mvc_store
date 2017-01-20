<?php

require_once "adminmodules_class.php";

class AdminSectionContent extends AdminModules {

    protected $table;

    protected function getContent() {
        $this->table = 'section';
        $this->template->set('title', 'Категории');
        $this->template->set('keywords', 'Категории');
        $this->template->set('description', 'Категории');
        $this->template->set('right_tpl_name', array($this->setTable()));
        $this->template->set('left_tpl_string', array($this->setAddButton('editsection', 'Категорию')));
        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('title', '');
        $column_params['name'] = array('Название', 'Действие');
        $column_params['width'] = array('', '150');
        return $column_params;
    }

    protected function getColumnData($section) {
        $columns_data = array(
            $section['title'],
            $this->getActionTableLinks($section['id'], 'section')
        );
        return $columns_data;
    }

}








 ?>