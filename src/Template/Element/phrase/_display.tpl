<div class='phrase_all'>
    {if $phrase->html && $phrase->css}
        <div class='phrase_object phrase_object_display phrase_object_{$i|escape}'style='{if $phrase->color}background-color:{$phrase->color};{/if}{if $phrase->picture_content}background-image: url("/chapters/picture/{$phrase->id|escape}/1");background-size: cover;{/if}'>
            {$phrase->html}
        </div>
    {else}
        {if $character->html && $character->css}
            {assign var='nameClass' value='character-name'}
            <div class="face character-image character_{$character->id}">
                {$character->html}
            </div>
        {/if}
        {if $character || $phrase->speaker_name}
            <div class="phrase">
                    <div class="{$nameClass}"
                         style="color:{if $phrase->speaker_name}{$phrase->speaker_color}{else}{$character->name_color}{/if}">
                        <b>{if $phrase->speaker_name}{$phrase->speaker_name|escape}{else}{$character->name|escape}{/if}</b>
                    </div>
                {if $sentence}
                    {$sentence|nl2br}
                {else}
                    {if $phrase->sentence_translate}
                        <div style="color:{$character->foreign_color};">
                            {if $phrase->sentence_kana}
                                <div class="kana">{$phrase->sentence_kana|nl2br}</div>
                            {/if}
                            <div class="foreign">{$phrase->sentence|nl2br}</div>
                        </div>
                        ({$phrase->sentence_translate|nl2br}})
                    {else}
                        <div>
                            {$phrase->sentence|nl2br}
                        </div>
                    {/if}
                {/if}
            </div>
        {else}
            <div class="plain_phrase">
                {$phrase->sentence|escape|nl2br}
            </div>
        {/if}
    {/if}
</div>
