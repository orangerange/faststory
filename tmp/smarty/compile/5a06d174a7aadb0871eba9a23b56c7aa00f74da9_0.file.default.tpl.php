<?php
/* Smarty version 3.1.32, created on 2019-05-03 11:11:50
  from '/vagrant/src/Template/Layout/default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5ccc21f60a19b4_91628426',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a06d174a7aadb0871eba9a23b56c7aa00f74da9' => 
    array (
      0 => '/vagrant/src/Template/Layout/default.tpl',
      1 => 1535881092,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ccc21f60a19b4_91628426 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta name="description" content="">
        <meta name="keywords" content="" />
        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->script('jquery-1.8.3');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->css('faststory');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Fetch('script');?>

        <title></title>
    </head>
    <body>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('content');?>

    </body>
</html><?php }
}
