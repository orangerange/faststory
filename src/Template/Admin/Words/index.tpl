{$this->Flash->render()}
<h1>接頭辞/接尾辞一覧</h1>
<div><a href='/admin/words/input'>新規登録</a></div>
<div><a href='/admin/words/split'>単語分割</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>word</th>
            <th>接頭辞/接尾辞</th>
            <th>意味</th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$words item=word}
            <tr>
                <td>{$word->id}</td>
                <td>{$word->name|escape}</td>
                <td>{$this->Config->read("prefix_type.`$word->type`")}</td>
                <td>{$word->meaning|escape}</td>
                <td><a href='/admin/words/edit/{$word->id}'>編集</a></td> 
            </tr>
        {/foreach}
    </tbody>
</table>