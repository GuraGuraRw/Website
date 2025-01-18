<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/preload.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7713c8df0_61846417',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b9a73f4bde3682af9c22e6eca6b5d982d41844e2' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/preload.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7713c8df0_61846417 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['stylesheets']->value['external'], 'stylesheet');
$_smarty_tpl->tpl_vars['stylesheet']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['stylesheet']->value) {
$_smarty_tpl->tpl_vars['stylesheet']->do_else = false;
?>
  <?php if (strstr($_smarty_tpl->tpl_vars['stylesheet']->value['uri'],"assets/css/theme.css") || strstr($_smarty_tpl->tpl_vars['stylesheet']->value['uri'],"assets/cache/theme-")) {?>
    <?php $_smarty_tpl->_assignInScope('font_url', $_smarty_tpl->tpl_vars['stylesheet']->value['uri']);?>
    <?php break 1;?>
  <?php }
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php if (!empty($_smarty_tpl->tpl_vars['font_url']->value)) {
$_smarty_tpl->_assignInScope('font_url', (substr($_smarty_tpl->tpl_vars['font_url']->value,0,(strpos($_smarty_tpl->tpl_vars['font_url']->value,"assets")+6))).('/fonts/'));?>
<link rel="preload" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['font_url']->value, ENT_QUOTES, 'UTF-8');?>
fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['font_url']->value, ENT_QUOTES, 'UTF-8');?>
MaterialIcons-Regular.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<?php }
}
}
