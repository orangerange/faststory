{$this->Flash->render()}
{$this->Html->script('admin/ranks/index.js', ['block'=>'script'])}
{$this->Html->script('jquery-ui.min.js', ['block'=>'script'])}
{$this->Html->css('jquery-ui.min', ['block'=>'script'])}
<h1>階級ソート({$organization['name']})</h1>
<div><a href='/admin/ranks/input/{$organizationId|escape}/'>階級新規登録</a></div>
<table>
    <thead>
        <tr>
            <th> 名前</th>
            <th> 階級章_左</th>
            <th> 階級章_右</th>
            <th></th>
        </tr>
    </thead>
    <tbody id='sortable-table' class='list'>
        {foreach from=$ranks item=_rank}
            <tr class='item' id='{$_rank.id|escape}'>
                <td>{$_rank.name|escape}</td>
                <td>
                    {if {$_rank->badge_left_id}}
                        <button onclick="window.open('/admin/objects/detail/{$_rank->badge_left_id}', 'preview', 'width=600, height=300, menubar=no, toolbar=no')">
                            階級章を見る
                        </button>
                    {else}
                        なし
                    {/if}
                </td>
                <td>
                    {if {$_rank->badge_right_id}}
                        <button onclick="window.open('/admin/objects/detail/{$_rank->badge_right_id}', 'preview', 'width=600, height=300, menubar=no, toolbar=no')">階級章を見る</button>
                    {else}
                        なし
                    {/if}
                </td>
                <td><a href='/admin/ranks/edit/{$_rank->id}'>編集</a></td>
            </tr>
        {/foreach}
    </tbody>
</table>
