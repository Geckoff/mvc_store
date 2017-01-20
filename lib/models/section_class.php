<?php

require_once "global_class.php";

class Section extends GlobalClass {

    public function __construct() {
        parent::__construct('sections');
    }

    public function getAllSections() {                      // list of categories
        return $this->getAllStrings();
    }

    public function getSectionName($id) {
        $title = $this->getFieldOnID($id, 'title');
        return $title['title'];
    }

    public function getSectionsOrderDesc($order, $desc, $n) {     // Getting sorted items for current category
        return $this->getNStringsOrder($order, $desc, $n);
    }

    public function getSectionTitle($id) {
        return $this->getFieldOnID($id, 'title');  
    }
}

 ?>