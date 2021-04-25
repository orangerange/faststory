{* 元々読み込んでいたページめくり用jsファイルを、アニメーション用スクリプトを埋め込むために設定ファイル化(ヘルパー化)*}
{$this->Html->script('config_movie.js', ['block'=>true])}
{$this->Display->baseClassCss()}
{*{assign var='characterIds' value=","|explode:""}*}
{*{capture name="garbage"}{$characterIds|@array_pop}{/capture}*}
{foreach from=$chapter['phrases'] item=_phrase name=phraseLoop1}
    {if $_phrase->character->css && !$_phrase->character->id|in_array:$characterIds}
        {$this->Display->css($_phrase->character->css, '.character_'|cat:$_phrase->character->id)}
    {/if}
    {capture name="garbage"}{$characterIds|@array_push:$_phrase->character->id}{/capture}
    {if $_phrase->css}
        {$this->Display->css($_phrase->css)}
    {/if}
{/foreach}
{*{foreach from=$backgrounds key=$_phraseNum item=$_background}*}
{*    <div id="css_background_{$_background->id}" data-body_color="{$_background->body_color}">*}
{*        {$this->Display->css($_background->css, '.html_background_'|cat:$_background->id)}*}
{*    </div>*}
{*{/foreach}*}
{*{$this->Display->css($chapter->content->thumbnail_css, '#thumbnail_html_display_'|cat:$chapter->content->id)}*}
{$this->Form->control('phrase_num', ['type'=>'hidden', 'id'=>'phrase_num', 'value'=>count($chapter['phrases'])])}
<div id="movies">
    {foreach from=$chapter['phrases'] item=_phrase name=phraseLoop2}
        {$this->element('phrase/_movie', ['character'=>$_phrase->character, 'phrase'=>$_phrase, 'noCharacterCssFlg' => true, 'i' => $smarty.foreach.phraseLoop2.iteration])}
    {/foreach}
</div>
{$this -> Html-> script('axios.min')}
{$this -> Html-> script('vue')}
{$this->Display->movieJs($scripts)}

