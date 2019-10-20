{$this->Flash->render()}
{$this->Html->script('admin/part/index.js', ['block'=>'script'])}
<h1>パーツ覧</h1>
<div><a href='/admin/parts/input'>新規登録</a></div>
<div><a href='/admin/characters/input'>キャラクター新規登録</a></div>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<table>
    {assign var='partName' value=''}
        {foreach from=$parts item=part}
            {if $partName != $this->Config->read("parts.`$part->parts_category_no`")}
            <tr>
                {assign var='partName' value=$this->Config->read("parts.`$part->parts_category_no`")}
                <th>{$partName|escape}</th>
                {* <td><button onClick="location.href='/admin/parts/input/{$part->id|escape}'">複製</button></td> *}
            </tr>
            <tr>
            {/if}
            <td>
                <div class='css'>
                    {strip}
                        {$this->Display->css($part->css)}
                    {/strip}
                </div>
                <div class='character_box'>
                    {strip}
                    {$part->html}
                    {/strip}
                </div>
                <button class="slide">↕</button>
                <button onClick="location.href='/admin/parts/input/{$part->id|escape}'">複製</button>
                <div class="edit" style="display:none">
                    {$this->Form->create($part, ['url' => [
                        'controller' => 'Parts',
                        'action' => 'edit'
                        ],
                        'enctype' => 'multipart/form-data']
                        )
                    }
                    <span>HTML</span>
                    {$this->Form->input('html', ['type'=>'textarea', 'label'=>false, 'class'=>'html_input'])}
                    <span>CSS</span>
                    {$this->Form->input('css', ['type'=>'textarea', 'label'=>false, 'class'=>'css_input'])}
                    {$this->Form->button('更新')}
                    {$this->Form->end()}
                </div>
            </td>
        {/foreach}
    </tr>
</table>
