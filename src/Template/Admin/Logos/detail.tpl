{if !$isPreview}
    <h1>ロゴ詳細</h1>
{/if}
<div class='css css_sum'>
    {$this->Display->css($logo->css)}
</div>
<div class="html_logo" {if $logo->background_color}style="background-color:{$logo->background_color}"{/if}>
        {$logo->html}
</div>
<div class="icon_circle"></div>
{if !$isPreview}
    <div><a href='/admin/logos/index/'>一覧に戻る</a></div>
{/if}
