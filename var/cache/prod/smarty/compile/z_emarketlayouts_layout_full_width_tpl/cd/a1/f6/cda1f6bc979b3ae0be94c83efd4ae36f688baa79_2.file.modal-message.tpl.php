<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/modal-message.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be771592a71_01731379',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cda1f6bc979b3ae0be94c83efd4ae36f688baa79' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/modal-message.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be771592a71_01731379 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="modalMessage" class="modal fade modal-message js-modal-message" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-bs-dismiss="modal" aria-label="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
      <div class="alert alert-danger mb-0" role="alert">
        <i class="material-icons">error_outline</i> <span class="js-modal-message-text"></span>
      </div>
    </div>
  </div>
  </div>
</div>

<div class="modal fade simple-modal" id="extraModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="extra-content typo js-modal-extra-content"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade simple-modal js-checkout-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body js-modal-content"></div>
    </div>
  </div>
</div>
<?php }
}
