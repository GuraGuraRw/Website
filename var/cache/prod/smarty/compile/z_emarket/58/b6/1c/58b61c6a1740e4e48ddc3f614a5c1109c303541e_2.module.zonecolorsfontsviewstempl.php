<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from 'module:zonecolorsfontsviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be771546dd3_82736379',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '58b61c6a1740e4e48ddc3f614a5c1109c303541e' => 
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
function content_678be771546dd3_82736379 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['active_preview']->value) {?>
  <div class="aone-colors-live-preview d-none d-md-block">
    <div class="live-preview-toggle js-previewToggle" data-preview-controller="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['preview_controller']->value, ENT_QUOTES, 'UTF-8');?>
"><i class="fa fa-cog"></i></div>
    <div class="live-preview-container js-previewContainer"></div>
  </div>
<?php }
}
}
