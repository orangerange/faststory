<div class='popup' id='js-popup'>
    <input type='hidden' id='phrase_no'>
    <div class='popup-inner'>
        <div class='close-btn' id='js-close-btn'>
            <div class="stick stick_A"></div>
            <div class="stick stick_B"></div>
        </div>
        <table>
            <thead>
            <tr>
                {if !$isIndex}
                    {assign var='content' value=$chapter->content}
                {/if}
                <th>
                    <div id="thumbnail_html_display_{$content->id}" class="thumbnail_html_display_title"
                         {if $content->thumbnail_background_color}style="background-color:{$content->thumbnail_background_color}"{/if}>
                        {*                        {if $isIndex}*}
                        {$content->thumbnail_html}
                        {*                        {else}*}
                        {*                            {$chapter->content->thumbnail_html|escape}*}
                        {*                        {/if}*}
                    </div>
                </th>
            </tr>
            {if $isIndex && $content->copy}
                <tr>
                    <td>
                        <div class="copy">
                            {$content->copy|escape|nl2br}
                        </div>
                    </td>
                </tr>
            {/if}
            <tr>
                <td>
                    <b class="content_title">
                        {$content->name|escape}
                    </b>
                </td>
            </tr>
            {if !$isIndex}
                <tr v-if="isEnd">
                    <td>
                    <div class="chapter_end">第{$no|escape}話は以上です。</div>
                    {if $chapterCount > $no}
                        <button class="push next_chapter"
                                onclick="location.href='/chapters/display/{$chapter->content->prefix|escape}/{$no + 1|escape}/'">
                            次話へ進む
                        </button>
                    {/if}
                    </td>
                </tr>
            {/if}
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="chapter_list">話一覧</div>
                </td>
            </tr>
            {foreach from=$chapters item='_chapter'}
                <tr>
                    <td>
                        <a class="chapter_list_link" href='/chapters/display/{if $isIndex}{$content->prefix|escape}{else}{$chapter->content->prefix|escape}{/if}/{$_chapter->no|escape}'>第{$_chapter->no|escape}
                            話&nbsp;&nbsp;{$_chapter->title|escape}</a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class='black-background' id='js-black-bg'></div>
</div>
