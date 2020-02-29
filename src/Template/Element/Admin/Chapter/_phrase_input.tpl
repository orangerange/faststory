<div {if $i>1 && !$openFlg[$i]}style='display:none;' {/if}class='phrase_control'>
    <button class='insert' type='button'>挿入</button>
    {$this->Form->control('phrase_no',['type'=>'hidden', 'class'=>'phrase_no', 'value'=>$i])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.character_id',['options'=>$characters, 'empty'=>'--'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_name')}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_color',['type'=>'color'])}
    <span class="count">{$chapter['phrases'][$i]['sentence']|count_characters}</span>文字
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_kana', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence_kana'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_translate', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence_translate'])}
    {*{if $chapter['phrases'][$i]['dir']}
    <image src="{$this->Display->imagePath($chapter['phrases'][$i])}">
    {$this->Form->control('phrases.'|cat:$i|cat:'.picture_before',['type'=>'hidden','value'=>$chapter['phrases'][$i]['picture']])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.dir_before',['type'=>'hidden','value'=>$chapter['phrases'][$i]['dir']])}
    画像削除{$this->Form->checkbox('phrases.'|cat:$i|cat:'.picture_delete')}
    {/if}*}
    <div id='css_show_{$i|escape}' class='css_show'>
        {$this->Display->css($chapter['phrases'][$i]['css'])}
    </div>
    <div id='html_show_{$i|escape}' class='phrase_object html_show'>
        {$chapter['phrases'][$i]['html']}
    </div>
{*    {$this->Form->input('object_id', ['class'=>'object_id', 'options'=>$objects, 'empty'=>'-'])}*}
    <button class='object_select' type='button'>選択</button>
    {$this->Form->control('phrases.'|cat:$i|cat:'.html', ['type'=>'textarea', 'cols'=>50, 'class'=>'html'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.css', ['type'=>'textarea', 'cols'=>50, 'class'=>'css'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.js', ['type'=>'textarea', 'cols'=>50, 'class'=>'js'])}
    {*{$this->Form->control('phrases.'|cat:$i|cat:'.picture', ['type'=>'file'])}*}
    <button class='clear' type='button'>内容をクリア</button>
    {if $i < $smarty.const.PHRASE_MUX_NUM-1}
        <button class='slide' type='button'>↕</button>
    {/if}
