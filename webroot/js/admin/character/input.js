$(function () {
    $(document).on('change', '.parts', function(){
        var html = $(this).closest('td').find('.parts option:selected').text();
        if (html == '-') {
            html='';
        }
        var css = $('#css').val();
        var css_obj = $.parseJSON($('#css-string').val());
        var parts_no = $(this).closest('td').find('.parts option:selected').val();
        var parts_category_no = $(this).closest('td').find('.parts_category_no').val();
        var parts_class =  $(this).closest('td').find('.parts_class').val();
        var class_replaced = '';
        if(parts_no && parts_no != '-') {
            class_replaced = parts_class + '_' + parts_no;
            css += css_obj[parts_category_no][parts_no];
        }
        $('#css').val(css);
        $('.character_box_'+parts_category_no).html(html);
        $('.parts_sum').find('.' + parts_class).attr('class', parts_class + ' ' + class_replaced);
        var html_sum = $('.parts_sum').html();
        $('#html').val(html_sum);
    })
})
