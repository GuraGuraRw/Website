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
{extends file='page.tpl'}

{block name='page_content_container' prepend}
  <section id="content-hook_order_confirmation">
    <div class="alert alert-success">
      {block name='order_confirmation_header'}
        <h4>
          <i class="material-icons done">done</i>{l s='Your order is confirmed' d='Shop.Theme.Checkout'}
        </h4>
      {/block}

      <p class="mb-0">
        {l s='An email has been sent to your mail address %email%.' d='Shop.Theme.Checkout' sprintf=['%email%' => $order_customer.email]}

        {if $order.details.invoice_url}
          <br>
          {l
            s='You can also [1]download your invoice[/1]'
            d='Shop.Theme.Checkout'
            sprintf=[
              '[1]' => "<a href='{$order.details.invoice_url}'>",
              '[/1]' => "</a>"
            ]
          }
        {/if}
      </p>
    </div>

    {block name='hook_order_confirmation'}
      {if !empty($HOOK_ORDER_CONFIRMATION)}
        <div class="light-box-bg my-4">
          {$HOOK_ORDER_CONFIRMATION nofilter}
        </div>
      {/if}
    {/block}
  </section>
{/block}

{block name='page_content_container'}
  <section id="content" class="page-content page-order-confirmation">
    <div class="cart-grid row">
      {block name='order_confirmation_table'}
        <div class="col-12 col-lg-8">
          {include
            file='checkout/_partials/order-confirmation-table.tpl'
            products=$order.products
            subtotals=$order.subtotals
            totals=$order.totals
            labels=$order.labels
            add_product_link=false
          }
        </div>
      {/block}

      {block name='order_details'}
        <div class="col-12 col-lg-4">
          <div id="order-details" class="mb-3">
            <h4 class="page-subheading">{l s='Order details' d='Shop.Theme.Checkout'}</h4>
            <div class="light-box-bg">
              <ul>
                <li id="order-reference-value">{l s='Order reference: %reference%' d='Shop.Theme.Checkout' sprintf=['%reference%' => $order.details.reference]}</li>
                <li>{l s='Payment method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.details.payment]}</li>
                {if !$order.details.is_virtual}
                  <li>{l s='Shipping method: %method%' d='Shop.Theme.Checkout' sprintf=['%method%' => $order.carrier.name]} - <em>{$order.carrier.delay}</em></li>
                {/if}
                {if $order.details.recyclable}
                  <li><em>{l s='You have given permission to receive your order in recycled packaging.' d="Shop.Theme.Customeraccount"}</em></li>
                {/if}
              </ul>
            </div>
          </div>
        </div>
      {/block}
    </div>
  </section>

  {block name='hook_payment_return'}
    {if !empty($HOOK_PAYMENT_RETURN)}
      <section id="content-hook_payment_return" class="definition-list mt-4">
        <div class="light-box-bg">
          {$HOOK_PAYMENT_RETURN nofilter}
        </div>
      </section>
    {/if}
  {/block}

  {if !$registered_customer_exists}
    {block name='account_transformation_form'}
      <div class="account-transformation-form mt-4">
        <div class="light-box-bg">
          {include file='customer/_partials/account-transformation-form.tpl'}
        </div>
      </div>
    {/block}
  {/if}

  {block name='hook_order_confirmation_1'}
    <section class="hook-order-confirmation-1 mt-4">
      {hook h='displayOrderConfirmation1'}
    </section>
  {/block}

  {block name='hook_order_confirmation_2'}
    <section id="content-hook-order-confirmation-footer" class="mt-5">
      {hook h='displayOrderConfirmation2'}
    </section>
  {/block}

  <div class="cart-continue-shopping">
    <a class="btn btn-primary btn-wrap" href="{$urls.pages.index}">
      <i class="fa fa-home home" aria-hidden="true"></i> {l s='Continue shopping' d='Shop.Theme.Actions'}
    </a>
  </div>
{/block}
