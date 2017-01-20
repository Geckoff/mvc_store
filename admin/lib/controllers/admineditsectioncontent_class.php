<?php

require_once "adminmodules_class.php";

class AdminEditSectionContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'section';
        $this->template->set('title', $this->getHeaderTitle('Категории'));
        $this->template->set('keywords', $this->getHeaderTitle('Категории'));
        $this->template->set('description', $this->getHeaderTitle('Категории'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Категории'));
        $this->template->set('edit_form_string', $this->setEditFormString());
        $this->template->set('right_tpl_name', array('editform'));
        //$this->template->set('file_form', true);
    }

    protected function getHeaderTitleItemName() {
        $title = $this->section->getSectionTitle($this->data['id']);
        return $title['title'];
    }

    protected function setDataAdd() {
        $dataset = array(
            array('text', 'Название', 'title')
        );
        return $dataset;
    }

}








 ?>