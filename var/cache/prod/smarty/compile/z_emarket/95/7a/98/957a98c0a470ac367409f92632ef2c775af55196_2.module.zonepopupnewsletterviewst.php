<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from 'module:zonepopupnewsletterviewst' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7715329e7_07243548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '957a98c0a470ac367409f92632ef2c775af55196' => 
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
function content_678be7715329e7_07243548 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['save_time']->value) {?>
  <div class="js-aone-popupnewsletter" data-save-time="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['save_time']->value, ENT_QUOTES, 'UTF-8');?>
" data-modal-newsletter-controller="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ajax_modal_newsletter_controller']->value, ENT_QUOTES, 'UTF-8');?>
"></div>
<?php }?>
<div class="js-popup-newsletter-form" data-ajax-submit-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ajax_subscribe_url']->value, ENT_QUOTES, 'UTF-8');?>
"></div><?php }
}
