<?php
/* Smarty version 3.1.32, created on 2019-05-03 11:11:45
  from '/vagrant/src/Template/Admin/Chapters/input.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5ccc21f133d491_60666133',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '493777d0d8e9bc890472a55c9b4bbba97acbd76d' => 
    array (
      0 => '/vagrant/src/Template/Admin/Chapters/input.tpl',
      1 => 1539507279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ccc21f133d491_60666133 (Smarty_Internal_Template $_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->Html->script('admin/chapter/input.js',array('block'=>'script'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Flash->render();?>

<h1><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content_name']->value, ENT_QUOTES, 'UTF-8', true);?>
チャプター<?php if ($_smarty_tpl->tpl_vars['editFlg']->value) {?>編集<?php } else { ?>登録<?php }?>(<?php echo $_smarty_tpl->tpl_vars['chapterNo']->value;?>
)</h1>
<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->create($_smarty_tpl->tpl_vars['chapter']->value,array('enctype'=>'multipart/form-data'));?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->control('title',array('size'=>50,'accesskey'=>'z'));?>

<?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? @constant('PHRASE_MUX_NUM')-1+1 - (0) : 0-(@constant('PHRASE_MUX_NUM')-1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->element('chapter/phrase_input',array('i'=>$_smarty_tpl->tpl_vars['i']->value));?>

<?php }
}
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? @constant('PHRASE_MUX_NUM')-1+1 - (0) : 0-(@constant('PHRASE_MUX_NUM')-1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
    </div>
<?php }
}
echo $_smarty_tpl->tpl_vars['this']->value->Form->button('登録');?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->Form->end();?>

<div><a href='/admin/chapters/index/<?php echo $_smarty_tpl->tpl_vars['content_id']->value;?>
'>一覧に戻る</a></div><?php }
}
