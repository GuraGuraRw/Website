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

<div class="mailalert-product-page js-mailalert box-bg sm-bottom" data-url="{url entity='module' name='ps_emailalerts' controller='actions' params=['process' => 'add']}">

  <div class="mailalert-form js-mailalert-form d-flex">
    {if !empty($email)}
      <div class="alert-email">
        <input class="form-control" type="email" placeholder="{l s='your@email.com' d='Modules.Emailalerts.Shop'}"/>
      </div>
    {/if}
    {if !empty($id_module)}
      {capture name='gdprContent'}{hook h='displayGDPRConsent' id_module=$id_module}{/capture}
      {if $smarty.capture.gdprContent != ''}
         <div class="gdpr_consent_wrapper mt-1">{$smarty.capture.gdprContent nofilter}</div>
      {/if}       
    {/if}
    <div class="alert-button">
      <button
        data-product="{$product.id_product}"
        data-product-attribute="{$product.id_product_attribute}"
        class="btn btn-info js-mailalert-add"
        rel="nofollow">
        {l s='Notify me when available' d='Modules.Emailalerts.Shop'}
      </button>
    </div>
  </div>
  <div class="alert mailalert-msg js-mailalert-alerts" style="display: none;"></div>
</div>
