<?php
/* Smarty version 3.1.32, created on 2020-01-12 16:14:21
  from '/vagrant/src/Template/Layout/default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5e1b45dd140369_35806323',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a06d174a7aadb0871eba9a23b56c7aa00f74da9' => 
    array (
      0 => '/vagrant/src/Template/Layout/default.tpl',
      1 => 1577937574,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e1b45dd140369_35806323 (Smarty_Internal_Template $_smarty_tpl) {
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
        <?php echo $_smarty_tpl->tpl_vars['this']->value->Display->baseClassCss();?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->css('display');?>

        <title></title>
    </head>
    <body>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('content');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->script('vue');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Fetch('script');?>

    </body>
</html><?php }
}
