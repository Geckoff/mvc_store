<!DOCTYPE HTML>

<html>

<head>
    <title><?=$this->title ?></title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" >
    <meta name="description" content="<?=$this->description ?>" />
    <meta name="keywords" content="<?=$this->keywords ?>">
    <link rel="stylesheet" href="<?=$this->main_url?>styles/admin.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$this->main_url?>admin/js/adminscripts.js"></script>
    <script type="text/javascript" src="<?=$this->main_url?>admin/js/ckeditor/ckeditor.js"></script>
</head>

<body>
    <div id="header">
            <h2>Админ-панель</h2>
            <div class="main-menu">
                <div class="exit">
                    <a href="<?=$this->function_url.'?func=exit' ?>">Выход</a>
                </div>
                <ul>
                    <?php foreach ($this->sections as $name => $link) { ?>
                        <li><a href="<?=$link ?>"><?=$name ?></a></li>
                    <?php } ?>
                </ul>
            </div>
    </div>

    <hr>
    <div id="main_content">
        <div id="left">
            <?php
            if (isset($this->left_tpl_string[0])) {
                for ($i = 0; $i < count($this->left_tpl_string); $i++) {
                    echo $this->left_tpl_string[$i];
                }
            }
            ?>
            <?php
            if (isset($this->left_tpl_name[0])) {
                for ($i = 0; $i < count($this->left_tpl_name); $i++) {
                    include $this->left_tpl_name[$i].'.tpl';
                }
            }
            ?>
        </div>

        <div id="main-block">
            <?php
            if (isset($this->right_tpl_string[0])) {
                for ($i = 0; $i < count($this->right_tpl_string); $i++) {
                    echo $this->right_tpl_string[$i];
                }
            }
            ?>
            <?php
            if (isset($this->right_tpl_name[0])) {
                for ($i = 0; $i < count($this->right_tpl_name); $i++) {
                    include $this->right_tpl_name[$i].'.tpl';
                }
            }
            ?>
        </div>
        <div class="clear"></div>

        <div id="footer">
            <p>Все права защищены &copy; 2012</p>
        </div>
    </div>

</body>

</html>