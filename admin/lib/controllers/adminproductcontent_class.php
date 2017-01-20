<?php

require_once "adminmodules_class.php";

class AdminProductContent extends AdminModules {

    protected $excppar;

    protected function getContent() {

        $this->excppar = 'secid';                         // exceptional param, which is not supposed to be deleted from page url while sorting links for main table being built
        $this->template->set('title', 'Продукты');
        $this->template->set('keywords', 'Продукты');
        $this->template->set('description', 'Продукты');
        $this->template->set('right_tpl_string', array($this->setCategory()));     // getting title for main page
        $this->template->set('right_tpl_name', array($this->setTable()));          // getting main table
        $this->template->set('left_tpl_string', array($this->setAddButton('editproduct', 'Фильм')));   // setting link for adding item
        $this->template->set('left_tpl_name', array($this->setCatList()));         // setting bottom part of right column
        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('title', '', '', 'date', 'price', '');    // setting columns which support filtering
        $column_params['name'] = array('Название', 'Изображение', 'Категория', 'Дата внесения', 'Стоимость', 'Действие');   // setting columns names
        $column_params['width'] = array('217', '', '148', '', '', '150');          // setting columns width
        return $column_params;
    }

    protected function getColumnData($product) {
        $columns_data = array(
            $product['title'],
            '<img src="'.$this->url->getProdutImageFolder().$product['img'].'">',
            $this->section->getSectionName($product['section_id']),
            date("d.m.y H:i", $product['date']),
            $product['price'],
            $this->getActionTableLinks($product['id'], 'product')        // "delete" and "edit" buttons 
        );
        return $columns_data;
    }

    protected function getDataSet() {      // overriding getDataSet method form parent class because additional get parameter 'secid' is used
        $limit = $this->getLimit();
        if (isset($this->data['secid'])) $id = $this->data['secid'];
        else $id = '';
        if (isset($this->data['filter']) && isset($this->data['dir'])) {
            if ($this->data['dir'] == 'up') $dir = true;
            else $dir = false;
            $products = $this->product->getSectionProductsOrderDesc($this->data['filter'], $dir, $limit, $id);
        }
        else $products = $this->product->getSectionProductsOrderDesc(date, true, $limit, $id);
        return $products;
    }

    protected function getGeneralDataSet() {    // overriding getGeneralDataSet method form parent class because additional get parameter 'secid' is used
        if (isset($this->data['secid'])) $id = $this->data['secid'];
        else $id = '';
        $dataset = $this->product->getSectionProductsOrderDesc(date, true, '', $id);
        return  $dataset;
    }

    private function setCategory() {               // getting title for main page
        if (isset($this->data['secid'])) $category = $this->section->getSectionName($this->data['secid']);
        else $category = 'Все категории';
        return '<h3 class="product-category">Категория: '.$category.'</h3>';
    }

    protected function setLeftCats($cur_link) {         // setting catrgoris list in left column
        $dataset = $this->section->getAllSections();
        $catlist = array();
        $catlist[0]['name'] = 'Все категории';
        $catlist[0]['link'] = $cur_link;
        $catlist[0]['params'] = array('' => '');
        for ($i = 1; $i < count($dataset) + 1; $i++) {
            $catlist[$i]['name'] = $dataset[$i - 1]['title'];
            $catlist[$i]['link'] = $cur_link;
            $catlist[$i]['params'] = array('secid' => $dataset[$i - 1]['id']);
        }
        return $catlist;
    }

}








 ?>