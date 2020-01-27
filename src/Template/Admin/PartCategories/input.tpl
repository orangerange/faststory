{$this->Flash->render()}
<h1>パーツカテゴリー{if $editFlg}編集{else}登録{/if}({$template['name']|escape})</h1>
{if $editFlg}
    {$this->Form->create($category,['enctype' => 'multipart/form-data', 'url' => [$id]])}
{else}
    {$this->Form->create($category,['enctype' => 'multipart/form-data', 'url' => [$templateId]])}
{/if}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('class_name', ['type'=>'text'])}
{$this->Form->input('z_index', ['type'=>'text'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/part-categories/index/{$templateId|escape}/{$objectType|escape}'>一覧に戻る</a></div>