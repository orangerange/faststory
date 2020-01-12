{$this->Flash->render()}
<h1>{$content->name|escape}チャプター一覧</h1>
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
                <td><a href='/chapters/display/{$chapter->content->prefix|escape}/{$chapter->no|escape}'>この章を読む</a></td> 
            </tr>
        {/foreach}
    </tbody>
</table>