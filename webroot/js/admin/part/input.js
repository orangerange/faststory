$(function () {
    $(document).on('change', '.html_input', function () {
        $('.object_input').html($(this).val().replace('　', ''));
    })

    $(document).on('change', '.css_input', function () {
        $('.css').children('style').html($(this).val().replace('　', ''));
    })
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
                $('.html_input').val(html);
                $('.html_show').html(html);
                $('.z_index').html(z_index);
                $('.css_input').val(css);
                $('.css').children('style').html(css);
            }).fail(function () {
            });
        }
    })
})
