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
<div id="order-items">
  {block name='order_items_table_head'}
    <h4 class="page-subheading">{l s='Order items' d='Shop.Theme.Checkout'}</h4>
  {/block}

  <div class="order-confirmation-table cart-items cart-items-review light-box-bg">
    {block name='order_confirmation_table'}
      {foreach from=$products item=product}
        {include file='checkout/_partials/cart-summary-product-line.tpl' product=$product product_customizations=true}
      {/foreach}

      <div class="order-confirmation-total cart-item">
        {foreach $subtotals as $subtotal}
          {if $subtotal !== null && $subtotal.type !== 'tax' && $subtotal.label !== null}
          <div class="row subtotal-{$subtotal.type} {if $subtotal.amount == 0}free{/if}">
            <div class="col-8 text-end"><label>{$subtotal.label}</label></div>
            <div class="col-4 text-end">
              {if 'discount' == $subtotal.type}
                <span class="price price-normal discount-price">-&nbsp;{$subtotal.value}</span>
              {else}
                <span class="price price-normal">{$subtotal.value}</span>
              {/if}
            </div>
          </div>
          {/if}
        {/foreach}

        <div class="row">
          {if !$configuration.display_prices_tax_incl && $configuration.taxes_enabled}
            <div class="col-8 text-end"><label>{$totals.total.label}&nbsp;{$labels.tax_short}</label></div>
            <div class="col-4 text-end"><span class="price">{$totals.total.value}</span></div>
            <div class="col-8 text-end"><label>{$totals.total_including_tax.label}</label></div>
            <div class="col-4 text-end"><span class="price price-total">{$totals.total_including_tax.value}</span></div>
          {else}
            <div class="col-8 text-end"><label>{$totals.total.label}&nbsp;{if $configuration.taxes_enabled && $configuration.display_taxes_label}{$labels.tax_short}{/if}</label></div>
            <div class="col-4 text-end"><span class="price price-total">{$totals.total.value}</span></div>
          {/if}

          {if $subtotals.tax !== null && $subtotals.tax.label !== null}
            <div class="col-8 text-end"></div>
            <div class="col-4 text-end"><span style="font-size: 90%;"><i>{l s='%label%:' sprintf=['%label%' => $subtotals.tax.label] d='Shop.Theme.Global'}</i> {$subtotals.tax.value}</span></div>
          {/if}
        </div>
      </div>
    {/block}
  </div>
</div>
