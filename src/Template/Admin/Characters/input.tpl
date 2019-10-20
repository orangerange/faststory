{$this->Flash->render()}
{$this->Html->script('admin/character/input.js', ['block'=>'script'])}
{foreach from=$css item=_css}
    {$this->Display->css($_css.css)}
{/foreach}
<div><a href='/admin/parts'>パーツ一覧</a></div>
<h1>キャラクター{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($character,['enctype' => 'multipart/form-data'])}
<table>
    <tr>
        <th>作品</th>
        <td>{$this->Form->input('content_id',['options'=>$contents, 'label'=>false, 'empty'=>'-'])}</td>
    </tr>
    <tr>
        <th>キャラクター名</th>
        <td>{$this->Form->input('name', ['type'=>'text', 'label'=>false])}</td>
    </tr>
    <tr>
        <th>キャラクター名表示色</th>
        <td>{$this->Form->input('name_color',['type'=>'color', 'label'=>false])}</td>
    </tr>
    <tr>
        <th>パーツ合成</th>
        <td>
            <table colspan="{$this->Config->read('parts')|@count + 1}">
                <tr>
                    {foreach from=$this->Config->read('parts') key=_key item=_value}
                        <td>
                            <div class="character_box character_box_{$_key}">
                                {$parts[$_key][$partsSelected[$_key]]}
                            </div>
                            {$_value}
                        </td>
                    {/foreach}
                    <td>
                        <div class="character_box parts_sum">
                            {if $character->html}
                                {$character->html}
                            {else}
                                <div class='hat'></div>
                                <div class='hair'></div>
                                <div class='head'></div>
                            {/if}
                        </div>
                        合成結果
                    </td>
                    {$this->Form->input('html', ['type'=>hidden])}
                    {$this->Form->input('css', ['type'=>hidden])}
                    {$this->Form->input('css_string', ['type'=>hidden, 'value'=>$cssString])}
                </tr>
                <tr>
                    {foreach from=$this->Config->read('parts') key=_key item=_value}
                        <td>
                            {$this->Form->input('character_parts.'|cat:$_key|cat:'.parts_no', 
                                                [
                                                    'div'=>false, 
                                                    'class'=>'parts', 
                                                    'type'=>'select',
                                                    'options'=>$parts[$_key], 
                                                    'label'=>false, 
                                                    'empty'=>'-'
                                            ])}
                            <input type='hidden' class='parts_class' value={$this->Config->read('parts_class.'|cat:$_key)}>
                            {$this->Form->input('character_parts['|cat:$_key|cat:'][parts_category_no]', ['type'=>hidden, 'value'=>$_key, 'class'=>'parts_category_no'])}
                        </td>
                    {/foreach}
                </tr>
            </table>
        </td>
    </tr>
    {*{if $character->dir}
    <image src="{$this->Display->imagePath($character)}">
    {$this->Form->input('picture_before',['type'=>'hidden','value'=>$character->picture])}
    {$this->Form->input('dir_before',['type'=>'hidden','value'=>$character->dir])}
    画像削除{$this->Form->checkbox('picture_delete')}
    {/if}*}
    {*    {$this->Form->input('picture', ['type'=>'file', 'label'=>false])}*}
</table>
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/characters/index'>一覧に戻る</a></div>