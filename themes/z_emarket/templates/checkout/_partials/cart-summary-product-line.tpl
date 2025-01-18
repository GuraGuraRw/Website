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
{block name='cart_summary_product_line'}
  <div class="cart-item">
    <div class="product-line-grid">
      <div class="product-line-grid-left">
        <div class="product-image">
          {if !empty($product.url)}<a href="{$product.url}" title="{$product.name}" target="_blank" rel="noopener noreferrer nofollow">{/if}
            {if !empty($product.default_image.small.url)}
              <img src="{$product.default_image.small.url}" alt="{$product.name|escape:'quotes'}" class="img-fluid">
            {else}
              <img src="{$urls.no_picture_image.small.url}" alt="{$product.name|escape:'quotes'}" class="img-fluid">
            {/if}
          {if !empty($product.url)}</a>{/if}
        </div>
        <div class="product-line-grid-body">
          {if !empty($product.url)}<a href="{$product.url}" target="_blank" rel="noopener noreferrer nofollow">{/if}
            <span class="product-name">{$product.name}</span>
          {if !empty($product.url)}</a>{/if}
          <div class="product-prices">
            <span class="price">{$product.price}</span>
            <span class="qty px-1">x</span>
            <span class="qty">{$product.quantity}</span>
          </div>
          {if $product.attributes}
            <div class="product-line-info-wrapper product-attributes">
              <span><i>{' + '|implode:$product.attributes}</i></span>
            </div>
          {/if}

          {if $product_customizations && is_array($product.customizations) && $product.customizations|count}
            <div class="product-line-info-wrapper product-customizations">
              {foreach from=$product.customizations item="customization"}
                <div class="product-line-info">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#product-customizations-modal-{$customization.id_customization}">
                    <i class="material-icons">attach_file</i>{l s='Product customization' d='Shop.Theme.Catalog'}
                  </a>
                  <div class="modal fade customization-modal" id="product-customizations-modal-{$customization.id_customization}" tabindex="-1" role="dialog" aria-hidden="true">
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
            </div>
          {/if}

          {hook h='displayProductPriceBlock' product=$product type="unit_price"}
        </div>
      </div>
      <div class="product-line-grid-right">
        <div class="price-col">
          <span class="price product-price">{$product.total}</span>
        </div>
      </div>
    </div>
  </div>
{/block}
