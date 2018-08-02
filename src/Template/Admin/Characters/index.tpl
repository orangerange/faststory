{$this->Flash->render()}
<h1>キャラクター一覧</h1>
<div><a href='/admin/characters/input'>新規登録</a></div>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>キャラクター名</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$characters item=character}
            <tr>
                <td>{$character->id}</td>
                <td>{$character->name|escape}</td>
                <td><a href='/admin/characters/edit/{$character->id}'>編集</a></td>
                <td><a href='/admin/characters/detail/{$character->id}'>詳細</a></td>
                <td><button onclick="window.open('/admin/characters/detail/{$character->id}', 'preview', 'width=400, height=200, menubar=no, toolbar=no')">プレビュー</button></td> 
{*                <td><a href='/admin/characters/delete/{$character->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>