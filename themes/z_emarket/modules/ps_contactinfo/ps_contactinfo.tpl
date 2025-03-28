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

<div class="block-contact col-12 col-md-6 col-lg-3 links wrapper sm-bottom">
  <h4 class="text-uppercase block-contact-title">{l s='Store information' d='Shop.Theme.Global'}</h4>

  <p>{$contact_infos.address.formatted nofilter}</p>

  {if $contact_infos.phone}
    <p>
      {l s='Call us:' d='Shop.Theme.Global'}
      <a href="tel:{$contact_infos.phone|replace:' ':''}">{$contact_infos.phone}</a>
    </p>
  {/if}
  {if $contact_infos.fax}
    <p>
      {l s='Fax:' d='Shop.Theme.Global'}
      {$contact_infos.fax}
    </p>
  {/if}
  {if $contact_infos.email && $display_email}
    <p>
      {l s='Email us:' d='Shop.Theme.Global'}
      {mailto address=$contact_infos.email encode="javascript"}
    </p>
  {/if}
</div>