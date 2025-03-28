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
<ul class="dropdown-menu">
  <li>
    <a href="{$urls.pages.identity}" class="dropdown-item">
      <span>{l s='Information' d='Shop.Theme.Customeraccount'}</span>
      <i class="material-icons">account_circle</i>
    </a>
  </li>
  <li>
    <a href="{$urls.pages.addresses}" class="dropdown-item">
      <span>{l s='Addresses' d='Shop.Theme.Customeraccount'}</span>
      <i class="material-icons">person_pin_circle</i>
    </a>
  </li>
  {if !$configuration.is_catalog}
  <li>
    <a href="{$urls.pages.history}" class="dropdown-item">
      <span>{l s='Orders' d='Modules.Trackingfront.Shop'}</span>
      <i class="material-icons">date_range</i>
    </a>
  </li>
  {/if}
  {if !$configuration.is_catalog}
  <li>
    <a href="{$urls.pages.order_slip}" class="dropdown-item">
      <span>{l s='Credit slips' d='Shop.Theme.Customeraccount'}</span>
      <i class="material-icons">receipt</i>
    </a>
  </li>
  {/if}
  {if $configuration.voucher_enabled && !$configuration.is_catalog}
  <li>
    <a href="{$urls.pages.discount}" class="dropdown-item">
      <span>{l s='Vouchers' d='Shop.Theme.Customeraccount'}</span>
      <i class="material-icons">local_offer</i>
    </a>
  </li>
  {/if}
  {if $configuration.return_enabled && !$configuration.is_catalog}
  <li>
    <a href="{$urls.pages.order_follow}" class="dropdown-item">
      <span>{l s='Merchandise returns' d='Shop.Theme.Customeraccount'}</span>
      <i class="material-icons">assignment_return</i>
    </a>
  </li>
  {/if}
  <li class="d-none js-otherCustomerDropdownLinks"></li>
  <li class="logout">
    <a href="{$urls.actions.logout}">
      <span>{l s='Sign out' d='Shop.Theme.Actions'}</span>
      <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
  </li>
</ul>
{assign var='hook_display_customer_account' value={hook h='displayCustomerAccount'}}
<div class="d-none js-displayCustomerAccount" data-hook-content="{$hook_display_customer_account}"></div>