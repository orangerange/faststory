{$this->Flash->render()}
{$this->Html->script('admin/part_categories/index.js', ['block'=>'script'])}
{$this->Html->script('jquery-ui.min.js', ['block'=>'script'])}
{$this->Html->css('jquery-ui.min', ['block'=>'script'])}
<h1>アクションソート</h1>
<div><a href='/admin/actions/input/'>新規登録</a></div>
<div><a href='/admin/characters/input'>キャラクター新規登録</a></div>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<table>
    <thead>
        <tr>
            <th> 名前</th>
            <th> アルファベット表記</th>
            <th></th>
        </tr>
    </thead>
    <tbody id='sortable-table' class='list'>
        {foreach from=$actions item=_action}
            <tr class='item' id='{$_action.id|escape}'>
                <td>{$_action.name|escape}</td>
                <td>{$_action.name_en|escape}</td>
                <td><a href='/admin/actions/edit/{$_action->id}'>編集</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
