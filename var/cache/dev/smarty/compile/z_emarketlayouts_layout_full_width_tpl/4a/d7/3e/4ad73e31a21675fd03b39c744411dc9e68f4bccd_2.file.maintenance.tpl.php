<?php
/* Smarty version 3.1.43, created on 2025-01-18 17:22:42
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/errors/maintenance.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678bd55246f477_99360289',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ad73e31a21675fd03b39c744411dc9e68f4bccd' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/errors/maintenance.tpl',
      1 => 1722969778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678bd55246f477_99360289 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('lang', Context::getContext()->language);?>
<!doctype html>
<html lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value->iso_code, ENT_QUOTES, 'UTF-8');?>
">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
<?php if ((isset($_smarty_tpl->tpl_vars['ce_content']->value))) {?>
	<title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ce_content']->value->title, ENT_QUOTES, 'UTF-8');?>
</title><?php $_smarty_tpl->_assignInScope('content', preg_replace('!\s+!u', ' ',trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['ce_content']->value->content))));?>
	<meta name="description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['content']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php }?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!empty($_smarty_tpl->tpl_vars['favicon']->value)) {?>
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo htmlspecialchars((defined('_PS_IMG_') ? constant('_PS_IMG_') : null), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['favicon']->value, ENT_QUOTES, 'UTF-8');?>
?<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['favicon_update_time']->value, ENT_QUOTES, 'UTF-8');?>
">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo htmlspecialchars((defined('_PS_IMG_') ? constant('_PS_IMG_') : null), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['favicon']->value, ENT_QUOTES, 'UTF-8');?>
?<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['favicon_update_time']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php }?>
	<style>
	html, body { margin: 0; padding: 0; }
	</style>
	<?php echo '<script'; ?>
>
	var baseDir = <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'cefilter' ][ 0 ], array( json_encode((defined('__PS_BASE_URI__') ? constant('__PS_BASE_URI__') : null)) )), ENT_QUOTES, 'UTF-8');?>
;
	<?php echo '</script'; ?>
>
	<!--CE-JS-->
</head>
<body id="maintenance" class="<?php if ($_smarty_tpl->tpl_vars['lang']->value->is_rtl) {?>lang-rtl <?php }?>lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lang']->value->iso_code, ENT_QUOTES, 'UTF-8');?>
 page-maintenance">
	<main>
		<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'cefilter' ][ 0 ], array( $_smarty_tpl->tpl_vars['HOOK_MAINTENANCE']->value )), ENT_QUOTES, 'UTF-8');?>

	</main>
	<!--CE-JS-->
</body>
</html><?php }
}
