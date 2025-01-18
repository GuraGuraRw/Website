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
<div class="images-container">
  <div class="images-container-wrapper {if empty($modules.zonethememanager.product_image_zoom) || !empty($modules.zonethememanager.is_quickview) || !empty($is_quickview)}js-cover-image{else}js-enable-zoom-image{/if}">
    {if $product.default_image}
      {if !empty($modules.zonethememanager.is_mobile)}
        {block name='product_images_mobile'}
          <div class="product-cover sm-bottom">
            <div class="flex-scrollbox-wrapper js-mobile-images-scrollbox">
              <ul class="product-mobile-images">
                {foreach from=$product.images item=image}
                  <li>
                    <img
                      src = "{$image.bySize.large_default.url}"
                      class = "img-fluid"
                      alt = "{$image.legend|default: $product.name}"
                      width = "{$image.bySize.large_default.width}"
                      height = "{$image.bySize.large_default.height}"
                    >
                  </li>
                {/foreach}
              </ul>
            </div>
            <div class="scroll-box-arrows">
              <i class="material-icons left">chevron_left</i>
              <i class="material-icons right">chevron_right</i>
            </div>
          </div>
        {/block}
      {else}
        {block name='product_cover'}
          <div class="product-cover sm-bottom">
            <img
              src = "{$product.default_image.bySize.large_default.url}"
              class = "img-fluid js-qv-product-cover js-main-zoom"
              alt = "{$product.default_image.legend|default: $product.name}"
              data-zoom-image = "{$product.default_image.bySize.large_default.url}"
              data-id-image = "{$product.default_image.id_image}"
              width = "{$product.default_image.bySize.large_default.width}"
              height = "{$product.default_image.bySize.large_default.height}"
            >
            <div class="layer d-flex align-items-center justify-content-center">
              <span class="zoom-in js-mfp-button"><i class="material-icons">zoom_out_map</i></span>
            </div>
          </div>
        {/block}

        {block name='product_images'}
          {include file='catalog/_partials/product-thumbnails.tpl' images=$product.images default_id_image=$product.default_image.id_image}
        {/block}
      {/if}
    {else}
      {block name='product_cover'}
        <div class="product-cover sm-bottom">
          <img src="{$urls.no_picture_image.bySize.large_default.url}" class="img-fluid" alt="{$product.name}">
        </div>
      {/block}
    {/if}
  </div>

  {hook h='displayAfterProductThumbs' product=$product}
</div>
