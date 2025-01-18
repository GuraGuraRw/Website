<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:39
  from '/home/xbxgxbq/www/modules/crisp/views/templates/hook/crisp.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d3385af3_12667607',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dad1b47a121bc6dc2d5e65663a286e8cdd72637d' => 
    array (
      0 => '/home/xbxgxbq/www/modules/crisp/views/templates/hook/crisp.tpl',
      1 => 1737219184,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d3385af3_12667607 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type='text/javascript'>
  window.CRISP_PLUGIN_URL = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_plugin_url']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";
  window.CRISP_WEBSITE_ID = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_website_id']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";

  if ("<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_chatbox_disabled']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" !== "1") {
    if ("<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_customer']->value->isLogged(),'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" === "1") {
      CRISP_CUSTOMER = {
        id:  <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['crisp_customer']->value->id ? $_smarty_tpl->tpl_vars['crisp_customer']->value->id : 'null', ENT_QUOTES, 'UTF-8');?>
,
        logged_in: true,
        full_name: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_customer']->value->firstname,'javascript','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['crisp_customer']->value->lastname, ENT_QUOTES, 'UTF-8');?>
",
        email: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_customer']->value->email,'javascript','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
        address: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_customer_address']->value,'javascript','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
        phone: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['crisp_customer_phone']->value,'javascript','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
      }
    }

    <?php if (count(json_decode($_smarty_tpl->tpl_vars['productsData']->value)) > 0) {?>
      CRISP_CART = {
        id: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cartId']->value ? $_smarty_tpl->tpl_vars['cartId']->value : 'null', ENT_QUOTES, 'UTF-8');?>
,
        currency_id: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currencyId']->value ? $_smarty_tpl->tpl_vars['currencyId']->value : 'null', ENT_QUOTES, 'UTF-8');?>
,
        products: JSON.parse('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productsData']->value, ENT_QUOTES, 'UTF-8');?>
'.replace(/&quot;/g,'"'))
      }
    <?php }?>
  }
<?php echo '</script'; ?>
>
<?php }
}
