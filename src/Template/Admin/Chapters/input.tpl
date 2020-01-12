{literal}
    <script type="text/javascript">
        function deleteCheck() {
            return confirm("削除します。よろしいですか。");
        }
    </script>
{/literal}
<div>
    {$this->Html->script('admin/chapter/input.js', ['block'=>'script'])}
    {$this->Flash->render()}
    {if $editFlg}
        {$this->Form->create($chapter, ['method'=>'post', 'url'=>'/admin/chapters/delete', 'onSubmit'=>"return  deleteCheck()"])}
        {$this->Form->control('content_id', ['type'=>'hidden', 'value'=>$contentId])}
        {$this->Form->control('chapter_id', ['type'=>'hidden', 'value'=>$id])}
        <button type='submit'>このチャプターを削除</button>
        {$this->Form->end()}
    {/if}
    {$this->Form->control('phrase_num', ['type'=>'hidden', 'id'=>'phrase_num', 'value'=>$smarty.const.PHRASE_MUX_NUM])}
    <h1>{$contentName|escape}チャプター{if $editFlg}編集{else}登録{/if}({$chapterNo})</h1>
    {$this->Form->create($chapter,['enctype' => 'multipart/form-data'])}
    {$this->Form->control('title',['size'=>50, 'accesskey' => 'z'])}
    {*divタグを入れ子構造にする*}
    {for $i=0 to $smarty.const.PHRASE_MUX_NUM-1}
        {$this->element('chapter/phrase_input', ['i'=>$i])}
    {/for}
    {for $i=0 to $smarty.const.PHRASE_MUX_NUM-1}
    </div>
{/for}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/chapters/index/{$contentId}'>一覧に戻る</a></div>
</div>