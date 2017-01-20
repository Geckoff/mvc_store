<?php

require_once "adminmodules_class.php";

class AdminEditProductContent extends AdminModules {

    protected $table_class;

    protected function getContent() {
        $this->table_class = 'product';
        $this->template->set('title', $this->getHeaderTitle('Фильмы'));
        $this->template->set('keywords', $this->getHeaderTitle('Фильмы'));
        $this->template->set('description', $this->getHeaderTitle('Фильмы'));
        $this->template->set('h2_editform_title', $this->getHeaderTitle('Фильмы'));
        $this->template->set('edit_form_string', $this->setEditFormString());          // Data for editing/adding
        $this->template->set('left_tpl_string', array('<p>Понравилась ли вам наша система?</p>'));
        $this->template->set('right_tpl_name', array('editform'));
        $this->template->set('file_form', true);
    }

    protected function getHeaderTitleItemName() {
        $title = $this->product->getProductTitle($this->data['id']);
        return $title['title'];
    }

    protected function setDataAdd() {            // setting array with fields (without values) for showing in the form
        $preview = '
                <input type="file" id="image" name="img"/>
                <input type="reset" value="Сбросить"/>
                <div><img alt="" id="image_preview" src="'.$this->url->getProdutImageFolder().'prodimage"/></div>
                <script type="text/javascript">
                    $("#image").change(function() {
                        var input = $(this)[0];
                        if ( input.files && input.files[0] ) {
                            if ( input.files[0].type.match("image.*") ) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $("#image_preview").attr("src", e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                            } else console.log("is not image mime type");
                        } else console.log("not isset files data or files API not supordet");
                    });

                    $("#editform").bind("reset", function() {
                        $("#image_preview").attr("src", "");
                    });
                </script>';
        $dataset = array(
            array('text', 'Название', 'title'),
            array('text', 'Год выхода', 'year'),
            array('select', 'Жанр', $this->getGenres()),
            array('text', 'Страна-производитель', 'country'),
            array('text', 'Режиссер', 'director'),
            array('text', 'Продолжительность (чч:мм:сс)', 'play'),
            array('textarea', 'В ролях', 'cast'),
            array('text', 'Цена', 'price'),
            array('textarea', 'Описание', 'description'),
            array('spec', 'Загрузить файл', 'img', $preview, '%prodimage%'),  
        );
        return $dataset;
    }

    private function getGenres() {
        $sections = $this->section->getAllSections();
        $secdataset = array();
        $secdataset['selectname'] = 'section_id';
        for($i = 0; $i < count($sections); $i++) {
            $secdataset[$sections[$i]['id']] = $sections[$i]['title'];
        }
        return $secdataset;
    }

}








 ?>