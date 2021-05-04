{literal}
    <script type="text/javascript">
        function deleteCheck() {
            return confirm("削除します。よろしいですか。");
        }
        function frontCopyCheck() {
            return confirm("公開側に反映します。よろしいですか。");
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
                    {$this->Display->css('', null, 'object', $_value->object_template->width, $_value->object_template->height)}
                    <td>
                        <div class='css css_object_{$_value->id|escape}'>
                            {$this->Display->css($_value->css, '.object_'|cat:$_value->id)}
                        </div>
                        <input type='hidden' class='object_id' value={$_value->id|escape}>
                        <input type='hidden' class='width' value='{$_value->object_template->width|escape}'>
                        <input type='hidden' class='height' value='{$_value->object_template->height|escape}'>
                        <input type='hidden' class='class_name' value='{$_value->object_template->class_name|escape}'>
                        {if $_value->picture_content}
                            <input type='hidden' class='background_image_url' value='/objects/picture/{$_value->id|escape}'>
                        {/if}
                        <p>{$_value->name|escape}</p>
                        オブジェクト番号: <input type='text' class='object_no object_no_{$_value->id} {if $_value->character_id}{foreach from=","|explode:$_value->character_id item=_val}{if $_val}character_{$_val|escape} {/if}{/foreach}{/if}{if $_value->object_usage}{foreach from=","|explode:$_value->object_usage item=_val}{if $_val}usage_{$_val|escape} {/if}{/foreach}{/if}{if array_key_exists($_value->template_id, $this->Config->read('object_character'))}default_{$this->Config->read('object_character.'|cat:$_value->template_id)}{/if} ' value={$objectCount[$_value->id]+1|default:'1'}>
                        <div class='html_show'>
                            <div class='object_input' style='width:{$_value->object_template->width|escape}%; height:{$_value->object_template->height|escape}%;{if $_value->picture_content} background-image: url("/objects/picture/{$_value->id|escape}");background-size: cover;{/if}'>
                                <div class='{$_value->object_template->class_name|escape} object_{$_value->id|escape}'>
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
        <button type='button' onclick="window.open('/admin/chapters/display/{$chapter->content->prefix|escape}/{$chapter->no|escape}/')">公開側表示を確認</button>
        <button type='button' onclick="window.open('/admin/chapters/movie/{$chapter->content->prefix|escape}/{$chapter->no|escape}/')">ムービーを表示</button>
        {$this->Form->create($chapter, ['method'=>'post', 'url'=>'/admin/chapters/front-copy', 'onSubmit'=>"return  frontCopyCheck()"])}
        {$this->Form->control('content_id', ['type'=>'hidden', 'value'=>$contentId])}
        {$this->Form->control('chapter_id', ['type'=>'hidden', 'value'=>$id])}
        <button type='submit'>このチャプターを公開側に反映</button>
        {$this->Form->end()}
    {/if}
    {$this->Form->control('phrase_num', ['type'=>'hidden', 'id'=>'phrase_num', 'value'=>$smarty.const.PHRASE_MUX_NUM])}
    {$this->Form->control('object_usage_str', ['type'=>'hidden', 'id'=>'object_usage_str', 'value'=> $objectUsageStr])}
    <h1>{$contentName|escape}チャプター{if $editFlg}編集{else}登録{/if}({$chapterNo})</h1>
    {$this->Form->create($chapter,['enctype' => 'multipart/form-data'])}
    {$this->Form->control('title',['size'=>50, 'accesskey' => 'z'])}
{*    {$this->Form->control('content_id', ['type'=>'hidden', 'value'=>$contentId])}*}
{*    {$this->Form->control('chapter_id', ['type'=>'hidden', 'value'=>$id])}*}
    {*divタグを入れ子構造にする*}
    {for $i=0 to $smarty.const.PHRASE_MUX_NUM-1}
        {$this->element('admin/chapter/_phrase_input', ['i'=>$i])}
    {/for}
    {for $i=0 to $smarty.const.PHRASE_MUX_NUM-1}
    </div>
{/for}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/chapters/index/{$contentId}'>一覧に戻る</a></div>
</div>
{$this->Html->script('config.js')}
