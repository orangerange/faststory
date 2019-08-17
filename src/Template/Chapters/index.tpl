{$this->Flash->render()}
<h1>{$content->name|escape}チャプター一覧</h1>
<div><a href='/admin/chapters/input/{$content_id|escape}'>次のチャプターを登録</a></div>
<table>
    <thead>
        <tr>
            <th>チャプター番号</th>
            <th>タイトル</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$chapters item=chapter}
            <tr>
                <td>{$chapter->no}</td>
                <td>{$chapter->title|escape}</td>
                <td><a href='/admin/chapters/edit/{$chapter->id}'>編集</a></td> 
            </tr>
        {/foreach}
    </tbody>
</table>