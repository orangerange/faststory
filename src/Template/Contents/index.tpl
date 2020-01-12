<p>作品リスト</p>
<table>
    <thead>
        <tr>
            <th>作品名</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$contents item=content}
            <tr>
                <td>{$content->name|escape}</td>
                <td><a href='/chapters/index/{$content->prefix}'>チャプター一覧へ</a></td> 
            </tr>
        {/foreach}
    </tbody>
</table>