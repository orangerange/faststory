{$this->Flash->render()}
{$this->Html->script('admin/object_template/input.js', ['block'=>'script'])}
<h1>オブジェクトテンプレート{if $editFlg}編集{else}登録{/if}</h1>
<div>範囲</div>
<div class='phrase_object'>
    <div class='object_input' style='width:{$template->width|escape}%; height:{$template->height|escape}%;'>
    </div>
</div>
{$this->Form->create($template,['enctype' => 'multipart/form-data'])}
{$this->Form->input('name', ['type'=>'text'])}
{$this->Form->input('class_name', ['type'=>'text'])}
{$this->Form->input('width', ['type'=>'text'])}
{$this->Form->input('height', ['type'=>'text'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/object-templates/index'>一覧に戻る</a></div>