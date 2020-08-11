{$this->Flash->render()}
<h1>階級{if $editFlg}編集{else}登録{/if}({$organization['name']|escape})</h1>
{if $editFlg}
    {$this->Form->create($rank,['enctype' => 'multipart/form-data', 'url' => [$id]])}
{else}
    {$this->Form->create($rank,['enctype' => 'multipart/form-data', 'url' => [$organizationId]])}
{/if}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('badge_left_id',['options'=>$badges, 'empty' => '--'])}
{$this->Form->input('badge_right_id',['options'=>$badges, 'empty' => '--'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/ranks/index/{$organizationId|escape}/{$objectType|escape}'>一覧に戻る</a></div>
