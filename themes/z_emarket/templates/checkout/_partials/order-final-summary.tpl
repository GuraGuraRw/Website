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
<section id="order-summary-content" class="page-order-confirmation box-bg mb-4">
  <p class="h5 text-center p-2 summary-message alert-info">{l s='Please check your order before payment' d='Shop.Theme.Checkout'}</p>

  <div class="order-summary-address grid-small-padding mb-3">
    <div class="osb-title">
      <h5>{l s='Addresses' d='Shop.Theme.Checkout'}</h5>
      <span class="btn btn-link btn-small step-edit step-to-addresses js-edit-addresses"><i class="material-icons edit">mode_edit</i> {l s='Edit' d='Shop.Theme.Actions'}</span>
    </div>
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="box-bg mb-2">
          <p class="h6">{l s='Your Delivery Address' d='Shop.Theme.Checkout'}</p>
          {$customer.addresses[$cart.id_address_delivery]['formatted'] nofilter}
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="box-bg mb-2">
          <p class="h6">{l s='Your Invoice Address' d='Shop.Theme.Checkout'}</p>
          {$customer.addresses[$cart.id_address_invoice]['formatted'] nofilter}
        </div>
      </div>
    </div>
  </div>
  
  {if !$cart.is_virtual}
    <div class="order-summary-shipping mb-4">
      <div class="osb-title">
        <h5>{l s='Shipping Method' d='Shop.Theme.Checkout'}</h5>
        <span class="btn btn-link btn-small step-edit step-to-delivery js-edit-delivery"><i class="material-icons edit">mode_edit</i> {l s='Edit' d='Shop.Theme.Actions'}</span>
      </div>
      <div class="summary-selected-carrier box-bg">
        <div class="delivery-option">
          {if $selected_delivery_option.logo}
            <div class="carrier-logo">
              <img src="{$selected_delivery_option.logo}" alt="{$selected_delivery_option.name}">
            </div>
          {/if}
          <div class="d-flex flex-wrap justify-content-between w-100">
            <span class="carrier-name">{$selected_delivery_option.name}</span>
            <span class="carrier-delay">{$selected_delivery_option.delay}</span>
            <span class="carrier-price">{$selected_delivery_option.price}</span>
          </div>
        </div>
      </div>

      {if $is_recyclable_packaging}
        <em>{l s='You have given permission to receive your order in recycled packaging.' d="Shop.Theme.Customeraccount"}</em>
      {/if}
    </div>
  {/if}

  <div class="order-summary-items">
    {block name='order_confirmation_table'}
      {include file='checkout/_partials/order-final-summary-table.tpl'
        products=$cart.products
        products_count=$cart.products_count
        subtotals=$cart.subtotals
        totals=$cart.totals
        labels=$cart.labels
        add_product_link=true
      }
    {/block}
  </div>
</section>
