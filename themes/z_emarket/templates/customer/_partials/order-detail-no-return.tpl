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
  <div class="d-none d-lg-block">
    <table id="order-products" class="table table-bordered">
      <thead class="thead-default">
        <tr>
          <th>{l s='Product' d='Shop.Theme.Catalog'}</th>
          <th>{l s='Quantity' d='Shop.Theme.Catalog'}</th>
          <th>{l s='Unit price' d='Shop.Theme.Catalog'}</th>
          <th>{l s='Total price' d='Shop.Theme.Catalog'}</th>
        </tr>
      </thead>
      {foreach from=$order.products item=product}
        <tr>
          <td>
            <strong>
              <a href="{$urls.pages.product}&id_product={$product.id_product}">
                {$product.name}
              </a>
            </strong><br/>
            {if $product.product_reference}
              {l s='Reference' d='Shop.Theme.Catalog'}: {$product.product_reference}<br/>
            {/if}
            {if isset($product.download_link)}
              <a href="{$product.download_link}">{l s='Download' d='Shop.Theme.Actions'}</a><br/>
            {/if}
            {if $product.is_virtual}
              {l s='Virtual products can\'t be returned.' d='Shop.Theme.Customeraccount'}</br>
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
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}"><span aria-hidden="true">&times;</span></button>
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
          <td>
            {if $product.customizations}
              {foreach $product.customizations as $customization}
                {$customization.quantity}
              {/foreach}
            {else}
              {$product.quantity}
            {/if}
          </td>
          <td class="text-end">{$product.price}</td>
          <td class="text-end price-total">{$product.total}</td>
        </tr>
      {/foreach}
      <tfoot>
        {foreach $order.subtotals as $line}
          {if $line.value && $line.type !== 'tax'}  
            <tr class="text-end line-{$line.type}">
              <td colspan="3"><strong>{$line.label}</strong></td>
              {if 'discount' == $line.type}
                <td class="discount-price">-&nbsp;{$line.value}</td>
              {else}
                <td>{$line.value}</td>
              {/if}
            </tr>
          {/if}
        {/foreach}
        <tr class="text-end line-{$order.totals.total.type}">
          <td colspan="3"><strong>{$order.totals.total.label}</strong></td>
          <td class="price price-total">{$order.totals.total.value}</td>
        </tr>
        {if $order.subtotals.tax}
          <tr class="text-end line-tax">
            <td colspan="3"><strong>{$order.subtotals.tax.label}</strong></td>
            <td>{$order.subtotals.tax.value}</td>
          </tr>
        {/if}
      </tfoot>
    </table>
  </div>

  <div class="order-items d-block d-lg-none light-box-bg">
    {foreach from=$order.products item=product}
      <div class="order-item">
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
                <div id="_mobile_product_customization_modal_wrapper_{$customization.id_customization}"></div>
              {/foreach}
            {/if}
          </div>
          <div class="col-12 qty">
            <div class="row">
              <div class="col-5 text-start">
                {$product.price}
              </div>
              <div class="col-2 text-center">
                {if $product.customizations}
                  {foreach $product.customizations as $customization}
                    {$customization.quantity}
                  {/foreach}
                {else}
                  {$product.quantity}
                {/if}
              </div>
              <div class="col-5 price-total text-end">
                {$product.total}
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
{/block}
