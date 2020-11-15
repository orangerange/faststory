{$this->Flash->render()}
{$this->Html->script('admin/part/index.js', ['block'=>'script'])}
{$this->Display->css('', null, 'object', $template->width, $template->height)}
<h1>パーツ一覧({$template['name']})</h1>
<div><a href='/admin/parts/input/{$templateId|escape}/'>新規登録</a></div>
<div><a href='/admin/objects/input/{$templateId|escape}/'>オブジェクトを作成する</a></div>
<table>
    {assign var='partName' value=''}
        {foreach from=$parts item=part}
            {if $partName != $part->part_category->name}
            <tr>
                {assign var='partName' value=$part->part_category->name}
                <th>{$partName|escape}({$part->part_category->z_index|escape})</th>
            </tr>
            <tr>
            {/if}
            <td>
                <div class='css'>
                    {strip}
                        {$this->Display->css($part->css)}
                    {/strip}
                </div>
                {if $template['class_name'] == 'face'}
                    <div class='face character_box object_input'>
                        {strip}
                            {$part->html}
                        {/strip}
                    </div>
                {else}
                    <div class='html_show'>
                        <div class='{$template->class_name|escape} object_input' style='width:{$template->width|escape}%; height:{$template->height|escape}%;'>
                            {$part->html}
                        </div>
                    </div>
                {/if}
                <button class="slide">↕</button>
                <button onClick="location.href='/admin/parts/input/{$templateId|escape}/{$part->parts_category_no|escape}/{$part->parts_no|escape}/'">複製</button>
                <div class="edit" style="display:none">
                    {$this->Form->create($part, ['url' => [
                        'controller' => 'Parts',
                        'action' => 'edit',
                        $part->id,
                        $templateId,
                        $objectType
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
