$(function () {
    $(document).on('change', '#width', function () {
        var width = $(this).val();
        $('.object_input').css('width' , width+'%');
    });
    $(document).on('change', '#height', function () {
        var height = $(this).val();
        $('.object_input').css('height' , height+'%');
    });
})