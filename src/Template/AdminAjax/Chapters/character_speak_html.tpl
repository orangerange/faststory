{if $face || $body || $rightArm}
    <div class="character_speak_{$phraseNo}">
        {if $rightArm}
            <div class="right_arm object_{$rightArm->id}">
                {$rightArm->html}
            </div>
        {/if}
        {if $face}
            <div class="face object_{$face->id}">
                {$face->html}
            </div>
        {/if}
        {if $body}
            <div class="body object_{$body->id}">
                {$body->html}
            </div>
        {/if}
    </div>
{/if}
{if $speech}
    <div class="speech object_{$speech->id}">
        {$speech->html}
    </div>
{/if}
