{$this->Flash->render()}
{$this->Html->script('admin/object/input.js', ['block'=>'script'])}
{$this->Display->css('', null, 'object', $template->width, $template->height)}
{foreach from=$css item=_css}
    {$this->Display->css($_css.css|cat:$_css.keyframe)}
{/foreach}
<div><a href='/admin/parts/index/{$templateId|escape}'>パーツ一覧</a></div>
<h1>{$template->name|escape}オブジェクト{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($object,['enctype' => 'multipart/form-data'])}
{if $object->picture_content}
    {$this->Form->control('picture_content_id', ['class'=>'picture_content_id','type'=>'hidden', 'value'=>$object->id])}
{/if}
{$this->Form->control('object_template_id', ['id'=>'object_template_id','type'=>'hidden', 'value'=>$template->id])}
{$this->Form->control('mime', ['class'=>'mime','type'=>'hidden', 'value'=>$object->mime])}
<table class='object_table'>
    <tr>
        <th>作品</th>
        <td>{$this->Form->input('content_id',['class'=>'content_id', 'options'=>$contents, 'label'=>false, 'empty'=>'-'])}</td>
    </tr>
    <tr>
        <th>オブジェクト名</th>
        <td>{$this->Form->input('name', ['type'=>'text', 'label'=>false])}</td>
    </tr>
{*    <tr>*}
{*        <th>キャラクター</th>*}
{*        <td class="character_select">*}
{*            {$this->Form->input('character_id',['multiple' => 'select', 'class'=>'character_id', 'label'=>false, 'options'=>$characters])}*}
{*        </td>*}
{*    </tr>*}
{*    <tr>*}
{*        <th>活用場面</th>*}
{*        <td>{$this->Form->input('object_usage', ['multiple'=>'select', 'label'=>false, 'options'=>$actions])}</td>*}
{*    </tr>*}
    <tr>
        <th>パーツ合成</th>
        <td>
            <table>
                <tr>
                    <th>
                        {$this->Form->input('html', ['type'=>'textarea', 'label'=>false, 'class'=>'html_input'])}
                         HTML
                    </th>
                    <th>
                        {$this->Form->input('css', ['type'=>'textarea', 'label'=>false, 'class'=>'css_input'])}
                         CSS
                    </th>
                    <th>
                        {$this->Form->input('keyframe', ['type'=>'textarea', 'label'=>false, 'class'=>'keyframe_input'])}
                        キーフレーム
                    </th>
                    <th>
                        <div class='css css_sum'>
                            {$this->Display->css($object->css, '.parts_sum')}
                        </div>
                        <div class='keyframe keyframe_sum'>
                            {$this->Display->css($object->keyframe)}
                        </div>
                        <div class="{$template->class_name|escape} phrase_object html_show">
                            <div class='object_input parts_sum' style='width:{$template->width|escape}%; height:{$template->height|escape}%;{if $object->picture_content}background-image: url("/objects/picture/{$object->id|escape}");background-size: cover;{/if}'>
                                {if $object->html}
                                    {$object->html}
                                {else}
                                    {foreach from=$partCategories key=_key item=_value}
                                        <div class='{$_value->class_name|escape}'></div>
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        合成結果
                    </th>
                    {if $object->id}
                        <th>
                            <button type="button" onclick="window.open('/admin/objects/copy-object/{$object->id|escape}')">オブジェクトを複製</button>
                        </th>
                    {/if}
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>各種パーツ</th>
        <td>
            <table class='scroll_x'>
                <tr>
                    {$this->Form->input('css_string', ['type'=>hidden, 'value'=>$cssString])}
                    {$this->Form->input('keyframe_string', ['type'=>hidden, 'value'=>$keyframeString])}
                    {foreach from=$partCategories key=_key item=_value}
                        <td>
                            <div class="phrase_object html_show">
                                <div class='{$template->class_name|escape} object_input object_input_{$_value->id}' style='width:{$template->width|escape}%; height:{$template->height|escape}%;'>
                                    {$parts[$_value->id][$partsSelected[$_value->id]]}
                                </div>
                            </div>
                            {$_value->name}({$_value->z_index|escape})
                        </td>
                    {/foreach}
                </tr>
                <tr>
                    {assign var='categoryIds' value=','|explode:''}
                    {capture name='garbage'}{$categoryIds|@array_pop}{/capture}
                    {foreach from=$partCategories key=_key item=_value name=partsLoop}
                        {capture name="garbage"}{$categoryIds|@array_push:$_value->id}{/capture}
                        <td class='parts_category_{$_value->id|escape}'>
                            <input type='hidden' class='parts_category_no' value={$_value->id|escape}>
                            <button class='parts_select' type='button'>選択</button>
                            <button class='parts_clear' type='button'>クリア</button>
                            <div class='popup' id='js-popup_{$_value->id|escape}'>
                                <div class='popup-inner'>
                                    <div class='close-btn' id='js-close-btn_{$_value->id|escape}'><i class='fas fa-times'></i></div>
                                    <table class="scroll_x">
                                        <tr>
                                            {foreach from=$parts[{$_value->id|escape}] key=_partsNo item=_html}
                                                <td>
                                                    <input type='hidden' class='parts_category_no' value={$_value->id|escape}>
                                                    <input type='hidden' class='parts_no' value={$_partsNo|escape}>
                                                    <input type='hidden' class='parts_class' value={$_value->class_name|escape}>
                                                    {if $partsPicture[$_value->id][$_partsNo]}
                                                        <input type='hidden' class='background_image_url' value='/parts/picture/{$partsPicture[$_value->id][$_partsNo]|escape}'>
                                                    {/if}
                                                    <div class='phrase_object html_show'>
                                                        <div class='{$template->class_name|escape} object_input' style='width:{$template->width|escape}%; height:{$template->height|escape}%;{if $partsPicture[$_value->id][$_partsNo]} background-image: url("/parts/picture/{$partsPicture[$_value->id][$_partsNo]|escape}");background-size: cover;{/if}'>
                                                            {$_html}
                                                        </div>
                                                    </div>
                                                    <button type='button' class='parts_box_select'>決定</button>
                                                </td>
                                            {/foreach}
                                        </tr>
                                    </table>
                                </div>
                                <div class='black-background' id='js-black-bg_{$_value->id|escape}'></div>
                            </div>
                            {$this->Form->input('object_parts.'|cat:$_value->id|cat:'.parts_no',
                                                [
                                                    'class'=>'parts parts_'|cat:$_value->id,
                                                    'type'=>'hidden'
                                            ])}
                            <input type='hidden' class='parts_class' value={$_value->class_name|escape}>
                            {$this->Form->input('object_parts['|cat:$_value->id|cat:'][parts_category_no]', ['type'=>hidden, 'value'=>$_value->id, 'class'=>'parts_category_no'])}
                        </td>
                    {/foreach}
                    {$this->Form->input('category_ids', ['type'=>hidden, 'value'=>$categoryIds|@json_encode, 'id'=>'category_ids'])}
                </tr>
                <tr>
                    {foreach from=$partCategories key=_key item=_value name=partsCssLoop}
                        <td class='parts_category_{$_key}'>
                            {$this->Form->input('object_parts.'|cat:$_value->id|cat:'.parts_css',
                                                [
                                                    'style'=>'width:100px',
                                                    'class'=>'parts_css parts_css_'|cat:$_value->id,
                                                    'type'=>'textarea',
                                                    'label'=>false
                                            ])}
                            {$this->Form->input('object_parts.'|cat:$_value->id|cat:'.parts_keyframe',
                                                [
                                                'style'=>'width:100px',
                                                'class'=>'parts_keyframe parts_keyframe_'|cat:$_value->id,
                                                'type'=>'textarea',
                                                'label'=>false
                                            ])}
                            {$this->Form->input('object_parts.'|cat:$_value->id|cat:'.id', ['class'=>'id','type'=>'hidden'])}
                            <input type='hidden' class='parts_category_no' value={$_value->id|escape}>
                            <button type='button' class='copy_object_parts'>複製</button>
                            <button type='button' class='edit_object_parts'>編集</button>
                        </td>
                    {/foreach}
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>画像</th>
        <td>
            {$this->Form->input('picture', ['type'=>'file', 'class'=>'picture', 'label'=>false])}
            画像削除{$this->Form->input('picture_del', ['class'=>'picture_del','type'=>'checkbox', 'label'=>false])}
        </td>
    </tr>
    <tr class='action_layout_header'>
        <th>アクションレイアウト</th>
        <td>
            <button class='add_action' type='button'>追加</button>
        </td>
    </tr>
    {for $i=0 to count($object['action_layouts'])-1}
        {$this->element('admin/chapter/_action_layout_input', ['i'=>$i])}
    {/for}
</table>
{$this->Form->button('登録')}
{$this->Form->end()}
<form id='parts_copy_form' target='_blank' method='post'>
    <input type='hidden' class='base_css' name='base_css'>
</form>
<form id='parts_edit_form' target='_blank' method='post'>
    <input type='hidden' class='base_css' name='base_css'>
</form>
<div><a href='/admin/objects/index/{$templateId|escape}'>一覧に戻る</a></div>
