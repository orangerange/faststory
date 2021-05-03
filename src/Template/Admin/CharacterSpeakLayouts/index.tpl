{$this->Flash->render()}
<h1>character_speakレイアウト一覧</h1>
<div><a href='/admin/character-speak-layouts/input'>新規登録</a></div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>キャラクター</th>
            <th>アクション</th>
            <th>left</th>
            <th>right</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach from=$characterSpeakLayouts item=characterSpeakLayout}
            <tr>
                <td>{$characterSpeakLayout->id}</td>
                <td>{$characters[$characterSpeakLayout->character_id]|escape}</td>
                <td>{$actions[$characterSpeakLayout->action_id]|escape}</td>
                <td>{$characterSpeakLayout->left_perc|escape}</td>
                <td>{$characterSpeakLayout->right_perc|escape}</td>
                <td><a href='/admin/character-speak-layouts/edit/{$characterSpeakLayout->id}'>編集</a></td>
{*                <td><a href='/admin/character-speak-layouts/delete/{$characterSpeakLayout->id}'>削除</a></td>*}
            </tr>
        {/foreach}
    </tbody>
</table>
