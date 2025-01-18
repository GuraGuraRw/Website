<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:04
  from 'module:zonepopupnewsletterviewst' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7749e3be6_19984397',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb12566cccd6fb4a92dfcc0effa8ae2938ea2f12' => 
    array (
      0 => 'module:zonepopupnewsletterviewst',
      1 => 1716929805,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7749e3be6_19984397 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="aone-popup-newsletter-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-hidepopup-time="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['cookie_time']->value), ENT_QUOTES, 'UTF-8');?>
">
  <div class="modal-dialog" role="document" style="max-width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['width']->value+16, ENT_QUOTES, 'UTF-8');?>
px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="aone-popupnewsletter" style="min-height:<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['height']->value), ENT_QUOTES, 'UTF-8');?>
px;">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="material-icons">close</i>
          </button>

          <div class="popup-background" style="background-color:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bg_color']->value, ENT_QUOTES, 'UTF-8');?>
; background-image:url('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bg_image']->value, ENT_QUOTES, 'UTF-8');?>
');"></div>
          <div class="popup-content">
            <div class="clearfix newsletter-content">
              <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

            </div>
            <div class="ps-email-subscription-module js-popupemailsubscription">
              <?php echo $_smarty_tpl->tpl_vars['subscribe_form']->value;?>

            </div>
          </div>
          <div class="noshow">
            <a href="#no-thanks" class="js-newsletter-nothanks" rel="nofollow"><i class="fa fa-minus-circle"></i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Do not show this popup again.','d'=>'Shop.Zonetheme'),$_smarty_tpl ) );?>
</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php }
}
