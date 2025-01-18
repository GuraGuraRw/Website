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
<article class="product-item">
  <div class="product-container">
    {if $product.cover}
      {assign var=thumbnail value=$product.cover.bySize.home_default}
    {else}
      {assign var=thumbnail value=$urls.no_picture_image.medium}
    {/if}
    <div class="product-thumbnail">
      <a href="{$product.url}" class="product-cover-link">
        <img
          src       = "{$thumbnail.url}"
          alt       = "{$product.cover.legend|default: $product.name}"
          title     = "{$product.name}"
          class     = "img-fluid"
          width     = "{$thumbnail.width}"
          height    = "{$thumbnail.height}"
        >
      </a>
    </div>

    <div class="product-name"><a href="{$product.url}">{$product.name}</a></div>

    {if $product.show_price}
      <div class="product-price-and-shipping d-flex align-items-center justify-content-center">
        <span class="price product-price">{$product.price}</span>
        {if $product.has_discount}<span class="regular-price">{$product.regular_price}</span>{/if}
      </div>
    {/if}
  </div>
</article>
