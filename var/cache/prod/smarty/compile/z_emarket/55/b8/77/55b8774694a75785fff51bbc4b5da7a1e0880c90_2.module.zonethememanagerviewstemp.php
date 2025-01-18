<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from 'module:zonethememanagerviewstemp' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7715695a9_17116480',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '55b8774694a75785fff51bbc4b5da7a1e0880c90' => 
    array (
      0 => 'module:zonethememanagerviewstemp',
      1 => 1716929805,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7715695a9_17116480 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['cookieMessage']->value) {?>
  <div id="cookieMessage" class="cookie-message js-cookieMessage">
    <div class="cookie-message-wrapper">
      <div class="cookie-message-content">
        <?php echo $_smarty_tpl->tpl_vars['cookieMessage']->value;?>

      </div>
      <a class="cookie-close-button btn js-cookieCloseButton"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Accept','d'=>'Shop.Zonetheme'),$_smarty_tpl ) );?>
</a>
    </div>
  </div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['enableScrollTop']->value) {?>
  <div id="scrollTopButton" data-scroll-to-top>
    <a class="scroll-button" href="#scroll-to-top" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Back to Top','d'=>'Shop.Zonetheme'),$_smarty_tpl ) );?>
" data-toggle="tooltip" data-placement="top"><i class="fa fa-angle-double-up"></i></a>
  </div>
<?php }
}
}
