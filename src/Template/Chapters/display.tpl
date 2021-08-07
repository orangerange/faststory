{* 元々読み込んでいたページめくり用jsファイルを、アニメーション用スクリプトを埋め込むために設定ファイル化(ヘルパー化)*}
{*{$this->Html->script('chapter/display.js', ['block'=>true])}*}
{*{$this->Html->script('config.js', ['block'=>true])}*}
{$this->Html->script('copy_objects.js', ['block'=>true])}
{$this->Display->baseClassCss()}
{$this->Display->css('', 'character-image', 'object', 12.5, 25)}
{assign var='characterIds' value=","|explode:""}
{capture name="garbage"}{$characterIds|@array_pop}{/capture}
{foreach from=$chapter['phrases'] item=_phrase name=phraseLoop1}
    {if $_phrase->character->css && !$_phrase->character->id|in_array:$characterIds}
        {$this->Display->css($_phrase->character->css, '.character_'|cat:$_phrase->character->id)}
    {/if}
    {capture name="garbage"}{$characterIds|@array_push:$_phrase->character->id}{/capture}
    {if $_phrase->css}
        {$this->Display->css($_phrase->css)}
    {/if}
{/foreach}
{foreach from=$backgrounds key=$_phraseNum item=$_background}
    <div id="css_background_{$_background->id}" data-body_color="{$_background->body_color}">
        {$this->Display->css($_background->css, '.html_background_'|cat:$_background->id)}
    </div>
{/foreach}
{$this->Display->css($chapter->content->thumbnail_css, '#thumbnail_html_display_'|cat:$chapter->content->id)}
<div id="phrases">
    <div class="background">
        {foreach from=$backgrounds key=$_phraseNum item=$_background}
            <div class="html_background html_background_{$_background->id}"
                 v-show="background_id == {$_background->id}">
                {$_background->html}
            </div>
        {/foreach}
    </div>
    {$this->element('chapter/_header_titles')}
    <div class="header" ref="header" id="header" @click="header">
        <div>
            {$chapter['content']->name|escape}&nbsp;第{$no|escape}話
        </div>
    </div>
    <div class="phrases_body">
        {$this->Form->control('phrase_num', ['type'=>'hidden', 'id'=>'phrase_num', 'value'=>count($chapter['phrases'])])}
        {foreach from=$chapter['phrases'] item=_phrase name=phraseLoop2}
            <div class="speak" {if $_phrase->background_id}data-background_id="{$_phrase->background_id|escape}"{/if}
                 v-show="num >={$smarty.foreach.phraseLoop2.iteration}"
                 ref="speak_{$smarty.foreach.phraseLoop2.iteration}">
                {$this->element('phrase/_display', ['character'=>$_phrase->character, 'phrase'=>$_phrase, 'noCharacterCssFlg' => true, 'i' => $smarty.foreach.phraseLoop2.iteration])}
            </div>
        {/foreach}
        {*背景変更スクロール時の調整用*}
        <div class="shadow_height" v-show="shadowHeight > 0" v-bind:style="{ height:shadowHeight }">
        </div>
        <div class="next_out push_out" ref="next">
            <button v-if="buttonShow" class="next push" @click="next">＋</button>
        </div>
    </div>
</div>
{$this -> Html-> script('axios.min')}
{$this -> Html-> script('vue')}
{$this->Display->phraseJs($scripts)}
{$this->Html->script('config.js')}

