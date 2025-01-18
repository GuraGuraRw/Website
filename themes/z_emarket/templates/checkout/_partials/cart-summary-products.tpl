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

<div class="cart-summary-products js-cart-summary-products">
  <div class="cart-summary-line">
    <label>{$cart.summary_string}</label>
    <span class="value">
      <a href="#" data-bs-toggle="modal" data-bs-target="#cart-summary-product-list" class="show-details js-show-details">
        {l s='show details' d='Shop.Theme.Actions'} <i class="fa fa-info-circle" aria-hidden="true"></i>
      </a>
    </span>
  </div>

  {block name='cart_summary_product_list'}
    <div class="modal fade" id="cart-summary-product-list" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">{l s='Shopping Cart' d='Shop.Theme.Checkout'}</h5>
          </div>
          <div class="modal-body">
            <div class="cart-items cart-items-review">
              {foreach from=$cart.products item=product}
                {include file='checkout/_partials/cart-summary-product-line.tpl' product=$product product_customizations=false}
              {/foreach}
            </div>
          </div>
        </div>
      </div>
    </div>
  {/block}
</div>
