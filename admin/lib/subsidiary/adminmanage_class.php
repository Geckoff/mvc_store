<?php

require_once "url_class.php";
require_once "check_class.php";
require_once "discount_class.php";
require_once "order_class.php";
require_once "product_class.php";
require_once "user_class.php";
require_once "page_class.php";
require_once "config_class.php";
require_once "section_class.php";

class AdminManage {

    private $url;
    private $check;
    private $discount;
    private $product;
    private $order;
    private $user;
    private $page;
    private $config;
    private $section;

    public function __construct(){
        session_start();
        $this->url = new Url();
        $this->check = new Check();
        $this->discount = new Discount();
        $this->order = new Order();
        $this->product = new Product();
        $this->user = new User();
        $this->page = new Page();
        $this->config = new Config();
        $this->section = new Section();
    }

    public function adminLogin($data) {
        $password = $this->user->getFieldOnField('login', $data['login'], 'password');
        $password = $password[0]['password'];
        $admin = $this->user->getFieldOnField('login', $data['login'], 'admin');
        if (md5($data['password']) == $password && $admin[0]['admin'] == 1){
            $_SESSION['login'] = $data['login'];
            $_SESSION['password'] = $data['password'];
        }
        else {
            $_SESSION['air_message'] = 'Неверный логин/пароль!';
        }
        $this->url->prevPage();
    }

    public function changePagesQuant($quantity) {
        if (!$this->check->checkID($quantity)) $this->url->prevPage();
        setcookie("Pagequant", $quantity);
        $this->url->prevPage();
    }

    private function goToMesaageAdminPage($message) {
        $_SESSION['msg_title'] = $message;
        $this->url->messageAdminPage();
    }

    private function airMessage($air_message) {
        if ($air_message) {
            $_SESSION['air_message'] = $air_message;
            $this->url->prevPage();
        }
    }

    private function setSessionAddData($data) {           // Saving data if attempt to save item was performed
        foreach ($data as $name => $value) {
            $_SESSION['add_data'][$name] = $value;
        }
    }

    private function insertData($fields, $values, $message, $table) {
        if ($this->$table->insert($fields, $values)) {
            unset($_SESSION['add_data']);
            $this->goToMesaageAdminPage($message);
        }
        else  $this->goToMesaageAdminPage($message.'_ERROR');
    }

    private function updateData($fields, $values, $id, $message, $table) {      
        $where = '`id` = '.$id;
        if ($this->$table->update($fields, $values, $where)) $this->goToMesaageAdminPage($message);
        else  $this->goToMesaageAdminPage($message.'_ERROR');
    }

    private function uploadFile() {
        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
        foreach ($blacklist as $item) {
            if(preg_match("/$item\$/i", $_FILES['img']['name'])) {
                $this->airMessage('Неверный формат файла!');
            }
        }
        $type = $_FILES['img']['type'];
        $size = $_FILES['img']['size'];
        if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/png') $this->airMessage('Неверный формат файла');
        $type = strrchr($_FILES['img']['name'], '.');
        if ($size > 10240000) $this->airMessage('Размер файла не должен превышать 10Мб');
        $dir = "images/products/";
        $files = scandir($dir);
        $img = $_FILES['img']['name'];
        $i = 1;
        $_SESSION['filename'] = array();
        $img = $this->findSameFileName($files, $img, $i, $type);
        if (isset($_SESSION['filename'][0])) {
            $img = $_SESSION['filename'][0];
        }
        unset($_SESSION['filename']);
        $uploadfile = $dir.$img;
        if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
            $this->airMessage('Не удалось загрузить файл! Попробуйте еще раз');
        }
        else return $img;
    }

    private function  translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ', '?', '&');
        $lat = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '-', '', '');
        return str_replace($rus, $lat, $str);
    }

    private function findSameFileName($files, $img, $i, $type) {
        foreach ($files as $file) {
            if ($file == $img) {
                if ($i == 1) {
                    $img = substr($img, 0, strpos($img, $type));
                }
                else {
                    $img = substr($img, 0, strpos($img, '('.($i - 1).')'.$type));
                }
                $img .= '('.$i.')'.$type;
                $i++;
                $this->findSameFileName($files, $img, $i, $type);
                array_push($_SESSION['filename'], $img);
            }
        }
        return $img;
    }

    private function checkUniqueField($field, $value, $table) {
       return $this->$table->getStringOnField($field, $value);
    }

    private function checkUniqueLinkName($title_link, $table) {
        $i = 1;
        $k = 0;
        while ($this->checkUniqueField('title_link', $title_link, $table)) {
            if ($k == 1) $title_link = substr($title_link, 0, strlen($title_link) - (strlen($i) + 1));
            $title_link = $title_link.'-'.$i;                 // adding number at the end of the link name to make it unique
            $i++;
            $k = 1;
        }
        return $title_link;
    }

    private function productFieldsErrors($data) {
        switch (true) {
            case ($data['section_id'] == ''): $air_message = 'Нужно выбрать категорию'; break;
            case ($data['title'] == ''): $air_message = 'Нужно указать название'; break;
            case ($data['price'] == ''): $air_message = 'Нужно указать цену'; break;
            case (!$this->check->checkID($data['price'])): $air_message = 'Неверный формат цены'; break;
            case ($data['year'] == ''): $air_message = 'Нужно указать год'; break;
            case (!$this->check->checkID($data['year'])): $air_message = 'Неверный формат года'; break;
            case ($data['director'] == ''): $air_message = 'Нужно указать режиссера'; break;
            case ($data['play'] == ''): $air_message = 'Нужно указать продолжительность'; break;
            case (!preg_match("/^\d\d:\d\d:\d\d$/i", $data['play'])): $air_message = 'Формат для продолжительности: ЧЧ:ММ:СС'; break;
            case ($data['cast'] == ''): $air_message = 'Нужно указать актеров'; break;
            case ($data['description'] == ''): $air_message = 'Нужно указать описание'; break;
            case ($_FILES['img']['name'] == ''): $air_message = 'Нужно выбрать картинку'; break;
        }
        return $air_message;
    }

    public function addProduct($data){
        $air_message = $this->productFieldsErrors($data);      // Message pops up if error in filling of fields has ocured
        $this->setSessionAddData($data);                       // Saving data if attempt to save item was performed
        $this->airMessage($air_message);
        $fields = array('section_id', 'img', 'title', 'title_link', 'price', 'year', 'country', 'director', 'play', 'cast', 'description', 'date');
        $img = $this->uploadFile();
        $title_link = $this->checkUniqueLinkName($this->translit($data['title']), 'product');     // replacng cirilic letters if necessary. setting unique name to use it in friendly url
        $values = array($data['section_id'], $img, $data['title'], $title_link, $data['price'], $data['year'], $data['country'], $data['director'], $data['play'], $data['cast'], $data['description'], time());
        $this->insertData($fields, $values, 'ADD_MOVIE', 'product');
    }

    public function editProduct($data) {
        $air_message = $this->productFieldsErrors($data);
        if ($air_message != 'Нужно выбрать картинку') {       // while editing page, $_FILES may be empty if we did not replace image, however it does not impact properness of the saving data
            $this->airMessage($air_message);
        }
        $fields = array('section_id', 'title', 'title_link', 'price', 'year', 'country', 'director', 'play', 'cast', 'description');
        if ($_FILES['img']['name'] != '') {                   // if we  replacing image, $_FILES array is not empty and we're uploading new image
            $img = $this->uploadFile();
            array_push($fields, 'img');
        }
        $title_link = $this->checkUniqueLinkName($this->translit($data['title']), 'product');     // replacng cirilic letters if necessary. setting unique name to use it in friendly url
        $values = array($data['section_id'], $data['title'], $title_link, $data['price'], $data['year'], $data['country'], $data['director'], $data['play'], $data['cast'], $data['description']);
        if ($_FILES['img']['name'] != '') {
            array_push($values, $img);
        }
        $this->updateData($fields, $values, $data['id'], 'EDIT_MOVIE', 'product');

    }

    public function addSection($data){
        if ($data['title'] == '') $this->airMessage('Название не может быть пустым!');
        $this->setSessionAddData($data);
        $fields = array('title');
        $values = array($data['title']);
        $this->insertData($fields, $values, 'ADD_SECTION', 'section');
    }

    public function editSection($data) {
        if ($data['title'] == '') $this->airMessage('Название не может быть пустым!');
        $fields = array('title');
        $values = array($data['title']);
        $this->updateData($fields, $values, $data['id'], 'EDIT_SECTION', 'section');
    }

    private function userFieldsErrors($data, $form_type) {
        $exist_login = $this->user->getStringOnField('login', $data['login']);
        $exist_email = $this->user->getStringOnField('email', $data['email']);
        switch (true) {

            case ($data['login'] == ''): $air_message = 'Нужно указать имя'; break;
            case ($data['email'] == ''): $air_message = 'Нужно указать емэйл'; break;
            case (!$this->check->checkLogin($data['login'])): $air_message = 'Только цифры и буквы'; break;
            case (!$this->check->checkEmail($data['email'])): $air_message = 'Неверный формат емэйла'; break;
        }
        if ($form_type == 'add') {
            switch (true) {
                case ($exist_login): $air_message = 'Логин занят'; break;
                case ($exist_email): $air_message = 'Емэйл занят'; break;
                case ($data['add-new-pas'] == ''): $air_message = 'Нужно указать пароль'; break;
                case ($data['add-rep-pas'] == ''): $air_message = 'Повторите пароль'; break;
                case ($data['add-rep-pas'] != $data['add-new-pas']): $air_message = 'Пароли не совпадают'; break;
            }
        }
        elseif ($form_type == 'edit') {
            switch (true) {
                case ($exist_login && $exist_login[0]['login'] !== $this->user->getUserLogin($data['id'])): $air_message = 'Логин занят'; break;
                case ($exist_email && $exist_email[0]['email'] !== $this->user->getUserEmail($data['id'])): $air_message = 'Емэйл занят'; break;
            }
            if ($data['edit-new-pas'] != '' && $data['edit-rep-pas'] != $data['edit-new-pas']) {
                $air_message = 'Пароли не совпадают';
            }
        }
        return $air_message;
    }

    public function addUser($data){
        $air_message = $this->userFieldsErrors($data, "add");
        $this->setSessionAddData($data);
        $this->airMessage($air_message);
        if ($data['admin'] == 1) $admin = 1;
        else $admin = 0;
        $fields = array('login', 'email', 'password', 'admin', 'regdate', 'address');
        $values = array($data['login'], $data['email'], md5($data['add-new-pas']), $admin, time(), $data['address']);
        $this->insertData($fields, $values, 'ADD_USER', 'user');
    }

    public function editUser($data){
        $air_message = $this->userFieldsErrors($data, "edit");
        $this->airMessage($air_message);
        if ($data['admin'] == 1) $admin = 1;
        else $admin = 0;
        $fields = array('login', 'email', 'admin', 'address');
        $values = array($data['login'], $data['email'], $admin, $data['address']);
        if ($data['edit-new-pas'] != '') {
            array_push($fields, 'password');
            array_push($values, md5($data['edit-new-pas']));
        }
        $this->updateData($fields, $values, $data['id'], 'EDIT_USER', 'user');
    }

    private function orderFieldsErrors($data, $movies) {
        foreach ($movies as $id => $quant) {
            if ($id == 0 || $quant == 0) $air_message = 'Необходимо выбрать фильм и количество копий';
        }
        switch (true) {
            case ($data['name'] == ''): $air_message = 'Нужно указать имя'; break;
            case ($data['price'] == ''): $air_message = 'Нужно указать цену'; break;
            case ($data['phone'] == ''): $air_message = 'Нужно указать телефон'; break;
            case ($data['email'] == ''): $air_message = 'Нужно указать email'; break;
        }
        return $air_message;
    }

    private function setMoviesList($data) {
        /**
        * Movies in $data are saved in pairs of array elements:
        * [Ntitle] = movie_id, [Nnumber] = quantity, where N is a position of the movie in current order
        *
        */
        $movies = array();
        foreach ($data as $name => $value) {
            if (preg_match("/\d{1,2}title/", $name)) {
                $number = substr($name, 0, strlen($name) - 5);
                $movies[$data[$name]] = $data[$number.'number'];
            }
        }
        return $movies;   // associative array, where key is movie id and value is quantity of items
    }

    private function setMoviesDBList($movies) {
        $db_movies = array();
        foreach ($movies as $id => $quant) {
            for ($i = 0; $i < $quant; $i++) {
                array_push($db_movies, $id);
            }
        }
        $db_movies = implode(',', $db_movies);
        return $db_movies;
    }

    public function addOrder($data){
        $movies = $this->setMoviesList($data);
        $air_message = $this->orderFieldsErrors($data, $movies);
        $this->setSessionAddData($data);
        $this->airMessage($air_message);
        $db_movies = $this->setMoviesDBList($movies);   // string for inserting into db - a comma-separated list

        $fields = array('delivery', 'product_ids', 'price', 'name', 'phone', 'email', 'address', 'notice', 'date_order', 'date_send', 'date_pay');
        $values = array($data['delivery'], $db_movies, $data['price'], $data['name'], $data['phone'], $data['email'], $data['address'], $data['notice'], time(), $data['date_send'], $data['date_pay']);
        $this->insertData($fields, $values, 'ADD_ORDER', 'order');
    }

    public function editOrder($data){
        $movies = $this->setMoviesList($data);
        $air_message = $this->orderFieldsErrors($data, $movies);
        $this->airMessage($air_message);
        $db_movies = $this->setMoviesDBList($movies);

        $fields = array('delivery', 'product_ids', 'price', 'name', 'phone', 'email', 'address', 'notice', 'date_send', 'date_pay');
        $values = array($data['delivery'], $db_movies, $data['price'], $data['name'], $data['phone'], $data['email'], $data['address'], $data['notice'], $data['date_send'], $data['date_pay']);
        $this->updateData($fields, $values, $data['id'], 'EDIT_ORDER', 'order');
    }

    private function discountFieldsErrors($data) {
        if ($data['code'] == '') {
            $air_message = 'Введите код';
        }
        if ($this->discount->getStringOnField('code', $data['code'])) {
            $air_message = 'Данный код уже используется';
        }
        if (!preg_match("/^0\.[\d]+$/", $data['value'])) {
            $air_message = 'Значение должно быть между 0 и 1';
        }
        return $air_message;
    }

    public function addDiscount($data){
        $air_message = $this->discountFieldsErrors($data);
        $this->setSessionAddData($data);
        $this->airMessage($air_message);

        $fields = array('code', 'value');
        $values = array($data['code'], $data['value']);
        $this->insertData($fields, $values, 'ADD_DISCOUNT', 'discount');
    }

    public function editDiscount($data){
        $air_message = $this->discountFieldsErrors($data);
        $this->setSessionAddData($data);
        $this->airMessage($air_message);

        $fields = array('code', 'value');
        $values = array($data['code'], $data['value']);
        $this->updateData($fields, $values, $data['id'], 'EDIT_DISCOUNT', 'discount');
    }

    private function pageFieldsErrors($data) {
        switch (true) {
            case ($data['title'] == ''): $air_message = 'Нужно указать название'; break;
            case ($data['text'] == ''): $air_message = 'Нужно содержание'; break;
        }
        return $air_message;
    }

    public function addPage($data){
        $air_message = $this->pageFieldsErrors($data);
        $this->setSessionAddData($data);
        $this->airMessage($air_message);
        $title_link = $this->checkUniqueLinkName($this->translit($data['title']), 'page');

        $fields = array('title', 'text', 'title_link');
        $values = array($data['title'], $data['text'], $title_link);
        $this->insertData($fields, $values, 'ADD_PAGE', 'page');
    }

    public function editPage($data){
        $air_message = $this->pageFieldsErrors($data);
        $this->airMessage($air_message);

        $fields = array('title', 'text');
        $values = array($data['title'], $data['text']);
        $this->updateData($fields, $values, $data['id'], 'EDIT_PAGE', 'page');
    }

    public function deleteString($data) {
        $where = "`id` = '".$data['id']."'";
        $message = strtoupper($data['table_name']);
        if ($this->$data['table_name']->delete($where)) {
            $this->goToMesaageAdminPage('DELETE_'.$message);
        }
        else $this->goToMesaageAdminPage('DELETE_'.$message.'_ERROR');
    }

}



 ?>