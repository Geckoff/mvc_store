<?php

require_once "modules_class.php";

class SectionContent extends Modules {

    private $id;

    protected function getContent() {
        $this->id = $this->check->checkID($this->data['id']);
        $this->checkIssetSection($this->id);                       // Checking if current section exists
        $this->checkAttrFieldSort();                               // Preventing usage of sorting parameters from $_GET array in inappropriate way in URL
        $this->template->set('title', $this->section->getSectionName($this->id));
        $this->template->set('keywords', $this->section->getSectionName($this->id));
        $this->template->set('description', $this->section->getSectionName($this->id));
        $this->template->set('tpl_name', 'products');              // Setting template file from tmpl directory
        $this->getSortLinks($this->id);                            // Links used for sorting of items in catalog
        $this->pagination_count = count($this->getSectionProducts());
        $this->template->set('products', $this->getSortedSectionProducts());
    }

    protected function getSortedSectionProducts() {     // Getting sorted items according to sorting parametres which were set
        $limit = $this->getLimit();                     // Getting starting and ending records in selection. Used for pagination
        if ($this->data['field'] == 'price' && $this->data['sort'] == 'up') return $this->product->getSectionProductsOrderDesc('price', true, $limit, $this->id);
        if ($this->data['field'] == 'price' && $this->data['sort'] == 'down') return $this->product->getSectionProductsOrderDesc('price', false, $limit, $this->id);
        if ($this->data['field'] == 'title' && $this->data['sort'] == 'up') return $this->product->getSectionProductsOrderDesc('title', true, $limit, $this->id);
        if ($this->data['field'] == 'title' && $this->data['sort'] == 'down') return $this->product->getSectionProductsOrderDesc('title', false, $limit, $this->id);
        return $this->product->getNSectionProductsDate($limit, $this->id);    // Getting list of items if sorting is not set
    }

    private function checkIssetSection($id) {
        $sections = $this->section->getAllSections();
        foreach ($sections as $section_id) {
            if ($section_id['id'] == $id) return true;
        }
        $this->url->notFound();
    }

    private function getSectionProducts() {             // Geting items without sorting
        return $this->product->getStringOnField('section_id', $this->id);
    }


}








 ?>