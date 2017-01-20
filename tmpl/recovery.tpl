<h1>Восстановление пароля</h1>
<p>Чтобы восстановить пароль, введите емэйл вашего аккаунта</p>
<form action="<?=$this->function_url ?>" method="post" name="recovery-form">
    <input type="text" name="recovery-email"/>
    <input type="hidden" name="func" value="recovery" />                
    <input type="submit" name="submit" value="Воссановить" />
    <span style='color: red;'><?=$this->air_message ?></span>
</form>