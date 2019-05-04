{$this->Html->script('admin/chapter/input.js', ['block'=>'script'])}
{$this->Flash->render()}
<h1>{$content_name|escape}チャプター{if $editFlg}編集{else}登録{/if}({$chapterNo})</h1>
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
<div><a href='/admin/chapters/index/{$content_id}'>一覧に戻る</a></div>