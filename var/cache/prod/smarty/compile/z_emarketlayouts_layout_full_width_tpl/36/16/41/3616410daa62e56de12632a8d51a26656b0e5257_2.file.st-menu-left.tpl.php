<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/st-menu-left.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7714763e5_01539412',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3616410daa62e56de12632a8d51a26656b0e5257' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/st-menu-left.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7714763e5_01539412 (Smarty_Internal_Template $_smarty_tpl) {
if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['sidebar_navigation'])) {?>
  <div class="st-menu st-effect-left" data-st-menu>
    <div class="st-menu-close d-flex" data-close-st-menu><i class="material-icons">close</i></div>
    <div class="st-menu-title h4">
      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Menu','d'=>'Shop.Zonetheme'),$_smarty_tpl ) );?>

    </div>

    <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['mobile_megamenu'])) {?>
      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayMobileMenu'),$_smarty_tpl ) );?>

    <?php } else { ?>
      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displaySidebarNavigation'),$_smarty_tpl ) );?>

    <?php }?>

    <div id="js-header-phone-sidebar" class="sidebar-header-phone js-hidden"></div>
    <div id="js-account-sidebar" class="sidebar-account text-center user-info js-hidden"></div>
    <div id="js-language-sidebar" class="sidebar-language js-hidden"></div>
    <div id="js-left-currency-sidebar" class="sidebar-currency js-hidden"></div>
  </div>
<?php }
}
}
