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
  {if $customer.is_logged && !$customer.is_guest}
    <div class="light-box-bg mb-4">
      <h5 class="identity">
        {l s='Connected as [1]%firstname% %lastname%[/1].'
          d='Shop.Theme.Customeraccount'
          sprintf=[
            '[1]' => "<a href='{$urls.pages.identity}'>",
            '[/1]' => "</a>",
            '%firstname%' => $customer.firstname,
            '%lastname%' => $customer.lastname
          ]
        }
      </h5>
      <p class="mb-0">
        {l
          s='Not you? [1]Log out[/1]'
          d='Shop.Theme.Customeraccount'
          sprintf=[
          '[1]' => "<a href='{$urls.actions.logout}'>",
          '[/1]' => "</a>"
          ]
        }
        {if !isset($empty_cart_on_logout) || $empty_cart_on_logout}
          (<span class="font-italic">{l s='If you sign out now, your cart will be emptied.' d='Shop.Theme.Checkout'}</span>)
        {/if}
      </p>
    </div>
    
    <div class="step-button-continue text-end">
      <form method="GET" action="{$urls.pages.order}">
        <button class="continue btn btn-primary" name="controller" type="submit" value="order">
          {l s='Continue' d='Shop.Theme.Actions'}
        </button>
      </form>
    </div>
  
  {else}

    <div class="personal-form {if !empty($modules.zonethememanager.checkout_login_first)}active{/if}" id="checkout-login-form">
      <h5 class="page-subheading">{l s='Sign in' d='Shop.Theme.Actions'}</h5>
      <div class="shadow-box">
        {render file='checkout/_partials/login-form.tpl' ui=$login_form}
      </div>

      <div class="text-center mt-4 mb-4">
        <a href="#checkout-guest-form" class="js-switch-personal-form btn btn-secondary btn-wrap">
          {if $guest_allowed}
            {l s='Order as a guest' d='Shop.Theme.Checkout'}
          {else}
            {l s='Create an account' d='Shop.Theme.Customeraccount'}
          {/if}
        </a>
      </div>
    </div>

    <div class="personal-form {if !empty($modules.zonethememanager.checkout_login_first)}{else}active{/if}" id="checkout-guest-form">
      <h5 class="page-subheading">
        {if $guest_allowed}
          {l s='Order as a guest' d='Shop.Theme.Checkout'}
        {else}
          {l s='Create an account' d='Shop.Theme.Customeraccount'}
        {/if}
      </h5>
      <div class="shadow-box">
        {render file='checkout/_partials/customer-form.tpl' ui=$register_form guest_allowed=$guest_allowed}
      </div>

      <div class="text-center mt-4 mb-4">
        <a href="#checkout-login-form" class="js-switch-personal-form btn btn-secondary btn-wrap">{l s='Already have an account?' d='Shop.Theme.Customeraccount'} {l s='Log in instead!' d='Shop.Theme.Customeraccount'}</a>
      </div>
    </div>
  {/if}
{/block}
