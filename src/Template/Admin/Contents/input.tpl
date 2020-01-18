{$this->Flash->render()}
<h1>作品{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($content,['enctype' => 'multipart/form-data'])}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('prefix', ['type'=>'text'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/contents/index'>一覧に戻る</a></div>