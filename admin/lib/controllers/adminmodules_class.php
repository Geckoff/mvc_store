<?php

/**
* Core admin side controller class for MVC architecture
**/

/**
* Model MVC classes are included below
* Each table from database has its own Model class.
**/

require_once "section_class.php";
require_once "discount_class.php";
require_once "check_class.php";
require_once "order_class.php";
require_once "config_class.php";
require_once "product_class.php";
require_once "template_class.php";
require_once "url_class.php";
require_once "user_class.php";
require_once "page_class.php";


abstract class AdminModules {

    protected $template;
    protected $url;
    protected $user;
    protected $page;
    protected $section;
    protected $discount;
    protected $product;
    protected $data;
    protected $check;
    protected $config;
    protected $order;
    protected $pagination_count;
    protected $posts_per_page;

    public function __construct() {
        session_start();
        $this->template = new Template('adminmain');    // base template for admin side
        $this->url = new Url();                         // class for URLs interaction
        $this->data = $this->xss($_REQUEST);            // processing of incoming data with htmlspecialchars function
        $this->section = new Section();
        $this->discount = new Discount();
        $this->product = new Product();
        $this->check = new Check();                     // class is used for different types of data checks
        $this->config = new Config();                   // project configuration
        $this->order = new Order();
        $this->user = new User();
        $this->page = new Page();
        $this->template->set('function_url', $this->url->getFunctionUrl());                // link to functions.php
        $this->template->set('adminfunction_url', $this->url->getAdminFunctionUrl());      // link to adminfunctions.php
        $this->template->set('air_message', $_SESSION['air_message']);
        $this->template->set('main_url', $this->url->getMainPage());
        $this->template->set('sections', array('Фильмы'=>$this->url->getAdminPage().'product', 'Категории'=>$this->url->getAdminPage().'section', 'Пользователи'=>$this->url->getAdminPage().'user', 'Заказы'=>$this->url->getAdminPage().'order', 'Скидки'=>$this->url->getAdminPage().'discount', 'Страницы'=>$this->url->getAdminPage().'page')); // admin dashboard top menu
        $this->template->set('current_page', $this->getCurrentPage());                     // current page # for pagination
        $this->template->set('pages_quant', array(2, 3, 4));                               // quantity of pages ti display in dashboard main table
        if (isset($_COOKIE["Pagequant"])) {
            $this->posts_per_page = $_COOKIE["Pagequant"];
        }
        else  $this->posts_per_page = 2;

        if (!$this->comparePassword()) {
            $this->url->adminAuth();
        }
        unset($_SESSION['air_message']);
        unset($_SESSION['main_air_message']);
        $this->getContent();
        /**
        * Displaying of the page.
        * Function below is loading base template .tpl file.
        * Base .tpl file includes content .tpl files in its body.
        * Base template has 2 spots to include .tpl files and 2 spots to include html code built in controller class.
        **/
        $this->template->display('admin/');
    }

    abstract protected function getContent();

    protected function getCurrentPage() {                                    // getting current page # for pagintaion
        if (isset($this->data['page'])) return $this->data['page'];
        else return 1;
    }

    private function getPagesCount() {
        $pages_count = ceil(count($this->getGeneralDataSet()) / $this->posts_per_page);     // getGeneralDataSet() is selecting all the records from db table
        return $pages_count;
    }

    protected function getLimit() {                          // Function used for setting limits for selection of relevant items...
        if (isset($this->data['page'])) {                    // ...in the main table while pagination is used
            $l1 = ($this->data['page'] - 1) * $this->posts_per_page;
            $l2 = $this->posts_per_page;
            $limit = "$l1, $l2";
        }
        else $limit = "0, ".$this->posts_per_page;
        return $limit;
    }

    protected function xss($data) {
        foreach($data as $key => $value) {
            if (is_array($value)) $this->xss($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    protected function comparePassword() {
        $password = $this->user->getFieldOnField('login', $_SESSION['login'], 'password');
        $password = $password[0]['password'];
        $admin = $this->user->getFieldOnField('login', $_SESSION['login'], 'admin');
        if ($admin[0]['admin'] !== '1') return false;
        if (md5($_SESSION['password']) == $password) {
            return true;
        }
        else {
            unset ($_SESSION['login'], $_SESSION['password']);
            return false;
        }
    }

    protected function setTable() {
        $this->template->set('pagination_pages', $this->getPagesCount());                // quantity of pagination pages
        $this->template->set('current_section', $this->url->getPaginationUrl());         // getting URL for current page WITH opportunity of setting pagination page # (with ?page= parameter)
        $this->template->set('current_section_short', $this->url->getPaginationUrl(1));  // getting URL for current page WITHOUT opportunity of setting pagination page # (without ?page= parameter)
        $this->template->set('upper_table', $this->setUpperTable());                     // setting up header of main table
        $this->template->set('lower_table', $this->setLowerTable());                     // setting up body of main table
        return 'table';
    }

    protected function getActionTableLinks($id, $class) {        // "delete" and "edit" buttons
        $link = '<a href="'.$this->url->getAdminPage().'edit'.$class.'?id='.$id.'">Редактировать</a><br><a class="delete" href="'.$this->url->getAdminFunctionUrl().'?func=del&table_name='.$class.'&id='.$id.'">Удалить</a>';
        return $link;
    }

    protected function getFilterLink($attr) {
        if ($attr == '') return '';
        if (isset($this->data[$this->excppar])) {    // excppar - parameter that is not supposed to be deleted while building URL
            $cur_page = $this->url->getPageUrlWtParams($this->excppar);
            $char = '&';
        }
        else {
            $cur_page = $this->url->getPageUrlWtParams();
            $char = '?';
        }
        if ($this->data['filter'] == $attr) {         // setting ascending and descending sorting
            if ($this->data['dir'] == 'up') {
                $link = $cur_page.$char.'filter='.$attr.'&dir=dn';
            }
            elseif($this->data['dir'] == 'dn') {
                $link = $cur_page.$char.'filter='.$attr.'&dir=up';
            }
        }
        else $link = $cur_page.$char.'filter='.$attr.'&dir=up';
        return $link;
    }

    protected function setUpperTable() {        // setting up header of main table
        $upper_table = array();
        $columns_params = $this->getColumnParams();                   // getting parameters of columns in the table
        $filter_columns = $columns_params['filter'];                  // getting columns for wich filters are available
        $name_columns = $columns_params['name'];                      // getting columns names
        $width_columns = $columns_params['width'];                    // getting columns width
        for ($i = 0; $i < count($filter_columns); $i++) {             // setting up each cell of table header
            $upper_table[$i]['column_name'] = $name_columns[$i];
            $upper_table[$i]['width'] = $width_columns[$i];
            $upper_table[$i]['link'] = $this->getFilterLink($filter_columns[$i]);
            if (isset($this->data['filter']) && isset($this->data['dir'])) {
                if ($this->data['filter'] == $filter_columns[$i]) {
                    if ($this->data['dir'] == 'up') $upper_table[$i]['filter'] = 'up-filter';
                    elseif ($this->data['dir'] == 'dn') $upper_table[$i]['filter'] = 'dn-filter';
                }
            }
        }
        return $upper_table;
    }

    protected function setLowerTable() {
        $products = $this->getDataSet();     // selecting data from db table
        for ($i = 0; $i < count($products); $i++) {
            $columns_data = $this->getColumnData($products[$i]); // Inserting data in the main table. Some fields may require addtional processing which is performed in extended class
            for ($j = 0; $j < count($columns_data); $j++) {
                $columns[$i][$j] = $columns_data[$j];
            }
        }
        return $columns;
    }



    protected function setAddButton($link, $name) {        // setting button for adding item of current admin page
        return '<p class="add"><a href="'.$this->url->getAdminPage().$link.'">Добавить '.$name.'</a></p>';
    }

    protected function setCatList() {
        $cur_page = $this->url->getPageUrlWtParams();
        $this->template->set('catlist', $this->setLeftCats($cur_page));
        return 'leftlist';
    }

    protected function getHeaderTitle($section) {
        if (isset($this->data['id'])) return  'Редактирование: '.$this->getHeaderTitleItemName();
        else return $section." - добавление";
    }

    protected function  setEditFormString() {
        $finaldataset = array();
        $dataset = $this->setDataAdd();
        for ($i = 0; $i < count($dataset); $i++) {    // making associative array out of $dataset
                $finaldataset[$i]['type'] = $dataset[$i][0];
                $finaldataset[$i]['input_title'] = $dataset[$i][1];
                $finaldataset[$i]['input_name'] = $dataset[$i][2];
                if ($finaldataset[$i]['type'] == 'spec'){      // "special" type of data which is requireing specific code to be inserted in the template file
                    $finaldataset[$i]['show_this'] = $dataset[$i][3];
                    $finaldataset[$i]['change_elem'] = $dataset[$i][4];
                }
        }
        if (isset($this->data['id'])) {     // setting fileds for "edit" page
            $class = $this->table_class;
            $itemdataset = $this->$class->getStringOnID($this->data['id']);       // getting original fields values
            $finaldataset = $this->insertValues($finaldataset, $dataset, $itemdataset);
            array_push($finaldataset, array('type' => 'hidden', 'input_title' => '', 'input_name' => 'id', 'input_value' => $this->data['id']));
            array_push($finaldataset, array('type' => 'hidden', 'input_title' => '', 'input_name' => 'func', 'input_value' => 'edit'));   // field is used for starting execution function of editing record in db
        }
        else {                              // setting fileds for "add" page
            $finaldataset = $this->insertValues($finaldataset, $dataset, $_SESSION['add_data']);
            array_push($finaldataset, array('type' => 'hidden', 'input_title' => '', 'input_name' => 'func', 'input_value' => 'add'));    // field is used for starting execution function of adding record into db
        }
        array_push($finaldataset, array('type' => 'submit', 'input_title' => $this->getSubmitName(), 'input_name' => 'submit', 'input_value' => ''));    // submit button
        array_push($finaldataset, array('type' => 'hidden', 'input_title' => '', 'input_name' => 'table_name', 'input_value' => $this->table_class));    // setting db table to work with
        return $finaldataset;
    }

    private function insertValues($finaldataset, $dataset, $array) {   // composing final data array fields + values
        for ($i = 0; $i < count($finaldataset); $i++) {
            if (is_array($dataset[$i][2])) {
                if (isset($dataset[$i][2]['selectname'])) {            // exception for select composing
                    $finaldataset[$i]['input_value'] = $array[$dataset[$i][2]['selectname']];
                }
            }
            /**
            * Since we use same function both for add and  edit pages, some of the values in fields might be void.
            * $array is array from $_SESSION if user is on add page and have already tried to save data
            * or array with db data if user is on add edit page.
            */
            elseif (isset($array[$dataset[$i][2]])) $finaldataset[$i]['input_value'] = $array[$dataset[$i][2]];
            else $finaldataset[$i]['input_value'] = '';
        }
        return $finaldataset;
    }

    protected function getSubmitName() {
        if (isset($this->data['id'])) return 'Редактировать';
        return 'Добавить';
    }

    protected function getDataSet() {      // selecting data from db table
        $table = $this->table;
        $limit = $this->getLimit();
        if (isset($this->data['filter']) && isset($this->data['dir'])) {     // considering filters
            if ($this->data['dir'] == 'up') $dir = true;
            else $dir = false;
            $products = $this->$table->getNStringsOrder($this->data['filter'], $dir, $limit);
        }
        else $products = $this->$table->getNStringsOrder('id', false, $limit);
        return $products;
    }

    protected function getGeneralDataSet() {
        $table = $this->table;
        $dataset = $this->$table->getNStringsOrder('id', true, '');
        return  $dataset;
    }

}


?>