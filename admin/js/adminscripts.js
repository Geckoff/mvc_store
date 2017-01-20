

$(document).ready(function(){

    //nicEditors.allTextareas();

    $('form').on('submit', function(){
        $(".notify").remove();
    });

    if ($('table').is("#upper-table")) {

        setTimeout(function() {
          var width = $('#lower-table').width();
          $('#upper-table').width(width);
        }, 1);


        $("#upper-table tr td").width(function(i,val){
            $("#lower-table tr td").eq(i).width(val);
        });

    }

    //Отправка формы с количеством элементов на страницу таблицы в админпанели
    if ($("form").is(".quant-on-page")) {
        form = $(".quant-on-page");
        select = $(".quant-on-page select");
        select.change(function(){
            form.submit();
        });
    }

    if ($('img').is('#image_preview')) { 
        if ($('#image_preview').attr('src').match('products/$')) {
            $('#image_preview').attr('src', '');
        }
    }


    $('.delete').on('click', function(){
        var link = $(this).attr('href');
        var element = $("<div id='del-akn'><p>Вы уверены?</p><a href=" + link +">Да</a><a class='akno' href='/'>Нет</a></div>");
        element.insertBefore('#footer');
        $('.akno').on('click', function(){
            $("#del-akn").remove();
            return false;
        });
        return false;
    });






   /*$(function(){
        $("#delete").click(function() {
            alert($(this).attr("id"));
        });
    });*/

    //Проверка заполненности полей
    $('#editform').on('submit', function(){
        var form = $(this);
        var k = 0;

        var elements_arr = new Array();
        elements_arr[0] = {'condition': 'voidfield',
                      'input[name="login"]': 'Укажите логин',
                      'input[name="add-new-pas"]': 'Укажите пароль',
                      'input[name="add-rep-pas"]': 'Повторите пароль',
                      'input[name="cur_password"]': 'Укажите текущий пароль',
                      'input[name="country"]': 'Укажите страну',
                      'input[name="director"]': 'Укажите режиссера',
                      'input[name="phone"]': 'Укажите телефон',
                      'input[name="name"]': 'Укажите имя',
                      'input[name="code"]': 'Укажите код',
                      'input[name="value"]': 'Укажите значение',
                      'textarea[name="cast"]': 'Укажите актеров',
                      'textarea[name="description"]': 'Добавьте описание',
                      'input[name="title"]': 'Укажите название'};
        elements_arr[1] = {'condition': 'numeric',
                      'input[name="year"]': 'Неверный формат года',
                      'input[name="price"]': 'Неверный формат цены'};
        elements_arr[2] = {'condition': 'time-format',
                      'input[name="play"]': 'Неверный формат продолжительности'};

        for (var i = 0; i < elements_arr.length; i++) {
            var condition = elements_arr[i]['condition'];
            $.each(elements_arr[i], function(element, notice_text) {
                if ($(element).is($(element))) {
                    if (element !== 'condition') {
                        if (checkCondition(condition, element)) {
                            k = insertNotice(notice_text, element, form);
                        }
                    }
                }

            });
        }

        if ($('input[name="login"]').is($('input[name="login"]')) && form.find('input[name="login"]').val() !== '' && !form.find('input[name="login"]').val().match(/[a-zA-Z0-9]+/)) {
            k = insertNotice('Только цифры и буквы', 'input[name="login"]', form);
        }
        if ($('input[name="email"]').is($('input[name="email"]')) && !form.find('input[name="email"]').val().match(/.+@.+\..+/i)) {
            k = insertNotice('Укажите корректный емэйл', 'input[name="email"]', form);
        }
        if ($('input[name="value"]').is($('input[name="value"]')) && !$('input[name="value"]').val().match(/^0\.\d+$/i) )  {
            k = insertNotice('Значение должно быть между 0 и 1', 'input[name="value"]', form);
        }


        if ($('.movie-section').is($('.movie-section'))) {

            $(".movie-section").each(function(i, section){
                var section = $(section);
                var name =  section.find('input[type="number"]').attr('name');
                if (section.find('input[type="number"]').val() == 0 || section.find('select').val() == 0) {
                    k = insertNotice('Выберите фильм и количество копий', 'input[name="' + name + '"]', form);
                }
            });
        }

        if (k == 1) return false;
    });

    function checkCondition(condition, element) {
        switch (true) {
            case (condition == 'voidfield'): return $(element).val() == ''; break;
            case (condition == 'numeric'): return !$(element).val().match('^[0-9]+$'); break;
            case (condition == 'time-format'): return !$(element).val().match('^[0-9][0-9]:[0-9][0-9]:[0-9][0-9]$'); break;
        }
    }

    function insertNotice(notice_text, element, cur_element) {
        $('<span class="notify" style="color:red;">' + notice_text + '</span>').insertAfter(cur_element.find(element));
        k = 1;
        return k;
    }



    if ($('input[name="edit-new-pas"]').is($('input[name="edit-new-pas"]'))) {
        var name = 'edit';
        pasRepeatNotify(name);
    }
    else if ($('input[name="add-new-pas"]').is($('input[name="add-new-pas"]'))){
        var name = 'add';
        pasRepeatNotify(name);
    }


    function pasRepeatNotify(name) {
        $('<div class="pas-compare"></div>').insertAfter($('input[name="' + name + '-new-pas"]'));
        $('<div class="pas-compare"></div>').insertAfter($('input[name="' + name + '-rep-pas"]'));
        $('input[name="' + name + '-rep-pas"]').keyup(function(eventObject){
            if ($(this).val() !== $('input[name="' + name + '-new-pas"]').val()) {
                $('.pas-compare').css("background", "url(http://imtrying.local/admin/images/red_cross.png)");
            }
            else {
                $('.pas-compare').css("background", "url(http://imtrying.local/admin/images/green_check.png)");
            }
        });
    }

    //Удаление и добавление секции фильма в админпанели на странице редактирования заказа

    $('input[name="addmovie"]').on('click', function(){
        $('#delnotify').remove();
        var select = $('div.movie-section:first').clone();
        select.insertBefore($("#add-movie"));
        select.find('option[selected]').removeAttr('selected');
        select.find('input[type="number"]').attr("value", "0");
        setNamesTitleNumberMovieSection();
    });

    $('body').on('click', 'input[name="delmovie"]', function(){
        $('#delnotify').remove();
        if ($(".movie-section").length == 1) {
            $('<span id="delnotify" style="color: red">В заказе должен быть как минимум 1 фильм</span>').insertAfter($('input[name="delmovie"]'));
        }
        else {
            var input = $(this);
            input.parent().parent().remove();
            setNamesTitleNumberMovieSection();
        }
    });

    function setNamesTitleNumberMovieSection() {
        $(".movie-section").each(function(i, section){
            section = $(section);
            section.find('select.product-select').attr("name", (i + 1) + "title");
            section.find('input[type="number"]').attr("name", (i + 1) + "number");
        });

    }

});
