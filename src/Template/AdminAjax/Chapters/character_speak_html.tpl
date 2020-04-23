<div class="face object_{$face->id}">
    {$face->html}
</div>
<div class="body object_{$body->id}">
    {$body->html}
</div>
<div class="speech object_{$speech->id}">
    <div class="main_1">
        {if $sentence_translate}
            <div style="color:{$character->foreign_color};">
                {if $sentence_kana}
                    <div class="kana">{$sentence_kana|escape|nl2br}</div>
                {/if}
                <div class="foreign">{$sentence|escape|nl2br}</div>
            </div>
            ({$sentence_translate})
        {else}
            <div class="speak">
                {$sentence|escape|nl2br}
            </div>
        {/if}
    </div>
</div>
