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

{if $product.show_price}
  <div class="product-price-and-shipping d-flex {if !empty($modules.zonethememanager.ps_legalcompliance_spl)}has-aeuc{/if}">
    <div class="first-prices d-flex flex-wrap align-items-center">
      {hook h='displayProductPriceBlock' product=$product type="before_price"}

      <span class="price product-price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">
        {capture name='custom_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
        {if '' !== $smarty.capture.custom_price}
          {$smarty.capture.custom_price nofilter}
        {else}
          {$product.price}
        {/if}
      </span>
    </div>

    {if $product.has_discount}
      <div class="second-prices d-flex flex-wrap align-items-center">
        {hook h='displayProductPriceBlock' product=$product type="old_price"}

        <span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
      </div>
    {/if}

    <div class="third-prices d-flex flex-wrap align-items-center">
      {hook h='displayProductPriceBlock' product=$product type="unit_price"}
      {hook h='displayProductPriceBlock' product=$product type="weight"}
    </div>
  </div>
{/if}
