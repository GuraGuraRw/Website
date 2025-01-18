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
{if $product.show_price}
  <div class="product-prices sm-bottom js-product-prices">
    {block name='product_price'}
      <div class="product-prices-wrapper">
        <p class="current-price">
          <span class='price product-price current-price-value' content="{$product.rounded_display_price}">
            {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='product_sheet'}{/capture}
            {if '' !== $smarty.capture.custom_price}
              {$smarty.capture.custom_price nofilter}
            {else}
              {$product.price}
            {/if}
          </span>

          {if !$configuration.taxes_enabled}
            <span class="tax-label labels-no-tax">{l s='No tax' d='Shop.Theme.Catalog'}</span>
          {elseif $configuration.display_taxes_label}
            <span class="tax-label labels-tax-long">{$product.labels.tax_long}</span>
          {/if}
        </p>

        <p class="show-more-without-taxes">
          <span style="font-size: 80%;">{Tools::displayPrice($product.price_tax_exc)}</span>
          <span class="tax-label">{l s='Tax excluded' d='Shop.Theme.Global'}</span>
        </p>

        {if $product.has_discount}
          <p class="previous-price">
            {hook h='displayProductPriceBlock' product=$product type="old_price"}

            <span class="regular-price">{$product.regular_price}</span>

            {if $product.discount_type === 'percentage'}
              <span class="discount-percentage">{$product.discount_percentage}</span>
            {else}
              <span class="discount-amount">- {$product.discount_to_display}</span>
            {/if}
          </p>
        {/if}

        {block name='product_unit_price'}
          {if $displayUnitPrice}
            <p class="product-unit-price">
              <span class="sub">{$product.unit_price_full}</span>
            </p>
          {/if}
        {/block}
      </div>
    {/block}

    {block name='product_without_taxes'}
      {if $priceDisplay == 2}
        <p class="product-without-taxes">{l s='%price% tax excl.' d='Shop.Theme.Catalog' sprintf=['%price%' => $product.price_tax_exc]}</p>
      {/if}
    {/block}

    {block name='product_pack_price'}
      {if $displayPackPrice}
        <p class="product-pack-price"><span>{l s='Instead of %price%' d='Shop.Theme.Catalog' sprintf=['%price%' => $noPackPrice]}</span></p>
      {/if}
    {/block}

    {block name='product_ecotax'}
      {if !$product.is_virtual && $product.ecotax.amount > 0}
        <p class="price-ecotax">{l s='Including %amount% for ecotax' d='Shop.Theme.Catalog' sprintf=['%amount%' => $product.ecotax.value]}
          {if $product.has_discount}
            {l s='(not impacted by the discount)' d='Shop.Theme.Catalog'}
          {/if}
        </p>
      {/if}
    {/block}

    {hook h='displayProductPriceBlock' product=$product type="weight" hook_origin='product_sheet'}

    <div class="shipping-delivery-label">
      {hook h='displayProductPriceBlock' product=$product type="price"}
      {hook h='displayProductPriceBlock' product=$product type="after_price"}

      {if $product.is_virtual == 0}
        {if $product.additional_delivery_times == 1}
          {if $product.delivery_information}
            <span class="delivery-information">{$product.delivery_information}</span>
          {/if}
        {elseif $product.additional_delivery_times == 2}
          {if $product.quantity >= $product.quantity_wanted}
            <span class="delivery-information">{$product.delivery_in_stock}</span>
          {elseif $product.add_to_cart_url}
            <span class="delivery-information">{$product.delivery_out_stock}</span>
          {/if}
        {/if}
      {/if}
    </div>

    {if isset($product.specific_prices) && isset($product.specific_prices.to) && $product.specific_prices.to != '0000-00-00 00:00:00'}
      <div class="js-new-specific-prices-to" data-new-specific-prices-to="{$product.specific_prices.to}"></div>
    {/if}
  </div>
{/if}
