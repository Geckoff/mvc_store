<?php

require_once "modules_class.php";

class PageContent extends Modules {

    protected function getContent() {
        /**
        * Function getView() which is called below is normally getting Controller name.
        * However in this case it's getting the name of the page from URL.
        * Example: website.com/first_level. First_level is always controller name except of Page pages.
        * For Page pages first_level is page name which is used as an id in friendly URL for pulling record out of DB.
        **/
        $page_content = $this->getPageContent($this->url->getView());
        $this->template->set('title', $page_content['title']);
        $this->template->set('keywords', $page_content['title']);
        $this->template->set('description', $page_content['title']);
        $this->template->set('page_title', $page_content['title']);
        $this->template->set('page_content', $page_content['text']);
        $this->template->set('tpl_name', 'page');          // Setting template file from tmpl directory
    }

    private function getPageContent($title_link) {
        $page_content = $this->page->getStringOnField('title_link', $title_link);
        return $page_content[0];
    }
}








 ?>