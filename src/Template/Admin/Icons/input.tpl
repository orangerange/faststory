{$this->Flash->render()}
{$this->Html->script('admin/icons/input.js', ['block'=>'script'])}
{$this->Html->css('config_icon', ['block'=>'css'])}
<div class='css_icon'>
    {$this->Display->css($icon->css)}
</div>
<div class='popup' id='js-popup'>
    <div class='popup-inner'>
        <div class='close-btn' id='js-close-btn'><i class='fas fa-times'></i></div>
        <table class="scroll_x">
            <tr>
                {foreach from=$objects key=_key item=_value}
                    {$this->Display->css('', null, 'object', $_value->object_template->width, $_value->object_template->height)}
                    <td>
                        <div class='css css_object_{$_value->id|escape}'>
                            {$this->Display->css($_value->css, '.object_'|cat:$_value->id)}
                        </div>
                        <input type='hidden' class='object_id' value={$_value->id|escape}>
                        <input type='hidden' class='width' value='{$_value->object_template->width|escape}'>
                        <input type='hidden' class='height' value='{$_value->object_template->height|escape}'>
                        <input type='hidden' class='class_name' value='{$_value->object_template->class_name|escape}'>
                        <p>{$_value->name|escape}</p>
                        オブジェクト番号: <input type='text' class='object_no {if $_value->character_id}{foreach from=","|explode:$_value->character_id item=_val}{if $_val}character_{$_val|escape} {/if}{/foreach}{/if}{if $_value->object_usage}{foreach from=","|explode:$_value->object_usage item=_val}{if $_val}usage_{$_val|escape} {/if}{/foreach}{/if}{if array_key_exists($_value->template_id, $this->Config->read('object_character'))}default_{$this->Config->read('object_character.'|cat:$_value->template_id)}{/if} ' value={$objectCount[$_value->id]+1|default:'1'}>
                        <div class='html_show'>
                            <div class='{$_value->object_template->class_name|escape} object_input' style='width:{$_value->object_template->width|escape}%; height:{$_value->object_template->height|escape}%;'>
                                <div class='object_{$_value->id|escape}'>
                                    {$_value->html}
                                </div>
                            </div>
                        </div>
                        <button type='button' class='object_decide'>決定</button>
                    </td>
                {/foreach}
            </tr>
        </table>
    </div>
    <div class='black-background' id='js-black-bg'></div>
</div>
<div class='object_layout_input'>
    {$this->element('admin/layout/_object_layout', ['layouts'=>$layouts])}
</div>
<h1>アイコン{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($icon,['enctype' => 'multipart/form-data'])}
{$this->Form->input('name', ['type'=>'text'])}
{assign var='backgroundColor' value='#ffffff'}
{if $icon->background_color}
    {assign var='backgroundColor' value=$icon->background_color|escape}
{/if}
{$this->Form->input('background_color', ['class'=>'background_color', 'type'=>'color', 'value' => $backgroundColor|escape])}
<div id="icon" class="html_icon html_icon_admin" {if $icon->background_color}style="background-color:{$icon->background_color}"{/if}>
    {$icon->html}
</div>
<div class="icon_circle"></div>
<button class='object_select' type='button'>選択</button>
<button class='object_modify' type='button'>微調整</button>
<button class='object_clear' type='button'>クリア</button>
{$this->Form->input('html', ['class' => 'html_input', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->input('css', ['class' => 'css_input', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/icons/index'>一覧に戻る</a></div>
