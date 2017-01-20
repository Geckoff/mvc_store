<?php

require_once "adminmodules_class.php";

class AdminOrderContent extends AdminModules {

    protected $table;

    protected function getContent() {
        $this->table = 'order';
        $this->template->set('title', 'Заказы');
        $this->template->set('keywords', 'Заказы');
        $this->template->set('description', 'Заказы');
        $this->template->set('right_tpl_name', array($this->setTable()));
        $this->template->set('left_tpl_string', array($this->setAddButton('editorder', 'Заказы')));

        $this->setTable();
    }

    protected function getColumnParams() {
        $column_params = array();
        $column_params['filter'] = array('id', '', 'price', 'name', '', '', '', 'date_order', '');
        $column_params['name'] = array('№', 'Доставка', 'Цена', 'Имя', 'Номер телефона', 'Емэйл', 'Адрес', 'Дата заказа', 'Действия');
        $column_params['width'] = array('20', '100', '30', '200', '200', '250', '150', '', '150');
        return $column_params;
    }

    protected function getColumnData($order) {
        if ($order['delivery'] == 1) $delivery = 'Да';
        else $delivery = 'Нет';
        $columns_data = array(
            $order['id'],
            $delivery,
            $order['price'],
            $order['name'],
            $order['phone'],
            $order['email'],
            $order['address'],
            date("d.m.y H:i", $order['date_order']),
            $this->getActionTableLinks($order['id'], 'order')
        );
        return $columns_data;
    }



}








 ?>