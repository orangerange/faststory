<?php
/* Smarty version 3.1.32, created on 2018-08-02 13:06:12
  from 'C:\sites\faststory\src\Template\Layout\default.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b6301c457d572_22036108',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0c625dc82e9b9a18fb908a2170b656642eebca49' => 
    array (
      0 => 'C:\\sites\\faststory\\src\\Template\\Layout\\default.tpl',
      1 => 1532224954,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b6301c457d572_22036108 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta name="description" content="">
        <meta name="keywords" content="" />
        <?php echo $_smarty_tpl->tpl_vars['this']->value->Html->css('peep');?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->Fetch('script');?>

        <title></title>
    </head>
    <body>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->fetch('content');?>

    </body>
</html><?php }
}
