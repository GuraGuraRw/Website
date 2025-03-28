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
{extends file='checkout/_partials/steps/checkout-step.tpl'}

{block name='step_content'}
  <div id="hook-display-before-carrier">
    {$hookDisplayBeforeCarrier nofilter}
  </div>

  {if $delivery_options|count}
    <form
      class="clearfix"
      id="js-delivery"
      data-url-update="{url entity='order' params=['ajax' => 1, 'action' => 'selectDeliveryOption']}"
      method="post"
    >
      <div class="delivery-options-list light-box-bg pt-2">
        <div class="form-fields">
          {block name='delivery_options'}
            <div class="delivery-options grid-small-padding">
              {foreach from=$delivery_options item=carrier key=carrier_id}
                <div class="delivery-option row js-delivery-option">
                  <div class="custom-radio">
                    <span class="check-wrap">
                      <input
                        type="radio"
                        name="delivery_option[{$id_address}]"
                        id="delivery_option_{$carrier.id}"
                        value="{$carrier_id}"
                        {if $delivery_option == $carrier_id}checked{/if}
                      >
                      <span class="check-shape"><i class="material-icons check-icon">check</i></span>
                    </span>
                  </div>
                  <label for="delivery_option_{$carrier.id}" class="delivery-option-2">
                    <div class="d-flex align-items-center">
                      {if $carrier.logo}
                        <div class="carrier-logo">
                          <img src="{$carrier.logo}" alt="{$carrier.name}" />
                        </div>
                      {/if}
                      <div class="w-100 d-flex flex-wrap justify-content-between">
                        <span class="carrier-name">{$carrier.name}</span>
                        <span class="carrier-delay">{$carrier.delay}</span>
                        <span class="carrier-price">{$carrier.price}</span>
                      </div>
                    </div>
                  </label>
                </div>

                <div class="carrier-extra-content row js-carrier-extra-content"{if $delivery_option != $carrier_id} style="display:none;"{/if}>
                  {$carrier.extraContent nofilter}
                </div>
              {/foreach}
            </div>
          {/block}

          {block name='order_options'}
            <div class="order-options">
              <div id="delivery" class="mb-3">
                <label for="delivery_message" class="text-start">{l s='If you would like to add a comment about your order, please write it in the field below.' d='Shop.Theme.Checkout'}</label>
                <textarea rows="2" cols="120" id="delivery_message" class="form-control" name="delivery_message">{$delivery_message nofilter}</textarea>
              </div>

              {if $recyclablePackAllowed}
                <label class="custom-checkbox">
                  <span class="check-wrap">
                    <input type="checkbox" id="input_recyclable" name="recyclable" value="1" {if $recyclable} checked {/if}>
                    <span class="check-shape"><i class="material-icons check-icon">check</i></span>
                  </span>
                  <span>{l s='I would like to receive my order in recycled packaging.' d='Shop.Theme.Checkout'}</span>
                </label>
              {/if}

              {if $gift.allowed}
                <label class="custom-checkbox">
                  <span class="check-wrap">
                    <input
                      class="js-gift-checkbox"
                      id="input_gift"
                      name="gift"
                      type="checkbox"
                      value="1"
                      {if $gift.isGift}checked="checked"{/if}
                    >
                    <span class="check-shape"><i class="material-icons check-icon">check</i></span>
                  </span>
                  <span>{$gift.label}</span>
                </label>

                <div id="gift" class="collapse{if $gift.isGift} show{/if}">
                  <label for="gift_message">{l s='If you\'d like, you can add a note to the gift:' d='Shop.Theme.Checkout'}</label>
                  <textarea rows="2" cols="120" id="gift_message" name="gift_message" class="form-control">{$gift.message}</textarea>
                </div>
              {/if}
            </div>
          {/block}
        </div>
      </div>
      <div class="step-button-continue text-end">
        <button type="submit" class="continue btn btn-primary" name="confirmDeliveryOption" value="1">
          {l s='Continue' d='Shop.Theme.Actions'}
        </button>
      </div>
    </form>
  {else}
    <p class="alert alert-danger">{l s='Unfortunately, there are no carriers available for your delivery address.' d='Shop.Theme.Checkout'}</p>
  {/if}

  <div id="hook-display-after-carrier">
    {$hookDisplayAfterCarrier nofilter}
  </div>

  <div id="extra_carrier"></div>
{/block}
