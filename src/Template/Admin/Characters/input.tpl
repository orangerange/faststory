{$this->Flash->render()}
{$this->Html->script('admin/character/input.js', ['block'=>'script'])}
{foreach from=$css item=_css}
    {$this->Display->css($_css.css)}
{/foreach}
<div><a href='/admin/parts/index/0/{$config->object_type_key['face']}'>パーツ一覧</a></div>
{$this->Display->css('', null, 'object', 25, 50)}
<h1>キャラクター{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($character,['enctype' => 'multipart/form-data'])}
<table>
    <tr>
        <th>作品</th>
        <td>{$this->Form->input('content_id',['options'=>$contents, 'label'=>false, 'empty'=>'-'])}</td>
    </tr>
    <tr>
        <th>組織</th>
        <td>
            {$this->Form->input('organization_id',['class'=>'organization_id', 'options'=>$organizations, 'label'=>false, 'empty'=>'-'])}
        </td>
    </tr>
    <tr>
        <th>階級</th>
        <td class="rank_select">
            {$this->Form->input('rank_id',['options'=>$ranks, 'label'=>false, 'empty'=>'--'])}
        </td>
    </tr>
    <tr>
        <th>キャラクター名</th>
        <td>{$this->Form->input('name', ['type'=>'text', 'label'=>false])}</td>
    </tr>
    <tr>
        <th>キャラクター名表示用</th>
        <td>{$this->Form->input('name_display', ['type'=>'text', 'label'=>false])}</td>
    </tr>
    <tr>
        <th>キャラクター名表示色</th>
        <td>{$this->Form->input('name_color',['type'=>'color', 'label'=>false])}</td>
    </tr>
    <tr>
        <th>外国語表示色</th>
        <td>{$this->Form->input('foreign_color',['type'=>'color', 'label'=>false])}</td>
    </tr>
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
                        <div class='css css_sum'>
                            {$this->Display->css($character->css, '.parts_sum')}
                        </div>
                        <div class='face character_box parts_sum'>
                            {if $character->html}
                                {$character->html}
                            {else}
                                {foreach from=$partCategories key=_key item=_value}
                                    <div class='{$_value->class_name|escape}'></div>
                                {/foreach}
                            {/if}
                        </div>
                        合成結果
                    </th>
                    {if $character->id}
                        <th>
                            <button type="button" onclick="window.open('/admin/characters/copy-character/{$character->id|escape}')">キャラクターを複製</button>
                        </th>
                        <th>
                            <button type="button" onclick="window.open('/admin/objects/copy-face/{$character->id|escape}')">オブジェクトとして複製</button>
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
                    {foreach from=$partCategories key=_key item=_value}
                        <td>
                            <div class='face character_box character_box_{$_value->id}'>
                                {$parts[$_value->id][$partsSelected[$_value->id]]}
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
                                                    <div class='face character_box'>
                                                        {$_html}
                                                    </div>
                                                    <button type='button' class='parts_box_select'>決定</button>
                                                </td>
                                            {/foreach}
                                        </tr>
                                    </table>
                                </div>
                                <div class='black-background' id='js-black-bg_{$_value->id|escape}'></div>
                            </div>
                            {$this->Form->input('character_parts.'|cat:$_value->id|cat:'.parts_no',
                                                [
                                                    'class'=>'parts parts_'|cat:$_value->id,
                                                    'type'=>'hidden'
                                            ])}
                            <input type='hidden' class='parts_class' value={$_value->class_name|escape}>
                            {$this->Form->input('character_parts['|cat:$_value->id|cat:'][parts_category_no]', ['type'=>hidden, 'value'=>$_value->id, 'class'=>'parts_category_no'])}
                        </td>
                    {/foreach}
                    {$this->Form->input('category_ids', ['type'=>hidden, 'value'=>$categoryIds|@json_encode, 'id'=>'category_ids'])}
                </tr>
                <tr>
                    {foreach from=$partCategories key=_key item=_value name=partsCssLoop}
                        <td class='parts_category_{$_key}'>
                            {$this->Form->input('character_parts.'|cat:$_value->id|cat:'.parts_css',
                                                [
                                                    'style'=>'width:100px',
                                                    'class'=>'parts_css parts_css_'|cat:$_value->id,
                                                    'type'=>'textarea',
                                                    'label'=>false
                                            ])}
                            <input type='hidden' class='parts_category_no' value={$_value->id|escape}>
                            <button type='button' class='copy_character_parts'>複製</button>
                            <button type='button' class='edit_character_parts'>編集</button>
                        </td>
                    {/foreach}
                </tr>
            </table>
        </td>
    </tr>
    {*{if $character->dir}
    <image src='{$this->Display->imagePath($character)}'>
    {$this->Form->input('picture_before',['type'=>'hidden','value'=>$character->picture])}
    {$this->Form->input('dir_before',['type'=>'hidden','value'=>$character->dir])}
    画像削除{$this->Form->checkbox('picture_delete')}
    {/if}*}
    {*    {$this->Form->input('picture', ['type'=>'file', 'label'=>false])}*}
</table>
{$this->Form->button('登録')}
{$this->Form->end()}
<form id='parts_copy_form' target='_blank' method='post'>
    <input type='hidden' class='base_css' name='base_css'>
</form>
<form id='parts_edit_form' target='_blank' method='post'>
    <input type='hidden' class='base_css' name='base_css'>
</form>
<div><a href='/admin/characters/index'>一覧に戻る</a></div>
