<h1>オブジェクト詳細</h1>
{$this->Display->css('', null, 'object', $object->object_template->width, $object->object_template->height)}
<div class='css css_sum'>
    {$this->Display->css($object->css)}
</div>
<div class="html_show">
    <div class='{$object->object_template->class_name|escape} object_input' style='width:{$object->object_template->width|escape}%; height:{$object->object_template->height|escape}%;{if $object->picture_content}background-image: url("/objects/picture/{$object->id|escape}");background-size: cover;{/if}'>
        {$object->html}
    </div>
</div>
<div><a href='/admin/objects/index/{$object->template_id|escape}'>一覧に戻る</a></div>
