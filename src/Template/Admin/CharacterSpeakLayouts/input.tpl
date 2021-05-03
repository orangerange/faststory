{$this->Flash->render()}
{*{$this->Html->script('admin/contents/input.js', ['block'=>'script'])}*}

<h1>character_speak_layout{if $editFlg}編集{else}登録{/if}</h1>
{$this->Form->create($characterSpeakLayout,['enctype' => 'multipart/form-data'])}
キャラクター:{$this->Form->input('character_id',['class'=>'character_id', 'options'=>$characters, 'label'=>false, 'empty'=>'-'])}
アクション:{$this->Form->input('action_id',['class'=>'action_id', 'options'=>$actions, 'label'=>false, 'empty'=>'-'])}
{$this->Form->input('left_perc', ['class' => 'left_perc', 'type'=>'text'])}
{$this->Form->input('right_perc', ['class' => 'right_perc', 'type'=>'text'])}
{$this->Form->button('登録')}
{$this->Form->end()}
<div><a href='/admin/character-speak-layouts/index'>一覧に戻る</a></div>
