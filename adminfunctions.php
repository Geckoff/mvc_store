<?php

require_once "start.php";
require_once "adminmanage_class.php";
require_once "url_class.php";
require_once "check_class.php";

$check = new Check();



$data = $check->checkData($_REQUEST);
if (isset($data['text'])) {
    $data['text'] = $_POST['text'];
}

if (isset($data['id'])) {
    $check->checkID($data['id']);
}

$url = new Url();
$adminmanage = new AdminManage();

if ($data['func'] == 'admin_auth'){
    $adminmanage->adminLogin($data);
}
elseif ($data['func'] == 'changepagesquant'){
    $adminmanage->changePagesQuant($data['pagesquant']);
}
elseif ($data['func'] == 'add' || $data['func'] == 'edit'){
    $function = $data['func'].$data['table_name'];
    $adminmanage->$function($data);
}
elseif ($data['func'] == 'del') {
    $adminmanage->deleteString($data);
}
else {
    $url->notFound();
}





 ?>