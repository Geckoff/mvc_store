<ul class="cat-list">
    <?php for ($i = 0; $i < count($this->catlist); $i++) {
        $k = 0;
        $params = '';
        foreach ($this->catlist[$i]['params'] as $name => $value) {
            if ($k == 0) $curparam = '?'.$name.'='.$value;
            else $curparam = '&'.$name.'='.$value;
            if ($name == '' || $value == '') $curparam = '';
            $params .= $curparam;
            $k++;
        } ?>
        <li><a href="<?=$this->catlist[$i]['link'] ?><?=$params ?>"><?=$this->catlist[$i]['name'] ?></a></li>
    <?php } ?>
</ul>