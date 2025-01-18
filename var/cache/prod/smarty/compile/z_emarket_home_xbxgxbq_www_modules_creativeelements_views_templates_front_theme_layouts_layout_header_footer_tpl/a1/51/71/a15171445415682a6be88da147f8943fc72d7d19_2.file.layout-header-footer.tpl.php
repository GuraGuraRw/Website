<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:40
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/layouts/layout-header-footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d4c9e354_13088088',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a15171445415682a6be88da147f8943fc72d7d19' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/layouts/layout-header-footer.tpl',
      1 => 1722969778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:[1]_partials/helpers.tpl' => 1,
    'parent:_partials/helpers.tpl' => 1,
    'file:_partials/head.tpl' => 1,
    'file:catalog/_partials/product-activation.tpl' => 1,
    'file:_partials/header.tpl' => 1,
    'file:_partials/notifications.tpl' => 1,
    'file:_partials/footer.tpl' => 1,
    'file:_partials/javascript.tpl' => 1,
  ),
),false)) {
function content_678be7d4c9e354_13088088 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
if (file_exists(((string)(defined('_PS_THEME_DIR_') ? constant('_PS_THEME_DIR_') : null))."templates/_partials/helpers.tpl")) {?>
	<?php $_smarty_tpl->_subTemplateRender('file:[1]_partials/helpers.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
} elseif ((defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null) && file_exists(((string)(defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null))."templates/_partials/helpers.tpl")) {?>
	<?php $_smarty_tpl->_subTemplateRender('parent:_partials/helpers.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
<!doctype html>
<html lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8');?>
">
<head>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1712348060678be7d4c914d0_63756402', 'head');
?>

</head>
<body id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value['page_name'], ENT_QUOTES, 'UTF-8');?>
" class="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'classnames' ][ 0 ], array( $_smarty_tpl->tpl_vars['page']->value['body_classes'] )), ENT_QUOTES, 'UTF-8');?>
">
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_824596711678be7d4c93fc8_21527946', 'hook_after_body_opening_tag');
?>

	<main>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1568826568678be7d4c95395_65924506', 'product_activation');
?>

		<header id="header">
			<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_898910613678be7d4c96835_12525940', 'header');
?>

		</header>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_247488826678be7d4c97ba8_88190465', 'notifications');
?>

		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_698881311678be7d4c991b0_83356584', "content");
?>

		<footer id="footer">
			<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_270872023678be7d4c99f15_40025939', "footer");
?>

		</footer>
	</main>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1501980316678be7d4c9b3e2_49716782', 'javascript_bottom');
?>

	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_543602296678be7d4c9ce94_23301819', 'hook_before_body_closing_tag');
?>

</body>
</html><?php }
/* {block 'head'} */
class Block_1712348060678be7d4c914d0_63756402 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_1712348060678be7d4c914d0_63756402',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php $_smarty_tpl->_subTemplateRender('file:_partials/head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	<?php
}
}
/* {/block 'head'} */
/* {block 'hook_after_body_opening_tag'} */
class Block_824596711678be7d4c93fc8_21527946 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_after_body_opening_tag' => 
  array (
    0 => 'Block_824596711678be7d4c93fc8_21527946',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAfterBodyOpeningTag'),$_smarty_tpl ) );?>

	<?php
}
}
/* {/block 'hook_after_body_opening_tag'} */
/* {block 'product_activation'} */
class Block_1568826568678be7d4c95395_65924506 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_activation' => 
  array (
    0 => 'Block_1568826568678be7d4c95395_65924506',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<?php $_smarty_tpl->_subTemplateRender('file:catalog/_partials/product-activation.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		<?php
}
}
/* {/block 'product_activation'} */
/* {block 'header'} */
class Block_898910613678be7d4c96835_12525940 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header' => 
  array (
    0 => 'Block_898910613678be7d4c96835_12525940',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

				<?php $_smarty_tpl->_subTemplateRender('file:_partials/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php
}
}
/* {/block 'header'} */
/* {block 'notifications'} */
class Block_247488826678be7d4c97ba8_88190465 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'notifications' => 
  array (
    0 => 'Block_247488826678be7d4c97ba8_88190465',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<?php $_smarty_tpl->_subTemplateRender('file:_partials/notifications.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
		<?php
}
}
/* {/block 'notifications'} */
/* {block "content"} */
class Block_698881311678be7d4c991b0_83356584 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_698881311678be7d4c991b0_83356584',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "content"} */
/* {block "footer"} */
class Block_270872023678be7d4c99f15_40025939 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'footer' => 
  array (
    0 => 'Block_270872023678be7d4c99f15_40025939',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

				<?php $_smarty_tpl->_subTemplateRender("file:_partials/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
			<?php
}
}
/* {/block "footer"} */
/* {block 'javascript_bottom'} */
class Block_1501980316678be7d4c9b3e2_49716782 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript_bottom' => 
  array (
    0 => 'Block_1501980316678be7d4c9b3e2_49716782',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php $_smarty_tpl->_subTemplateRender("file:_partials/javascript.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('javascript'=>$_smarty_tpl->tpl_vars['javascript']->value['bottom']), 0, false);
?>
	<?php
}
}
/* {/block 'javascript_bottom'} */
/* {block 'hook_before_body_closing_tag'} */
class Block_543602296678be7d4c9ce94_23301819 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_before_body_closing_tag' => 
  array (
    0 => 'Block_543602296678be7d4c9ce94_23301819',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayBeforeBodyClosingTag'),$_smarty_tpl ) );?>

	<?php
}
}
/* {/block 'hook_before_body_closing_tag'} */
}
