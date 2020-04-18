$(function () {
    $(document).on('click', '.slide', function(){
        if($(this).parent().children('.phrase_control').is(':visible')) {
            $(this).parent().children('.phrase_control').slideUp();
        }
        else {
           $(this).parent().children('.phrase_control').slideDown();
        }
    })
    $(document).on('change', '.html', function () {
        var html = deleteSpace($(this).val());
        $(this).parent().prevAll('.html_show').html(html);
    })

    $(document).on('change', '.css', function () {
        var css = deleteSpace($(this).val());
        $(this).parent().prevAll('.css_show').children('style').html(css);
    })
    $(document).on('click', '.clear', function(){
          $(this).prevAll().find('input').val('');
          $(this).prevAll().find('textarea').val('');
          $(this).prevAll().find('select').val('');
          //イラストクリア
          $(this).prevAll('.html_show').html('');
          $(this).prevAll('.html_show').find('style').html('');
    })
    $(document).on('click', '.object_clear', function(){
          //イラストクリア
          $(this).prevAll('.html_show').html('');
          $(this).prevAll('.html_show').find('style').html('');
          //イラストhtml・cssクリア
        $(this).nextAll().find('.html').val('');
        $(this).nextAll().find('.css').val('');
    })
    $(document).on('click', '.object_speak', function () {
        // 共通セレクタ定義
        var html_selector = $(this).parents('.checkbox').prevAll('.textarea').find('.html');
        var css_selector = $(this).closest('.checkbox').prevAll('.textarea').find('.css');
        var html_show_selector = $(this).closest('.checkbox').prevAll('.html_show');
        var css_show_selector = $(this).closest('.checkbox').prevAll('.css_show');
        if ($(this).prop('checked')) {
            //キャラクタID取得
            var character_id = $(this).closest('.checkbox').prevAll('.select').find('.character_id').val();
            var sentence = $(this).closest('.checkbox').nextAll('.textarea').find('.sentence').val();
            var sentence_kana = $(this).closest('.checkbox').nextAll('.textarea').find('.sentence_kana').val();
            var sentence_translate = $(this).closest('.checkbox').nextAll('.textarea').find('.sentence_translate').val();
            if (!character_id) {
                alert('キャラクターを選択して下さい');
                $(this).prop('checked', false);
            } else {
                // 値クリア
                html_selector.val('');
                css_selector.val('');
                html_show_selector.html('');
                css_show_selector.find('style').html('');
                // html取得
                $.ajax({
                    type: "post",
                    url: "/admin_ajax/chapters/character-speak-html",
                    dataType: 'text',
                    // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
                    data: {
                        "character_id": character_id,
                        "sentence": sentence,
                        "sentence_kana": sentence_kana,
                        "sentence_translate": sentence_translate,
                    },
                }).done(function (data, status, jqXHR) {
                    var html = data;
                    html_selector.val(html);
                    html_show_selector.html(html);
                }).fail(function (jqXHR, status, error) {
                    console.log(jqXHR);
                    console.log(status);
                    console.log(error);
                });
                // css取得
                $.ajax({
                    type: "post",
                    url: "/admin_ajax/chapters/character-speak-css",
                    dataType: 'text',
                    // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
                    data: {
                        "character_id": character_id,
                    },
                }).done(function (data, status, jqXHR) {
                    var css = data;
                    css_selector.val(css);
                    css_show_selector.find('style').html(css);
                }).fail(function (jqXHR, status, error) {
                    console.log(jqXHR);
                    console.log(status);
                    console.log(error);
                });
            }
        } else {
            html_selector.val('');
            css_selector.val('');
            html_show_selector.html('');
            css_show_selector.find('style').html('');
        }
    })

    $(document).on('click', '.insert', function(){
        var phrase_no = $(this).parent().children('.phrase_no').val();
        var phrase_num = $('#phrase_num').val();
        for (var i = phrase_num -2 ; i >= phrase_no; i--) {
            var j = i+1;
            var columns = ['character_id', 'speaker_name', 'speaker_color', 'sentence', 'picture_before', 'dir_before', 'picture_delete', 'html', 'css'];
            $.each(columns, function (index, value) {
                $('*[name="phrases[' + j + ']['+ value +']"]').val($('*[name="phrases[' + i + ']['+ value +']"]').val());
                $('*[name="phrases[' + i + ']['+ value +']"]').val('');
                if (value=='html') {
                    if ($('*[name="phrases[' + j + ']['+ value +']"]').val()) {
                        $('#html_show_' + j).html($('*[name="phrases[' + j + ']['+ value +']"]').val());
                        $('#html_show_' + i).html('');
                    }
                }
                if (value=='css') {
                    if ($('*[name="phrases[' + i + ']['+ value +']"]').val()) {
                        $('#css_show_' + j).children('style').html(($('*[name="phrases[' + j + ']['+ value +']"]').val()));
                        $('#css_show_' + i).children('style').html('');
                    }
                }
            })
        }
    })
    $('.sentence').bind('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().length;
        $(this).closest('.textarea').prevAll().find('.count').html(thisValueLength);
        // 発話フラグが立っている場合
        if ($(this).closest('.textarea').prevAll('.checkbox').find('.object_speak').prop('checked')) {
            $(this).closest('.textarea').prevAll().find('.speak').html($(this).val());
            var html = $(this).closest('.textarea').prevAll('.html_show').html();
            $(this).closest('.textarea').prevAll().find('.html').html(html);
        }
    })
    $(document).on("click", ".object_select", function () {
        var phrase_no = $(this).parent().children('.phrase_no').val();
        $('#phrase_no').val(phrase_no);
        var popup = document.getElementById('js-popup');
        popup.classList.add('is-show');
        var blackBg = document.getElementById('js-black-bg');
        var closeBtn = document.getElementById('js-close-btn');
        closePopUp(blackBg);
        closePopUp(closeBtn);
        function closePopUp(elem) {
            if (!elem)
                return;
            elem.addEventListener('click', function () {
                popup.classList.remove('is-show');
            })
        }
    });
    $(document).on('click', '.object_decide', function () {
        var phrase_no = $('#phrase_no').val();
        var object_id = $(this).closest('td').find('.object_id').val();
        var object_no = $(this).closest('td').find('.object_no').val();
        var width = $(this).closest('td').find('.width').val();
        var height = $(this).closest('td').find('.height').val();

        var html_select = deleteSpace($(this).closest('td').find('.html_show').html());
        html_select = wholeReplace(html_select , 'object_' + object_id, 'object_'  + object_id + '_' + object_no)
        var css_select = deleteSpace($(this).closest('td').find('style').html());
        css_select = wholeReplace(css_select , 'object_' + object_id, 'object_' + object_id + '_' + object_no);
        var css_add = '.object_'  + object_id + '_' + object_no + '{position:absolute; width:' + width + '%; height:' + height + '%;}';
        var html_input = $('#phrases-'+phrase_no+'-html').val();
        var css_input = $('#phrases-'+phrase_no+'-css').val();
        var html = html_select + html_input;
        var css  = css_add + css_select + css_input;

        $('#phrases-'+phrase_no+'-html').val(html);
        $('#phrases-'+phrase_no+'-css').val(css);
        $('#html_show_'+phrase_no).html(html);
        $('#css_show_'+phrase_no).children('style').html(css);
        //オブジェクト数カウント
        object_no ++;
        $(this).closest('td').find('.object_no').val(object_no);
        //ポップアップを閉じる
        var popup = document.getElementById('js-popup');
        popup.classList.remove('is-show');
    });
})
