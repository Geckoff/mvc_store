<table id="hornav">
    <tr>
        <td>
            <a href="<?=$this->main_url?>">Главная</a>
        </td>
        <td>
            <img src="<?=$this->main_url?>images/hornav_arrow.png" alt="" />
        </td>
        <td>
            <a href="<?=$this->section_url_product?>"><?=$this->section_title?></a>
        </td>
        <td>
            <img src="<?=$this->main_url?>images/hornav_arrow.png" alt="" />
        </td>
        <td><?=$this->product['title']?></td>
    </tr>
</table>
<table id="product">
    <tr>
        <td class="product_img">
            <img src="<?=$this->main_url?>images/products/<?=$this->product['img']?>" alt="<?=$this->product['title']?>" />
        </td>
        <td class="product_desc">
            <p>Название: <span class="title"><?=$this->product['title']?></span></p>
            <p>Год выхода: <span><?=$this->product['year']?></span></p>
            <p>Жанр: <span><?=$this->section_title?></span></p>
            <p>Страна-производитель: <span><?=$this->product['country']?></span></p>
            <p>Режиссер: <span><?=$this->product['director']?></span></p>
            <p>Продолжительность: <span><?=$this->product['play']?></span></p>
            <p>В ролях: <span><?=$this->product['cast']?></span></p>
            <table>
                <tr>
                    <td>
                        <p class="price"><?=$this->product['price']?> руб.</p>
                    </td>
                    <td>
                        <p>
                            <a href="<?=$this->cart_url?><?=$this->product['id']?>" class="link_cart"></a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p class="desc_title">Описание</p>
            <p class="desc"><?=$this->product['description']?></p>
        </td>
    </tr>
</table>
<div id="others">
    <h3>С этим товаром также заказывают:</h3>
    <table class="products">
        <tr>
            <?php
                for ($i = 0; $i < count($this->similar_products); $i++) {
                if ($this->similar_products[$i]['id'] == $this->product['id']) continue;
             ?>
            <td>
                <div class="intro_product">
                    <p class="img">
                        <img src="<?=$this->main_url?>images/products/<?=$this->similar_products[$i]['img']?>" alt="<?=$this->similar_products[$i]['title']?>" />
                    </p>
                    <p class="title">
                        <a href="#"><?=$this->similar_products[$i]['title']?></a>
                    </p>
                    <p class="price"><?=$this->similar_products[$i]['price']?> руб.</p>
                    <p>
                        <a class="link_cart" href="<?=$this->cart_url?><?=$this->similar_products[$i]['id']?>"></a>
                    </p>
                </div>
            </td>
            <?php } ?>

        </tr>
    </table>
</div>