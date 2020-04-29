<div {if $i>1 && !$openFlg[$i]}style='display:none;' {/if}class='phrase_control'>
    <button class='insert' type='button'>挿入</button>
    {$this->Form->control('phrase_no',['type'=>'hidden', 'class'=>'phrase_no', 'value'=>$i])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.character_id',['options'=>$characters, 'empty'=>'--', 'class' => 'character_id'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_name')}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_color',['type'=>'color'])}
    <div id='css_show_{$i|escape}' class='css_show'>
        {$this->Display->css($chapter['phrases'][$i]['css'])}
    </div>
    {$this->Display->adminAnimateJs($i, $chapter['phrases'][$i]['js'])}
    <div id='html_show_{$i|escape}' class='phrase_object html_show'>
        {$chapter['phrases'][$i]['html']}
    </div>
    <button class='object_select' type='button'>選択</button>
    <button class='object_clear' type='button'>イラストクリア</button>
    <button class='object_animate object_animate_{$i}' type='button'>アニメーション実行</button>
    {$this->Form->control('phrases.'|cat:$i|cat:'.html', ['type'=>'textarea', 'cols'=>50, 'class'=>'html'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.css', ['type'=>'textarea', 'cols'=>50, 'class'=>'css'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.js', ['type'=>'textarea', 'cols'=>50, 'class'=>'js'])}
    {assign var='checked' value=''}
    {if $chapter->phrases[$i]->character_id && $chapter->phrases[$i]->html && $chapter->phrases[$i]->css}
        {assign var=checked value='checked'}
    {/if}
    {$this->Form->control('phrases.'|cat:$i|cat:'.object_speak', ['class'=>'object_speak','type'=>'checkbox', 'checked'=>$checked])}
    <div class="count_display">
        <span class="count">{$chapter['phrases'][$i]['sentence']|count_characters}</span>文字
    </div>
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_kana', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence_kana'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_translate', ['type'=>'textarea', 'cols'=>50, 'class'=>'sentence_translate'])}
    <button class='clear' type='button'>内容をクリア</button>

    {if $i < $smarty.const.PHRASE_MUX_NUM-1}
        <button class='slide' type='button'>↕</button>
    {/if}
