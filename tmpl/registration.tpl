<h1>Регистрация</h1>
<form id='reg-form' action="<?=$this->function_url ?>" name='reg-form' method="post">
    <div class="reg-form-string">
        <span>Логин:</span>
        <input type="text" name='login' value='<?=$this->reg_login ?>' />
    </div>
    <div class="reg-form-string">
        <span>Емэйл:</span>
        <input type="text" name='email' value='<?=$this->reg_email ?>' />
    </div>
    <div class="reg-form-string">
        <span>Пароль:</span>
        <input type="password" name='nm_password' />
    </div>
    <div class="reg-form-string">
        <span>Повторите пароль:</span>
        <input type="password" name='rep_password' />
        <div class='pas-compare'></div>
    </div>
    <div class="captcha">
        <img src="<?=$this->captcha ?>" alt="captcha" />
    </div>
    <div class="reg-form-string">
        <span>Код:</span>
        <input type="text" name='code' />
    </div>
    <input type="hidden" name="func" value="reg" />
    <div class="reg-form-string">
        <input type="submit" name="sub" value='Зарегистрироваться' />
    </div>
</form>
<span style='color: red;'><?=$this->air_message ?></span>