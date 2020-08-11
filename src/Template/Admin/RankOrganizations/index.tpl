{$this->Flash->render()}
<h1>階級組織</h1>
<div><a href='/admin/rank-organizations/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th> 名前</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$rankOrganizations item=_organization}
            <tr>
                <td>{$_template.name|escape}</td>
                <td><a href='/admin/rank-organizations/edit/{$_organization->id}'>編集</a></td>
                <td><a href='/admin/ranks/index/{$_organization->id}'>階級一覧</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
