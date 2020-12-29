{$this -> Html -> script('jquery-1.8.3', ['block'=>true])}
{*{$this->Html->script('contents/index.js', ['block'=>true])}*}
{$this->Html->script('contents/index_ajax.js', ['block'=>true])}
{$this->Display->baseClassCss()}
{foreach from=$contents item=content}
    {if $content->thumbnail_css}
        {$this->Display->css($content->thumbnail_css, '#thumbnail_html_display_'|cat:$content->id)}
    {/if}
{/foreach}
{*<h1>このサイトでは自作の物語を、チャット小説形式で公開しています。</h1>*}
<h1>チャット小説公開中</h1>
<h2>作品一覧</h2>
<div id="contents">
    {foreach from=$contents item=content}
        <div class="thumbnail" data-id="{$content->id|escape}" @click="showPopUp">
            <div id="thumbnail_html_display_{$content->id}" class="thumbnail_html_display"
                 {if $content->thumbnail_background_color}style="background-color:{$content->thumbnail_background_color}"{/if}>
                {$content->thumbnail_html}
            </div>
            {$content->name|escape}
        </div>
    {/foreach}
</div>
<div id="popup_outside"></div>
{$this -> Html-> script('axios.min')}
{$this -> Html-> script('vue')}
