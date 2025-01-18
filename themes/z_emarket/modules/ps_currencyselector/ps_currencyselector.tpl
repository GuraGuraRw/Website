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

<div class="currency-selector-wrapper">
  <div class="currency-selector dropdown js-dropdown">
    <div class="desktop-dropdown">
      <span id="currency-selector-label">{l s='Currency:' d='Shop.Theme.Global'}</span>
      <button class="btn-unstyle dropdown-current expand-more dropdown-toggle" data-bs-toggle="dropdown" data-offset="0,2px" aria-haspopup="true" aria-expanded="false" aria-label="{l s='Currency dropdown' d='Shop.Theme.Global'}">
        <span>{$current_currency.iso_code}{if $current_currency.iso_code !== $current_currency.sign} {$current_currency.sign}{/if}</span>
      </button>
      <div class="dropdown-menu js-currency-source" aria-labelledby="currency-selector-label">
        <ul class="currency-list">
          {foreach from=$currencies item=currency}
            <li {if $currency.current}class="current"{/if}>
              <a title="{$currency.name}" rel="nofollow" href="{$currency.url}" class="dropdown-item">
                {$currency.iso_code}
                {if $currency.sign !== $currency.iso_code}<span class="c-sign">{$currency.sign}</span>{/if}
              </a>
            </li>
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>