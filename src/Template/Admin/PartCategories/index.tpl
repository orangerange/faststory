{$this->Flash->render()}
{$this->Html->script('admin/part_categories/index.js', ['block'=>'script'])}
{$this->Html->script('jquery-ui.min.js', ['block'=>'script'])}
{$this->Html->css('jquery-ui.min', ['block'=>'script'])}
<h1>パーツカテゴリーソート({if $template}{$template->name}{else}{$config->object_type[$objectType]}{/if})</h1>
<div><a href='/admin/part-categories/input/{$templateId|escape}/{$objectType|escape}'>新規登録</a></div>
<div><a href='/admin/characters/input'>キャラクター新規登録</a></div>
<div><a href='/admin/parts/index/{$templateId|escape}/{$objectType|escape}'>パーツ一覧</a></div>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<table>
    <thead>
        <tr>
            <th> 名前</th>
            <th> クラス名</th>
            <th> z_index</th>
            <th></th>
        </tr>
    </thead>
    <tbody id='sortable-table' class='list'>
        {foreach from=$partCategories item=_category}
            <tr class='item' id='{$_category.id|escape}'>
                <td>{$_category.name|escape}</td>
                <td>{$_category.class_name|escape}</td>
                <td>{$_category.z_index|escape}</td>
                <td><a href='/admin/part-categories/edit/{$_category->id}'>編集</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
