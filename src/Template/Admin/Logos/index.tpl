{$this->Flash->render()}
<h1>ロゴ一覧</h1>
<div><a href='/admin/logos/input'>新規登録</a></div>
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
        {foreach from=$logos item=logo}
            <tr>
                <td>{$logo->id}</td>
                <td>{$logo->name|escape}</td>
                <td><a href='/admin/logos/edit/{$logo->id}'>編集</a></td>
                <td><a href='/admin/logos/detail/{$logo->id}'>詳細</a></td>
                {*                <td><a href='/admin/logos/delete/{$logo->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
