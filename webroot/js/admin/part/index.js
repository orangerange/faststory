$(function () {
    $(document).on('click', '.slide', function(){
        if($(this).parent().children('.edit').is(':visible')) {
            $(this).parent().children('.edit').slideUp();
        }
        else {
           $(this).parent().children('.edit').slideDown();
        }
    })
    $(document).on('change', '.html', function(){
        $(this).closest('td').find('.html').html($(this).val());
    })

    $(document).on('change', '.css', function(){
         $(this).closest('td').find('style').html($(this).val());
    })
})
