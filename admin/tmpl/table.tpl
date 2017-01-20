<form class="quant-on-page" action="<?=$this->adminfunction_url ?>" method='post'>
    Количество на страницу:
    <select name="pagesquant">
        <?php for ($i = 0; $i < count($this->pages_quant); $i++) { ?>
        <option value="<?=$this->pages_quant[$i] ?>" <?php if ($this->pages_quant[$i] == $_COOKIE["Pagequant"]) echo 'selected="selected"' ?>><?=$this->pages_quant[$i] ?></option>
        <?php } ?>
        <input type="hidden" name='func' value='changepagesquant' />
    </select>
</form>

<table class="items-table" id='upper-table'>
    <tr class="table-head">
        <?php for ($i = 0; $i < count($this->upper_table); $i++){ ?>
            <td <?php if ($this->upper_table[$i]['width'] != '') echo 'style="width: '.$this->upper_table[$i]['width'].'px;"' ?>><?php if ($this->upper_table[$i]['link'] != '') echo'<a href="'.$this->upper_table[$i]['link'].'" class="'.$this->upper_table[$i]['filter'].'">'?><?=$this->upper_table[$i]['column_name'] ?><?php if ($this->upper_table[$i]['link'] != '') echo'</a>'?></td>
        <?php } ?>
    </tr>
</table>
<div class="admin-table-wrap">
    <table class="items-table" id='lower-table'>
        <?php for ($i = 0; $i < count($this->lower_table); $i++) {?>
        <tr>
            <?php for ($j = 0; $j < count($this->lower_table[$i]); $j++) {?>
                <td><?=$this->lower_table[$i][$j] ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
</div>
<?php if ($this->pagination_pages > 1) { ?>
<?php include 'pagination.tpl'; ?>
<?php } ?>