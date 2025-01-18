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

{function renderProductQtyAdd}
  <div class="product-quantity-touchspin">
    <div class="qty">
      <input
        type="number"
        name="qty"
        id="quantity_wanted"
        inputmode="numeric"
        pattern="[0-9]*"
        {if $product.quantity_wanted}
          value="{$product.quantity_wanted}"
          min="{$product.minimal_quantity}"
        {else}
          value="1"
          min="1"
        {/if}
        class="form-control"
        aria-label="{l s='Quantity' d='Shop.Theme.Actions'}"
      />
    </div>
  </div>
  <div class="add">
    <button
      class="btn add-to-cart"
      data-button-action="add-to-cart"
      type="submit"
      {if !$product.add_to_cart_url}disabled{/if}
    >
      <i class="material-icons shopping-cart">shopping_cart</i><span>{l s='Add to cart' d='Shop.Theme.Actions'}</span>
      <span class="js-waitting-add-to-cart page-loading-overlay add-to-cart-loading">
        <span class="page-loading-backdrop d-flex align-items-center justify-content-center">
          <span class="uil-spin-css"><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span></span>
        </span>
      </span>
    </button>
  </div>
{/function}

<div class="product-add-to-cart js-product-add-to-cart {if !$product.add_to_cart_url}add-to-cart-disabled{/if}">
{if !$configuration.is_catalog}
  
  {if !empty($modules.zonethememanager.product_qty_add_inline)}
    <div class="product-quantity inline-style d-flex align-items-center sm-bottom">
      {block name='product_quantity'}
        {renderProductQtyAdd}
      {/block}
    </div>
  {else}
    <div class="product-quantity normal-style sm-bottom">
      {block name='product_quantity'}
        <div class="row">
          <label class="form-control-label col-3">{l s='Quantity' d='Shop.Theme.Catalog'}</label>
          <div class="col-9">
            {renderProductQtyAdd}
          </div>
        </div>
      {/block}
    </div>
  {/if}

  {block name='product_minimal_quantity'}
    <div class="product-minimal-quantity js-product-minimal-quantity sm-bottom">
      {if $product.minimal_quantity > 1}
        <i>{l
          s='The minimum purchase order quantity for the product is %quantity%.'
          d='Shop.Theme.Checkout'
          sprintf=['%quantity%' => $product.minimal_quantity]
        }</i>
      {/if}
    </div>
  {/block}

  {hook h='displayProductActions' product=$product}

  {block name='product_availability'}
    {if $product.show_availability && $product.availability_message}
      <div class="js-product-availability-source d-none">
        <span id="product-availability" class="js-product-availability">
          {if $product.availability == 'available' && $product.quantity > 0}
            <span class="product-availability product-available alert alert-success">
              <i class="material-icons">check</i>&nbsp;{$product.availability_message}
            </span>
          {elseif $product.availability == 'last_remaining_items'}
            <span class="product-availability product-last-items alert alert-info">
              <i class="material-icons">notifications_active</i>&nbsp;{$product.availability_message}
            </span>
          {elseif $product.availability == 'available' && $product.quantity <= 0}
            <span class="product-availability product-available-order alert alert-success">
              <i class="material-icons">new_releases</i>&nbsp;{$product.availability_message}
            </span>
          {elseif isset($product.quantity_all_versions) && $product.quantity_all_versions <= 0}
            <span class="product-availability product-available-order alert alert-danger">
              <i class="material-icons">block</i>&nbsp;{$product.availability_message}
            </span>
          {else}
            <span class="product-availability product-unavailable alert alert-warning">
              <i class="material-icons">error_outline</i>&nbsp;{$product.availability_message}
            </span>
          {/if}
        </span>
      </div>
    {/if}
  {/block}

{/if}
</div>
