<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:39
  from 'module:zonecolorsfontsviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d33c35f1_73651632',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4b9a3bbde203959a444e1b320092f8eb012e792' => 
    array (
      0 => 'module:zonecolorsfontsviewstempl',
      1 => 1716929805,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d33c35f1_73651632 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['styleLink']->value) {
echo $_smarty_tpl->tpl_vars['styleLink']->value;
}?>

<?php if ($_smarty_tpl->tpl_vars['colorStyle']->value) {?>
<style type="text/css"><?php echo $_smarty_tpl->tpl_vars['colorStyle']->value;?>
</style>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['zoneCustomCSS']->value) {?>
<style type="text/css"><?php echo $_smarty_tpl->tpl_vars['zoneCustomCSS']->value;?>
</style>
<?php }
}
}
