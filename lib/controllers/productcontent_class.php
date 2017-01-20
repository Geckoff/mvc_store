<?php

require_once "modules_class.php";;

class ProductContent extends Modules {

    protected function getContent() {
        $title_link = $this->url->getProductTitleLink();
        $product = $this->product->getTheProduct($title_link);


        $this->template->set('title', $product['title']);
        $this->template->set('keywords', $product['title']);
        $this->template->set('description', $product['title']);
        $this->template->set('section_title', $this->section->getSectionName($product['section_id']));
        $this->template->set('section_url_product', $this->url->getSectionUrl().$product['section_id']);
        $this->template->set('product', $product);
        $this->template->set('similar_products', $this->product->getProductsOnSection($product['section_id']));
        $this->template->set('tpl_name', 'single-product');
    }


}








 ?>