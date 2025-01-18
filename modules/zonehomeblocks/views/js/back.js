/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

$(document).ready(function() {
	$('#block_type_selectbox').change(function() {
		if (this.value == blocktype_product) {
			$('.block_type_static_html').slideUp();
			$('.block_type_tabs').slideUp();
			setTimeout(function() {
			  	$('.block_type_product').slideDown();
			}, 400);
		} else if (this.value == blocktype_html) {
			$('.block_type_product').slideUp();
			$('.block_type_tabs').slideUp();
			setTimeout(function() {
				$('.block_type_static_html').slideDown();
			}, 400);
		} else if (this.value == blocktype_tabs) {
			$('.block_type_product').slideUp();
			$('.block_type_static_html').slideUp();
			setTimeout(function() {
				$('.block_type_tabs').slideDown();
			}, 400);
		}
	});

	$('#product_filter_selectbox').change(function() {
		if (this.value == products_selected)
			$('.filter_selected_products').slideDown().addClass('block_type_product');
		else {
			$('.filter_selected_products').slideUp().removeClass('block_type_product');
		}
		if (this.value == products_category)
			$('.filter_select_category').slideDown().addClass('block_type_product');
		else {
			$('.filter_select_category').slideUp().removeClass('block_type_product');
		}
	});

	$('#layout_selectbox').trigger('change');
	$('#product_filter_selectbox').trigger('change');
	$('#block_type_selectbox').trigger('change');

	aInitTableDnD('zonehomeblocks', 'zhomeblock');
	aInitTableDnD('zonehomeblocks', 'zhometab');
});