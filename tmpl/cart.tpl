<div id="cart">
    <h2>Корзина</h2>
    <table>
        <tr>
            <td colspan="8" id="cart_top"></td>
        </tr>
        <tr>
            <td class="cart_left"></td>
            <td colspan="2">Товар</td>
            <td>Цена за 1 шт.</td>
            <td>Количество</td>
            <td>Стоимость</td>
            <td></td>
            <td class="cart_right"></td>
        </tr>
        <tr>
            <td class="cart_left"></td>
            <td colspan="6"><hr></td>
            <td class="cart_right"></td>
        </tr>

        <?php if ($this->show_items == 1) { ?>

        <form action="<?=$this->function_url?>" name='recalc' method='post'>
            <input type="hidden" name='recalc' value='1' />
            <?php for ($i = 0; $i < count($this->products); $i++) {  ?>
            <tr class="cart_row">
                <td class="cart_left"></td>
                <td class="img">
                    <img src="images/products/<?=$this->products[$i]['img']?>" alt="<?=$this->products[$i]['title']?>" />
                </td>
                <td class="title"><?=$this->products[$i]['title']?></td>
                <td><?=$this->products[$i]['price']?> руб.</td>
                <td>
                    <table class="count">
                        <tr>
                            <td>
                                <input type="text" name="<?=$this->products[$i]['id']?>" value="<?=$this->products[$i]['quant']?>"/>
                            </td>
                            <td>шт.</td>
                        </tr>
                    </table>
                </td>
                <td class="bold"><?=$this->products[$i]['full_price']?> руб.</td>
                <td>
                    <a href="<?=$this->del_cart_url?><?=$this->products[$i]['id']?>" class="link_delete">x удалить</a>
                </td>
                <td class="cart_right"></td>
            </tr>
            <?php if ($i != count($this->products) - 1) { ?>
            <tr>
                <td class="cart_left"></td>
                <td colspan="6" class="cart_border"><hr></td>
                <td class="cart_right"></td>
            </tr>
            <?php } ?>
            <?php } ?>
            <tr>
                <td class="cart_left"></td>
                <td colspan="6" class="cart_border"><input type="image" src="images/cart_recalc.png" alt="Пересчитать" onmouseover="this.src='images/cart_recalc_active.png'" onmouseout="this.src='images/cart_recalc.png'" /></td>
                <td class="cart_right"></td>
            </tr>
        </form>
        <?php } ?>

        <tr>
            <td class="cart_left"></td>
            <td colspan="6"></td>
            <td class="cart_right"></td>
        </tr>
        <tr id="discount">
            <td class="cart_left"></td>
            <td colspan="6">
                <form id='discount_form' action="<?=$this->function_url?>" name="discount" method="post">
                    <table>
                        <tr>
                            <td>Введите номер купона<br><span>(если есть)</span></td>
                            <td>
                                <input type="text" name="discount" value='<?=$this->discount?>' />
                                <input type="hidden" name='coupon' value='1' />
                            </td>
                            <td>
                                <input  type="image" src="images/cart_discount.png" alt="Получить скидку" onmouseover="this.src='images/cart_discount_active.png'" onmouseout="this.src='images/cart_discount.png'" />
                            </td>
                            <td class='coupon'><?=$this->air_message?></td>
                        </tr>
                    </table>
                </form>
            </td>
            <td class="cart_right"></td>
        </tr>
        <tr id="summa">
            <td class="cart_left"></td>
            <td colspan="6">
                <p>Итого: <span><?=$this->cart_comprice_discount?>  руб.</span></p>
            </td>
            <td class="cart_right"></td>
        </tr>
        <tr>
            <td class="cart_left"></td>

            <td>
                <a id='orderlink' class='<?=$this->show_items ?>' href="<?=$this->order_url?>"><img src="images/cart_order.png" onmouseover="this.src='images/cart_order_active.png'" onmouseout="this.src='images/cart_order.png'"  alt="Оформить" /></a>
            </td>
            <td  colspan="6" class="cart_right"></td>
        </tr>
        <tr>
            <td colspan="8" id="cart_bottom"></td>
        </tr>
    </table>
</div>