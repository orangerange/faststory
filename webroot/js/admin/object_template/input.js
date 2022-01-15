$(function () {
    $(document).on('change', '#width', function () {
        var width = $(this).val();
        $('.object_input').css('width' , width+'%');
    });
    $(document).on('change', '#height', function () {
        var height = $(this).val();
        $('.object_input').css('height' , height+'%');
    });
    // アクション登録追加
    var action_num = 0;
    $(document).on('click', '.add_action', function () {alert(action_num);
        action_num --;
        $.ajax({
            type: "POST",
            datatype:'text',
            // 処理をする Ajaxの URLを指定。自サーバ内であればドキュメントルートからのパスでも OK
            url: "/admin_ajax/objects/add-actions",
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "action_num": action_num,
                "is_template": true,
            },

            // 正常に処理が実行された場合は、1つ目のパラメータに取得した HTMLが返ってくる
            success: function(data, status, xhr){
                console.log(data);
                $('.action_layout_header').after(data);
            },

            // 正常に処理が行われなかった場合の処理
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                // 返ってきたステータスコードなどをアラートで表示（デバッグ用）
                alert('Error : ' + errorThrown + "\n" +
                    XMLHttpRequest.status + "\n" +
                    XMLHttpRequest.statusText + "\n" +
                    textStatus );
            }
        });
    });
    $(document).on('click', '.delete_action', function () {
        if(!confirm('削除します。よろしいですか?')){
            return false;
        }else{
            $(this).parents('tr').remove();
        }
    });
})
