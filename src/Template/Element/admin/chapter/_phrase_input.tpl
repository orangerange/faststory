<div {if $i>1 && !$openFlg[$i]}style='display:none;' {/if}class='phrase_control'>
    <button class='insert' type='button'>挿入</button>
    {$this->Form->control('phrase_no',['type'=>'hidden', 'class'=>'phrase_no', 'value'=>$i])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.character_id',['options'=>$characters, 'empty'=>'--', 'class' => 'character_id'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_name')}
    {$this->Form->control('phrases.'|cat:$i|cat:'.speaker_color',['type'=>'color'])}
    <div class="count_display">
        <span class="count">{$chapter['phrases'][$i]['sentence']|count_characters}</span>文字
    </div>
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence', ['type'=>'textarea', 'size'=>150, 'class'=>'sentence'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_kana', ['type'=>'text', 'size'=>150, 'class'=>'sentence_kana'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.sentence_translate', ['type'=>'text', 'size'=>150, 'class'=>'sentence_translate'])}
    <div id='css_show_{$i|escape}' class='css_show'>
        {$this->Display->css($chapter['phrases'][$i]['css'])}
    </div>
    {$this->Display->adminAnimateJs($i, $chapter['phrases'][$i]['js'])}
    <div id='html_show_{$i|escape}' class='phrase_object html_show phrase_object_{$i+1|escape}'>
        {$chapter['phrases'][$i]['html']}
    </div>
    <div class='object_layout_input object_layout_input_{$i}'>
        {$this->element('admin/chapter/_object_layout', ['layouts'=>$layouts[$i]])}
    </div>
    <button class='object_select' type='button'>選択</button>
    <button class='object_modify' type='button'>微調整</button>
    <button class='object_clear' type='button'>イラストクリア</button>
    <button class='object_animate object_animate_{$i}' type='button'>アニメーション実行</button>
    {assign var='checked' value=''}
    {if $chapter->phrases[$i]->character_id && $chapter->phrases[$i]->html && $chapter->phrases[$i]->css}
        {assign var=checked value='checked'}
    {/if}
    {$this->Form->input('phrases.'|cat:$i|cat:'.object_usage', ['class'=>'object_usage', 'type'=>'select', 'label'=>false, 'options'=>$this->Config->read('object_usage')])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.character_object', ['class'=>'character_object','type'=>'checkbox', 'checked'=>$checked])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.html', ['type'=>'textarea', 'cols'=>50, 'class'=>'html'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.css', ['type'=>'textarea', 'cols'=>50, 'class'=>'css'])}
    {$this->Form->control('phrases.'|cat:$i|cat:'.js', ['type'=>'textarea', 'cols'=>50, 'class'=>'js'])}

    <button class='clear' type='button'>内容をクリア</button>

    {if $i < $smarty.const.PHRASE_MUX_NUM-1}
        <button class='slide' type='button'>↕</button>
    {/if}
