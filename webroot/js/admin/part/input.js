$(function () {
    $(document).on('change', '.html_input', function () {
        $('.object_input').html($(this).val().replace('　', ''));
    })

    $(document).on('change', '.css_input', function () {
        $('.css').children('style').html($(this).val().replace('　', '') + $('.keyframe_input').val().replace('　', ''));
    })
    $(document).on('change', '.keyframe_input', function () {
        $('.css').children('style').html($(this).val().replace('　', '') + $('.css_input').val().replace('　', ''));
    })
    var base_class = '';
    $(document).on('change', '.parts_category_no', function () {
        var parts_category_no = $(this).val();
        if (parts_category_no) {
            $.ajax({
                url: '/admin_ajax/parts/get_base_html',
                type: "post",
                data: { parts_category_no: parts_category_no },
            }).done(function (response) {
                var result = JSON.parse(response);
                var html = result.html;
                var css = result.css;
                var z_index = result.z_index;
                base_class = result.class;
                $('.html_input').val(html);
                $('.object_input').html(html);
                $('.z_index').html(z_index);
                $('.css_input').val(css);
                $('.css').children('style').html(css);
            }).fail(function () {
            });
        }
    })
    // htmlタグの簡易追加
    $(document).on('click', '.add_tag', function () {
        var parent_class = $('.parent_class'). val();
        if (!parent_class) {
            parent_class = base_class;
        }
        var added_class = $('.added_class'). val();
        var added_tag = '<div class="' + added_class + '"></div>';
        $('.object_input').find('.' + parent_class).append(added_tag);
        $('.html_input').val($('.object_input').html());
    })
})
