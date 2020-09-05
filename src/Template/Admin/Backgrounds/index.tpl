{$this->Flash->render()}
<h1>背景一覧</h1>
<div><a href='/admin/backgrounds/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>背景名</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$backgrounds item=background}
            <tr>
                <td>{$background->id}</td>
                <td>{$background->name|escape}</td>
                <td><a href='/admin/backgrounds/edit/{$background->id}'>編集</a></td>
{*                <td><a href='/admin/backgrounds/delete/{$background->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
