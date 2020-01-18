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
            })
        }
    })
    $('.sentence').bind('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().length;
        $(this).closest('.count').html(thisValueLength);
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
        html_select = wholeReplace(html_select , 'object_'+object_id, 'object_'+object_id + '_' + object_no)
        var css_select = deleteSpace($(this).closest('td').find('style').html());
        css_select = wholeReplace(css_select , 'object_'+object_id, 'object_'+object_id + '_' + object_no);
        var css_add = '.object_'+ object_id + '_' + object_no + '{position:relative; width:' + width + '%; height:' + height + '%;}';
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