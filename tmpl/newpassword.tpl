<h1>Задайтие новый пароль</h1>
<form action="<?=$this->function_url ?>" class='newpas-form' name='reg-form' method="post">
    <div class="reg-form-string">
        <span>Новый пароль:</span>
        <input type="password" name='nm_password' />
    </div>
    <div class="reg-form-string">
        <span>Повторите пароль:</span>
        <input type="password" name='rep_password' />
        <div class='pas-compare'></div>
    </div>
    <input type="hidden" name="recover_code" value="<?=$this->recover_code ?>" />
    <input type="hidden" name="func" value="newpas" />
    <div class="reg-form-string">
        <input type="submit" name="submit" value='Задать' />
    </div>
</form>