$(function () {
    $(document).on('click', '.slide', function(){
        if($(this).parent().children('.edit').is(':visible')) {
            $(this).parent().children('.edit').slideUp();
        }
        else {
           $(this).parent().children('.edit').slideDown();
        }
    })
    $(document).on('change', '.html_input', function(){
        $(this).closest('td').find('.character_box').html($(this).val().replace('　', ''));
    })

    $(document).on('change', '.css_input', function(){
         $(this).closest('td').find('style').html($(this).val().replace('　', ''));
    })
})
