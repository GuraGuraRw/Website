<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/breadcrumb.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7714cb210_29591139',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1bd98545ab6470c97e954107bb7a59d1ff9c080' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/breadcrumb.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7714cb210_29591139 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<nav class="breadcrumb-wrapper <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['is_mobile'])) {?>mobile-breadcrumb-wrapper<?php }?>">
  <div class="container">
    <ol class="breadcrumb" data-depth="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['breadcrumb']->value['count'], ENT_QUOTES, 'UTF-8');?>
">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['breadcrumb']->value['links'], 'path', false, NULL, 'breadcrumb', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['path']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['path']->value) {
$_smarty_tpl->tpl_vars['path']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['total'];
?>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_842864458678be7714c4682_88690855', 'breadcrumb_item');
?>

      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ol>
  </div>
</nav>
<?php }
/* {block 'breadcrumb_item'} */
class Block_842864458678be7714c4682_88690855 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'breadcrumb_item' => 
  array (
    0 => 'Block_842864458678be7714c4682_88690855',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php if ($_smarty_tpl->tpl_vars['path']->value['url'] && $_smarty_tpl->tpl_vars['path']->value['title']) {?>
            <li class="breadcrumb-item">
              <?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first'] : null)) {?>
                <span class="separator material-icons">chevron_right</span>
              <?php }?>
              <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first'] : null) || !(isset($_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['last'] : null)) {?>
                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value['url'], ENT_QUOTES, 'UTF-8');?>
" class="item-name">
                  <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_breadcrumb']->value['first'] : null)) {?>
                    <i class="fa fa-home home" aria-hidden="true"></i>
                  <?php }?>
                    <span><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value['title'], ENT_QUOTES, 'UTF-8');?>
</span>
                </a>
              <?php } else { ?>
                <span class="item-name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value['title'], ENT_QUOTES, 'UTF-8');?>
</span>
              <?php }?>
            </li>
          <?php }?>
        <?php
}
}
/* {/block 'breadcrumb_item'} */
}
