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
{if $cart.vouchers.allowed}
  {block name='cart_voucher'}
    <div class="cart-item cart-voucher js-cart-voucher">
      {if $cart.vouchers.added}
        {block name='cart_voucher_list'}
          <ul class="promo-name">
            {foreach from=$cart.vouchers.added item=voucher}
              <li class="cart-summary-line">
                <span>
                  {$voucher.name}
                  
                  {if isset($voucher.code) && $voucher.code !== ''}
                    <a href="{$voucher.delete_url}" data-link-action="remove-voucher" class="remove-voucher"><i class="material-icons">delete</i></a>
                  {/if}
                </span>
                <span class="value discount-price">{$voucher.reduction_formatted}</span>
              </li>
            {/foreach}
          </ul>
        {/block}
      {/if}

      <div class="cart-promotions">
        <label class="promo-code-button display-promo {if $cart.discounts|count > 0}with-discounts{/if}">
          <a class="collapse-button" href="#promo-code" data-bs-toggle="collapse" data-bs-target="#promo-code" aria-expanded="false" aria-controls="promo-code">
            {l s='Have a promo code?' d='Shop.Theme.Checkout'}
          </a>
        </label>
        <div id="promo-code" class="collapse{if $cart.discounts|count > 0} show{/if}">
          <div class="promo-code">
            {block name='cart_voucher_form'}
              <form action="{$urls.pages.cart}" data-link-action="add-voucher" method="post">
                <input type="hidden" name="token" value="{$static_token}">
                <input type="hidden" name="addDiscount" value="1">
                <div class="input-group">
                  <input class="promo-input form-control" type="text" name="discount_name" placeholder="{l s='Promo code' d='Shop.Theme.Checkout'}">
                  <span class="input-group-btn">
                    <button type="submit" class="btn"><span>{l s='Add' d='Shop.Theme.Actions'}</span></button>
                  </span>
                </div>
              </form>
            {/block}

            {block name='cart_voucher_notifications'}
              <div class="alert alert-danger js-error" role="alert">
                <i class="material-icons">error_outline</i> <span class="js-error-text"></span>
              </div>
            {/block}

            <a class="collapse-button promo-code-button cancel-promo d-none" role="button" data-bs-toggle="collapse" data-bs-target="#promo-code" aria-expanded="true" aria-controls="promo-code">
              {l s='Close' d='Shop.Theme.Checkout'}
            </a>
          </div>
          {if $cart.discounts|count > 0}
            <div class="promo-highlighted">
              <label>
                {l s='Take advantage of our exclusive offers:' d='Shop.Theme.Actions'}
              </label>
              <ul class="js-discount promo-discounts linklist">
              {foreach from=$cart.discounts item=discount}
                <li>
                  <a>{$discount.name} - <span class="code discount-price">{$discount.code}</span></a>
                </li>
              {/foreach}
              </ul>
            </div>
          {/if}
        </div>

        
      </div>
    </div>
  {/block}
{/if}
