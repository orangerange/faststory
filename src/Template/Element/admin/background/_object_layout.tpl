{if $layouts}
<div class='popup' id='js_popup_modify'>
    <div class='popup-inner'>
        <div class='close-btn' id='js_modify_close_btn'><i class='fas fa-times'></i></div>
        <table class="scroll_x">
            <tr>
                {foreach from=$layouts key=_key item=_value}
                    <td>
                        <p>{$_value['name']|escape}</p>
                        <textarea class='css_layout css_layout_{$_key}' rows='5'>
                                {$_value['css']}
                            </textarea>
                        <input type='hidden' class='css_layout_original' value="{$_value['css']}">
                        <br>
                        <button type="button" class="object_delete">オブジェクト削除</button>
                        <input type="hidden" class="object_id" value={$_value['id']|escape}>
                        <input type="hidden" class="object_no" value={$_value['no']|escape}>
                    </td>
                {/foreach}
            </tr>
        </table>
    </div>
    <div class='black-background' id='js_modify_black_bg'></div>
</div>
{/if}
