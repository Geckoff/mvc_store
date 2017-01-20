<div id="order">
    <h2>Оформление заказа</h2>
    <form id='order_form' action="<?=$this->function_url ?>" method="post" name="order">
        <table id="form_order">
            <tr>
                <td class="w120">ФИО: </td>
                <td>
                    <input type="text" name="name" value='<?=$this->name ?>' />
                </td>
            </tr>
            <tr>
                <td>Телефон*: </td>
                <td>
                    <input type="text" name="phone" value='<?=$this->phone ?>' />
                </td>
            </tr>
            <tr>
                <td>E-mail: </td>
                <td>
                    <input type="text" name="email" value='<?=$this->email ?>' />
                </td>
            </tr>
            <tr>
                <td>Доставка*: </td>
                <td>
                    <select id='delivery-sel' name="delivery">
                        <option value="">выберите, пожалуйста...</option>
                        <option value="0" <?=$this->shipping ?>>Доставка</option>
                        <option value="1" <?=$this->selfshipping ?>>Самовывоз</option>
                    </select>
                </td>
            </tr>
        </table>
        <table>
            <tr id="address">
                <td colspan="2">
                    <p>Полный адрес</p>
                    <textarea name="address" id="" cols="80" rows="6"><?=$this->address ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Примечание к заказу</p>
                    <textarea name="notice" id="" cols="80" rows="6"><?=$this->notice ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="button">
                    <input type="image" src="images/order_end.png" alt="Закончить оформление заказа" onmouseover="this.src='images/order_end_active.png'" onmouseout="this.src='images/order_end.png'" />
                    <input type="hidden" name='func' value='addorder' />
                </td>

            </tr>
        </table>
        <span style='color: red;'><?=$this->air_message ?></span>
    </form>
</div>