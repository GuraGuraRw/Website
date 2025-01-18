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
{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Order details' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
  {block name='order_infos'}
    <div id="order-infos">
      <div class="light-box-bg">
        <div class="row">
          <div class="col-{if $order.details.reorder_url}9{else}12{/if}">
            <strong>
              {l
                s='Order Reference %reference% - placed on %date%'
                d='Shop.Theme.Customeraccount'
                sprintf=['%reference%' => $order.details.reference, '%date%' => $order.details.order_date]
              }
            </strong>
          </div>
          {if $order.details.reorder_url}
            <div class="col-3 text-end">
              <a href="{$order.details.reorder_url}" class="button-primary"><i class="material-icons">autorenew</i>{l s='Reorder' d='Shop.Theme.Actions'}</a>
            </div>
          {/if}
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="light-box-bg">
        <div class="row">
          {if $order.carrier.name}
            <div class="col-6 col-lg-4 font-weight-bold">{l s='Carrier' d='Shop.Theme.Checkout'}</div>
            <div class="col-6 col-lg-8">{$order.carrier.name}</div>
          {/if}

          <div class="col-6 col-lg-4 font-weight-bold">{l s='Payment method' d='Shop.Theme.Checkout'}</div>
          <div class="col-6 col-lg-8">{$order.details.payment}</div>

          {if $order.details.invoice_url}
            <div class="col-12">
              <a href="{$order.details.invoice_url}">
                <i class="material-icons">picture_as_pdf</i> {l s='Download your invoice as a PDF file.' d='Shop.Theme.Customeraccount'}
              </a>
            </div>
          {/if}

          {if $order.details.recyclable}
            <div class="col-12">
              {l s='You have given permission to receive your order in recycled packaging.' d='Shop.Theme.Customeraccount'}
            </div>
          {/if}

          {if $order.details.gift_message}
            <div class="col-12">{l s='You have requested gift wrapping for this order.' d='Shop.Theme.Customeraccount'}</div>
            <div class="col-12">{l s='Message' d='Shop.Theme.Customeraccount'} {$order.details.gift_message nofilter}</div>
          {/if}
        </div>
      </div>
    </div>
  {/block}

  {block name='order_history'}
    <section id="order-history" class="sm-bottom">
      <h4>{l s='Follow your order\'s status step-by-step' d='Shop.Theme.Customeraccount'}</h4>
      <table class="table table-bordered table-labeled d-none d-md-table">
        <thead class="thead-default">
          <tr>
            <th>{l s='Date' d='Shop.Theme.Global'}</th>
            <th>{l s='Status' d='Shop.Theme.Global'}</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$order.history item=state}
            <tr>
              <td>{$state.history_date}</td>
              <td>
                <span class="label label-pill {$state.contrast}" style="background-color:{$state.color}">
                  {$state.ostate_name}
                </span>
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
      <div class="history-lines light-box-bg d-block d-md-none">
        {foreach from=$order.history item=state}
          <div class="history-line">
            <div class="row">
              <div class="date col-4">{$state.history_date}</div>
              <div class="state col-8">
                <span class="label label-pill {$state.contrast}" style="background-color:{$state.color}">
                  {$state.ostate_name}
                </span>
              </div>
            </div>
          </div>
        {/foreach}
      </div>
    </section>
  {/block}

  {if $order.follow_up}
    <div class="light-box-bg">
      <p>{l s='Click the following link to track the delivery of your order' d='Shop.Theme.Customeraccount'}</p>
      <a href="{$order.follow_up}">{$order.follow_up}</a>
    </div>
  {/if}

  {block name='addresses'}
    <div class="addresses row">
      {if $order.addresses.delivery}
        <div class="col-12 col-sm-6">
          <article id="delivery-address" class="light-box-bg">
            <h5>{l s='Delivery address %alias%' d='Shop.Theme.Checkout' sprintf=['%alias%' => $order.addresses.delivery.alias]}</h5>
            <address class="mb-0">{$order.addresses.delivery.formatted nofilter}</address>
          </article>
        </div>
      {/if}

      <div class="col-12 col-sm-6">
        <article id="invoice-address" class="light-box-bg">
          <h5>{l s='Invoice address %alias%' d='Shop.Theme.Checkout' sprintf=['%alias%' => $order.addresses.invoice.alias]}</h5>
          <address class="mb-0">{$order.addresses.invoice.formatted nofilter}</address>
        </article>
      </div>
      <div class="clearfix"></div>
    </div>
  {/block}

  {$HOOK_DISPLAYORDERDETAIL nofilter}

  {block name='order_detail'}
    {if $order.details.is_returnable && !$orderIsVirtual}
      {include file='customer/_partials/order-detail-return.tpl'}
    {else}
      {include file='customer/_partials/order-detail-no-return.tpl'}
    {/if}
  {/block}

  {block name='order_carriers'}
    {if $order.shipping}
      <div class="sm-bottom d-none d-lg-block">
        <table class="table table-bordered">
          <thead class="thead-default">
            <tr>
              <th>{l s='Date' d='Shop.Theme.Global'}</th>
              <th>{l s='Carrier' d='Shop.Theme.Checkout'}</th>
              <th>{l s='Weight' d='Shop.Theme.Checkout'}</th>
              <th>{l s='Shipping cost' d='Shop.Theme.Checkout'}</th>
              <th>{l s='Tracking number' d='Shop.Theme.Checkout'}</th>
            </tr>
          </thead>
          <tbody>
            {foreach from=$order.shipping item=line}
              <tr>
                <td>{$line.shipping_date}</td>
                <td>{$line.carrier_name}</td>
                <td>{$line.shipping_weight}</td>
                <td>{$line.shipping_cost}</td>
                <td>{$line.tracking nofilter}</td>
              </tr>
            {/foreach}
          </tbody>
        </table>
      </div>
      <div class="d-block d-lg-none shipping-lines light-box-bg">
        {foreach from=$order.shipping item=line}
          <div class="shipping-line">
            <div class="row">
              <div class="col-6"><strong>{l s='Date' d='Shop.Theme.Global'}</strong></div>
              <div class="col-6">{$line.shipping_date}</div>

              <div class="col-6"><strong>{l s='Carrier' d='Shop.Theme.Checkout'}</strong></div>
              <div class="col-6">{$line.carrier_name}</div>

              <div class="col-6"><strong>{l s='Weight' d='Shop.Theme.Checkout'}</strong></div>
              <div class="col-6">{$line.shipping_weight}</div>

              <div class="col-6"><strong>{l s='Shipping cost' d='Shop.Theme.Checkout'}</strong></div>
              <div class="col-6">{$line.shipping_cost}</div>

              <div class="col-6"><strong>{l s='Tracking number' d='Shop.Theme.Checkout'}</strong></div>
              <div class="col-6">{$line.tracking nofilter}</div>
            </div>
          </div>
        {/foreach}
      </div>
    {/if}
  {/block}

  {block name='order_messages'}
    {include file='customer/_partials/order-messages.tpl'}
  {/block}
{/block}
