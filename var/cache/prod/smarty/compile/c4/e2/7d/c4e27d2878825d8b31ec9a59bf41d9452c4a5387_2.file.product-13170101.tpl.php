<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:00
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/miniatures/product-13170101.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be770b308f8_32709743',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c4e27d2878825d8b31ec9a59bf41d9452c4a5387' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/miniatures/product-13170101.tpl',
      1 => 1728949346,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be770b308f8_32709743 (Smarty_Internal_Template $_smarty_tpl) {
?>                <?php echo htmlspecialchars(ce_enqueue_miniature(13170101), ENT_QUOTES, 'UTF-8');?>

        <div data-elementor-type="product-miniature" data-elementor-id="13170101" class="elementor elementor-13170101<?php if (!empty($_smarty_tpl->tpl_vars['productClasses']->value)) {?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productClasses']->value, ENT_QUOTES, 'UTF-8');
}?>">
            <article class="elementor-section-wrap" data-id-product="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product'], ENT_QUOTES, 'UTF-8');?>
" data-id-product-attribute="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], ENT_QUOTES, 'UTF-8');?>
">
                    <section class="elementor-element elementor-element-ebdfb72 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="ebdfb72" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                  <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                <div class="elementor-element elementor-element-f922711 ce-valign-center elementor-column elementor-col-50 elementor-top-column" data-id="f922711" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-2a4d61e elementor-widget elementor-widget-product-miniature-image elementor-widget-image" data-id="2a4d61e" data-element_type="widget" data-widget_type="product-miniature-image.default">
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
                <div class="elementor-element elementor-element-e0d59b3 elementor-absolute ce-product-badges--inline elementor-widget elementor-widget-product-badges elementor-overflow-hidden" data-id="e0d59b3" data-element_type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="product-badges.default">
        <div class="elementor-widget-container">        <div class="ce-product-badges">
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['flags']['discount'])) {?>
                <div class="ce-product-badge ce-product-badge-sale">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['flags']['discount']['label'], ENT_QUOTES, 'UTF-8');?>
                </div>
            <?php }?>
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['flags']['new'])) {?>
                <div class="ce-product-badge ce-product-badge-new">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['flags']['new']['label'], ENT_QUOTES, 'UTF-8');?>
                </div>
            <?php }?>
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['flags']['pack'])) {?>
                <div class="ce-product-badge ce-product-badge-pack">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['flags']['pack']['label'], ENT_QUOTES, 'UTF-8');?>
                </div>
            <?php }?>
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['flags']['out_of_stock'])) {?>
                <div class="ce-product-badge ce-product-badge-out">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['flags']['out_of_stock']['label'], ENT_QUOTES, 'UTF-8');?>
                </div>
            <?php }?>
                    <?php if (!empty($_smarty_tpl->tpl_vars['product']->value['flags']['online-only'])) {?>
                <div class="ce-product-badge ce-product-badge-online">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['flags']['online-only']['label'], ENT_QUOTES, 'UTF-8');?>
                </div>
            <?php }?>
                </div>
        </div>        </div>
                        </div>
            </div>
        </div>
                <div class="elementor-element elementor-element-2772426 ce-valign-center elementor-column elementor-col-50 elementor-top-column" data-id="2772426" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-a32098c elementor-widget elementor-widget-product-miniature-name elementor-widget-heading" data-id="a32098c" data-element_type="widget" data-widget_type="product-miniature-name.default">
        <div class="elementor-widget-container"><h3 class="ce-product-name elementor-heading-title"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a></h3></div>        </div>
                <div class="elementor-element elementor-element-4a0e4aad elementor-star-rating--align-left elementor--star-style-star_fontawesome elementor-widget elementor-widget-product-miniature-rating elementor-widget-star-rating" data-id="4a0e4aad" data-element_type="widget" data-widget_type="product-miniature-rating.default">
        <div class="elementor-widget-container">        <?php $_smarty_tpl->_assignInScope('cb', Context::getContext()->controller->getContainer());?>
        <?php if ($_smarty_tpl->tpl_vars['cb']->value->has('product_comment_repository')) {?>
            <?php $_smarty_tpl->_assignInScope('pcr', $_smarty_tpl->tpl_vars['cb']->value->get('product_comment_repository'));?>
            <?php $_smarty_tpl->_assignInScope('pcm', Configuration::get('PRODUCT_COMMENTS_MODERATE'));?>
            <?php $_smarty_tpl->_assignInScope('nb_comments', _q_c_($_smarty_tpl->tpl_vars['pcr']->value,intval($_smarty_tpl->tpl_vars['pcr']->value->getCommentsNumber($_smarty_tpl->tpl_vars['product']->value['id'],$_smarty_tpl->tpl_vars['pcm']->value)),0));?>
            <?php if ($_smarty_tpl->tpl_vars['pcr']->value) {?>            <?php $_smarty_tpl->_assignInScope('average_grade', Tools::ps_round($_smarty_tpl->tpl_vars['pcr']->value->getAverageGrade($_smarty_tpl->tpl_vars['product']->value['id'],$_smarty_tpl->tpl_vars['pcm']->value),1));?>
            <div class="ce-product-rating">
                        <div class="elementor-star-rating__wrapper">
                        <div class="elementor-star-rating" title="5/5">        <?php $_smarty_tpl->_assignInScope('floored_rating', intval($_smarty_tpl->tpl_vars['average_grade']->value));?>
        <?php
$_smarty_tpl->tpl_vars['stars'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['stars']->step = 1;$_smarty_tpl->tpl_vars['stars']->total = (int) ceil(($_smarty_tpl->tpl_vars['stars']->step > 0 ? 5+1 - (1) : 1-(5)+1)/abs($_smarty_tpl->tpl_vars['stars']->step));
if ($_smarty_tpl->tpl_vars['stars']->total > 0) {
for ($_smarty_tpl->tpl_vars['stars']->value = 1, $_smarty_tpl->tpl_vars['stars']->iteration = 1;$_smarty_tpl->tpl_vars['stars']->iteration <= $_smarty_tpl->tpl_vars['stars']->total;$_smarty_tpl->tpl_vars['stars']->value += $_smarty_tpl->tpl_vars['stars']->step, $_smarty_tpl->tpl_vars['stars']->iteration++) {
$_smarty_tpl->tpl_vars['stars']->first = $_smarty_tpl->tpl_vars['stars']->iteration === 1;$_smarty_tpl->tpl_vars['stars']->last = $_smarty_tpl->tpl_vars['stars']->iteration === $_smarty_tpl->tpl_vars['stars']->total;?>
            <?php if ($_smarty_tpl->tpl_vars['stars']->value <= $_smarty_tpl->tpl_vars['floored_rating']->value) {?>
                <i class="elementor-star-full">&#xF005;</i>
            <?php } elseif ($_smarty_tpl->tpl_vars['floored_rating']->value+1 === $_smarty_tpl->tpl_vars['stars']->value) {?>
                <i class="elementor-star-<?php echo htmlspecialchars(10*($_smarty_tpl->tpl_vars['average_grade']->value-$_smarty_tpl->tpl_vars['floored_rating']->value), ENT_QUOTES, 'UTF-8');?>
">&#xF005;</i>
            <?php } else { ?>
                <i class="elementor-star-empty">&#xF005;</i>
            <?php }?>
        <?php }
}
?>
         <span class="elementor-screen-only">5/5</span></div>        </div>
                    <?php if ($_smarty_tpl->tpl_vars['nb_comments']->value) {?>
                            <span class="ce-product-rating__average-grade"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['average_grade']->value, ENT_QUOTES, 'UTF-8');?>
</span>
            
                        <?php }?>
            </div>
            <?php }?>        <?php }?>
        </div>        </div>
                <div class="elementor-element elementor-element-5e4e454 ce-product-prices--layout-stacked elementor-widget elementor-widget-product-miniature-price elementor-overflow-hidden elementor-widget-product-price" data-id="5e4e454" data-element_type="widget" data-widget_type="product-miniature-price.default">
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
                <div class="elementor-element elementor-element-a9797d0 elementor-widget__width-auto elementor-widget elementor-widget-product-miniature-add-to-cart elementor-widget-button" data-id="a9797d0" data-element_type="widget" data-widget_type="product-miniature-add-to-cart.default">
        <div class="elementor-widget-container"><?php if ($_smarty_tpl->tpl_vars['product']->value['available_for_order']) {?>        <div class="elementor-button-wrapper">
            <a <?php if ($_smarty_tpl->tpl_vars['product']->value['add_to_cart_url']) {?>href="#ce-action=addToCart<?php if ($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'] > 1) {?>&amp;qty=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');
}?>"<?php }?> class="elementor-button elementor-size-sm" role="button">
                <span class="elementor-button-content-wrapper">
                            <span class="elementor-button-icon elementor-align-icon-left">
            <i class="" aria-hidden="true"></i>
        </span>
                                            <span class="elementor-button-text">Add to Cart</span>
                                </span>
            </a>
        </div>
        <?php }?></div>        </div>
                <div class="elementor-element elementor-element-a6d204b elementor-widget__width-auto elementor-view-default elementor-widget elementor-widget-product-add-to-wishlist elementor-widget-icon" data-id="a6d204b" data-element_type="widget" data-widget_type="product-add-to-wishlist.default">
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
$_prefixVariable11 = ob_get_clean();
$_tmp_array = isset($_smarty_tpl->tpl_vars['js_custom_vars']) ? $_smarty_tpl->tpl_vars['js_custom_vars']->value : array();
if (!(is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess)) {
settype($_tmp_array, 'array');
}
$_tmp_array['blockwishlistController'] = $_prefixVariable11;
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
