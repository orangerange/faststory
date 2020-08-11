{$this->Flash->render()}
<h1>組織一覧</h1>
<div><a href='/admin/organizations/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>組織名</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$organizations item=organization}
            <tr>
                <td>{$organization->id}</td>
                <td>{$organization->name|escape}</td>
                <td><a href='/admin/organizations/edit/{$organization->id}'>編集</a></td>
                <td><a href='/admin/ranks/index/{$organization->id}'>階級一覧へ</a></td>
{*                <td><a href='/admin/organization/delete/{$organization->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
