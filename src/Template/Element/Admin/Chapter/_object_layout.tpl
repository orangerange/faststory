<div class='popup' id='js_popup_modify_{$i}'>
    <input type='hidden' id='phrase_no'>
    <div class='popup-inner'>
        <div class='close-btn' id='js_modify_close_btn_{$i}'><i class='fas fa-times'></i></div>
        <table class="scroll_x">
            <tr>
                {foreach from=$layouts key=_key item=_value}
                    <td>
                            <textarea class='css_layout css_layout_{$i}_{$_key}' rows='5'>
                                {$_value}
                            </textarea>
                        <input type='hidden' class='css_layout_original' value="{$_value}">
                    </td>
                {/foreach}
            </tr>
        </table>
    </div>
    <div class='black-background' id='js_modify_black_bg_{$i}'></div>
</div>
