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
* @author PrestaShop SA and Contributors <contact@prestashop.com>
  * @copyright Since 2007 PrestaShop SA and Contributors
  * @license https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
  *}

  <div class="block-newsletter js-emailsubscription" id="blockEmailSubscription_{$hookName}">
    <p class="h4">{l s='Newsletter' d='Modules.Emailsubscription.Shop'}</p>

    <form action="{if isset($urls) && $urls.current_url}{$urls.current_url}#blockEmailSubscription_{$hookName}{/if}"
      method="post" class="js-subscription-form">
      <div class="newsletter-message">
        {if $msg}
        <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">{$msg}</p>
        {elseif $conditions}
        <p class="conditons">{$conditions}</p>
        {/if}
      </div>
      <div class="newsletter-form">
        <div class="input-wrapper">
        <input
          name="email"
          type="email"
          value="{$value}"
          class="form-control"
          placeholder="{l s='Your email address' d='Shop.Forms.Labels'}"
          aria-label="{l s='Email address' d='Shop.Forms.Labels'}"
          required
        >
          <span class="input-btn">
            <button type="submit" name="submitNewsletter" class="btn btn-primary d-none d-lg-inline-block">
              {l s='Subscribe' d='Shop.Theme.Actions'}
            </button>
            <button type="submit" name="submitNewsletter" class="btn btn-primary d-inline-block d-lg-none">
              {l s='OK' d='Shop.Theme.Actions'}
            </button>
          </span>
        </div>
        <input type="hidden" name="blockHookName" value="{$hookName}" />
        <input type="hidden" name="action" value="0" />
      </div>

      {hook h='displayNewsletterRegistration'}
      {if isset($id_module)}
      {hook h='displayGDPRConsent' id_module=$id_module}
      {/if}
    </form>
  </div>