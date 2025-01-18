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

<div class="product-information light-box-bg sm-bottom">
  {if $product.is_customizable && count($product.customizations.fields)}
    {block name='product_customization'}
      {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
    {/block}
  {/if}

  <div class="product-actions js-product-actions">
    {block name='product_buy'}
      <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
        <input type="hidden" name="token" value="{$static_token}">
        <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
        <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id" class="js-product-customization-id">

        {block name='product_variants'}
          {include file='catalog/_partials/product-variants.tpl'}
        {/block}

        {block name='product_pack'}
          {if $packItems}
            <section class="product-pack md-bottom">
              <label>{l s='This pack contains' d='Shop.Theme.Catalog'}</label>
              <div class="pack-product-items">
                {foreach from=$packItems item="product_pack"}
                  {if !empty($is_quickview)}
                    {include file='catalog/_partials/miniatures/pack-product-quickview.tpl' product=$product_pack}
                  {else}
                    {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack showPackProductsPrice=$product.show_price}
                  {/if}
                {/foreach}
              </div>
            </section>
          {/if}
        {/block}

        {block name='product_discounts'}
          {include file='catalog/_partials/product-discounts.tpl'}
        {/block}

        {block name='product_prices'}
          {include file='catalog/_partials/product-prices.tpl'}
        {/block}

        {if !empty($modules.zonethememanager.product_countdown) && !empty($product.specific_prices.to) && $product.specific_prices.to != '0000-00-00 00:00:00'}
          <div class="js-product-countdown" data-specific-prices-to="{$product.specific_prices.to}"></div>
        {/if}

        {block name='product_add_to_cart'}
          {include file='catalog/_partials/product-add-to-cart.tpl'}
        {/block}

        {block name='product_refresh'}{/block}

      </form>
    {/block}
  </div>
</div><!-- /product-information -->
