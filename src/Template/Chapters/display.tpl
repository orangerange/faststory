{* 元々読み込んでいたページめくり用jsファイルを、アニメーション用スクリプトを埋め込むために設定ファイル化(ヘルパー化)*}
{*{$this->Html->script('chapter/display.js', ['block'=>true])}*}
{$this->Html->script('config.js', ['block'=>true])}
{$this->Display->baseClassCss()}
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
<div id="phrases">
    {$this->Form->control('phrase_num', ['type'=>'hidden', 'id'=>'phrase_num', 'value'=>count($chapter['phrases'])])}
    {foreach from=$chapter['phrases'] item=_phrase name=phraseLoop2}
        <div class="speak" v-show="num >={$smarty.foreach.phraseLoop2.iteration}" ref="speak_{$smarty.foreach.phraseLoop2.iteration}">
            {$this->element('phrase/_display', ['character'=>$_phrase->character, 'phrase'=>$_phrase, 'noCharacterCssFlg' => true, 'i' => $smarty.foreach.phraseLoop2.iteration])}
        </div>
    {/foreach}
    <div v-if="buttonShow" class="next_out" ref="next">
        <button class="next" @click="next">next!</button>
    </div>
    <div v-else class="next_out" ref="next" style="visibility:hidden">
        <button class="next" @click="next">next!</button>
    </div>
</div>
{$this -> Html-> script('vue')}
{$this->Display->phraseJs($scripts)}

