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
<div class="customer-signin-module">
  <div class="user-info">
    {if $customer.is_logged}
      <div class="customer-logged">
        <div class="js-account-source">
          <ul>
            <li>
              <div class="account-link d-flex align-items-center">
                <ul>
                  <li class="login">
                    <a href="{$urls.pages.my_account}"
                      title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                      <span>{l s='My account' d='Shop.Theme.Actions'}</span>
                    </a>
                  </li>
                  <li class="register">
                    <a href="{$urls.pages.register}"
                      title="{l s='My account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                      <span>{$customerName}</span>
                    </a>
                  </li>
                </ul>
              </div>
              <a href="{$urls.actions.logout}" class="logout-link">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span>{l s='Sign out' d='Shop.Theme.Actions'}</span>
              </a>
            </li>
          </ul>
        </div>

        {if !empty($modules.zonethememanager.is_mobile) || $page.page_name == 'cart' || $page.page_name == 'checkout'}
          <!-- Does not show on mobile -->
        {else}
          <div class="dropdown-customer-account-links">
            {include file="module:ps_customersignin/customer-dropdown-menu.tpl"}
          </div>
        {/if}
      </div>
    {else}
      <div class="js-account-source">
        <ul>
          <li>
            <div class="account-link d-flex align-items-center">
              <ul>
                <li class="login">
                  <a href="{$urls.pages.authentication}?back={$urls.current_url}"
                    title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                    <span>{l s='Sign in' d='Shop.Theme.Actions'}</span>
                  </a>
                </li>
                <li class="register">
                  <a href="{$urls.pages.register}"
                    title="{l s='Log in to your customer account' d='Shop.Theme.Customeraccount'}" rel="nofollow">
                    <span>{l s='Create an Account' d='Shop.Theme.Actions'}</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      {/if}
    </div>
  </div>