$(function () {
    var category_ids = JSON.parse($('#category_ids').val());
    $.each(category_ids, function (index, val) {
    });
    var css_obj = $.parseJSON($("#css-string").val());

    //初期htmlの設定
    var html_sum = $('.parts_sum').html().replace('　', '');
    $('.html_input').val(html_sum);

    //作品変更によるキャラクタ選択肢の変更
    $(document).on("change", ".content_id", function () {
        var content_id = $(this).val();
        $.ajax({
            type: "POST",
            datatype:'text',
            // 処理をする Ajaxの URLを指定。自サーバ内であればドキュメントルートからのパスでも OK
            url: "/admin_ajax/objects/get-characters",
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "content_id": content_id,
            },

            // 正常に処理が実行された場合は、1つ目のパラメータに取得した HTMLが返ってくる
            success: function(data, status, xhr){
                console.log(data);
                $('.character_select').html(data);
            },

            // 正常に処理が行われなかった場合の処理
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                // 返ってきたステータスコードなどをアラートで表示（デバッグ用）
                alert('Error : ' + errorThrown + "\n" +
                    XMLHttpRequest.status + "\n" +
                    XMLHttpRequest.statusText + "\n" +
                    textStatus );
            }
        });
    });

    //パーツ毎cssの変更
    $(document).on("change", ".parts_css", function () {
        var css_sum = '';
        $.each(category_ids, function (index, val) {
            if ($('.parts_css_' + val).val() != '') {
                css_sum += $('.parts_css_' + val).val();
            }
        });
        $(".css_input")
                .val(css_sum.replace("　", ""));
        var css_sum_add_class = addPreClassToCss(
                css_sum
                .replace("　", ""),
                ".parts_sum"
                );
        $(".css_sum")
                .find("style")
                .html(css_sum_add_class);
    });

    //合成html・cssの直接編集
    $(document).on("change", ".html_input", function () {
        $(".parts_sum").html(
                $(this)
                .val()
                .replace("　", "")
                );
    });
    $(document).on("change", ".css_input", function () {
        var css = addPreClassToCss(
                $(this)
                .val()
                .replace("　", ""),
                ".parts_sum"
                );
        $(".css_sum")
                .find("style")
                .html(css);
    });
    $(document).on("click", ".copy_object_parts", function () {
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var parts_no = $('.parts_'+parts_category_no).val();
        var css = $('.parts_css_' + parts_category_no).val();
        $('.base_css').val(css);
        $('#parts_copy_form').attr('action', '/admin/parts/input/0/'+parts_category_no+'/'+parts_no+'/');
        $('#parts_copy_form').submit();
    });
    $(document).on("click", ".edit_object_parts", function () {
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var parts_no = $('.parts_'+parts_category_no).val();
        var css = $('.parts_css_' + parts_category_no).val();
        $('.base_css').val(css);
        $('#parts_edit_form').attr('action', '/admin/parts/edit_copy/'+parts_category_no+'/'+parts_no+'/');
        $('#parts_edit_form').submit();
    });
    $(document).on("click", ".parts_select", function () {
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var popup = document.getElementById('js-popup_'+ parts_category_no);
        popup.classList.add('is-show');
        var blackBg = document.getElementById('js-black-bg_'+ parts_category_no);
        var closeBtn = document.getElementById('js-close-btn_'+ parts_category_no);
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
    $(document).on('click', '.parts_box_select', function () {
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var parts_no = $(this).closest('td').find('.parts_no').val();
        $('.parts_'+parts_category_no).val(parts_no);
        var html = $(this).closest('td').find('.object_input').html().replace('　', '');
        var css = css_obj[parts_category_no][parts_no];
        $('.object_input_' + parts_category_no).html(html);
        $('.css_' + parts_category_no).find('style').html(css);
        $('.parts_css_'+ parts_category_no).val(css);
        //その時点における全体cssを取得
         var css_sum ='';
         $.each(category_ids, function (index, val) {
            if ($('.parts_css_' + val).val() != '') {
                css_sum += $('.parts_css_' + val).val();
            }
        });
        $('.css_input').val(css_sum);
        var css_sum_add_class = addPreClassToCss(
                css_sum
                .replace('　', ''),
                '.parts_sum'
                );
        $('.css_sum')
                .find('style')
                .html(css_sum_add_class);
        var parts_class = $(this)
                .closest('td')
                .find('.parts_class')
                .val();
        $('.parts_sum')
                .find('.' + parts_class)
                .replaceWith(html);
        var html_sum = $('.parts_sum').html().replace('　', '');
        $('.html_input').val(html_sum);
        //ポップアップを閉じる
        var popup = document.getElementById('js-popup_'+ parts_category_no);
        popup.classList.remove('is-show');
    });
    $(document).on('click', '.parts_clear', function () {
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var parts_class = $(this).closest('td').find('.parts_class').val();
        var html = '<div class="' + parts_class + '"></div>';
        var css = '';
        $('.object_input_' + parts_category_no).html(html);
        $('.css_' + parts_category_no).find('style').html(css);
        $('.parts_css_'+ parts_category_no).val(css);
        //その時点における全体cssを取得
         var css_sum ='';
         $.each(category_ids, function (index, val) {
            if ($('.parts_css_' + val).val() != '') {
                css_sum += $('.parts_css_' + val).val();
            }
        });
        $('.css_input').val(css_sum);
        var css_sum_add_class = addPreClassToCss(
                css_sum
                .replace('　', ''),
                '.parts_sum'
                );
        $('.css_sum')
                .find('style')
                .html(css_sum_add_class);
        $('.parts_sum')
                .find('.' + parts_class)
                .replaceWith(html);
        var html_sum = $('.parts_sum').html().replace('　', '');
        $('.html_input').val(html_sum);
    });
})
