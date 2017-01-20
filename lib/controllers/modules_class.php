<?php

/**
* Core user side controller class for MVC architecture
**/

/**
* Model MVC classes are included below
* Each table from database has its own Model class.
**/
require_once "section_class.php";
require_once "product_class.php";
require_once "user_class.php";
require_once "page_class.php";

require_once "template_class.php";
require_once "url_class.php";
require_once "check_class.php";
require_once "config_class.php";

/*class Test {

    public $i = 1;
    public $req1;

    public function testFunc() {
        echo '111111111111111111111111111111111111111111';
        return $this;
    }

    public function testFunc2() {
        echo '333333333333';
        return $this;
    }

    public function testFunc3() {
        echo '2222222222';
        return $this;
    }

    public static function firstPart() {
        $a = new $this;
        echo 'asd';
        return $a;
    }
}*/


abstract class Modules {

    protected $template;
    protected $url;
    protected $user;
    protected $page;
    protected $section;
    protected $product;
    protected $data;
    protected $check;
    protected $config;
    protected $pagination_count;

    public function __construct() {
        session_start();
        $this->template = new Template('main');   // base template for user side
        $this->url = new Url();                   // class for URLs interaction
        $this->data = $this->xss($_REQUEST);      // processing of incoming data with htmlspecialchars function
        $this->section = new Section();
        $this->product = new Product();
        $this->check = new Check();               // class is used for different types of data checks
        $this->config = new Config();             // project configuration
        $this->user = new User();
        $this->page = new Page();
        /**
        * Data for showing in basic template is set with $this->template->set function below
        **/
        $this->template->set('phone', '937 9992');
        $this->template->set('schedule', 'we work from 9.00 till 10.00');
        $this->template->set('cart_url', $this->url->getCartUrl());
        $this->template->set('cart_page_url', $this->url->getCartPageUrl());
        $this->template->set('function_url', $this->url->getFunctionUrl());
        $this->template->set('section_url', $this->url->getSectionUrl());
        $this->template->set('profile_url', $this->url->getProfileUrl());
        $this->template->set('recovery_url', $this->url->getRecoveryUrl());
        $this->template->set('registration_page', $this->url->getRegPageUrl());
        $this->template->set('main_url', $this->url->getMainPage());
        $this->template->set('sections', $this->section->getAllSections());         // list of categories
        $this->template->set('cart_num', $this->numberItemsCart());                 // quantity of items added to cart
        $this->template->set('cart_comprice', $this->getCommonPriceCart());         // price of items added to cart
        $this->template->set('air_message', $_SESSION['air_message']);
        $this->template->set('main_air_message', $_SESSION['main_air_message']);
        $this->template->set('current_page', $this->getCurrentPage());              // current page # for pagination
        if ($this->comparePassword()) {                                             // validation user's authorization
            $this->template->set('login', $_SESSION['login']);
            $this->template->set('authorized', 1);
            $this->url->AuthRedirect(get_class($this));                             // denying access for certain pages for authorized user
        }
        else {                                                                      // denying access for certain pages for not authorized user
            $this->url->noAuthRedirect(get_class($this));
        }
        unset($_SESSION['air_message']);
        unset($_SESSION['main_air_message']);
        $this->getContent();
        /**
        * Pagination building.
        * Pagination is used for catalog pages only.
        * Pagination is built in pagination.tpl file.
        **/
        $this->template->set('pagination_pages', $this->getPagesCount());                   // quantity of pages for current page pagination
        $this->template->set('current_section', $this->url->getPaginationUrl());            // getting URL for current catalog section WITH opportunity of setting pagination page #
        $this->template->set('current_section_short', $this->url->getPaginationUrl(1));     // getting URL for current catalog section WITHOUT opportunity of setting pagination page #
        /**
        * Displaying of the page.
        * Function below is loading base template .tpl file.
        * Base .tpl file includes content .tpl file in its body.
        * Content .tpl file name is set in controller class of current page.
        **/

        /*Test::firstPart(); */
        //$this->interesting()->testFunc()->testFunc2()->testFunc3();
        $this->template->display();
    }

    /*public function interesting() {
        $a = new Test();
        return $a;
    }*/

    abstract protected function getContent();

    protected function getCurrentPage() {                               // getting current page # for pagintaion
        if (isset($this->data['page'])) return $this->data['page'];
        else return 1;
    }

    protected function numberItemsCart() {
        return count($_SESSION['added_items']);
    }

    protected function getCommonPriceCart() {
        if ($this->numberItemsCart() > 0) return $this->product->getCommonPrice($_SESSION['added_items']);
        return 0;
    }

    protected function getSortLinks($id='') {                              // Links used for sorting of items in catalog
        $this->template->set('sort_price_up', $this->url->getSortUrl('price', 'up', $id));
        $this->template->set('sort_price_dn', $this->url->getSortUrl('price', 'down', $id));
        $this->template->set('sort_title_up', $this->url->getSortUrl('title', 'up', $id));
        $this->template->set('sort_title_dn', $this->url->getSortUrl('title', 'down', $id));
    }

    protected function xss($data) {
        foreach($data as $key => $value) {
            if (is_array($value)) $this->xss($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function getLimit() {                                          // Function used for setting limits for selection of relevant items...
        if (isset($this->data['page'])) {                                    // ...on a section or main page while pagination is used
            $l1 = ($this->data['page'] - 1) * $this->config->posts_per_page;
            $l2 = $this->config->posts_per_page;
            $limit = "$l1, $l2";
        }
        else $limit = "0, ".$this->config->posts_per_page;
        return $limit;
    }

    protected function checkAttrFieldSort() {                                // Preventing usage of sorting parameters from $_GET array in inappropriate way in URL
        if (isset($this->data['field']) || isset($this->data['sort'])) {
            if (isset($this->data['field']) && isset($this->data['sort'])) {
                if ($this->data['field'] == 'title' || $this->data['field'] == 'price') {
                    if ($this->data['sort'] == 'up' || $this->data['sort'] == 'down') {

                    }
                    else {
                        $this->url->notFound();
                    }
                }
                else {
                    $this->url->notFound();
                }
            }
            else {
                $this->url->notFound();
            }
        }
    }

    private function getPagesCount() {
        $pages_count = ceil($this->pagination_count / $this->config->posts_per_page);     // pagination_count is set in Section constructor class
        return $pages_count;
    }

    protected function comparePassword() {
        $password = $this->user->getFieldOnField('login', $_SESSION['login'], 'password');
        $password = $password[0]['password'];
        if (md5($_SESSION['password']) == $password) {
            return true;
        }
        else {
            unset ($_SESSION['login'], $_SESSION['password']);
            return false;
        }
    }



}


?>