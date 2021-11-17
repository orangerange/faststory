$(function () {
    $(document).on('click', '.thumbnail', function () {
        var id = $(this).data('id');
        $.ajax({
            type: "get",
            url: "/chapters/axios-list/?content_id=" + id,
            dataType: 'text',
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
            },
        }).done(function (data, status, jqXHR) {
            var html = data.html;
            var popupOutside = document.getElementById("popup_outside");
            popupOutside.innerHTML = html;
            var popup = document.getElementById("js-popup");
            popup.classList.add("is-show");

            var blackBg = document.getElementById("js-black-bg");
            var closeBtn = document.getElementById("js-close-btn");
            closePopUp(blackBg);
            closePopUp(closeBtn);
            function closePopUp(elem) {
                if (!elem)
                    return;
                elem.addEventListener("click", function () {
                    popupOutside.innerHTML = '';
                })
            }
        }).fail(function (jqXHR, status, error) {
            console.log(jqXHR);
            console.log(status);
            console.log(error);
        });
    })
})
