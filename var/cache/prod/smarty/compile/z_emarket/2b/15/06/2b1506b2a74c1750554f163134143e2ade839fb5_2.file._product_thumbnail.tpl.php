<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:39
  from '/home/xbxgxbq/www/themes/z_emarket/templates/catalog/_partials/miniatures/_product_thumbnail.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d3738493_72749384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b1506b2a74c1750554f163134143e2ade839fb5' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/catalog/_partials/miniatures/_product_thumbnail.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d3738493_72749384 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="product-thumbnail">
  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" class="product-cover-link">
    <?php if ($_smarty_tpl->tpl_vars['product']->value['cover']) {?>
      <?php $_smarty_tpl->_assignInScope('thumbnail', $_smarty_tpl->tpl_vars['product']->value['cover']['bySize']['home_default']);?>

      <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['lazy_loading'])) {?>
        <img
          src       = "data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['width'], ENT_QUOTES, 'UTF-8');?>
%20<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['height'], ENT_QUOTES, 'UTF-8');?>
%22%3E%3C/svg%3E"
          data-original = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['url'], ENT_QUOTES, 'UTF-8');?>
"
          alt       = "<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['product']->value['cover']['legend'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['product']->value['name'] : $tmp), ENT_QUOTES, 'UTF-8');?>
"
          title     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
          class     = "img-fluid js-lazy"
          width     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['width'], ENT_QUOTES, 'UTF-8');?>
"
          height    = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['height'], ENT_QUOTES, 'UTF-8');?>
"
        >
      <?php } else { ?>
        <img
          src       = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['url'], ENT_QUOTES, 'UTF-8');?>
"
          alt       = "<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['product']->value['cover']['legend'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['product']->value['name'] : $tmp), ENT_QUOTES, 'UTF-8');?>
"
          class     = "img-fluid"
          title     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
          width     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['width'], ENT_QUOTES, 'UTF-8');?>
"
          height    = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['thumbnail']->value['height'], ENT_QUOTES, 'UTF-8');?>
"
        >
      <?php }?>
    <?php } else { ?>
      <img
        src       = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['no_picture_image']['medium']['url'], ENT_QUOTES, 'UTF-8');?>
"
        class     = "img-fluid"
        alt       = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
        title     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
        width     = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['no_picture_image']['medium']['width'], ENT_QUOTES, 'UTF-8');?>
"
        height    = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['no_picture_image']['medium']['height'], ENT_QUOTES, 'UTF-8');?>
"
      >
    <?php }?>
  </a>
</div>
<?php }
}
