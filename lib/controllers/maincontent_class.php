<?php

require_once "modules_class.php";

class MainContent extends Modules {

    protected function getContent() {

        $this->checkAttrFieldSort();                               // Preventing usage of sorting parameters from $_GET array in inappropriate way in URL
        $this->template->set('title', 'Welcome to DVD shop');
        $this->template->set('keywords', 'buy dvd');
        $this->template->set('description', 'buy many dvd');
        $this->template->set('tpl_name', 'products');              // Setting template file from tmpl directory
        $this->getSortLinks();                                     // Links used for sorting of items in catalog
        $this->pagination_count = count($this->getProducts());
        $this->template->set('products', $this->getSortedMainProducts());
    }

    private function getProducts() {
        return $this->product->getAllStrings();
    }

    protected function getSortedMainProducts() {    // Getting sorted items according to sorting parametres which were set
        $limit = $this->getLimit();                 // Getting starting and ending records in selection. Used for pagination
        if ($this->data['field'] == 'price' && $this->data['sort'] == 'up') return $this->product->getMainProductsOrderDesc('price', true, $limit);
        if ($this->data['field'] == 'price' && $this->data['sort'] == 'down') return $this->product->getMainProductsOrderDesc('price', false, $limit);
        if ($this->data['field'] == 'title' && $this->data['sort'] == 'up') return $this->product->getMainProductsOrderDesc('title', true, $limit);
        if ($this->data['field'] == 'title' && $this->data['sort'] == 'down') return $this->product->getMainProductsOrderDesc('title', false, $limit);
        return $this->product->getNProductsDate($limit);     // Getting list of items if sorting is not set
    }

}








 ?>