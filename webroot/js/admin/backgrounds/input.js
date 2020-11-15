$(function () {
    // 背景オブジェクトの複製
    copyObjects();

    // 作品変更によるキャラクタ選択肢の変更
    $(document).on("change", ".body_color", function () {
        document.getElementById('body').style.backgroundColor = $(this).val();
    })

    $(document).on("click", ".object_select", function () {
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
        var object_id = $(this).closest('td').find('.object_id').val();
        var object_no = $(this).closest('td').find('.object_no').val();
        var width = $(this).closest('td').find('.width').val();
        var height_original = $(this).closest('td').find('.height').val();
        var height = Math.round(height_original * 1 / 2); // 登録時の基準値との差異を調整
        var class_name = $(this).closest('td').find('.class_name').val();
        var html_select = deleteSpace($(this).closest('td').find('.object_input').html());
        html_select = wholeReplace(html_select , 'object_' + object_id, class_name + ' object object_'  + object_no + '_' + object_id)

        var css_select = deleteSpace($(this).closest('td').find('style').html());
        css_select = wholeReplace(css_select , 'object_' + object_id, 'object_' + object_no + '_' + object_id);
        var css_add = '/*.object_'  + object_no + '_' + object_id + '_start*/' + '.object_'  + object_no + '_' + object_id + '{position:absolute; width:' + width + '%; height:' + height + '%; --object_width:calc(var(--phrase_object_width) * ' + width / 100 + '); --object_height:calc(var(--phrase_object_height) * ' + height_original / 100 + ');}';
        var html_input = $('.html_input').val();
        var css_input = $('.css_input').val();
        var css_end_add = '/*.object_'  + object_no + '_' + object_id + '_end*/';
        var html = html_select + html_input;
        var css  = css_add + css_select + css_end_add + css_input ;
        // 集合対応
        var is_mass = $(this).closest('td').find('.is_mass').prop('checked');
        if (is_mass) {
            var row_num = $(this).closest('td').find('.row_num').val();
            var column_num = $(this).closest('td').find('.column_num').val();
            var html_objects = '<div class="objects objects_' + object_no + '_' + object_id + '" data-row_num="' + row_num + '">';
            var html_rows = '<div class="object_row object_row_' + object_no + '_' + object_id + '" data-column_num="' + column_num + '">';
            html = html_objects + html_rows + html + '</div>' + '</div>';
            // css
            var css_mass = '';
            var height_div = Math.round(100 / row_num);
            for (let i = 1; i <= row_num; i++) {
                var top_div = height_div * (i - 1);
                css_mass += '.object_row_' + object_no + '_' + object_id + ':nth-child(' + row_num + 'n+' + i + ') .object_'  + object_no + '_' + object_id + ' {\n' +
                    ' top:' + top_div + '%;\n' +
                    '}\n';
            }
            var width_div = Math.round(100 / column_num);
            for (let j = 1; j <= column_num; j++) {
                var left_div = width_div * (j - 1);
                css_mass += '.object_' + object_no + '_' + object_id + ':nth-child(' + column_num + 'n+' + j + ') {\n' +
                    ' left:' + left_div + '%;\n' +
                    '}';
            }
            css = css_mass + css;
        }
        $('.html_input').val(html);
        $('.css_input').val(css);
        $('.html_background_admin').html(html);
        $('.css_background').children('style').html(css);
        //オブジェクト数カウント
        object_no ++;
        $(this).closest('td').find('.object_no').val(object_no);
        // CSSレイアウト更新(ajax)
        $.ajax({
            type: "post",
            url: "/admin_ajax/layouts/object-layout",
            dataType: 'text',
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "css": css,
            },
        }).done(function (data, status, jqXHR) {console.log(data);
            $('.object_layout_input').html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(jqXHR);
            console.log(status);
            console.log(error);
        });
        // チェックボックスを外す
        $(this).closest('td').find('.is_mass').prop('checked', false);
        //ポップアップを閉じる
        var popup = document.getElementById('js-popup');
        popup.classList.remove('is-show');
    });
    $(document).on('change', '.html_input', function () {
        var html = deleteSpace($(this).val());
        $('.html_background').html(html);
    })

    $(document).on('change', '.css_input', function () {
        var css = deleteSpace($(this).val());
        $('.css_background').children('style').html(css);
        //CSSレイアウト更新(ajax)
        $.ajax({
            type: "post",
            url: "/admin_ajax/layouts/object-layout",
            dataType: 'text',
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "css": css,
            },
        }).done(function (data, status, jqXHR) {
            $('.object_layout_input').html(data);
        }).fail(function (jqXHR, status, error) {
            console.log(jqXHR);
            console.log(status);
            console.log(error);
        });
    })
    $(document).on("change", ".css_layout", function () {
        var css_after = wholeReplace($(this).val(), '　', '');
        css_after = wholeReplace(css_after, ' ', '');
        var css_before = $(this).next('.css_layout_original').val();
        var css = $('.css_input').val();
        var css_replaced = wholeReplace(css, css_before, css_after);
        $('.css_input').val(css_replaced);
        $('.css_background').find('style').html(css_replaced);
        $(this).next('.css_layout_original').val(css_after);
    })
    // オブジェクト削除
    $(document).on("click", ".object_delete", function () {
        if(!confirm('削除しますか？')){
            /* キャンセルの時の処理 */
            return false;
        } else {
            /*　OKの時の処理 */
            var object_id = $(this).parent().children('.object_id').val();
            var object_no = $(this).parent().children('.object_no').val();

            var object_class = '';
            // 通常オブジェクト
            object_class = '.object_' + object_no + '_' + object_id;

            $('.html_background').find(object_class).remove();
            var css = $('.css_input').val();
            var regexp = new RegExp('/\\*' + '([\\.face|\\.body|\\.speech]*)' + object_class + '_start' + '\\*/' + '([\\s\\S]*)' + '/\\*' + '(.*)' + object_class + '_end' + '\\*/' , 'g');
            var css_replaced = css.replace(regexp, '');
            $('.css_input').val(css_replaced);
            $('.object_layout_input').prevAll('.css_show').find('style').html(css_replaced);
            var html = $('.html_background').html();
            $('.html_input').val(html);
            $(this).parent('td').remove();
        }
    });
    $(document).on("click", ".object_modify", function () {
        var popup = document.getElementById('js_popup_modify');
        if (popup) {
            popup.classList.add('is-show');
            var blackBg = document.getElementById('js_modify_black_bg');
            var closeBtn = document.getElementById('js_modify_close_btn');
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
    });
    $(document).on('click', '.object_clear', function(){
        //イラストクリア
        $('.html_background_admin').html('');
        $('.css_background').find('style').html('');
        //イラストhtml・cssクリア
        $('.input').find('.html_input').val('');
        $('.input').find('.css_input').val('');
        $('.object_layout_input').html('');
    })
})
