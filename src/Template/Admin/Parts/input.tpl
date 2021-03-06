{$this->Flash->render()}
{$this->Html->script('admin/part/input.js', ['block'=>'script'])}
{$this->Display->css('', null, 'object', $template->width, $template->height)}
<div><a href='/admin/parts/index/{$templateId|escape}/{$objectType|escape}'>パーツ一覧</a></div>
<h1>パーツ{if $editFlg}個別編集{else}登録{/if}({$template['name']})</h1>
<div>
    {$this->Form->create($part, [
        'enctype' => 'multipart/form-data']
        )
    }
<table>
    <tr>
        <th>基本z-index</th>
        <td>
            <div class='z_index'>{$part->part_category->z_index|escape}</div>
        </td>
    </tr>
    <tr>
        <th>表示</th>
        <td>
            <div class='css'>
                {$this->Display->css($part->css)}
            </div>
            {if $template['class_name'] == 'face'}
                <div class='character_box html_show object_input'>
                    <div class='face character'>
                        {$part->html}
                    </div>
                </div>
            {else}
                <div class='phrase_object html_show'>
                    <div class='{$template->class_name|escape} object_input' style='width:{$template->width|escape}%; height:{$template->height|escape}%;'>
                        {$part->html}
                    </div>
                </div>
            {/if}
        </td>
    </tr>
    <tr>
        <th>種類</th>
{*        <td>{$this->Form->input('parts_category_no',['options'=>$this->Config->read('parts'), 'label'=>false, 'empty'=>'-', 'class'=>'parts_category_no'])}</td>*}
        <td>{$this->Form->input('parts_category_no',['options'=>$partCategories, 'label'=>false, 'empty'=>'-', 'class'=>'parts_category_no'])}</td>
    </tr>
    <tr>
        <th>HTML</th>
        <td>{$this->Form->input('html', ['type'=>'textarea', 'label'=>false, 'class'=>'html_input'])}</td>
    </tr>
    <tr>
        <th>CSS</th>
        <td>{$this->Form->input('css', ['type'=>'textarea', 'label'=>false, 'class'=>'css_input'])}</td>
    </tr>
    <tr>
        <th></th>
        <td>{$this->Form->button('登録')}</td>
    </tr>
</table>
    {$this->Form->end()}
</div>
