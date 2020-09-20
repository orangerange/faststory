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
                <th>
                    <b>{$chapter->content->name|escape}</b>
                </th>
            </tr>
            </thead>
        </table>
        <div v-if="isEnd">
            <p>
                第{$no|escape}話は以上です。
                {if $chapterCount > $no}
                    <button class="push next_chapter"
                            onclick="location.href='/chapters/display/{$chapter->content->prefix|escape}/{$no + 1|escape}/'">
                        次話へ進む
                    </button>
                {/if}
            </p>
            各話については下記リンクから進めます
        </div>
        <table>
            <tbody>
            {foreach from=$chapters item='_chapter'}
                <tr>
                    <td>
                        <a href='/chapters/display/{$chapter->content->prefix|escape}/{$_chapter->no|escape}'>第{$_chapter->no|escape}話&nbsp;&nbsp;{$_chapter->title|escape}</a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    <div class='black-background' id='js-black-bg'></div>
</div>
