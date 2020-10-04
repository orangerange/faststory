{$this->Flash->render()}
{$this->Html->script('admin/contents/input.js', ['block'=>'script'])}
<div class='popup' id='js-popup'>
    <div class='popup-inner'>
        <div class='close-btn' id='js-close-btn'><i class='fas fa-times'></i></div>
        <table class="scroll_x">
            <tr>
                {foreach from=$objects key=_key item=_value}
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
                            <div class='object_input' style='width:{$_value->object_template->width|escape}%; height:{$_value->object_template->height|escape}%;'>
                                <div class='{$_value->object_template->class_name|escape} object_{$_value->id|escape}'>
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
<h1>作品{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($content,['enctype' => 'multipart/form-data'])}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('prefix', ['type'=>'text'])}
<div id='thumbnail_css_show' class='thumbnail_css_show'>
    {$this->Display->css($content['thumbnail_css'])}
</div>
<div id='thumbnail_html_show' class='phrase_object thumbnail_html_show' {if $content->thumbnail_background_color}style="background-color:{$content->thumbnail_background_color}"{/if}>
    {$content['thumbnail_html']}
</div>
<div class='object_layout_input'>
    {$this->element('admin/layout/_object_layout', ['layouts'=>$layouts])}
</div>
<button class='object_select' type='button'>選択</button>
<button class='object_modify' type='button'>微調整</button>
<button class='object_clear' type='button'>イラストクリア</button>
{$this->Form->input('thumbnail_background_color', ['class'=>'thumbnail_background_color', 'type'=>'color'])}
{$this->Form->input('thumbnail_html', ['class' => 'thumbnail_html_input', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->input('thumbnail_css', ['class' => 'thumbnail_css_input', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->input('copy', ['class' => 'copy', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->input('summary', ['class' => 'summary', 'type'=>'textarea', 'cols'=>50])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/contents/index'>一覧に戻る</a></div>
