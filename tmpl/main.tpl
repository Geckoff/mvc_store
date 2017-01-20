<!DOCTYPE html>
<html xmlns="http://www.w3.org /1999/xhtml">
<head>
	<title><?=$this->title?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="description" content="<?=$this->keywords?>" />
			<meta name="keywords" content="<?=$this->description?>" />
			<link type="text/css" rel="stylesheet" href="<?=$this->main_url?>styles/main.css" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
    <div id="container">
        <div id="header">
            <img src="<?=$this->main_url?>images/header.png" alt="Шапка" />
            <div>
                <p class="red"><?=$this->main_url?></p>
                <p class="blue"><?=$this->schedule?></p>
            </div>
            <div class="cart">
                <p class="cart_title">Корзина</p>
                <p class="blue">Текущий заказ</p>
                <p>В корзине <span id='cartprods'><?=$this->cart_num?></span> товара<br>на сумму <span id='cartcomprice'><?=$this->cart_comprice?></span> руб.</p>
            <a href="<?=$this->cart_page_url?>">Перейти в корзину</a>
            </div>
        </div>
        <div class='auth-form'>
            <?php if ($this->authorized == 1) { ?>
            Привет, <?=$this->login ?>!
            <a href="<?=$this->profile_url ?>">Настройки профиля</a>
            <a href="<?=$this->function_url.'?func=exit' ?>">Выход</a>
            <?php }
            else { ?>
            <form action="<?=$this->function_url ?>" name='auth-form'>
                Login:&nbsp;&nbsp;<input type="text" name='login' />
                Password:&nbsp;&nbsp;<input type="password" name='password' />
                <input type="hidden" name='func' value='auth' />
                <input type="submit" name='auth' value='Войти' />
            </form>
            <a href="<?=$this->registration_page ?>">Регистрация</a>
            <a href="<?=$this->recovery_url ?>">Забыли пароль?</a>
            <span style='color: red;'><?=$this->main_air_message ?></span>
            <?php } ?>
        </div>
        <div id="topmenu">
            <ul>
                <li>
                    <a href="<?=$this->main_url?>">ГЛАВНАЯ</a>
                </li>
                <li>
                    <img src="<?=$this->main_url?>images/topmenu_border.png" alt="" />
                </li>
                <li>
                    <a href="<?=$this->main_url?>oplata-i-dostavka">ОПЛАТА И ДОСТАВКА</a>
                </li>
                <li>
                    <img src="<?=$this->main_url?>images/topmenu_border.png" alt="" />
                </li>
                <li>
                    <a href="<?=$this->main_url?>kontakty">КОНТАКТЫ</a>
                </li>
            </ul>
            <div id="search">
                <form name="search" action="#" method="get">
                    <table>
                        <tr>
                            <td class="input_left"></td>
                            <td>
                                <input type="text" name="q" value="поиск" onfocus="if(this.value == 'поиск') this.value=''" onblur="if(this.value == '') this.value='поиск'">
                            </td>
                            <td class="input_right"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="content">
            <div id="left">
                <div id="menu">
                    <div class="header">
                        <h3>Разделы</h3>
                    </div>
                    <div id="items">
                        <?php for ($i = 0; $i < count($this->sections); $i++) { ?>
                        <p>
                            <a href="<?=$this->section_url?><?=$this->sections[$i]['id']?>"><?=$this->sections[$i]['title']?></a>
                        </p>
                        <?php } ?>
                    </div>
                    <div class="bottom"></div>
                </div>
            </div>
            <div id="right">
                <?php include $this->tpl_name.'.tpl'; ?>
            </div>
            <div class="clear"></div>
            <div id="footer">
                <div id="pm">
                    <table>
                        <tr>
                            <td>Способы оплаты:</td>
                            <td>
                                <img src="<?=$this->main_url?>images/pm.png" alt="Способы оплаты" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="copy">
                    <p>Copyright &copy; Site.ru. Все права защищены.</p>
                    <p class="counter">
                        <img src="<?=$this->main_url?>images/counter.png" alt="Счетчик" />
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>