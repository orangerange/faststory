<div id="copyarea" class="phrases_novel">
    {assign var='characterId' value=''}
    {foreach from=$chapter['phrases'] item=_phrase name=phraseLoop}
        {if $_phrase->character_id}
            {if $characterId != $_phrase->character_id}
                {if $characterId}
                    」</br>
                {/if}
                {assign var='characterId' value=$_phrase->character_id}
                「
            {/if}
        {else}
            {if $characterId}
                {assign var='characterId' value=''}
                」</br>
            {/if}
        {/if}
        {$_phrase->sentence|escape|nl2br}
        {if !$characterId}
            <br/>
        {/if}
        {if $smarty.foreach.phraseLoop.last && $characterId}
            」
        {/if}
    {/foreach}
</div>

