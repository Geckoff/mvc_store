<?php

/**
* Class for working with urls
**/

require_once "config_class.php";

class Url {

    private $config;

    public function __construct() {
        $this->config = new Config();
    }

    public function getCartUrl() {
        return $this->config->main_page.'functions.php?func=add_cart&id=';
    }

    public function getNewPasswordUrl() {
        return $this->config->main_page.'newpassword?code=';
    }

    public function getDelCartUrl() {
        return $this->config->main_page.'functions.php?func=del_cart_item&id=';
    }

    public function getOrderUrl() {
        return $this->config->main_page.'order';
    }

    public function getRecoveryUrl() {
        return $this->config->main_page.'recovery';
    }

    public function getProfileUrl() {
        return $this->config->main_page.'profile';
    }

    public function getFunctionUrl() {
        return $this->config->main_page.'functions.php';
    }

    public function getRegPageUrl() {
        return $this->config->main_page.'registration';
    }

    public function getCartPageUrl() {
        return $this->config->main_page.'cart';
    }

    public function getSectionUrl() {
        return $this->config->main_page.'section?id=';
    }

    public function getNotFoundUrl() {
        return $this->config->main_page.'page404';
    }

    public function getMainPage() {
        return $this->config->main_page;
    }

    public function getProdutImageFolder() {
        return $this->config->main_page.'images/products/';
    }

    public function getCaptcha() {
        return $this->config->main_page.'captcha.php';
    }

    public function getPageUrl() {
        $url = $_SERVER['REQUEST_URI'];
        return $url;
    }

    public function getPageUrlWtParams($excppar = '') {
        $url = $this->getPageUrl();
        return $this->getRidOfParams($url, $excppar);
    }

    private function getRidOfParams($url, $excppar = '') {
        if ($pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos);
        }
        if ($excppar != '') {
            if (isset($_GET[$excppar])) $url .= '?'.$excppar.'='.$_GET[$excppar];
        }
        return $url;
    }

    public function noAuthRedirect($class_name) {    // denying access for certain pages for noy authorized user
        $restr_classes = array('ProfileContent');    //list of pages (controller classes) prohibited for not authorized user
        foreach ($restr_classes as $value) {
            if ($class_name == $value) $this->mainPage();
        }
    }

    public function AuthRedirect($class_name) {      // denying access for certain pages for authorized user
        $restr_classes = array('RegistrationContent', 'RecoveryContent','NewPasswordContent');   //list of pages (controller classes) prohibited for authorized user
        foreach ($restr_classes as $value) {
            if ($class_name == $value) $this->mainPage();
        }
    }

    public function getPaginationUrl($short = '') {
        $main_page = substr($this->config->main_page, 0, strlen($this->config->main_page) - 1);
        $pagurl = $main_page.$this->getPageUrl();
        if ($pos = strpos($pagurl, 'page')) {
            $pagurl = substr($pagurl, 0, $pos - 1);
        }
        if ($short == 1) return $pagurl;

        if (strpos($pagurl, '?')) {
            $pagurl .= '&page=';
        }
        else $pagurl .= '?page=';
        return $pagurl;
    }

    private function getPageUrlWtSlash() {
        $url = substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI']) - 1);
        return $url;
    }

    public function getProductTitleLink() {
        $url = $this->getPageUrlWtSlash();
        $pos = strpos($url, '/');
        $title_link = substr($url, $pos + 1, strlen($url) - $pos);
        return $title_link;
    }

    public function getView() {        // getting controller name
        $url = $this->getPageUrl();
        if ($pos = strpos($url, '?')) {      // consider that '?' is possible to use in controller name in the link
            $this->checkAttr($url, $pos);    // checking id get parameter in URL is valid
            $url = substr($url, 0, $pos);
        }
        /**
        * Projest is built on using of friendly urls.
        * Validation if second level pages are available for current controller (URL template for this instance: "website.com/controller/second_level) is started below.
        * Second level is used as an id for pulling record out of database. Used for items in catalog only.
        **/
        if ($pos = strpos(substr($url, 1, strlen($url) - 1), '/')) {
            $this->checkSecLevPage(substr($url, 1, $pos));   // checking second level page relevance
            $url = substr($url, 1, $pos);
        }
        else $url = substr($url, 1, strlen($url) - 1);
        return $url;
    }

    private function checkAttr($url, $pos) {   // checking id get parameter in URL is valid
        $aprattrs = array('field', 'sort', 'id', 'page', 'code', 'func', 'filter', 'dir', 'secid');  // list of valid parameters
        $url2 = substr($url, 1, $pos - 1);
        $length = strlen($url) - strlen($url2);
        $attrs = substr($url, $pos + 1, $length);
        $attrarr = explode('&', $attrs);
        $j = 0;
        for($i = 0; $i < count($attrarr); $i++) {
            $curattr = substr($attrarr[$i], 0, strpos($attrarr[$i], '='));
            foreach ($aprattrs as $aprvalue) {
                if ($curattr == $aprvalue) $j++;
            }
        }
        if ($i != $j) {
            $this->notFound();
        }
    }

    private function checkSecLevPage($curpage) {
        $aprpages = array('product', 'administrator');    // list of controllers with second level pages support
        $i = 0;
        foreach ($aprpages as $page) {
            if ($curpage == $page) {
                $i = 1;
            }
        }
        if ($i != 1) $this->notFound();
    }

    public function getSortUrl($field, $sort, $id) {
        $url = $this->getPageUrl();
        if ($pos = strpos($url, '?')) {
            $url = substr($url, 0, $pos);
        }
        if ($id == '') $url = $url.'?field='.$field.'&sort='.$sort;
        else $url = $url.'?id='.$id.'&field='.$field.'&sort='.$sort;
        return $url;
    }

    public function notFound() {
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
        header("Location: ".$this->getNotFoundUrl());
        exit;
    }

    public function prevPage() {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }

    public function messagePage() {
        header("Location: ".$this->config->main_page.'message');
        exit;
    }

    public function mainPage() {
        header("Location: ".$this->config->main_page);
        exit;
    }

    public function existsFile($file) {
        $arr = explode(PATH_SEPARATOR, get_include_path());
        foreach ($arr as $path) {
            if (file_exists($path.'/'.$file)) return true;
        }
        return false;
    }

    //------------------ADMIN------------------------//

    public function isAdminSection() {
        $url = $this->getPageUrl();
        if (strpos($url, '/administrator/')) return true;
        return false;
    }

    public function getSecLevAdmPage() {
        $url = $this->getPageUrl();
        $seclev = substr($url, strlen('/administrator/'), strlen($url) - strlen('/administrator/'));
        if (strpos($seclev, '/')) {
            $seclev = substr($seclev, 0, strpos($seclev, '/'));
        }
        $seclev = $this->getRidOfParams($seclev);
        return $seclev;
    }

    public function getAdminFunctionUrl() {
        return $this->config->main_page.'adminfunctions.php';
    }

    public function adminSection() {
        header("Location: ".$this->config->main_page.'administrator');
        exit;
    }

    public function getAdminPage() {
        return $this->config->main_page.'administrator/';
    }

    public function adminAuth() {
        header("Location: ".$this->config->main_page.'administrator/auth');
        exit;
    }

    public function mainAdminPage() {
        header("Location: ".$this->getAdminPage());
        exit;
    }

    public function messageAdminPage() {
        header("Location: ".$this->getAdminPage().'message');
        exit;
    }
}

 ?>