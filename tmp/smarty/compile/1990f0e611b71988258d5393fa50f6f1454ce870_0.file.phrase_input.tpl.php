<?php
/* Smarty version 3.1.32, created on 2019-05-03 11:11:46
  from '/vagrant/src/Template/Element/chapter/phrase_input.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5ccc21f2114186_58193191',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1990f0e611b71988258d5393fa50f6f1454ce870' => 
    array (
      0 => '/vagrant/src/Template/Element/chapter/phrase_input.tpl',
      1 => 1539089030,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ccc21f2114186_58193191 (Smarty_Internal_Template $_smarty_tpl) {
?><div <?php if ($_smarty_tpl->tpl_vars['i']->value > 0 && !$_smarty_tpl->tpl_vars['openFlg']->value[$_smarty_tpl->tpl_vars['i']->value]) {?>style='display:none;' <?php }?>class='phrase_control'>
<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.id'),array('type'=>'hidden'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.character_id'),array('options'=>$_smarty_tpl->tpl_vars['characters']->value,'empty'=>'--'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.speaker_name'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.speaker_color'),array('type'=>'color'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.sentence'),array('type'=>'textarea','cols'=>50));?>

<?php if ($_smarty_tpl->tpl_vars['chapter']->value['phrases'][$_smarty_tpl->tpl_vars['i']->value]['dir']) {?>
    <image src="<?php echo $_smarty_tpl->tpl_vars['this']->value->Display->imagePath($_smarty_tpl->tpl_vars['chapter']->value['phrases'][$_smarty_tpl->tpl_vars['i']->value]);?>
">
    <?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.picture_before'),array('type'=>'hidden','value'=>$_smarty_tpl->tpl_vars['chapter']->value['phrases'][$_smarty_tpl->tpl_vars['i']->value]['picture']));?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.dir_before'),array('type'=>'hidden','value'=>$_smarty_tpl->tpl_vars['chapter']->value['phrases'][$_smarty_tpl->tpl_vars['i']->value]['dir']));?>

    画像削除<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->checkbox((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.picture_delete'));?>

<?php }
echo $_smarty_tpl->tpl_vars['this']->value->Form->control((('phrases.').($_smarty_tpl->tpl_vars['i']->value)).('.picture'),array('type'=>'file'));?>

<button class='clear' type='button'>内容をクリア</button>
<?php if ($_smarty_tpl->tpl_vars['i']->value < @constant('PHRASE_MUX_NUM')-1) {?>
    <button class='slide' type='button'>↕</button>
<?php }
}
}
