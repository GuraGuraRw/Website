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
{extends file='checkout/_partials/steps/checkout-step.tpl'}

{block name='step_content'}

  {if $show_delivery_address_form}
    <div id="delivery-address">
      <h5 class="page-subheading">{l s='Shipping Address' d='Shop.Theme.Checkout'}</h5>
      {render file                      = 'checkout/_partials/address-form.tpl'
              ui                        = $address_form
              use_same_address          = $use_same_address
              type                      = "delivery"
              form_has_continue_button  = $form_has_continue_button
      }
    </div>
  {elseif $show_invoice_address_form}
    <div id="invoice-address">
      <h5 class="page-subheading">{l s='Your Invoice Address' d='Shop.Theme.Checkout'}</h5>
      {render file                      = 'checkout/_partials/address-form.tpl'
              ui                        = $address_form
              use_same_address          = $use_same_address
              type                      = "invoice"
              form_has_continue_button  = $form_has_continue_button
      }
    </div>
  {else}
    <form
      method="POST"
      data-id-address="{$id_address}"
      action="{$urls.pages.order}"
      data-refresh-url="{url entity='order' params=['ajax' => 1, 'action' => 'addressForm']}"
    >
      <section class="shipping-address mb-4">
        {if $customer.addresses|count > 0}
          <h5 class="page-subheading">{l s='Shipping Address' d='Shop.Theme.Checkout'}</h5>

          {if $use_same_address}
            <p class="alert alert-info p-2">
              {if $cart.is_virtual}
                {l s='The selected address will be used as your personal address (for invoice).' d='Shop.Theme.Checkout'}
              {else}
                {l s='The selected address will be used both as your personal address (for invoice) and as your delivery address.' d='Shop.Theme.Checkout'}
              {/if}
            </p>
          {/if}

          <div id="delivery-addresses" class="address-selector js-address-selector">
            {include  file        = 'checkout/_partials/address-selector-block.tpl'
                      addresses   = $customer.addresses
                      name        = "id_address_delivery"
                      selected    = $id_address_delivery
                      type        = "delivery"
                      interactive = !$show_delivery_address_form and !$show_invoice_address_form
            }
          </div>

          {if isset($delivery_address_error)}
            <p class="alert alert-danger js-address-error" name="alert-delivery" id="id-failure-address-{$delivery_address_error.id_address}">{$delivery_address_error.exception}</p>
          {else}
            <p class="alert alert-danger js-address-error" name="alert-delivery" style="display: none">{l s="Your address is incomplete, please update it." d="Shop.Notifications.Error"}</p>
          {/if}

          <p class="add-address mb-3">
            <a class="btn btn-secondary btn-small btn-wrap" href="{$new_address_delivery_url}"><i class="material-icons">add</i> {l s='add new address' d='Shop.Theme.Actions'}</a>
          </p>

          {if $use_same_address && !$cart.is_virtual}
            <p class="billing-address">
              <a data-link-action="different-invoice-address" href="{$use_different_address_url}" class="btn btn-teriary btn-small btn-wrap">
                {l s='Billing address differs from shipping address' d='Shop.Theme.Checkout'}
              </a>
            </p>
          {/if}
        {/if}
      </section>

      <section class="invoice-address mb-4">
        {if !$use_same_address && $customer.addresses|count > 0}
          <h5 class="page-subheading">{l s='Your Invoice Address' d='Shop.Theme.Checkout'}</h5>

          <div id="invoice-addresses" class="address-selector js-address-selector">
            {include  file        = 'checkout/_partials/address-selector-block.tpl'
                      addresses   = $customer.addresses
                      name        = "id_address_invoice"
                      selected    = $id_address_invoice
                      type        = "invoice"
                      interactive = !$show_delivery_address_form and !$show_invoice_address_form
            }
          </div>

          {if isset($invoice_address_error)}
            <p class="alert alert-danger js-address-error" name="alert-invoice" id="id-failure-address-{$invoice_address_error.id_address}">{$invoice_address_error.exception}</p>
          {else}
            <p class="alert alert-danger js-address-error" name="alert-invoice" style="display: none">{l s="Your address is incomplete, please update it." d="Shop.Notifications.Error"}</p>
          {/if}

          <p class="add-address">
            <a class="btn btn-secondary btn-small btn-wrap" href="{$new_address_invoice_url}"><i class="material-icons">add</i> {l s='add new address' d='Shop.Theme.Actions'}</a>
          </p>
        {/if}
      </section>

      {if !$form_has_continue_button}
        <div class="step-button-continue text-end">
          <button type="submit" class="btn btn-primary continue" name="confirm-addresses" value="1">
            {l s='Continue' d='Shop.Theme.Actions'}
          </button>
          <input type="hidden" id="not-valid-addresses" class="js-not-valid-addresses" value="{$not_valid_addresses}">
        </div>
      {/if}
    </form>
  {/if}

{/block}
