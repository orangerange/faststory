$(function () {
    $(document).on('change', '.html_input', function(){
        $('.html').html($(this).val());
    })

    $(document).on('change', '.css_input', function(){
         $('style').html($(this).val());
    })
    $(document).on('change', '.parts_category_no', function () {
        var parts_category_no = $(this).val();
        if(parts_category_no) {
            $.ajax({
                url: '/admin_ajax/parts/get_base_html',
                type: "post",
                data: {parts_category_no: parts_category_no},
            }).done(function (response) {
                var html = response;
                $('.html_input').val(html);
                $('.html').html(html);
            }).fail(function () {
            });
        }
    })
})
