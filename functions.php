<?php

/**
* Router to aditional functions located in class Manage.
* URLs look like website.com/function.php?func=param&other_param=value
**/

require_once "start.php";

require_once "manage_class.php";
require_once "url_class.php";
require_once "check_class.php";

$check = new Check();

$data = $check->checkData($_REQUEST);
$url = new Url();
$manage = new Manage();

if ($data['func'] == 'add_cart'){               // adding item to cart
    $manage->addCartItem($data['id']);
}
elseif ($data['coupon'] == '1'){                // getting a discount code
    $manage->useCoupon($data['discount']);
}
elseif ($data['recalc'] == '1'){                // recalculating price and quantity of items in the cart
    $manage->recalcItems($data);
}
elseif ($data['func'] == 'addorder'){           // checkout
    $manage->addOrder($data);
}
elseif ($data['func'] == 'del_cart_item'){      // deleting item from the cart
    $manage->delCartItem($data['id']);
}
elseif ($data['func'] == 'auth'){
    $manage->authorization($data);
}
elseif ($data['func'] == 'exit'){
    $manage->exitProfile();
}
elseif ($data['func'] == 'profile_address'){
    $manage->changeProfileAddress($data['address']);
}
elseif ($data['func'] == 'reg'){                // user registration
    $manage->userRegistration($data);
}
elseif (isset($data['code'])){
    $manage->verifyAccount($data['code']);
}
elseif ($data['func'] == 'recovery'){           // recovering user's password request
    $manage->recoveryPassword($data['recovery-email']);
}
elseif ($data['func'] == 'newpas'){             // setting up new user's password
    $manage->setNewPassword($data);
}
elseif ($data['func'] == 'refr_pas'){
    $manage->refreshPassword($data);
}
else {
    $url->notFound();
}





 ?>