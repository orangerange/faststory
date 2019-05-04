{$this->Flash->render()}
<h1>作品一覧</h1>
<div><a href='/admin/contents/input'>新規登録</a></div>
<div><a href='/admin/characters/index'>キャラクター一覧</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>作品名</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$contents item=content}
            <tr>
                <td>{$content->id}</td>
                <td>{$content->name|escape}</td>
                <td><a href='/admin/contents/edit/{$content->id}'>編集</a></td> 
                <td><a href='/admin/chapters/index/{$content->id}'>チャプター一覧へ</a></td> 
{*                <td><a href='/admin/contents/delete/{$content->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>