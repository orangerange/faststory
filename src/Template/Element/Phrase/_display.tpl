<div class='phrase_all'>
    {if $character->dir}
        <image class="character-image" src="{$this->Display->imagePath($character)}">
        {assign var='nameClass' value='character-name'}
    {/if}
    {if $character->html && $character->css}
         {assign var='nameClass' value='character-name'}
        <div class="character-image character_{$character->id}">
            {if !$noCssFlg}
                {$this->Display->css($character->css, '.character_'|cat:$character->id)}
            {/if}
            {$character->html}
        </div>
    {/if}
    <div class="phrase">
        {if $character || $speakerName}
            <div class="{$nameClass}" style="color:{if $speakerName}{$speakerColor}{else}{$character->name_color}{/if}"><b>{if $speakerName}{$speakerName|escape}{else}{$character->name|escape}{/if}</b></div></br>
        {/if}
        {$sentence|escape|nl2br}
    </div>
</div>