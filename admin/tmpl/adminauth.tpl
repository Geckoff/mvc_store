<!DOCTYPE html>
<html xmlns="http://www.w3.org /1999/xhtml">
<head>
	<title><?=$this->title?></title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="description" content="Authorization" />
			<meta name="keywords" content="Authorization" />
			<link type="text/css" rel="stylesheet" href="<?=$this->main_url?>styles/main.css" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <script type="text/javascript" src="../js/scripts.js"></script>
</head>

<body style='background: #fff;'>
    <form action="<?=$this->adminfunction_url ?>" method="post"  name='adminauth-form' >
        <div class="reg-form-string">
            <span>Логин:</span>
            <input type="text" name='login' value='<?=$this->adminauth_login ?>' />
        </div>
        <div class="reg-form-string">
            <span>Пароль:</span>
            <input type="password" name='password' />
        </div>
        <input type="hidden" name='func' value='admin_auth' />
        <input type="submit" name='auth' value='Войти' />
        <span style='color: red;'><?=$this->air_message ?></span>
    </form>

</body>

</html>