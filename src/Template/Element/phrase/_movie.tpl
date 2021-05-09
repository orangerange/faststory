    {if $phrase->html && $phrase->css}
        <div id='js_movie_{$i|escape}' class='movie movie_{$i|escape}' data-time="{$phrase->movie_time}" data-no="{$i}" style='{if $phrase->color}background-color:{$phrase->color};{/if}{if $phrase->picture_content}background-image: url("/chapters/picture/{$phrase->id|escape}/1");background-size: cover;{/if}{if $i > 1}visibility:hidden{/if}'>
            {$phrase->html}
        </div>
    {elseif $phrase->sentence}
        <div id='js_sentence_{$i|escape}' data-time="{$phrase->movie_time}" data-no="{$i}" data-sentence="{$phrase->sentence}" {if $phrase->other_sentence_num}data-other_sentence_num="{$phrase->other_sentence_num}"{/if}>
        </div>
    {/if}
