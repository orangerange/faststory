{$this->Html->script('admin/character/input.js', ['block'=>'script'])}
{$this->Flash->render()}
<h1>キャラクター{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($character,['enctype' => 'multipart/form-data'])}
{$this->Form->input('content_id',['options'=>$contents])}
{$this->Form->input('name')}
{$this->Form->input('name_color',['type'=>'color'])}
{if $character->dir}
    <image src="{$this->Display->imagePath($character)}">
    {$this->Form->input('picture_before',['type'=>'hidden','value'=>$character->picture])}
    {$this->Form->input('dir_before',['type'=>'hidden','value'=>$character->dir])}
    画像削除{$this->Form->checkbox('picture_delete')}
{/if}
{$this->Form->input('picture', ['type'=>'file'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/characters/index'>一覧に戻る</a></div>