    {if $phrase->html && $phrase->css}
        <div id='js_movie_{$i|escape}' class='movie movie_{$i|escape}' data-time="{$phrase->movie_time}" style='{if $phrase->color}background-color:{$phrase->color};{/if}{if $phrase->picture_content}background-image: url("/chapters/picture/{$phrase->id|escape}/1");background-size: cover;{/if}{if $i > 1}display:none;{/if}'>
            {$phrase->html}
        </div>
    {/if}
