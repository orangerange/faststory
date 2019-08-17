<div {if $i>1 && !$openFlg[$i]}style='display:none;' {/if}class='phrase_control'>
<button class='insert' type='button'>挿入</button>
{$this->Form->control('no',['type'=>'hidden', 'class'=>'no', 'value'=>$i])}
{$this->Form->control('phrases.'|cat:$i|cat:'.character_id',['options'=>$characters, 'empty'=>'--'])}
{$this->Form->control('phrases.'|cat:$i|cat:'.speaker_name')}
{$this->Form->control('phrases.'|cat:$i|cat:'.speaker_color',['type'=>'color'])}
<span class="count">{$chapter['phrases'][$i]['sentence']|count_characters}</span>文字
{$this->Form->control('phrases.'|cat:$i|cat:'.sentence', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence'])}
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