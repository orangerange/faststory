{literal}
    <script type="text/javascript">
        function deleteCheck() {
            return confirm("削除します。よろしいですか。");
        }
    </script>
{/literal}
<div class='popup' id='js-popup'>
    <input type='hidden' id='phrase_no'>
    <div class='popup-inner'>
        <div class='close-btn' id='js-close-btn'><i class='fas fa-times'></i></div>
        <table class="scroll_x">
            <tr>
                {foreach from=$objects key=_key item=_value}
                    <td>
                        <div class='css css_object_{$_value->id|escape}'>
                            {$this->Display->css($_value->css, '.object_'|cat:$_value->id)}
                        </div>
                        <input type='hidden' class='object_id' value={$_value->id|escape}>
                        <input type='hidden' class='width' value='{$_value->object_template->width|escape}'>
                        <input type='hidden' class='height' value='{$_value->object_template->height|escape}'>
                        オブジェクト番号: <input type='text' class='object_no' value='1'>
                        <div class='phrase_object'>
                            <div class='html_show object_input' style='width:{$_value->object_template->width|escape}%; height:{$_value->object_template->height|escape}%;'>
                                <div class='object_{$_value->id|escape}'>
                                    {$_value->html}
                                </div>
                            </div>
                        </div>
                        <button type='button' class='object_decide'>決定</button>
                    </td>
                {/foreach}
            </tr>
        </table>
    </div>
    <div class='black-background' id='js-black-bg'></div>
</div>
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
{*        <div class="phrase_unit">*}
            {$this->element('admin/chapter/_phrase_input', ['i'=>$i])}
{*        </div>*}
    {/for}
    {for $i=0 to $smarty.const.PHRASE_MUX_NUM-1}
    </div>
{/for}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/chapters/index/{$contentId}'>一覧に戻る</a></div>
</div>
