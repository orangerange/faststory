{$this->Html->css('config_icon', ['block'=>'css'])}
<h1>アイコン詳細</h1>
<div class='css css_sum'>
    {$this->Display->css($icon->css)}
</div>
<div class="html_icon" {if $icon->background_color}style="background-color:{$icon->background_color}"{/if}>
        {$icon->html}
</div>
<div class="icon_circle"></div></br>
<div><a href='/admin/icons/index/'>一覧に戻る</a></div>
