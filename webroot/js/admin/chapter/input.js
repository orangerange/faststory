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
          $(this).prevAll().find('input').val('');
          $(this).prevAll().find('textarea').val('');
          $(this).prevAll().find('select').val('');
    })
    $(document).on('click', '.insert', function(){
        var no = $(this).parent().children('.no').val();
        var phrase_num = $('#phrase_num').val();
        for (var i = phrase_num -2 ; i >= no; i--) {
            var j = i+1;
            var columns = ['character_id', 'speaker_name', 'speaker_color', 'sentence', 'picture_before', 'dir_before', 'picture_delete', ''];
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
})