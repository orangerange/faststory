$(function () {
    $(document).on('click', '.slide', function(){
        if($(this).parent().children('.phrase_control').is(':visible')) {
            $(this).parent().children('.phrase_control').slideUp();
        }
        else {
           $(this).parent().children('.phrase_control').slideDown();
        }
    })

    $(document).on('click', '.clear', function(){
        var phrase = $(this).parent().children('.phrase_control');
        var columns = ['character_id', 'speaker_name', 'speaker_color', 'sentence'];
          $(this).prevAll().find('input').val('');
          $(this).prevAll().find('textarea').val('');
          $(this).prevAll().find('select').val('');
    })
})