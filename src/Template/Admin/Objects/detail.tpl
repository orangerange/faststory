<h1>オブジェクト詳細</h1>
<div class='css css_sum'>
    {$this->Display->css($object->css)}
</div>
<div class="phrase_object">
    <div class='object_input' style='width:{$object->object_template->width|escape}%; height:{$object->object_template->height|escape}%;'>
        {$object->html}
    </div>
</div>
<div><a href='/admin/objects/index/{$object->template_id|escape}'>一覧に戻る</a></div>