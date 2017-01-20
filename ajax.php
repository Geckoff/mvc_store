<?php
require_once "start.php";

require_once "manage_class.php";
require_once "product_class.php";

/* Adding item to cart */

$manage = new Manage();
$product = new Product();

if (isset($_POST['id'])) {
    $manage->addCartItem($_POST['id']);
    $title = $product->getProductTitle($_POST['id']);
    $src = $product->getFieldOnID($_POST['id'], 'img');
    $src = 'images/products/'.$src['img'];
    /* Data below is needed for changing of cart module on the page and for small window that pops up after hitting "add to cart" button.*/
    $data = json_encode(array('product_num' => count($_SESSION['added_items']), 'cartprice' => $manage->getCommonPriceCart(), 'title' => $title['title'], 'src' => $src));
    echo $data;
}




?>