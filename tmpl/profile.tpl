<h1>Настройки профиля - <?=$this->login ?></h1>
<h2>Адрес</h2>
<form action="<?=$this->function_url ?>" name="user_address" method='post' >
    <input type="hidden" name='func' value='profile_address' />
    <textarea name="address" id="" cols="60" rows="10"><?=$this->address ?></textarea>  <br> <br>
    <input type="submit" name="submit" value="Сохранить" />
    <span style='color: red;'><?=$this->air_message ?></span>
</form>
<h2>Пароль</h2>
<form action="<?=$this->function_url ?>" name="change_password" method='post'>
    <div class="reg-form-string">
        <span>Новый пароль:</span>
        <input type="password" name='nm_password' />
    </div>
    <div class="reg-form-string">
        <span>Повторите:</span>
        <input type="password" name='rep_password' />
        <div class='pas-compare'></div>
    </div>
    <div class="reg-form-string">
        <span>Текущий пароль:</span>
        <input type="password" name='cur_password' />
    </div>
    <div class="reg-form-string">
        <input type="hidden" name='func' value='refr_pas' />
        <input type="submit" name="sub" value='Обновить' />
    </div>
</form>