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

{block name='step_title'}{/block}
{block name='step_content'}

  {hook h='displayPaymentTop'}

  <div style="display:none" class="js-cart-payment-step-refresh"></div>

  {if !empty($display_transaction_updated_info)}
  <p class="cart-payment-step-refreshed-info p-2 alert-success">
    {l s='Transaction amount has been correctly updated' d='Shop.Theme.Checkout'}
  </p>
  {/if}

  {if $show_final_summary}
    {include file='checkout/_partials/order-final-summary.tpl'}
  {/if}

  <h5 class="step-title page-subheading">{$title}</h5>

  {if $is_free}
    <p class="p-2 alert-success cart-payment-step-not-needed-info">{l s='No payment needed for this order' d='Shop.Theme.Checkout'}</p>
  {/if}

  <div class="payment-options light-box-bg {if $is_free}d-none{/if}">
    {foreach from=$payment_options item="module_options"}
      {foreach from=$module_options item="option"}
        <div class="payment-line">
          <div id="{$option.id}-container" class="payment-option clearfix">
            <div class="custom-radio">
              <span class="check-wrap">
                <input
                  class="ps-shown-by-js {if $option.binary}binary{/if}"
                  id="{$option.id}"
                  data-module-name="{$option.module_name}"
                  name="payment-option"
                  type="radio"
                  required
                  {if ($selected_payment_option == $option.id || $is_free)}checked{/if}
                >
                <span class="check-shape"><i class="material-icons check-icon">check</i></span>
              </span>
              <label for="{$option.id}">
                <span class="option-text">{$option.call_to_action_text}</span>
                {if $option.logo}<img class="option-logo" src="{$option.logo}">{/if}
              </label>
            </div>

            <form method="GET" class="ps-hidden-by-js">
              {if $option.id === $selected_payment_option}
                {l s='Selected' d='Shop.Theme.Checkout'}
              {else}
                <button class="ps-hidden-by-js" type="submit" name="select_payment_option" value="{$option.id}">
                  {l s='Choose' d='Shop.Theme.Actions'}
                </button>
              {/if}
            </form>
          </div>

          {if $option.additionalInformation}
            <div
              id="{$option.id}-additional-information"
              class="js-additional-information definition-list additional-information{if $option.id != $selected_payment_option} ps-hidden {/if}"
            >
              {$option.additionalInformation nofilter}
            </div>
          {/if}

          <div
            id="pay-with-{$option.id}-form"
            class="js-payment-option-form {if $option.id != $selected_payment_option} ps-hidden {/if}"
          >
            {if $option.form}
              {$option.form nofilter}
            {else}
              <form id="payment-{$option.id}-form" method="POST" action="{$option.action nofilter}">
                {foreach from=$option.inputs item=input}
                  <input type="{$input.type}" name="{$input.name}" value="{$input.value}">
                {/foreach}
                <button style="display:none" id="pay-with-{$option.id}" type="submit"></button>
              </form>
            {/if}
          </div>
        </div>
      {/foreach}
    {foreachelse}
      <p class="alert alert-danger mt-3">{l s='Unfortunately, there are no payment method available.' d='Shop.Theme.Checkout'}</p>
    {/foreach}
  </div>

  <div class="payment-final">
    {if $conditions_to_approve|count}
      <form id="conditions-to-approve" method="GET" class="js-conditions-to-approve mb-3">
        <ul>
          {foreach from=$conditions_to_approve item="condition" key="condition_name"}
            <li>
              <label class="custom-checkbox">
                <span class="check-wrap">
                  <input  id    = "conditions_to_approve[{$condition_name}]"
                          name  = "conditions_to_approve[{$condition_name}]"
                          required
                          type  = "checkbox"
                          value = "1"
                          class = "ps-shown-by-js"
                  >
                  <span class="check-shape"><i class="material-icons check-icon">check</i></span>
                </span>
                <span class="js-terms">{$condition nofilter}</span>
              </label>
            </li>
          {/foreach}
        </ul>
      </form>
    {/if}

    {hook h='displayCheckoutBeforeConfirmation'}

    <div id="payment-confirmation" class="js-payment-confirmation">
      <div class="ps-shown-by-js text-center">
        <button type="submit" class="btn btn-primary btn-large btn-wrap {if !$selected_payment_option}disabled{/if}">
          {l s='Place order' d='Shop.Theme.Checkout'}
        </button>
        {if $show_final_summary}
          <article class="alert alert-warning mt-3 mb-0 p-1 js-alert-payment-conditions text-center d-none" role="alert" data-alert="danger">
            {l
              s='Please make sure you\'ve chosen a [1]payment method[/1] and accepted the [2]terms and conditions[/2].'
              sprintf=[
                '[1]' => '<a href="#checkout-payment-step">',
                '[/1]' => '</a>',
                '[2]' => '<a href="#conditions-to-approve">',
                '[/2]' => '</a>'
              ]
              d='Shop.Theme.Checkout'
            }
          </article>
        {/if}
      </div>
      <div class="ps-hidden-by-js">
        {if $selected_payment_option and $all_conditions_approved}
          <label for="pay-with-{$selected_payment_option}">{l s='Order with an obligation to pay' d='Shop.Theme.Checkout'}</label>
        {/if}
      </div>
    </div>
  </div>

  {hook h='displayPaymentByBinaries'}
{/block}
