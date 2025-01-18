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
<div class="product-line-grid">
  <div class="product-line-grid-left">
    <div class="product-image">
      {if !empty($product.default_image.small.url)}
        <img src="{$product.default_image.small.url}" alt="{$product.name|escape:'quotes'}" class="img-fluid">
      {else}
        <img src="{$urls.no_picture_image.small.url}" alt="{$product.name|escape:'quotes'}" class="img-fluid">
      {/if}
    </div>
    <div class="product-line-grid-body">
      <h5 class="product-name"><a href="{$product.url}" data-id_customization="{$product.id_customization|intval}">{$product.name}</a></h5>
      <div class="product-prices">
        {if $product.has_discount}<span class="regular-price">{$product.regular_price}</span>&nbsp;{/if}<span class="price">{$product.price}</span>
        {if $product.unit_price_full}
          &nbsp;<span class="unit-price-cart">{l s='(%unit_price%)' d='Shop.Theme.Catalog' sprintf=['%unit_price%' => $product.unit_price_full]}</span>
        {/if}
        {hook h='displayProductPriceBlock' product=$product type="unit_price"}
      </div>
      {if $product.attributes}
        <div class="product-line-info-wrapper">
          {foreach from=$product.attributes key="attribute" item="value"}
            <div class="product-line-info">
              <span><i>{$attribute}: {$value}</i></span>
            </div>
          {/foreach}
        </div>
      {/if}
      {if is_array($product.customizations) && $product.customizations|count}
        <div class="product-line-info-wrapper">
          {block name='cart_detailed_product_line_customization'}
            {foreach from=$product.customizations item="customization"}
              <div class="product-line-info">
                <a href="#" class="btn-link" data-bs-toggle="modal" data-bs-target="#product-customizations-modal-{$customization.id_customization}">
                  <i class="material-icons">attach_file</i>{l s='Product customization' d='Shop.Theme.Catalog'}
                </a>
                <div class="modal fade customization-modal js-customization-modal" id="product-customizations-modal-{$customization.id_customization}" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">{l s='Product customization' d='Shop.Theme.Catalog'}</h5>
                      </div>
                      <div class="modal-body">
                        {foreach from=$customization.fields item="field"}
                          <div class="product-customization-line">
                            <div class="col-4 label px-2">
                              {$field.label}
                            </div>
                            <div class="col-8 value px-2">
                              {if $field.type == 'text'}
                                {if (int)$field.id_module}
                                  {$field.text nofilter}
                                {else}
                                  {$field.text}
                                {/if}
                              {elseif $field.type == 'image'}
                                <img class="img-thumbnail" src="{$field.image.small.url}">
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
          {/block}
        </div>
      {/if}
    </div>
  </div>

  <div class="product-line-grid-right product-line-actions">
    <div class="qty-col-actions">
      <div class="qty-col product-quantity-touchspin">
        {if !empty($product.is_gift)}
          <span class="gift-quantity">{$product.quantity}</span>
        {else}
          <input
            class="js-cart-line-product-quantity"
            data-down-url="{$product.down_quantity_url}"
            data-up-url="{$product.up_quantity_url}"
            data-update-url="{$product.update_quantity_url}"
            data-product-id="{$product.id_product}"
            type="number"
            inputmode="numeric"
            pattern="[0-9]*"
            value="{$product.quantity}"
            name="product-quantity-spin"
            aria-label="{l s='%productName% product quantity field' sprintf=['%productName%' => $product.name] d='Shop.Theme.Checkout'}"
          />
        {/if}
      </div>
      <div class="cart-line-product-actions">
        <a
          class                       = "remove-from-cart icon-link"
          rel                         = "nofollow"
          href                        = "{$product.remove_from_cart_url}"
          data-link-action            = "delete-from-cart"
          data-id-product             = "{$product.id_product|escape:'javascript'}"
          data-id-product-attribute   = "{$product.id_product_attribute|escape:'javascript'}"
          data-id-customization       = "{$product.id_customization|default|escape:'javascript'}"
          title                       = "{l s='Delete' d='Shop.Theme.Actions'}"
        >
          {if empty($product.is_gift)}
            <i class="fa fa-trash-o" aria-hidden="true"></i>
          {/if}
        </a>

        {block name='hook_cart_extra_product_actions'}
          {hook h='displayCartExtraProductActions' product=$product}
        {/block}
      </div>
    </div>
    <div class="price-col">
      <span class="price product-price">
        {if !empty($product.is_gift)}
          <span class="gift">{l s='Gift' d='Shop.Theme.Checkout'}</span>
        {else}
          {$product.total}
        {/if}
      </span>
    </div>
  </div>
</div>
