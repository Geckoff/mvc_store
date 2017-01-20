<?php

require_once "url_class.php";

class Check {

    private $url;

    public function __construct() {
        $this->url = new Url();
    }

    public function checkID($id) {      // Checking if ID is integer
        if (!preg_match("/^[\d]+$/", $id)) $this->url->notFound();
        $id = intval($id);
        if (!is_integer($id) || $id < 1) $this->url->notFound();
        return $id;
    }

    public function checkData($data) {
        foreach($data as $key => $value) {
            if (is_array($value)) $this->checkData($value);
            else $data[$key] = htmlspecialchars($value);
        }
        return $data;
    }

    public function checkLogin($login) {
        if (!preg_match("/^[a-zA-Z0-9]+$/", $login) || $this->isContainQuotes($login)) {
            return false;
        }
        return true;
    }

    public function checkEmail($email) {
        if (!preg_match("/^.+@.+\..+$/", $email) || $this->isContainQuotes($email))  {
            return false;
        }
        return true;
    }

    public function checkPassword($password) {
        if (!preg_match("/^.{4,}$/", $password) || $this->isContainQuotes($password))  {
            return false;
        }
        return true;
    }

    public function checkZeroLength($string) {
        if (strlen($string) == 0 || $this->isContainQuotes($string)) return false;
        else return true;
    }

    private function isContainQuotes($string) {
        $array = array("\"", "'", "`", "&quot;", "&apos;");
        foreach ($array as $key => $value) {
            if (strpos($string, $value) == true) return true;
        }
        return false;
    }
}


 ?>