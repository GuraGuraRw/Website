{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

{* miniatures/product.tpl *}
<div class="tax-shipping-delivery-label">
  {if $configuration.display_taxes_label}
    <span class="aeuc_tax_label">{$product.labels.tax_short}</span>
  {/if}
  {hook h='displayProductPriceBlock' product=$product type="price"}
</div>

{block name='product_buttons'}
  {if !empty($modules.zonethememanager.product_addtocart) && !$configuration.is_catalog && $product.add_to_cart_url && $product.customizable == 0}
    <div class="addtocart-quantity product-quantity-touchspin">
      <input
        type="number"
        name="qty"
        value="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
        class="form-control js-add-to-cart-quantity"
        min="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity}{$product.product_attribute_minimal_quantity}{else}{$product.minimal_quantity}{/if}"
        data-id-product="{$product.id_product}"
      />
    </div>

    <button type="button" class="btn add-to-cart js-ajax-add-to-cart" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
      <i class="fa fa-plus text-for-list" aria-hidden="true"></i><span class="text-for-list">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
      <span class="text-for-grid">{l s='Buy' d='Shop.Zonetheme'}</span>
    </button>
  {elseif !empty($modules.zonethememanager.product_details)}
    <a class="btn add-to-cart details-link" href="{$product.url}">
      <span class="text-for-grid">{l s='Details' d='Shop.Zonetheme'}</span>
      <span class="text-for-list">{l s='View details' d='Shop.Zonetheme'} &nbsp;<i class="caret-right"></i></span>
    </a>
  {/if}
{/block}

{block name='product_reference'}
  {if isset($product.reference_to_display) && $product.reference_to_display neq ''}
    <div class="product-reference">
      <span>{l s='Ref:' d='Shop.Zonetheme'} {$product.reference_to_display}</span>
    </div>
  {/if}
{/block}

{* product-details.tpl *}
{function renderDimensionUnit}{if !empty($modules.zonethememanager.psDimensionUnit)}{$modules.zonethememanager.psDimensionUnit}{/if}{/function}

{block name='product_width'}
  {if isset($product.width) && ($product.width != 0)}
    <div class="attribute-item product-width d-none">
      <label>{l s='Width' d='Shop.Theme.Catalog'}</label>
      <span>{$product.width|string_format:"%.2f"|replace:'.00':''} {renderDimensionUnit}</span>
    </div>
  {/if}
{/block}
{block name='product_height'}
  {if isset($product.height) && ($product.height != 0)}
    <div class="attribute-item product-height d-none">
      <label>{l s='Height' d='Shop.Theme.Catalog'}</label>
      <span>{$product.height|string_format:"%.2f"|replace:'.00':''} {renderDimensionUnit}</span>
    </div>
  {/if}
{/block}
{block name='product_depth'}
  {if isset($product.depth) && ($product.depth != 0)}
    <div class="attribute-item product-depth d-none">
      <label>{l s='Depth' d='Shop.Theme.Catalog'}</label>
      <span>{$product.depth|string_format:"%.2f"|replace:'.00':''} {renderDimensionUnit}</span>
    </div>
  {/if}
{/block}
{block name='product_weight'}
  {if isset($product.weight) && ($product.weight != 0)}
    <div class="attribute-item product-weight d-none">
      <label>{l s='Weight' d='Shop.Theme.Catalog'}</label>
      <span>{$product.weight|string_format:"%.2f"|replace:'.00':''} {$product.weight_unit}</span>
    </div>
  {/if}
{/block}