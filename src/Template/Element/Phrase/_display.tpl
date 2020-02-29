<div class='phrase_all'>
    {if $phrase->html && $phrase->css}
        <div class='phrase_object_display'>
            {$phrase->html}
        </div>
    {else}
        {if $character->dir}
            <image class="character-image" src="{$this->Display->imagePath($character)}">
            {assign var='nameClass' value='character-name'}
        {/if}
        {if $character->html && $character->css}
            {assign var='nameClass' value='character-name'}
            <div class="character-image character_{$character->id}">
                {$character->html}
            </div>
        {/if}
        <div class="phrase">
            {if $character || $phrase->speaker_name}
                <div class="{$nameClass}"
                     style="color:{if $phrase->speaker_name}{$phrase->speaker_color}{else}{$character->name_color}{/if}">
                    <b>{if $phrase->speaker_name}{$phrase->speaker_name|escape}{else}{$character->name|escape}{/if}</b>
                </div>
            {/if}
            {if $sentence}
                {$sentence|escape|nl2br}
            {else}
                {if $phrase->sentence_translate}
                    <div style="color:{$character->foreign_color};">
                        {if $phrase->sentence_kana}
                            <div class="kana">{$phrase->sentence_kana|escape|nl2br}</div>
                        {/if}
                        <div class="foreign">{$phrase->sentence|escape|nl2br}</div>
                    </div>
                    ({$phrase->sentence_translate})
                {else}
                    <div>
                        {$phrase->sentence|escape|nl2br}
                    </div>
                {/if}
            {/if}
        </div>
    {/if}
</div>
