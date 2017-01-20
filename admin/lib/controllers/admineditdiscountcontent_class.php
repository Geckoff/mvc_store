<?php

require_once "adminmodules_class.php";

class AdminEditDiscountContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'discount';
        $this->template->set('title', $this->getHeaderTitle('Скидки'));
        $this->template->set('keywords', $this->getHeaderTitle('Скидки'));
        $this->template->set('description', $this->getHeaderTitle('Скидки'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Скидки'));
        $this->template->set('edit_form_string', $this->setEditFormString());
        $this->template->set('right_tpl_name', array('editform'));
    }

    protected function getHeaderTitleItemName() {
        $code = $this->discount->getFieldOnID($this->data['id'], 'code');
        return $code['code'];
    }

    protected function setDataAdd() {
        $dataset = array(
            array('text', 'Код', 'code'),
            array('text', 'Значение', 'value')
        );
        return $dataset;
    }

}








 ?>