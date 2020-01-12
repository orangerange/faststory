{$this->Flash->render()}
<h1>オブジェクトテンプレート</h1>
<div><a href='/object-templates/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th> 名前</th>
            <th> クラス名</th>
            <th>width(%)</th>
            <th>height(%)</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$objectTemplates item=_template}
            <tr>
                <td>{$_template.name|escape}</td>
                <td>{$_template.class_name|escape}</td>
                <td>{$_template.width|escape}</td>
                <td>{$_template.height|escape}</td>
                <td><a href='/admin/object-templates/edit/{$_template->id}'>編集</a></td>
                <td><a href='/admin/part-categories/index/{$_template->id}'>パーツカテゴリー一覧</a></td>
                <td><a href='/admin/part-categories/input/{$_template->id}'>パーツカテゴリー登録</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
