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
{block name='cart_detailed_totals'}
  <div class="cart-detailed-totals js-cart-detailed-totals">
    <div class="cart-products-count alert-info">
      {if $cart.products_count > 1}{l s='There are %products_count% items in your cart.' sprintf=['%products_count%' => $cart.products_count] d='Shop.Theme.Checkout'}
      {else}{l s='There is %products_count% item in your cart.' sprintf=['%products_count%' =>$cart.products_count] d='Shop.Theme.Checkout'}{/if}
    </div>

    {block name='cart_voucher'}
      {include file='checkout/_partials/cart-voucher.tpl'}
    {/block}

    {**
    * /checkout/_partials/cart-summary-subtotals.tpl
    *}
    <div class="cart-item cart-summary-subtotals cart-detailed-subtotals js-cart-detailed-subtotals">
      {foreach from=$cart.subtotals item="subtotal"}
        {if $subtotal && $subtotal.value|count_characters > 0 && $subtotal.type !== 'tax'}
          <div class="cart-summary-line cart-subtotal-{$subtotal.type} {if $subtotal.amount == 0}free{/if}" id="cart-subtotal-{$subtotal.type}">
            <label>{$subtotal.label}</label>
            {if 'discount' == $subtotal.type}
              <span class="value price discount-price">-&nbsp;{$subtotal.value}</span>
            {else}
              <span class="value price">{$subtotal.value}</span>
            {/if}
          </div>
        {/if}
      {/foreach}
      {if $cart.subtotals.shipping}
        <div class="shipping-hook">
          {hook h='displayCheckoutSubtotalDetails' subtotal=$cart.subtotals.shipping}
        </div>
      {/if}
    </div>

    {block name='cart_summary_totals'}
      {include file='checkout/_partials/cart-summary-totals.tpl' cart=$cart}
    {/block}
  </div>
{/block}
