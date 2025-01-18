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

{if !empty($modules.zonethememanager.sidebar_navigation)}
  <div class="st-menu st-effect-left" data-st-menu>
    <div class="st-menu-close d-flex" data-close-st-menu><i class="material-icons">close</i></div>
    <div class="st-menu-title h4">
      {l s='Menu' d='Shop.Zonetheme'}
    </div>

    {if !empty($modules.zonethememanager.mobile_megamenu)}
      {hook h='displayMobileMenu'}
    {else}
      {hook h='displaySidebarNavigation'}
    {/if}

    <div id="js-header-phone-sidebar" class="sidebar-header-phone js-hidden"></div>
    <div id="js-account-sidebar" class="sidebar-account text-center user-info js-hidden"></div>
    <div id="js-language-sidebar" class="sidebar-language js-hidden"></div>
    <div id="js-left-currency-sidebar" class="sidebar-currency js-hidden"></div>
  </div>
{/if}