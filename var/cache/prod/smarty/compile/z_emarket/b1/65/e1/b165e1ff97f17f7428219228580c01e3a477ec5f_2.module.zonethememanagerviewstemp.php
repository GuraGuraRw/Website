<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:04
  from 'module:zonethememanagerviewstemp' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be77448a828_94274683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b165e1ff97f17f7428219228580c01e3a477ec5f' => 
    array (
      0 => 'module:zonethememanagerviewstemp',
      1 => 1716929805,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'module:zonethememanager/views/templates/front/sub_category_tree.tpl' => 1,
  ),
),false)) {
function content_678be77448a828_94274683 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['sidebarMenus']->value) {?>
  <div class="category-tree sidebar-category-tree js-sidebar-categories">
    <ul>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sidebarMenus']->value, 'menu');
$_smarty_tpl->tpl_vars['menu']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->do_else = false;
?>
      <li>
        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['link'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['name'], ENT_QUOTES, 'UTF-8');?>
" data-category-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['id'], ENT_QUOTES, 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['menu']->value['menu_thumb']) {?>class="name-with-icon"<?php }?>><?php if ($_smarty_tpl->tpl_vars['menu']->value['menu_thumb']) {?><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['menu_thumb']['url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['name'], ENT_QUOTES, 'UTF-8');?>
" width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['menu_thumb']['width'], ENT_QUOTES, 'UTF-8');?>
" height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['menu_thumb']['height'], ENT_QUOTES, 'UTF-8');?>
" /><?php }?><span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['menu']->value['name'], ENT_QUOTES, 'UTF-8');?>
</span></a>

        <?php if ((isset($_smarty_tpl->tpl_vars['menu']->value['children'])) && $_smarty_tpl->tpl_vars['menu']->value['children']) {?>
          <?php $_smarty_tpl->_subTemplateRender("module:zonethememanager/views/templates/front/sub_category_tree.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('submenus'=>$_smarty_tpl->tpl_vars['menu']->value['children']), 0, true);
?>
        <?php }?>
      </li>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
  </div>
<?php }
}
}
