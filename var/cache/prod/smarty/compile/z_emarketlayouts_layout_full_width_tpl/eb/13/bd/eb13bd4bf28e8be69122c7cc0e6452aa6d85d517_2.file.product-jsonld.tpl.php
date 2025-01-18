<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/microdata/product-jsonld.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be771458ca5_94972928',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb13bd4bf28e8be69122c7cc0e6452aa6d85d517' => 
    array (
      0 => '/home/xbxgxbq/www/modules/creativeelements/views/templates/front/theme/catalog/_partials/microdata/product-jsonld.tpl',
      1 => 1722969778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be771458ca5_94972928 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('hasAggregateRating', false);
if (!empty($_smarty_tpl->tpl_vars['product']->value['productComments']['averageRating']) && !empty($_smarty_tpl->tpl_vars['product']->value['productComments']['nbComments'])) {?>
	<?php $_smarty_tpl->_assignInScope('hasAggregateRating', true);?>
	<?php $_smarty_tpl->_assignInScope('ratingValue', $_smarty_tpl->tpl_vars['product']->value['productComments']['averageRating']);?>
	<?php $_smarty_tpl->_assignInScope('ratingReviewCount', $_smarty_tpl->tpl_vars['product']->value['productComments']['nbComments']);
} elseif (!empty($_smarty_tpl->tpl_vars['ratings']->value['avg']) && !empty($_smarty_tpl->tpl_vars['nbComments']->value)) {?>
	<?php $_smarty_tpl->_assignInScope('hasAggregateRating', true);?>
	<?php $_smarty_tpl->_assignInScope('ratingValue', $_smarty_tpl->tpl_vars['ratings']->value['avg']);?>
	<?php $_smarty_tpl->_assignInScope('ratingReviewCount', $_smarty_tpl->tpl_vars['nbComments']->value);
}
echo '<script'; ?>
 type="application/ld+json">
{
	"@context": "https://schema.org/",
	"@type": "Product",
	"name": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
",
	"description": "<?php echo htmlspecialchars(str_replace(array("\r\n","\n"),' ',$_smarty_tpl->tpl_vars['page']->value['meta']['description']), ENT_QUOTES, 'UTF-8');?>
",
	"category": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['category_name'], ENT_QUOTES, 'UTF-8');?>
",
<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['cover'])) {?>
	"image" :"<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['bySize']['home_default']['url'], ENT_QUOTES, 'UTF-8');?>
",
<?php }?>
	"sku": "<?php if ($_smarty_tpl->tpl_vars['product']->value['reference']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['reference'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');
}?>",
	"mpn": "<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['mpn'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['mpn'], ENT_QUOTES, 'UTF-8');
} elseif ($_smarty_tpl->tpl_vars['product']->value['reference']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['reference'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');
}?>",
<?php if ($_smarty_tpl->tpl_vars['product']->value['ean13']) {?>
	"gtin13": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['ean13'], ENT_QUOTES, 'UTF-8');?>
",
<?php } elseif ($_smarty_tpl->tpl_vars['product']->value['upc']) {?>
	"gtin13": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['upc'], ENT_QUOTES, 'UTF-8');?>
",
<?php }
if ($_smarty_tpl->tpl_vars['product_manufacturer']->value->name || $_smarty_tpl->tpl_vars['shop']->value['name']) {?>
	"brand": {
		"@type": "Brand",
		"name": "<?php if ($_smarty_tpl->tpl_vars['product_manufacturer']->value->name) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product_manufacturer']->value->name, ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');
}?>"
	},
<?php }
if ($_smarty_tpl->tpl_vars['hasAggregateRating']->value) {?>
	"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['ratingValue']->value,1), ENT_QUOTES, 'UTF-8');?>
",
		"reviewCount": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ratingReviewCount']->value, ENT_QUOTES, 'UTF-8');?>
"
	},
<?php }
if (!empty($_smarty_tpl->tpl_vars['product']->value['weight'])) {?>
	"weight": {
			"@context": "https://schema.org",
			"@type": "QuantitativeValue",
			"value": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['weight'], ENT_QUOTES, 'UTF-8');?>
",
			"unitCode": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['weight_unit'], ENT_QUOTES, 'UTF-8');?>
"
	},
<?php }
if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
	"offers": {
		"@type": "Offer",
		"priceCurrency": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value['iso_code'], ENT_QUOTES, 'UTF-8');?>
",
		"name": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
",
		"price": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price_amount'], ENT_QUOTES, 'UTF-8');?>
",
		"url": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
",
		"priceValidUntil": "<?php echo htmlspecialchars(date('Y-m-d',3600*24*15+time()), ENT_QUOTES, 'UTF-8');?>
",
	<?php if ($_smarty_tpl->tpl_vars['product']->value['images']) {?>
		"image": [<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product']->value['images'], 'p_img', false, NULL, 'p_img_list', array (
  'last' => true,
  'iteration' => true,
  'total' => true,
));
$_smarty_tpl->tpl_vars['p_img']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['p_img']->value) {
$_smarty_tpl->tpl_vars['p_img']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['total'];
?>"<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['p_img']->value['large']['url'], ENT_QUOTES, 'UTF-8');?>
"<?php if (!(isset($_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_p_img_list']->value['last'] : null)) {?>,<?php }
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>],
	<?php }?>
		"sku": "<?php if ($_smarty_tpl->tpl_vars['product']->value['reference']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['reference'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');
}?>",
		"mpn": "<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['mpn'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['mpn'], ENT_QUOTES, 'UTF-8');
} elseif ($_smarty_tpl->tpl_vars['product']->value['reference']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['reference'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');
}?>",
	<?php if ($_smarty_tpl->tpl_vars['product']->value['ean13']) {?>
		"gtin13": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['ean13'], ENT_QUOTES, 'UTF-8');?>
",
	<?php } elseif ($_smarty_tpl->tpl_vars['product']->value['upc']) {?>
		"gtin13": "0<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['upc'], ENT_QUOTES, 'UTF-8');?>
",
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['product']->value['condition'] === 'new') {?>
		"itemCondition": "https://schema.org/NewCondition",
	<?php } elseif ($_smarty_tpl->tpl_vars['product']->value['show_condition'] && $_smarty_tpl->tpl_vars['product']->value['condition'] === 'used') {?>
		"itemCondition": "https://schema.org/UsedCondition",
	<?php } elseif ($_smarty_tpl->tpl_vars['product']->value['show_condition'] && $_smarty_tpl->tpl_vars['product']->value['condition'] === 'refurbished') {?>
		"itemCondition": "https://schema.org/RefurbishedCondition",
	<?php }?>
		"availability": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['seo_availability'], ENT_QUOTES, 'UTF-8');?>
",
		"seller": {
			"@type": "Organization",
			"name": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
"
		}
	},
<?php }?>
	"url": "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"
}
<?php echo '</script'; ?>
><?php }
}
