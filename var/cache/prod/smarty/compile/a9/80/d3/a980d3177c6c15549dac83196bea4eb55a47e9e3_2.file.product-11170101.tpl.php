<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:40
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/miniatures/product-11170101.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d42c0da6_88782268',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a980d3177c6c15549dac83196bea4eb55a47e9e3' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/miniatures/product-11170101.tpl',
      1 => 1728757610,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d42c0da6_88782268 (Smarty_Internal_Template $_smarty_tpl) {
?>                <?php echo htmlspecialchars(ce_enqueue_miniature(11170101), ENT_QUOTES, 'UTF-8');?>

        <div data-elementor-type="product-miniature" data-elementor-id="11170101" class="elementor elementor-11170101<?php if (!empty($_smarty_tpl->tpl_vars['productClasses']->value)) {?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productClasses']->value, ENT_QUOTES, 'UTF-8');
}?>">
            <article class="elementor-section-wrap" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" data-id-product-attribute="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], ENT_QUOTES, 'UTF-8');?>
">
                    <section class="elementor-element elementor-element-820d0ce elementor-section-full_width elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="820d0ce" data-element_type="section">
                  <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                <div class="elementor-element elementor-element-2d1242b elementor-column elementor-col-100 elementor-top-column" data-id="2d1242b" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-c7cb9fb elementor-widget elementor-widget-product-miniature-image elementor-widget-image" data-id="c7cb9fb" data-element_type="widget" data-widget_type="product-miniature-image.default">
        <div class="elementor-widget-container"><?php if ($_smarty_tpl->tpl_vars['product']->value['cover']) {
$_smarty_tpl->_assignInScope('image', $_smarty_tpl->tpl_vars['product']->value['cover']);
} else {
$_smarty_tpl->_assignInScope('image', call_user_func("CE\Helper::getNoImage"));
}?>        <?php $_smarty_tpl->_assignInScope('caption', '');?>
        <?php $_smarty_tpl->_assignInScope('image_by_size', $_smarty_tpl->tpl_vars['image']->value['bySize']['large_default']);?>
        <?php $_smarty_tpl->_assignInScope('srcset', array(((string)$_smarty_tpl->tpl_vars['image_by_size']->value['url'])." ".((string)$_smarty_tpl->tpl_vars['image_by_size']->value['width'])."w"));?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['image']->value['bySize'], 'img', false, 'size');
$_smarty_tpl->tpl_vars['img']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['size']->value => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->do_else = false;
?>
            <?php if ('large_default' !== $_smarty_tpl->tpl_vars['size']->value) {?>
                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['srcset']) ? $_smarty_tpl->tpl_vars['srcset']->value : array();
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array[] = ((string)$_smarty_tpl->tpl_vars['img']->value['url'])." ".((string)$_smarty_tpl->tpl_vars['img']->value['width'])."w";
$_smarty_tpl->_assignInScope('srcset', $_tmp_array);?>
            <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <div class="ce-product-image elementor-image">
        <?php if ($_smarty_tpl->tpl_vars['caption']->value) {?>
            <figure class="ce-caption">
        <?php }?>
            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
">
                <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_by_size']->value['url'], ENT_QUOTES, 'UTF-8');?>
" srcset="<?php echo htmlspecialchars(implode(', ',$_smarty_tpl->tpl_vars['srcset']->value), ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['caption']->value, ENT_QUOTES, 'UTF-8');?>
" loading="lazy"
                                    width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_by_size']->value['width'], ENT_QUOTES, 'UTF-8');?>
" height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_by_size']->value['height'], ENT_QUOTES, 'UTF-8');?>
"
                    sizes="(max-width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_by_size']->value['width'], ENT_QUOTES, 'UTF-8');?>
px) 100vw, <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_by_size']->value['width'], ENT_QUOTES, 'UTF-8');?>
px">
            </a>
        <?php if ($_smarty_tpl->tpl_vars['caption']->value) {?>
            <figcaption class="widget-image-caption ce-caption-text"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['caption']->value, ENT_QUOTES, 'UTF-8');?>
</figcaption>
            </figure>
        <?php }?>
        </div>
        </div>        </div>
                        </div>
            </div>
        </div>
                        </div>
            </div>
        </section>
                <section class="elementor-element elementor-element-6b39201 my-pro-mini elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="6b39201" data-element_type="section">
                  <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                <div class="elementor-element elementor-element-0d47dd3 elementor-column elementor-col-100 elementor-top-column" data-id="0d47dd3" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-3478069 elementor-widget elementor-widget-product-miniature-name elementor-widget-heading" data-id="3478069" data-element_type="widget" data-widget_type="product-miniature-name.default">
        <div class="elementor-widget-container"><h3 class="ce-product-name elementor-heading-title"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a></h3></div>        </div>
                <div class="elementor-element elementor-element-5a9cbef ce-product-prices--layout-stacked elementor-widget elementor-widget-product-miniature-price elementor-overflow-hidden elementor-widget-product-price" data-id="5a9cbef" data-element_type="widget" data-widget_type="product-miniature-price.default">
        <div class="elementor-widget-container">        <?php if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
            <div class="ce-product-prices">
                    <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'old_price'),$_smarty_tpl ) );?>

                <div class="ce-product-price-regular"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['regular_price'], ENT_QUOTES, 'UTF-8');?>
</div>
            <?php }?>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'before_price'),$_smarty_tpl ) );?>

                <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'ce_price', null);
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'custom_price','hook_origin'=>'products_list'),$_smarty_tpl ) );
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
                <div class="ce-product-price<?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?> ce-has-discount<?php }?>">
                    <span><?php if ($_smarty_tpl->tpl_vars['ce_price']->value) {
echo $_smarty_tpl->tpl_vars['ce_price']->value;
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');
}?></span>
                    <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
                <?php if ('percentage' === $_smarty_tpl->tpl_vars['product']->value['discount_type']) {?>
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-percentage">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save %percentage%','sprintf'=>array('%percentage%'=>$_smarty_tpl->tpl_vars['product']->value['discount_percentage_absolute']),'d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>

                    </span>
                <?php } else { ?>
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-amount">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save %amount%','sprintf'=>array('%amount%'=>$_smarty_tpl->tpl_vars['product']->value['discount_to_display']),'d'=>'Shop.Theme.Catalog'),$_smarty_tpl ) );?>

                    </span>
                <?php }?>
            <?php }?>
                        </div>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'weight'),$_smarty_tpl ) );?>

            </div>
        <?php }?>
        </div>        </div>
                <div class="elementor-element elementor-element-db51891 elementor-view-default elementor-widget elementor-widget-product-add-to-wishlist elementor-widget-icon" data-id="db51891" data-element_type="widget" data-widget_type="product-add-to-wishlist.default">
        <div class="elementor-widget-container">        <?php $_smarty_tpl->_assignInScope('atw_class', 'ce-add-to-wishlist');?>
        <?php $_smarty_tpl->_assignInScope('atw_icon', 'ceicon-heart-o');?>
        <?php if (!(isset($_smarty_tpl->tpl_vars['js_custom_vars']->value['productsAlreadyTagged']))) {?>
            <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['js_custom_vars']) ? $_smarty_tpl->tpl_vars['js_custom_vars']->value : array();
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array['productsAlreadyTagged'] = array();
$_smarty_tpl->_assignInScope('js_custom_vars', $_tmp_array);?>
            <?php ob_start();
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('entity'=>'module','name'=>'blockwishlist','controller'=>'action'),$_smarty_tpl ) );
$_prefixVariable1 = ob_get_clean();
$_tmp_array = isset($_smarty_tpl->tpl_vars['js_custom_vars']) ? $_smarty_tpl->tpl_vars['js_custom_vars']->value : array();
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array['blockwishlistController'] = $_prefixVariable1;
$_smarty_tpl->_assignInScope('js_custom_vars', $_tmp_array);?>
        <?php }?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['js_custom_vars']->value['productsAlreadyTagged'], 'tagged');
$_smarty_tpl->tpl_vars['tagged']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['tagged']->value) {
$_smarty_tpl->tpl_vars['tagged']->do_else = false;
?>
            <?php if ($_smarty_tpl->tpl_vars['tagged']->value['id_product'] == $_smarty_tpl->tpl_vars['product']->value['id'] && $_smarty_tpl->tpl_vars['tagged']->value['id_product_attribute'] == $_smarty_tpl->tpl_vars['product']->value['id_product_attribute']) {?>
                <?php $_smarty_tpl->_assignInScope('atw_icon', 'ceicon-heart');?>
                <?php $_smarty_tpl->_assignInScope('atw_class', 'ce-add-to-wishlist elementor-active');?>
                <?php break 1;?>
            <?php }?>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        <div class="elementor-icon-wrapper">
            <a class="elementor-icon <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['atw_class']->value, ENT_QUOTES, 'UTF-8');?>
" data-product-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
" data-product-attribute-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], ENT_QUOTES, 'UTF-8');?>
" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['js_custom_vars']->value['blockwishlistController'], ENT_QUOTES, 'UTF-8');?>
">
                <i class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['atw_icon']->value, ENT_QUOTES, 'UTF-8');?>
" aria-hidden="true"></i>
            </a>
        </div>
        </div>        </div>
                        </div>
            </div>
        </div>
                        </div>
            </div>
        </section>
                    </article>
        </div>
        <?php }
}
