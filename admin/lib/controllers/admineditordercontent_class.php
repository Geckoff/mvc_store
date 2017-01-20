<?php

require_once "adminmodules_class.php";

class AdminEditOrderContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'order';
        $this->template->set('title', $this->getHeaderTitle('Заказы'));
        $this->template->set('keywords', $this->getHeaderTitle('Заказы'));
        $this->template->set('description', $this->getHeaderTitle('Заказы'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Заказы'));
        $this->template->set('edit_form_string', $this->setEditFormString());
        $this->template->set('right_tpl_name', array('editform'));
    }

    protected function getHeaderTitleItemName() {
        return 'Заказ №'.$this->data['id'];
    }

    protected function setDataAdd() {
        if (isset($this->data['id'])) {
            $goods = $this->order->getFieldOnID($this->data['id'], 'product_ids');
            $goodstoshow = array();
            $goods = explode(',', $goods['product_ids']);
            for ($i = 0; $i < count($goods); $i++) {
                if ($i == 0) {
                    $goodstoshow[$goods[$i]] = 1;
                }
                elseif ($goods[$i] == $goods[$i - 1]) {
                    $goodstoshow[$goods[$i]]++;
                }
                else {
                    $goodstoshow[$goods[$i]] = 1;
                }
            }
            $finalselect = '';
            $movies = $this->product->getAllStrings();
            $select = array();
            $k = 1;
            foreach ($goodstoshow as $id => $number) {
                $select[$k] = '<div class="movie-section"><select class="product-select" name="'.($k).'title"><option value="0">Выберите фильм</option>';
                for ($i = 0; $i < count($movies); $i++) {
                    if ($movies[$i]['id'] == $id) $selected = 'selected';
                    else $selected = '';
                    $select[$k] .= '<option '.$selected.' value="'.$movies[$i]['id'].'">'.$movies[$i]['title'].'</option>';
                }
                $select[$k] .= '</select><div class="product-select">Количество:</div> <input style="width: 40px;" class="product-select" type="number" min="0" name ="'.($k).'number" value="'.$number.'"  /><div class="product-select"><input type="button" name="delmovie" value="Удалить" /></div><br></div>';
                $k++;
            }
            $select = implode('', $select);
            $select .= '<div id="add-movie" class="product-select"><input type="button" name="addmovie" value="Добавить" /></div>';
        }
        else {
            if (!isset($_SESSION['add_data']['name'])) unset($_SESSION['add_data']['email']);
            $movies = $this->product->getAllStrings();
            $select = '<div class="movie-section"><select class="product-select" name="1title"><option value="0">Выберите фильм</option>';
            for ($i = 0; $i < count($movies); $i++) {
                $select .= '<option value="'.$movies[$i]['id'].'">'.$movies[$i]['title'].'</option>';
            }
            $select .= '</select><div class="product-select">Количество:</div> <input style="width: 40px;" class="product-select" type="number" min="0" name ="1number" value="0"  /><div class="product-select"><input type="button" name="delmovie" value="Удалить" /></div><br></div>';
            $select .= '<div id="add-movie" class="product-select"><input type="button" name="addmovie" value="Добавить" /></div>';
        }

        $dataset = array(
            array('checkbox', 'Доставка', 'delivery'),
            array('spec', 'Товары в заказе', '', $select, ''),
            array('text', 'Цена', 'price'),
            array('text', 'Имя', 'name'),
            array('text', 'Телефон', 'phone'),
            array('text', 'Емэйл', 'email'),
            array('text', 'Адрес', 'address'),
            array('textarea', 'Примечание', 'notice'),
            array('date', 'Дата отправки', 'date_send'),
            array('date', 'Дата оплаты', 'date_pay')
        );
        return $dataset;
    }

}








 ?>