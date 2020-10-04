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
        var phrase_no = $(this).closest('.input').prevAll('.phrase_no').val();
        // CSSレイアウト更新(ajax)
        $.ajax({
            type: "post",
            url: "/admin_ajax/chapters/object-layout",
            dataType: 'text',
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "css": css,
                "phrase_no": phrase_no,
            },
        }).done(function (data, status, jqXHR) {
            $('.object_layout_input_'+phrase_no).html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(jqXHR);
            console.log(status);
            console.log(error);
        });
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
          $(this).prevAll('.css_show').find('style').html('');
          //イラストhtml・cssクリア
        $(this).nextAll('.input').find('.html').val('');
        $(this).nextAll('.input').find('.css').val('');
        $(this).prevAll('.object_layout_input').html('');
    })
    // 無意味だったので一旦コメントアウト
    // $(document).on('change', '.js', function() {
    //     var phrase_no = $(this).parents().children('.phrase_no').val();
    //     var js ="$(document).on('click', '.object_animate_" + phrase_no + ", function() { " + $(this).val() + "})";
    //     $(this).closest('div').prevAll('script').html(js);
    // })

    $(document).on('click', '.character_object', function () {
        // 共通セレクタ定義
        var html_selector = $(this).closest('.checkbox').nextAll('.textarea').find('.html');
        var css_selector = $(this).closest('.checkbox').nextAll('.textarea').find('.css');
        var html_show_selector = $(this).closest('.checkbox').prevAll('.html_show');
        var css_show_selector = $(this).closest('.checkbox').prevAll('.css_show');
        var character_object_check = $(this);
        var phrase_no = $(this).closest('.input').prevAll('.phrase_no').val();
        if ($(this).prop('checked')) {
            //キャラクタID取得
            var character_id = $(this).closest('.checkbox').prevAll('.select').find('.character_id').val();
            var object_usage = $(this).closest('.checkbox').prevAll('.select').find('.object_usage').val();
            var sentence = $(this).closest('.checkbox').prevAll('.input').find('.sentence').val();
            var sentence_kana = $(this).closest('.checkbox').prevAll('.input').find('.sentence_kana').val();
            var sentence_translate = $(this).closest('.checkbox').prevAll('.input').find('.sentence_translate').val();
            if (!character_id) {
                alert('キャラクターを選択して下さい');
                character_object_check.prop('checked', false);
            } else {
                // 値クリア
                html_selector.val('');
                css_selector.val('');
                html_show_selector.html('');
                css_show_selector.find('style').html('');
                // 各パーツのオブジェクトNoを取得
                var character_class = '.character_' + character_id;
                var usage_class = '.usage_' + object_usage;
                var face_object_no = $('#js-popup').find('.object_no' + character_class + usage_class + '.default_face').val();
                var body_object_no = $('#js-popup').find('.object_no' + character_class + usage_class + '.default_body').val();
                var speech_object_no = $('#js-popup').find('.object_no' + usage_class + '.default_speech').val();

                // html取得
                $.ajax({
                    type: "post",
                    url: "/admin_ajax/chapters/character-speak",
                    dataType: 'json',
                    // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
                    data: {
                        "character_id": character_id,
                        "phrase_no": phrase_no,
                        "object_usage": object_usage,
                        // "sentence": sentence,
                        // "sentence_kana": sentence_kana,
                        // "sentence_translate": sentence_translate,
                    },
                }).done(function (data, status, jqXHR) {
                    var html = data.html;
                    var css = data.css;
                    var badge_left_html = data.badge_left_html;
                    var badge_right_html = data.badge_right_html;
                    if (html && css) {
                        // html調整
                        html = wholeReplace(html , 'face object', 'face object_'  + face_object_no);
                        html = wholeReplace(html , 'body object', 'body object_'  + body_object_no);
                        html = wholeReplace(html , 'speech object', 'speech object_'  + speech_object_no);
                        // html_selector.val(html);
                        html_show_selector.html(html);
                        // 文章置き換え
                        replace_sentence(object_usage, sentence, html_show_selector);
                        // 階級章置き換え
                        if (badge_left_html) {
                            html_show_selector.find('.rank_badge_left').html(badge_left_html);
                        }
                        if (badge_right_html) {
                            html_show_selector.find('.rank_badge_right').html(badge_right_html);
                        }
                        html_selector.val(html_show_selector.html());
                        // css調整
                        css = wholeReplace(css , '.face.object', '.face.object_'  + face_object_no);
                        css = wholeReplace(css , '.body.object', '.body.object_'  + body_object_no);
                        css = wholeReplace(css , '.speech.object', '.speech.object_'  + speech_object_no);
                        css_selector.val(css);
                        css_show_selector.find('style').html(css);
                        // オブジェクトNoのインクレメント
                        face_object_no++;
                        body_object_no++;
                        speech_object_no++;
                        $('#js-popup').find('.object_no' + character_class + usage_class + '.default_face').val(face_object_no);
                        $('#js-popup').find('.object_no' + character_class + usage_class + '.default_body').val(body_object_no);
                        $('#js-popup').find('.object_no' + character_class + '.default_speech').val(speech_object_no);

                        // CSSレイアウト更新(ajax)
                        $.ajax({
                            type: "post",
                            url: "/admin_ajax/chapters/object-layout",
                            dataType: 'text',
                            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
                            data: {
                                "css": css,
                                "phrase_no": phrase_no,
                            },
                        }).done(function (data, status, jqXHR) {
                            $('.object_layout_input_' + phrase_no).html(data);
                        }).fail(function (jqXHR, status, error) {
                            console.log(jqXHR);
                            console.log(status);
                            console.log(error);
                        });

                    } else {
                        alert('対応するパーツが存在しません。');
                        character_object_check.prop('checked', false);
                    }
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

    $(document).on('click', '.insert', function() {
        var phrase_no = $(this).parent().children('.phrase_no').val();
        var phrase_num = $('#phrase_num').val();
        for (var i = phrase_num -2 ; i >= phrase_no; i--) {
            var j = i+1;
            var columns = ['character_id', 'speaker_name', 'speaker_color', 'sentence', 'picture_before', 'dir_before', 'picture_delete', 'html', 'css', 'background_id', 'object_usage'];
            $.each(columns, function (index, value) {
                $('*[name="phrases[' + j + ']['+ value +']"]').val($('*[name="phrases[' + i + ']['+ value +']"]').val());
                $('*[name="phrases[' + i + ']['+ value +']"]').val('');
                if (value=='html') {
                    if ($('*[name="phrases[' + j + ']['+ value +']"]').val()) {
                        $('#html_show_' + j).html($('*[name="phrases[' + j + ']['+ value +']"]').val());
                        $('#html_show_' + i).html('');
                    }
                }
                if (value =='css') {
                    if ($('*[name="phrases[' + i + ']['+ value +']"]').val()) {
                        $('#css_show_' + j).children('style').html(($('*[name="phrases[' + j + ']['+ value +']"]').val()));
                        $('#css_show_' + i).children('style').html('');
                    }
                }
            })
        }
    })

    $('.sentence').bind('keydown keyup keypress change',function() {
        var thisValueLength = $(this).val().length;
        $(this).closest('.input').prevAll().find('.count').html(thisValueLength);
        // 発話フラグが立っている場合
        if ($(this).closest('.input').nextAll('.checkbox').find('.character_object').prop('checked')) {
            var sentence = $(this).val();
            var html_show_selector = $(this).closest('.input').nextAll('.html_show');
            var object_usage = $(this).closest('.textarea').nextAll('.select').find('.object_usage').val();
            // 文章置き換え
            replace_sentence(object_usage, sentence, html_show_selector);
            var html = html_show_selector.html();
            $(this).closest('.input').nextAll('.input').find('.html').html(html);
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
    })
    $(document).on('click', '.object_decide', function () {
        var phrase_no = $('#phrase_no').val();
        var object_id = $(this).closest('td').find('.object_id').val();
        var object_no = $(this).closest('td').find('.object_no').val();
        var width = $(this).closest('td').find('.width').val();
        var height = $(this).closest('td').find('.height').val();
        var class_name = $(this).closest('td').find('.class_name').val();

        var html_select = deleteSpace($(this).closest('td').find('.object_input').html());
        html_select = wholeReplace(html_select , 'object_' + object_id, class_name + ' object object_'  + object_no + '_' + object_id)
        var css_select = deleteSpace($(this).closest('td').find('style').html());
        css_select = wholeReplace(css_select , 'object_' + object_id, 'object_' + object_no + '_' + object_id);
        var css_add = '/*.object_'  + object_no + '_' + object_id + '_start*/' + '.object_'  + object_no + '_' + object_id + '{position:absolute; width:' + width + '%; height:' + height + '%;}';
        var html_input = $('#phrases-'+phrase_no+'-html').val();
        var css_input = $('#phrases-'+phrase_no+'-css').val();
        var css_end_add = '/*.object_'  + object_no + '_' + object_id + '_end*/';
        var html = html_select + html_input;
        var css  = css_add + css_select + css_end_add + css_input ;

        $('#phrases-'+phrase_no+'-html').val(html);
        $('#phrases-'+phrase_no+'-css').val(css);
        $('#html_show_'+phrase_no).html(html);
        $('#css_show_'+phrase_no).children('style').html(css);
        //オブジェクト数カウント
        object_no ++;
        $(this).closest('td').find('.object_no').val(object_no);
        // CSSレイアウト更新(ajax)
        $.ajax({
            type: "post",
            url: "/admin_ajax/chapters/object-layout",
            dataType: 'text',
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "css": css,
                "phrase_no": phrase_no,
            },
        }).done(function (data, status, jqXHR) {
            $('.object_layout_input_'+phrase_no).html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(jqXHR);
            console.log(status);
            console.log(error);
        });
        //ポップアップを閉じる
        var popup = document.getElementById('js-popup');
        popup.classList.remove('is-show');
    });
    // オブジェクト削除
    $(document).on("click", ".object_delete", function () {
        if(!confirm('削除しますか？')){
            /* キャンセルの時の処理 */
            return false;
        }else{
            /*　OKの時の処理 */
            var phrase_no = $(this).parent().children('.phrase_no').val();
            var object_id = $(this).parent().children('.object_id').val();
            var object_no = $(this).parent().children('.object_no').val();

            var object_class = '';
            var speak_flg = false;
            // 通常オブジェクト
            if (object_id) {
                object_class = '.object_' + object_no + '_' + object_id;
            // それ以外(発話オブジェクト)
            } else {
                object_class = '.character_speak_' + phrase_no;
                speak_flg = true;
            }
            var html_show_id = '#html_show_' + phrase_no;
            $(html_show_id).find(object_class).remove();
            var css = $(this).closest('.object_layout_input').nextAll('.input').find('.css').val();
            var regexp = new RegExp('/\\*' + '([\\.face|\\.body|\\.speech]*)' + object_class + '_start' + '\\*/' + '([\\s\\S]*)' + '/\\*' + '(.*)' + object_class + '_end' + '\\*/' , 'g');
            var css_replaced = css.replace(regexp, '');
            $(this).closest('.object_layout_input').nextAll('.input').find('.css').val(css_replaced);
            $(this).closest('.object_layout_input').prevAll('.css_show').find('style').html(css_replaced);
            var html = $(html_show_id).html();
            $('#phrases-'+phrase_no + '-html').val(html);
            $(this).parent('td').remove();
        }
    });
    $(document).on("click", ".object_modify", function () {
        var phrase_no = $(this).parent().children('.phrase_no').val();
        var popup = document.getElementById('js_popup_modify_' + phrase_no);
        if (popup) {
            popup.classList.add('is-show');
            var blackBg = document.getElementById('js_modify_black_bg_' + phrase_no);
            var closeBtn = document.getElementById('js_modify_close_btn_' + phrase_no);
            closePopUp(blackBg);
            closePopUp(closeBtn);

            function closePopUp(elem) {
                if (!elem)
                    return;
                elem.addEventListener('click', function () {
                    popup.classList.remove('is-show');
                })
            }
        }
    })
    $(document).on("change", ".css_layout", function () {
        var css_after = wholeReplace($(this).val(), '　', '');
        css_after = wholeReplace(css_after, ' ', '');
        var css_before = $(this).next('.css_layout_original').val();
        var css = $(this).closest('.object_layout_input').nextAll('.input').find('.css').val();
        var css_replaced = wholeReplace(css, css_before, css_after);
        $(this).closest('.object_layout_input').nextAll('.input').find('.css').val(css_replaced);
        $(this).closest('.object_layout_input').prevAll('.css_show').find('style').html(css_replaced);
        $(this).next('.css_layout_original').val(css_after);
    })

    // 文章置き換え
    function replace_sentence(object_usage, sentence, html_show_selector) {
        var object_usage_str =  $('#object_usage_str').val();
        var object_usage_arr =  JSON.parse(object_usage_str);
        if (object_usage_arr[object_usage] == 'introduction') {
            // 肩書紹介の場合
            var arr = sentence.split(/\r\n|\n/);
            if (arr[1]) {
                html_show_selector.find('.sentence').find('.title').html(arr[0]);
                html_show_selector.find('.sentence').find('.name').html(arr[1]);
            } else {
                html_show_selector.find('.sentence').find('.title').html('');
                html_show_selector.find('.sentence').find('.name').html(arr[0]);
            }

        } else {
            html_show_selector.find('.sentence').html(sentence);
        }
    }
})
