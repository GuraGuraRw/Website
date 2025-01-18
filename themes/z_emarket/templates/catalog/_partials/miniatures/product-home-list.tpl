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

{block name='product_miniature_item'}
<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
  <div class="product-container product-style">
    <div class="first-block">
      {block name='product_thumbnail'}
        {include file='catalog/_partials/miniatures/_product_thumbnail.tpl'}
      {/block}

      {include file='catalog/_partials/product-flags.tpl'}

      {block name='grid_hover'}
        <div class="grid-hover-btn">
          {include file='catalog/_partials/miniatures/_product_quickview.tpl'}
        </div>
      {/block}

      {include file='catalog/_partials/miniatures/_product_countdown.tpl'}
    </div>

    <div class="second-third-block">
      <div class="second-block">
        {block name='product_name'}
          <h5 class="product-name"><a href="{$product.url}" title="{$product.name}">{$product.name}</a></h5>
        {/block}

        {block name='product_description_short'}
          <div class="product-description-short">
            {$product.description_short|strip_tags:false|nl2br nofilter}
          </div>
        {/block}

        {block name='product_variants'}
          {if $product.main_variants}
            {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
          {/if}
        {/block}
      </div>

      <div class="third-block">
        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}

        {block name='product_price_and_shipping'}
          {include file='catalog/_partials/miniatures/_product_prices.tpl'}
        {/block}
        
        <div class="buttons-sections">
          {block name='product_buttons'}
            {if !empty($modules.zonethememanager.product_addtocart) && !$configuration.is_catalog && $product.add_to_cart_url && $product.customizable == 0 && ((!$product.product_attribute_minimal_quantity && $product.minimal_quantity == 1) || $product.product_attribute_minimal_quantity == 1)}
              <button type="button" class="btn add-to-cart js-ajax-add-to-cart" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
                <i class="fa fa-plus text-for-list" aria-hidden="true"></i><span class="text-for-list">{l s='Add to cart' d='Shop.Theme.Actions'}</span>
              </button>
            {elseif !empty($modules.zonethememanager.product_details)}
              <a class="btn add-to-cart details-link" href="{$product.url}">
                <span class="text-for-list">{l s='View details' d='Shop.Zonetheme'} &nbsp;<i class="caret-right"></i></span>
              </a>
            {/if}
          {/block}
        </div>
      </div>
    </div>
  </div>
</article>
{/block}
