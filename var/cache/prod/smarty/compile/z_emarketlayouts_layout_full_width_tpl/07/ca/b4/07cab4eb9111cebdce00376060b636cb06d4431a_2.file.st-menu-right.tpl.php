<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/st-menu-right.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be77157ef52_94544473',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '07cab4eb9111cebdce00376060b636cb06d4431a' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/st-menu-right.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be77157ef52_94544473 (Smarty_Internal_Template $_smarty_tpl) {
if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['sidebar_cart']) && $_smarty_tpl->tpl_vars['page']->value['page_name'] != 'cart') {?>
  <div class="st-menu-right st-effect-right" data-st-cart>
    <div class="st-menu-close d-flex" data-close-st-cart><i class="material-icons">close</i></div>
    <div id="js-cart-sidebar" class="sidebar-cart cart-preview js-hidden"></div>
    <div id="js-currency-sidebar" class="sidebar-currency js-hidden"></div>
  </div>
<?php }
}
}
