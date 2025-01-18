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
{block name='order_products_table'}
  <form id="order-return-form" class="js-order-return-form" action="{$urls.pages.order_follow}" method="post">

    <div class="d-none d-lg-block">
      <table id="order-products" class="table table-bordered return">
        <thead class="thead-default">
          <tr>
            <th class="head-checkbox"><input type="checkbox"/></th>
            <th>{l s='Product' d='Shop.Theme.Catalog'}</th>
            <th>{l s='Quantity' d='Shop.Theme.Catalog'}</th>
            <th>{l s='Returned' d='Shop.Theme.Customeraccount'}</th>
            <th>{l s='Unit price' d='Shop.Theme.Catalog'}</th>
            <th>{l s='Total price' d='Shop.Theme.Catalog'}</th>
          </tr>
        </thead>
        {foreach from=$order.products item=product name=products}
          <tr>
            <td>
              {if !$product.is_virtual}
                <span id="_desktop_product_line_{$product.id_order_detail}">
                  <input type="checkbox" id="cb_{$product.id_order_detail}" name="ids_order_detail[{$product.id_order_detail}]" value="{$product.id_order_detail}">
                </span>
              {/if}
            </td>
            <td>
              <strong>{$product.name}</strong><br/>
              {if $product.product_reference}
                {l s='Reference' d='Shop.Theme.Catalog'}: {$product.product_reference}<br/>
              {/if}
              {if $product.is_virtual}
                {l s='Virtual products can\'t be returned.' d='Shop.Theme.Customeraccount'}<br/>
              {/if}
              {if isset($product.download_link)}
                <a href="{$product.download_link}">{l s='Download' d='Shop.Theme.Actions'}</a><br/>
              {/if}
              {if $product.customizations}
                {foreach from=$product.customizations item="customization"}
                  <div class="customization">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a>
                  </div>
                  <div id="_desktop_product_customization_modal_wrapper_{$customization.id_customization}">
                    <div class="modal fade customization-modal" id="product-customizations-modal-{$customization.id_customization}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}"></button>
                            <h4 class="modal-title">{l s='Product customization' d='Shop.Theme.Catalog'}</h4>
                          </div>
                          <div class="modal-body">
                            {foreach from=$customization.fields item="field"}
                              <div class="product-customization-line row">
                                <div class="col-sm-3 col-4 label">
                                  {$field.label}
                                </div>
                                <div class="col-sm-9 col-8 value">
                                  {if $field.type == 'text'}
                                    {if (int)$field.id_module}
                                      {$field.text nofilter}
                                    {else}
                                      {$field.text}
                                    {/if}
                                  {elseif $field.type == 'image'}
                                    <img src="{$field.image.small.url}" class="img-thumbnail">
                                  {/if}
                                </div>
                              </div>
                            {/foreach}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                {/foreach}
              {/if}
            </td>
            <td class="qty">
              <div class="current">
                {$product.quantity}
              </div>
              {if $product.quantity > $product.qty_returned && !$product.is_virtual}
                <div class="select" id="_desktop_return_qty_{$product.id_order_detail}">
                  <select name="order_qte_input[{$product.id_order_detail}]" class="form-control form-control-select">
                    {section name=quantity start=1 loop=$product.quantity+1-$product.qty_returned}
                      <option value="{$smarty.section.quantity.index}">{$smarty.section.quantity.index}</option>
                    {/section}
                  </select>
                  {if $product.customizations}
                    <input type="hidden" value="1" name="customization_qty_input[{$customization.id_customization}]" />
                  {/if}
                </div>
              {/if}
            </td>
            <td class="text-end">{if !$product.is_virtual}{$product.qty_returned}{/if}</td>
            <td class="text-end">{$product.price}</td>
            <td class="text-end price-total">{$product.total}</td>
          </tr>
        {/foreach}
        <tfoot>
          {foreach $order.subtotals as $line}
            {if $line.value && $line.type !== 'tax'}  
              <tr class="text-end line-{$line.type}">
                <td colspan="5"><strong>{$line.label}</strong></td>
                {if 'discount' == $line.type}
                  <td class="discount-price">-&nbsp;{$line.value}</td>
                {else}
                  <td>{$line.value}</td>
                {/if}
              </tr>
            {/if}
          {/foreach}
          <tr class="text-end line-{$order.totals.total.type}">
            <td colspan="5"><strong>{$order.totals.total.label}<strong></td>
            <td class="price price-total">{$order.totals.total.value}</td>
          </tr>
          {if $order.subtotals.tax}
            <tr class="text-end line-tax">
              <td colspan="5"><strong>{$order.subtotals.tax.label}</strong></td>
              <td>{$order.subtotals.tax.value}</td>
            </tr>
          {/if}
        </tfoot>
      </table>
    </div>

    <div class="order-items d-block d-lg-none light-box-bg">
      {foreach from=$order.products item=product}
        <div class="order-item">
          <div class="d-flex">
            <div class="checkbox">
              {if !$product.customizations}
                <span id="_tablet_product_line_{$product.id_order_detail}"></span>
              {else}
                {foreach $product.customizations  as $customization}
                  <span id="_tablet_product_customization_line_{$product.id_order_detail}_{$customization.id_customization}"></span>
                {/foreach}
              {/if}
            </div>
            <div class="content">
              <div class="row">
                <div class="col-12 desc">
                  <div class="name"><strong>{$product.name}</strong></div>
                  {if $product.product_reference}
                    <div class="ref">{l s='Reference' d='Shop.Theme.Catalog'}: {$product.product_reference}</div>
                  {/if}
                  {if isset($product.download_link)}
                    <a href="{$product.download_link}">{l s='Download' d='Shop.Theme.Actions'}</a><br/>
                  {/if}
                  {if $product.customizations}
                    {foreach $product.customizations as $customization}
                      <div class="customization">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a>
                      </div>
                      <div id="_tablet_product_customization_modal_wrapper_{$customization.id_customization}">
                      </div>
                    {/foreach}
                  {/if}
                </div>
                <div class="col-12 qty">
                  <div class="row">
                    <div class="col-4 text-sm-left text-start">
                      {$product.price}
                    </div>
                    <div class="col-4">
                      {if $product.customizations}
                        {foreach $product.customizations as $customization}
                          <div class="q">{l s='Quantity' d='Shop.Theme.Catalog'}: {$customization.quantity}</div>
                          <div class="s" id="_tablet_return_qty_{$product.id_order_detail}_{$customization.id_customization}"></div>
                        {/foreach}
                      {else}
                        <div class="q">{l s='Quantity' d='Shop.Theme.Catalog'}: {$product.quantity}</div>
                        {if $product.quantity > $product.qty_returned}
                          <div class="s" id="_tablet_return_qty_{$product.id_order_detail}"></div>
                        {/if}
                      {/if}
                      {if $product.qty_returned > 0}
                        <div>{l s='Returned' d='Shop.Theme.Customeraccount'}: {$product.qty_returned}</div>
                      {/if}
                    </div>
                    <div class="col-4 price-total text-end">
                      {$product.total}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      {/foreach}
      <div class="order-totals order-item">
        {foreach $order.subtotals as $line}
          {if $line.value && $line.type !== 'tax'}  
            <div class="order-total row">
              <div class="col-8"><strong>{$line.label}</strong></div>
              {if 'discount' == $line.type}
                <div class="col-4 text-end discount-price">-&nbsp;{$line.value}</div>
              {else}
                <div class="col-4 text-end">{$line.value}</div>
              {/if}
            </div>
          {/if}
        {/foreach}
        <div class="order-total row">
          <div class="col-8"><strong>{$order.totals.total.label}</strong></div>
          <div class="col-4 text-end price price-total">{$order.totals.total.value}</div>
        </div>
        {if $order.subtotals.tax}
          <div class="order-total row">
            <div class="col-12 text-end"><i>{l s='%label%:' sprintf=['%label%' => $order.subtotals.tax.label] d='Shop.Theme.Global'}</i> {$order.subtotals.tax.value}</div>
          </div>
        {/if}
      </div>
    </div>

    <div class="merchandise-return shadow-box">
      <header>
        <h4>{l s='Merchandise return' d='Shop.Theme.Customeraccount'}</h4>
        <p>{l s='If you wish to return one or more products, please mark the corresponding boxes and provide an explanation for the return. When complete, click the button below.' d='Shop.Theme.Customeraccount'}</p>
      </header>
      <section class="form-fields">
        <div class="form-group">
          <textarea cols="67" rows="3" name="returnText" class="form-control"></textarea>
        </div>
      </section>
      <div class="form-footer">
        <input type="hidden" name="id_order" value="{$order.details.id}">
        <button class="form-control-submit btn btn-primary" type="submit" name="submitReturnMerchandise">
          {l s='Request a return' d='Shop.Theme.Customeraccount'}
        </button>
      </div>
    </div>

  </form>
{/block}
