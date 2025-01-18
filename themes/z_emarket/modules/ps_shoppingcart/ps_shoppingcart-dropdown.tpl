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
<div class="cart-dropdown" data-shopping-cart-source>
  <div class="cart-dropdown-wrapper">
    <div class="cart-title h4">{l s='Shopping Cart' d='Shop.Theme.Checkout'}</div>
    {if $cart.products}
      <ul class="cart-items _allow-update-quantity">
        {foreach from=$cart.products item=product}
          {include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}
        {/foreach}
      </ul>
      <div class="cart-bottom">
        <p class="cart-products-count alert-info">
          {if $cart.products_count > 1}{l s='There are %products_count% items in your cart.' sprintf=['%products_count%' => $cart.products_count] d='Shop.Theme.Checkout'}
          {else}{l s='There is %products_count% item in your cart.' sprintf=['%products_count%' =>$cart.products_count] d='Shop.Theme.Checkout'}{/if}
        </p>
        <div class="cart-summary-subtotals">
          {foreach from=$cart.subtotals item="subtotal"}
            {if $subtotal && $subtotal.value|count_characters > 0 && $subtotal.type !== 'tax'}
              <div class="cart-summary-line cart-subtotal-{$subtotal.type} {if $subtotal.amount == 0}free{/if}">
                <label>{$subtotal.label}</label>
                {if 'discount' == $subtotal.type}
                  <span class="price discount-price">-&nbsp;{$subtotal.value}</span>
                {else}
                  <span class="price">{$subtotal.value}</span>
                {/if}
              </div>
            {/if}
          {/foreach}
          {if $cart.subtotals.shipping}
            <div class="cart-summary-line shipping-hook">
              {hook h='displayCheckoutSubtotalDetails' subtotal=$cart.subtotals.shipping}
            </div>
          {/if}
        </div>
        <div class="cart-total">
          {if !$configuration.display_prices_tax_incl && $configuration.taxes_enabled}
            <div class="cart-summary-line">
              <label>{$cart.totals.total.label}{if $configuration.display_taxes_label}&nbsp;{$cart.labels.tax_short}{/if}</label>
              <span class="price">{$cart.totals.total.value}</span>
            </div>
            <div class="cart-summary-line product-total">
              <label>{$cart.totals.total_including_tax.label}</label>
              <span class="price price-total">{$cart.totals.total_including_tax.value}</span>
            </div>
          {else}
            <div class="cart-summary-line product-total">
              <label>{$cart.totals.total.label}&nbsp;{if $configuration.taxes_enabled && $configuration.display_taxes_label}{$cart.labels.tax_short}{/if}</label>
              <span class="price price-total">{$cart.totals.total.value}</span>
            </div>
          {/if}
          {if $cart.subtotals.tax}
            <div class="cart-summary-line cart-tax">
              <label></label>
              <span style="font-size: 90%;"><i>{l s='%label%:' sprintf=['%label%' => $cart.subtotals.tax.label] d='Shop.Theme.Global'}</i> {$cart.subtotals.tax.value}</span>
            </div>
          {/if}
        </div>

        {hook h='displayCartModalContent' product=$product}

        {if $cart.minimalPurchaseRequired}
          <div class="cart-minimal alert alert-warning" role="alert">
            {$cart.minimalPurchaseRequired}
          </div>
        {/if}

        <div class="cart-action">
          <div class="text-center">
            <a href="{$cart_url}" class="btn btn-primary">{l s='Checkout' d='Shop.Theme.Actions'} &nbsp;<i class="caret-right"></i></a>
          </div>
        </div>
      </div>

      {hook h='displayCartModalFooter' product=$product}
    {else}
      <div class="no-items">
        {l s='There are no more items in your cart' d='Shop.Theme.Checkout'}
      </div>
    {/if}
  </div>
  <div class="js-cart-update-quantity page-loading-overlay cart-overview-loading">
    <div class="page-loading-backdrop d-flex align-items-center justify-content-center">
      <span class="uil-spin-css"><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span></span>
    </div>
  </div>
</div>
