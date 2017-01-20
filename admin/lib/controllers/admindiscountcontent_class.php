<?php

require_once "adminmodules_class.php";

class AdminDiscountContent extends AdminModules {

    protected $table;

    protected function getContent() {
        $this->table = 'discount';
        $this->template->set('title', 'Скидки');
        $this->template->set('keywords', 'Скидки');
        $this->template->set('description', 'Скидки');
        $this->template->set('right_tpl_name', array($this->setTable()));
        $this->template->set('left_tpl_string', array($this->setAddButton('editdiscount', 'Скидка')));

        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('code', 'value', '');
        $column_params['name'] = array('Код', 'Значение', 'Действие');
        $column_params['width'] = array('', '', '');
        return $column_params;
    }

    protected function getColumnData($discount) {
        $columns_data = array(
            $discount['code'],
            $discount['value'],
            $this->getActionTableLinks($discount['id'], 'discount')
        );
        return $columns_data;
    }



}








 ?>