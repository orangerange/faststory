{$this->Flash->render()}
<h1>作品{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($content,['enctype' => 'multipart/form-data'])}
{$this->Form->input('name')}
{$this->Form->input('prefix')}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/contents/index'>一覧に戻る</a></div>