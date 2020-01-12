{$this->Flash->render()}
<div><a href='/admin/words/input'>新規登録</a></div>
<div><a href='/admin/words/index'>一覧</a></div>
<h1>単語分解</h1>
{$this->Form->create($content,['enctype' => 'multipart/form-data'])}
{$this->Form->input('word', ['label'=>false])}
{$this->Form->button('分解')}
{$this->Form->end()}
<table>
    <tr>
        <td>
            {if $prefix}
                {foreach from=$prefix key=$_key item=$_value}
                    <font color='red'>{$_value['name']|escape}</font>＋
                {/foreach}
            {/if}
        </td>
        <td>{$word|escape}</td>
        <td>
            {if $suffix}
                {foreach from=$suffix key=$_key item=$_value}
                    ＋<font color='red'>{$_value['name']|escape}</font>
                {/foreach}
            {/if}
        </td>
    </tr>
    <tr>
        <td>
            {if $prefix}
                {foreach from=$prefix key=$_key item=$_value}
                    <font color='red'>{$_value['meaning']|escape}</font>＋
                {/foreach}
            {/if}
        </td>
        <td></td>
        <td>
            {if $suffix}
                {foreach from=$suffix key=$_key item=$_value}
                    ＋<font color='red'>{$_value['meaning']|escape}</font>
                {/foreach}
            {/if}
        </td>
    </tr>
</table>
