{literal}
    <script type="text/javascript">
    function deleteCheck() {
            return confirm("削除します。よろしいですか。");
    }
    </script>
{/literal}
{$this->Flash->render()}
<h1>{$content->name|escape}チャプター一覧</h1>
<div><a href='/admin/contents/index'>作品一覧</a></div>
<div><a href='/admin/chapters/input/{$contentId|escape}'>次のチャプターを登録</a></div>
<table>
    <thead>
        <tr>
            <th>チャプター番号</th>
            <th>タイトル</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$chapters item=chapter}
            <tr>
                <td>{$chapter->no}</td>
                <td>{$chapter->title|escape}</td>
                <td><a href='/admin/chapters/edit/{$chapter->id}'>編集</a></td>
                <td>
                    <button type='button' onclick="window.open('/admin/chapters/display/{$content->prefix|escape}/{$chapter->no|escape}/')">公開側表示を確認</button>
                </td>
                <td>
                    <button type='button' onclick="window.open('/admin/chapters/movie/{$content->prefix|escape}/{$chapter->no|escape}/')">ムービーを表示</button>
                </td>
                <td>
                    <button type='button' onclick="window.open('/admin/chapters/novel/{$content->prefix|escape}/{$chapter->no|escape}/')">文章化</button>
                </td>
                <td>
                    {$this->Form->create($chapte, ['method'=>'post', 'url'=>'/admin/chapters/delete', 'onSubmit'=>"return  deleteCheck()"])}
                    {$this->Form->control('content_id', ['type'=>'hidden', 'value'=>$contentId])}
                    {$this->Form->control('chapter_id', ['type'=>'hidden', 'value'=>$chapter->id])}
                        <button type='submit'>削除</button>
                    {$this->Form->end()}
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
