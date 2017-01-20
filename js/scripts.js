

$(document).ready(function(){

    if ($('.link_cart').is($('.link_cart'))) {
        $('.link_cart').on('click', function(){
            $.post("ajax.php", {id: $(this).attr('id')}, function(data) {
                data = JSON.parse(data);
                $("#cartprods").text(data['product_num']);
                $("#cartcomprice").text(data['cartprice']);
                var prompts = 0;
                if ($(".prompt-block").is($(".prompt-block"))) {
                    prompts = $(".prompt-block").length;
                    var last_hight =  $(".prompt-block:last").css('bottom');
                    last_hight = parseInt(last_hight.slice(0, last_hight.length - 2));
                    //alert(last_hight);
                    if (last_hight > 250) {
                        last_hight = -125;
                    }
                }

                $("<div class='prompt-block'><span>В корзине:<br><b>" + data['title'] + "</b></span><img src='" + data['src'] + "' /></div>").appendTo($('body'));
                $(".prompt-block:last").css('bottom', last_hight + 95);
                $(".prompt-block").animate({
                  marginBottom: "40px",
                  opacity: 1
                }, 200);
                $(".prompt-block").delay(1000).animate({
                  marginBottom: "-40px",
                  opacity: 0
                }, 200, function(){
                    $(this).remove();
                });
            });
        });
    }


    $('form').on('submit', function(){
        $(".notify").remove();
    });

    //Проверка заполнености скидочного купона в корзине
    $('#discount_form').on('submit', function(){
        if ($('#discount_form input[type="text"]').val() == '') {
            $('#discount_form .coupon').html('Заполните поле!');
            return false;
        }
    });

    //Проверка заполненности полей при оформлении заказа
    $('#order_form').on('submit', function(){
        var k = 0;
        if ($('#order_form input[name="phone"]').val() == '') {
            $('<td style="background: none;"><span class="notify" style="color:red;">Заполните номeр телефона</span></td>').insertAfter($('#order_form input[name="phone"]').parent());
            k = 1;
        }
        if ($('#order_form input[name="email"]').val() != '' && !$('#order_form input[name="email"]').val().match(/.+@.+\..+/i)) {
            $('<td style="background: none;"><span class="notify" style="color:red;">Введите корректный email</span></td>').insertAfter($('#order_form input[name="email"]').parent());
            k = 1;
        }
        if ($("#delivery-sel").val() == '') {
            $('<td style="background: none;"><span class="notify" style="color:red;">Выберите вариант</span></td>').insertAfter($('#delivery-sel').parent());
            k = 1;
        }
        if (k == 1) return false;
    });

    //Демонстрация/скрытие поля адреса в корзине в зависимости от типа доставки
    $('#delivery-sel').on('change', function(){
        if ($("#delivery-sel").val() == '1') {
            $("#address").hide();
        }
        else {
            $("#address").show();
        }
    });
    if ($('#delivery-sel option[value=1]').attr('selected') == 'selected') $("#address").hide();

    //Запрет перехода к оформлению заказа при пустой корзине
    if ($('#orderlink').attr('class') == '0') {
        $("#orderlink").click(function(event) {
            $(".notify").remove();
            event.preventDefault();
            $(this).parent().siblings('.cart_right').html('<span class="notify" style="color:red; align:left;">Корзина пуста - нельзя оформить заказ</span>');
        });
    }

    //Проверка заполненности полей при регистрации
    $('#reg-form').on('submit', function(){
        var k = 0;
        if ($('#reg-form input[name="login"]').val() == '') {
            k = insertNotice('Укажите логин', 'input[name="login"]', $(this));
        }
        if ($('#reg-form input[name="login"]').val() !== '' && !$('#reg-form input[name="login"]').val().match(/[a-zA-Z0-9]+/)) {
            k = insertNotice('Только цифры и буквы', 'input[name="login"]', $(this));
        }
        if (!$('#reg-form input[name="email"]').val().match(/.+@.+\..+/i)) {
            k = insertNotice('Укажите корректный емэйл', 'input[name="email"]', $(this));
        }
        if (k == 1) return false;
    });

    $('input[name="rep_password"]').keyup(function(eventObject){
        if ($(this).val() !== $('input[name="nm_password"]').val()) {
            $('.pas-compare').css("background", "url(images/red_cross.png)");
        }
        else {
            $('.pas-compare').css("background", "url(images/green_check.png)");
        }
    });

    //Проверка заполненности полей логина-пароля
    $('form').on('submit', function(){
        var form = $(this);
        var k = 0;
        elements = {'input[name="login"]': 'Укажите логин', 'input[name="cur_password"]': 'Укажите текущий пароль'};
        $.each(elements, function(element, notice_text){
            if (form.find(element).val() == '') {
                k = insertNotice(notice_text, element, form);
            }
        });
        if (form.is('input[name="nm_password"]') && !form.find('input[name="nm_password"]').val().match(/.{4,}/i)) {
            k = insertNotice('Длина пароля не менее 4 символов', 'input[name="nm_password"]', $(this));
        }

        if (form.is('input[name="rep_password"]') && $('form input[name="rep_password"]').val() !== $('form input[name="nm_password"]').val()) {
            k = insertNotice('Несовпадение паролей', 'input[name="rep_password"]', $(this));
        }
        if (k == 1) {
            return false;
        }
    });

    function insertNotice(notice_text, element, cur_element) {
        $('<span class="notify" style="color:red;">' + notice_text + '</span>').insertAfter(cur_element.find(element));
        k = 1;
        return k;
    }

    //Отправка формы с количеством элементов на страницу таблицы в админпанели
    form = $(".quant-on-page");
    select = $(".quant-on-page select");
    select.change(function(){
      form.submit();
    });




});

