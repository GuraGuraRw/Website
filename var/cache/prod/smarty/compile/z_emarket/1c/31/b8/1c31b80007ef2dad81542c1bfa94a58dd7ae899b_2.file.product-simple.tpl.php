<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:39
  from '/home/xbxgxbq/www/themes/z_emarket/templates/catalog/_partials/miniatures/product-simple.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d3705881_93171789',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c31b80007ef2dad81542c1bfa94a58dd7ae899b' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/catalog/_partials/miniatures/product-simple.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/_product_thumbnail.tpl' => 1,
  ),
),false)) {
function content_678be7d3705881_93171789 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1475030168678be7d36fda76_54858459', 'product_miniature_item');
}
/* {block 'product_name'} */
class Block_574588572678be7d36ff656_07968044 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <p class="product-name" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a></p>
    <?php
}
}
/* {/block 'product_name'} */
/* {block 'product_price_and_shipping'} */
class Block_1681219232678be7d3701dd1_90820573 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
        <div class="product-price-and-shipping d-flex flex-wrap justify-content-center align-items-center">
          <span class="price product-price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');?>
</span>
          <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?><span class="regular-price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['regular_price'], ENT_QUOTES, 'UTF-8');?>
</span><?php }?>
        </div>
      <?php }?>
    <?php
}
}
/* {/block 'product_price_and_shipping'} */
/* {block 'product_miniature_item'} */
class Block_1475030168678be7d36fda76_54858459 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_miniature_item' => 
  array (
    0 => 'Block_1475030168678be7d36fda76_54858459',
  ),
  'product_name' => 
  array (
    0 => 'Block_574588572678be7d36ff656_07968044',
  ),
  'product_price_and_shipping' => 
  array (
    0 => 'Block_1681219232678be7d3701dd1_90820573',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<article class="product-miniature" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
">
  <div class="product-container product-style pg-onp">
    <div class="first-block">
      <?php $_smarty_tpl->_subTemplateRender('file:catalog/_partials/miniatures/_product_thumbnail.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    </div>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_574588572678be7d36ff656_07968044', 'product_name', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1681219232678be7d3701dd1_90820573', 'product_price_and_shipping', $this->tplIndex);
?>

  </div>
</article>
<?php
}
}
/* {/block 'product_miniature_item'} */
}
