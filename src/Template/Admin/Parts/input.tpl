{$this->Flash->render()}
{$this->Html->script('admin/part/input.js', ['block'=>'script'])}
<div><a href='/admin/parts/index'>パーツ一覧</a></div>
<h1>パーツ登録</h1>
<div>
    {$this->Form->create($part, [
        'enctype' => 'multipart/form-data']
        )
    }
<table>
    <tr>
        <th>表示</th>
        <td>
            <div class='css'>
                {$this->Display->css($part->css)}
            </div>
            <div class='character_box'>
                {$part->html}
            </div>
        </td>
    </tr>
    <tr>
        <th>種類</th>
        <td>{$this->Form->input('parts_category_no',['options'=>$this->Config->read('parts'), 'label'=>false, 'empty'=>'-', 'class'=>'parts_category_no'])}</td>
    </tr>
    <tr>
        <th>HTML</th>
        <td>{$this->Form->input('html', ['type'=>'textarea', 'label'=>false, 'class'=>'html_input'])}</td>
    </tr>
    <tr>
        <th>CSS</th>
        <td>{$this->Form->input('css', ['type'=>'textarea', 'label'=>false, 'class'=>'css_input'])}</td>
    </tr>
    <tr>
        <th></th>
        <td>{$this->Form->button('登録')}</td>
    </tr>
</table>
    {$this->Form->end()}
</div>
