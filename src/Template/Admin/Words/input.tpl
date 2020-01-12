{$this->Flash->render()}
<h1>接頭辞/接尾辞{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($word,['enctype' => 'multipart/form-data', 'label'=>false])}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('meaning', ['type'=>'text', 'size'=>100])}
{$this->Form->input('type',['options'=>$this->Config->read('prefix_type')])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/words/index'>一覧に戻る</a></div>