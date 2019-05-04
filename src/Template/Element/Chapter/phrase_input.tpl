<div {if $i>0 && !$openFlg[$i]}style='display:none;' {/if}class='phrase_control'>
{$this->Form->control('phrases.'|cat:$i|cat:'.id',['type'=>'hidden'])}
{$this->Form->control('phrases.'|cat:$i|cat:'.character_id',['options'=>$characters, 'empty'=>'--'])}
{$this->Form->control('phrases.'|cat:$i|cat:'.speaker_name')}
{$this->Form->control('phrases.'|cat:$i|cat:'.speaker_color',['type'=>'color'])}
{$this->Form->control('phrases.'|cat:$i|cat:'.sentence', ['type'=>'textarea', 'cols'=>50])}
{if $chapter['phrases'][$i]['dir']}
    <image src="{$this->Display->imagePath($chapter['phrases'][$i])}">
    {$this->Form->control('phrases.'|cat:$i|cat:'.picture_before',['type'=>'hidden','value'=>$chapter['phrases'][$i]['picture']])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.dir_before',['type'=>'hidden','value'=>$chapter['phrases'][$i]['dir']])}
    画像削除{$this->Form->checkbox('phrases.'|cat:$i|cat:'.picture_delete')}
{/if}
{$this->Form->control('phrases.'|cat:$i|cat:'.picture', ['type'=>'file'])}
<button class='clear' type='button'>内容をクリア</button>
{if $i < $smarty.const.PHRASE_MUX_NUM-1}
    <button class='slide' type='button'>↕</button>
{/if}