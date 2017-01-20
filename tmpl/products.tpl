<table>
    <tr>
        <td rowspan="2">
            <div class="header">
                <h3>Новинки</h3>
            </div>
        </td>
        <td class="section_bg"></td>
        <td class="section_right"></td>
    </tr>
    <tr>
        <td colspan="2">
            <table class="sort">
                <tr>
                    <td>Сортировать по:</td>
                    <td>цене (<a href="<?=$this->sort_price_up  ?>"><span>возр</span></a> | <a href="<?=$this->sort_price_dn  ?>"><span>убыв</span></a>)</td>
                    <td>названию (<a href="<?=$this->sort_title_up  ?>"><span>возр</span></a> | <a href="<?=$this->sort_title_dn  ?>"><span>убыв</span></a>)</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="products">
    <tr>
        <?php for ($i = 0; $i < count($this->products); $i++) {  ?>
        <?php if ($i % 4  == 0) echo '<tr></tr>'; ?>
        <td>
            <div class="intro_product">
                <p class="img">
                    <img src="images/products/<?=$this->products[$i]['img']?>" alt="<?=$this->products[$i]['title'] ?>" />
                </p>
                <p class="title">
                    <a href="<?=$this->main_url?>product/<?=$this->products[$i]['title_link']?>"><?=$this->products[$i]['title'] ?></a>
                </p>
                <p class="price"><?= $this->products[$i]['price'] ?> руб.</p>
                <p>
                    <!--<a class="link_cart" href="<?=$this->cart_url ?><?=$this->products[$i]['id'] ?>"></a>-->
                    <div class="link_cart" id="<?=$this->products[$i]['id'] ?>"></div>
                </p>
            </div>
        </td>
        <?php } ?>
    </tr>
</table>
<?php if ($this->pagination_pages > 1) { ?>
<?php include 'pagination.tpl'; ?>
<?php } ?>