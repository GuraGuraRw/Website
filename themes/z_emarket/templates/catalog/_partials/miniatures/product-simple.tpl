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
{block name='product_miniature_item'}
<article class="product-miniature" data-id-product="{$product.id_product}">
  <div class="product-container product-style pg-onp">
    <div class="first-block">
      {include file='catalog/_partials/miniatures/_product_thumbnail.tpl'}
    </div>

    {block name='product_name'}
      <p class="product-name" title="{$product.name}"><a href="{$product.url}">{$product.name}</a></p>
    {/block}

    {block name='product_price_and_shipping'}
      {if $product.show_price}
        <div class="product-price-and-shipping d-flex flex-wrap justify-content-center align-items-center">
          <span class="price product-price">{$product.price}</span>
          {if $product.has_discount}<span class="regular-price">{$product.regular_price}</span>{/if}
        </div>
      {/if}
    {/block}
  </div>
</article>
{/block}