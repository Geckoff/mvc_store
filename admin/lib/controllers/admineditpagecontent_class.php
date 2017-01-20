<?php

require_once "adminmodules_class.php";

class AdminEditPageContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'page';
        $this->template->set('title', $this->getHeaderTitle('Страницы'));
        $this->template->set('keywords', $this->getHeaderTitle('Страницы'));
        $this->template->set('description', $this->getHeaderTitle('Страницы'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Страницы'));
        $this->template->set('edit_form_string', $this->setEditFormString());
        $this->template->set('right_tpl_name', array('editform'));
    }

    protected function getHeaderTitleItemName() {
        $title = $this->discount->getFieldOnID($this->data['id'], 'title');
        return $title['title'];
    }

    protected function setDataAdd() {
        $js = '<script type="text/javascript">
        	CKEDITOR.replace( "text" );
        </script>';
        $dataset = array(
            array('text', 'Название', 'title'),
            array('textarea', 'Содержание', 'text'),
            array('spec', '', '', $js, ''),
        );
        return $dataset;
    }

}








 ?>