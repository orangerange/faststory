<tr>
    <th><button class='delete_action' type='button'>削除</button></th>
    <td>
        <table class="scroll_x">
            <tr>
                <th></th>
                <td>
                    キャラクター:{$this->Form->input('action_layouts.'|cat:$i|cat:'.character_id',['class'=>'character_id', 'options'=>$characters, 'label'=>false, 'empty'=>'-'])}
                </td>
                <td>
                    アクション:{$this->Form->input('action_layouts.'|cat:$i|cat:'.action_id',['class'=>'action_id', 'options'=>$actions, 'label'=>false, 'empty'=>'-'])}
                </td>
                <td>
                    倍率:{$this->Form->input('action_layouts.'|cat:$i|cat:'.magnification',['class'=>'magnification', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    is_character:{$this->Form->input('action_layouts.'|cat:$i|cat:'.is_character', ['class'=>'is_character','type'=>'checkbox', 'label'=>false])}
                </td>
                <td>
                    no_character:{$this->Form->input('action_layouts.'|cat:$i|cat:'.no_character', ['class'=>'no_character','type'=>'checkbox', 'label'=>false])}
                </td>
                <td>
                    left:{$this->Form->input('action_layouts.'|cat:$i|cat:'.left_perc',['class'=>'left_perc', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    top:{$this->Form->input('action_layouts.'|cat:$i|cat:'.top_perc',['class'=>'top_perc', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    right:{$this->Form->input('action_layouts.'|cat:$i|cat:'.right_perc',['class'=>'right_perc', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    bottom:{$this->Form->input('action_layouts.'|cat:$i|cat:'.bottom_perc',['class'=>'bottom_perc', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    rotate:{$this->Form->input('action_layouts.'|cat:$i|cat:'.rotate',['class'=>'rotate', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    z_index:{$this->Form->input('action_layouts.'|cat:$i|cat:'.z_index',['class'=>'z_index', 'label'=>false, 'type'=>'text'])}
                </td>
                <td>
                    is_reverse:{$this->Form->input('action_layouts.'|cat:$i|cat:'.is_reverse',['class'=>'is_reverse', 'label'=>false, 'type'=>'checkbox'])}
                </td>

            </tr>
        </table>
    </td>
</tr>
