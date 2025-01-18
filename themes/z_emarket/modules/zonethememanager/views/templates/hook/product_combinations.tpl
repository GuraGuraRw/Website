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

{if $combinations}
<div class="product-combinations js-product-combinations">
  <div class="combinations-wrapper">
    {foreach from=$combinations key=id_combination item=combination}
      <div class="combination-item js-switch-cbnt {if $id_combination == $id_product_attribute}active{/if} {if $combination.disable}disabled{/if}" data-groups="{$combination.groups|json_encode}">
        <div class="switch-cbnt">
          {if $combination.price}<span class="cbnt-price product-price">{$combination.price}</span>{/if}
          <span class="cbnt-name">{$combination.title nofilter}</span>
          {if $combination.quantity}<span class="cbnt-qty">({$combination.quantity} {$combination.quantity_label})</span>{/if}
        </div>
      </div>
    {/foreach}
  </div>
</div>
{/if}
