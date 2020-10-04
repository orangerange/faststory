{$this->Flash->render()}
<h1>ロゴ一覧</h1>
<div><a href='/admin/icons/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>ロゴ名</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$icons item=icon}
            <tr>
                <td>{$icon->id}</td>
                <td>{$icon->name|escape}</td>
                <td><a href='/admin/icons/edit/{$icon->id}'>編集</a></td>
                <td><a href='/admin/icons/detail/{$icon->id}'>詳細</a></td>
                {*                <td><a href='/admin/icons/delete/{$icon->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
