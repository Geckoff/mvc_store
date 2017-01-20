<?php

    /**
    * Router for MVC architectural pattern
    * Link Template: website.com/controller/*
    * In any link 'controller' from template above is key to construct relevant controller MVC class
    **/

    require_once "start.php";
    require_once "config_class.php";
    require_once "url_class.php";
    require_once "page_class.php";

    $url = new Url();
    $page_class = new Page();       // model class for Page type of page

    $cururl = $url->getView();      // getting type of page to start relevant controller class
    $class =  $cururl.'Content';

    if ($cururl == '')  {           // loading controller for main page
        require_once "maincontent_class.php";
        $page = new MainContent();
    }
    elseif ($url->existsFile($cururl.'content_class.php')) {  // loading controller for secondary page
        require_once $cururl.'content_class.php';
        $page = new $class();
    }
    elseif ($page_class->isPage($cururl)) {                    // checking if current page is informational text page - this type of pages is exception
        require_once 'pagecontent_class.php';
        new PageContent();
    }
    /**
    * Router part for admin side has different Link Template:
    * website.com/administrator/controller/*
    **/
    elseif ($cururl == 'administrator') {
        $seclev = $url->getSecLevAdmPage();
        if ($seclev == '') {                                               // loading controller for main page
            require_once 'adminmaincontent_class.php';
            new AdminMainContent();
        }
        elseif ($url->existsFile('admin'.$seclev.'content_class.php')) {   // loading controller for secondary page
            require_once 'admin'.$seclev.'content_class.php';
            $adminurl = 'Admin'.$seclev.'Content';
            new $adminurl();
        }
        else {
            $url->adminSection();
        }
    }
    else {
        header("Location: ".$url->getNotFoundUrl());
        exit;
    }





 ?>