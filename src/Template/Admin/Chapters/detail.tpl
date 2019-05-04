<h1>プレビュー</h1>

<div class="speak">
    {if $character->dir}
        <image class="character-image" src="{$this->Display->imagePath($character)}">
        {assign var='nameClass' value='character-name'}
    {/if}
    <div class="phrase">
        <div class="{$nameClass}" style="color:{$character->name_color}">{$character->name}</div></br>
        サンプル　サンプル　サンプル</br>
        あああああ
    </div>
</div>
<div><a href='/admin/characters/index'>一覧に戻る</a></div>