<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:40
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d4c797d0_61658638',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '187db3e5d2af704b7784bf6e754cc92ef3a24416' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/index.tpl',
      1 => 1722969778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d4c797d0_61658638 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
if ((isset($_smarty_tpl->tpl_vars['CE_PAGE_INDEX']->value))) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', $_smarty_tpl->tpl_vars['layout']->value);
} elseif (file_exists(((string)(defined('_PS_THEME_DIR_') ? constant('_PS_THEME_DIR_') : null))."templates/index.tpl")) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', '[1]index.tpl');
} elseif ((defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null)) {?>
	<?php $_smarty_tpl->_assignInScope('ce_layout', 'parent:index.tpl');
}?>



<?php if ((isset($_smarty_tpl->tpl_vars['CE_PAGE_INDEX']->value))) {?>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_745236456678be7d4c77dc0_91539759', _q_c_('alysum' === (defined('_THEME_NAME_') ? constant('_THEME_NAME_') : null) || 'alysum' === (defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null),'main','content'));
?>

<?php }
$_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['ce_layout']->value);
}
/* {block _q_c_('alysum' === (defined('_THEME_NAME_') ? constant('_THEME_NAME_') : null) || 'alysum' === (defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null),'main','content')} */
class Block_745236456678be7d4c77dc0_91539759 extends Smarty_Internal_Block
{
public $subBlocks = array (
  '_q_c_(\'alysum\' === (defined(\'_THEME_NAME_\') ? constant(\'_THEME_NAME_\') : null) || \'alysum\' === (defined(\'_PARENT_THEME_NAME_\') ? constant(\'_PARENT_THEME_NAME_\') : null),\'main\',\'content\')' => 
  array (
    0 => 'Block_745236456678be7d4c77dc0_91539759',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<section id="content"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'cefilter' ][ 0 ], array( $_smarty_tpl->tpl_vars['CE_PAGE_INDEX']->value )), ENT_QUOTES, 'UTF-8');?>
</section>
	<?php
}
}
/* {/block _q_c_('alysum' === (defined('_THEME_NAME_') ? constant('_THEME_NAME_') : null) || 'alysum' === (defined('_PARENT_THEME_NAME_') ? constant('_PARENT_THEME_NAME_') : null),'main','content')} */
}
