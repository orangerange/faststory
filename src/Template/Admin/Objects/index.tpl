{$this->Flash->render()}
<h1>{$template->name|escape}オブジェクト一覧</h1>
<div><a href='/admin/objects/input/{$template->id|escape}'>新規登録</a></div>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>オブジェクト名</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$objects item=_object}
            <tr>
                <td>{$_object->id}</td>
                <td>{$_object->name|escape}</td>
                <td><a href='/admin/objects/edit/{$_object->id}'>編集</a></td>
                <td><a href='/admin/objects/detail/{$_object->id}'>詳細</a></td>
                <td><button onclick="window.open('/admin/objects/detail/{$_object->id}', 'preview', 'width=600, height=300, menubar=no, toolbar=no')">プレビュー</button></td>
{*                <td><a href='/admin/objects/delete/{$_object->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
