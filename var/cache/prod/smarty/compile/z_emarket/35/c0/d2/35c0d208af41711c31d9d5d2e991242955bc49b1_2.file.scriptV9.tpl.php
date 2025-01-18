<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:39
  from '/home/xbxgxbq/www/modules/doofinder/views/templates/front/scriptV9.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d33459d9_78026760',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '35c0d208af41711c31d9d5d2e991242955bc49b1' => 
    array (
      0 => '/home/xbxgxbq/www/modules/doofinder/views/templates/front/scriptV9.tpl',
      1 => 1737216655,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d33459d9_78026760 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['installation_ID']->value)) && $_smarty_tpl->tpl_vars['installation_ID']->value) {?>
  <!-- START OF DOOFINDER ADD TO CART SCRIPT -->
  <?php echo '<script'; ?>
>
    document.addEventListener('doofinder.cart.add', function(event) {

      const checkIfCartItemHasVariation = (cartObject) => {
        return (cartObject.item_id === cartObject.grouping_id) ? false : true;
      }

      /**
      * Returns only ID from string
      */
      const sanitizeVariationID = (variationID) => {
        return variationID.replace(/\D/g, "")
      }

      doofinderManageCart({
        cartURL          : "<?php if ((isset($_smarty_tpl->tpl_vars['urls']->value))) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['urls']->value['pages']['cart'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?>",  //required for prestashop 1.7, in previous versions it will be empty.
        cartToken        : "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['static_token']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
        productID        : checkIfCartItemHasVariation(event.detail) ? event.detail.grouping_id : event.detail.item_id,
        customizationID  : checkIfCartItemHasVariation(event.detail) ? sanitizeVariationID(event.detail.item_id) : 0,   // If there are no combinations, the value will be 0
        quantity         : event.detail.amount,
        statusPromise    : event.detail.statusPromise,
        itemLink         : event.detail.link,
        group_id         : event.detail.group_id
      });
    });
  <?php echo '</script'; ?>
>
  <!-- END OF DOOFINDER ADD TO CART SCRIPT -->

  <!-- START OF DOOFINDER UNIQUE SCRIPT -->
  <?php echo '<script'; ?>
 data-keepinline>
    
    (function(w, k) {w[k] = window[k] || function () { (window[k].q = window[k].q || []).push(arguments) }})(window, "doofinderApp")
    

    // Custom personalization:
    doofinderApp("config", "language", "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['lang']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
");
    doofinderApp("config", "currency", "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['currency']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
");
  <?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="https://<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['df_region']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
-config.doofinder.com/2.x/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['installation_ID']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.js" async><?php echo '</script'; ?>
>
  <!-- END OF DOOFINDER UNIQUE SCRIPT -->
<?php }
}
}
