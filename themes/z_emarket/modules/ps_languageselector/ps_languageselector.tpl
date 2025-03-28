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
<div class="language-selector-wrapper">
  <div class="language-selector dropdown js-dropdown">
    <div class="desktop-dropdown">
      <span id="language-selector-label" class="hidden-md-up">{l s='Language:' d='Shop.Theme.Global'}</span>
      <button class="btn-unstyle dropdown-current expand-more dropdown-toggle" data-bs-toggle="dropdown" data-offset="0,2px" aria-haspopup="true" aria-expanded="false" aria-label="{l s='Language dropdown' d='Shop.Theme.Global'}">
        <span><img src="{$urls.img_lang_url}{$current_language.id_lang}.jpg" alt="{$current_language.name_simple}" width="16" height="11"></span>
        <span>&nbsp;&nbsp;{$current_language.name_simple}</span>
      </button>
      <div class="dropdown-menu js-language-source" aria-labelledby="language-selector-label">
        <ul class="language-list">
          {foreach from=$languages item=language}
            <li {if $language.id_lang == $current_language.id_lang} class="current" {/if}>
              <a href="{url entity='language' id=$language.id_lang}" title="{$language.name}" class="dropdown-item" data-iso-code="{$language.iso_code}">
                <span class="l-name">
                  <span><img src="{$urls.img_lang_url}{$language.id_lang}.jpg" alt="{$language.name_simple}" width="16" height="11"></span>
                  <span>&nbsp;&nbsp;{$language.name_simple}</span>
                </span>
                <span class="l-code">{$language.iso_code}</span>
              </a>
            </li>
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>
