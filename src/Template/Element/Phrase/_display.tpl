<div class='phrase_all'>
    {if $character->dir}
        <image class="character-image" src="{$this->Display->imagePath($character)}">
        {assign var='nameClass' value='character-name'}
    {/if}
    {if $character->html && $character->css}
         {assign var='nameClass' value='character-name'}
        <div class="character-image">
            {if !$noCssFlg}
                {$this->Display->css($character->css)}
            {/if}
            {$character->html}
        </div>
    {/if}
    <div class="phrase">
        {if $character}
            <div class="{$nameClass}" style="color:{$character->name_color}"><b>{$character->name|escape}</b></div></br>
        {/if}
        {$sentence|escape|nl2br}
    </div>
</div>