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
{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Merchandise returns' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}

  <p class="font-weight-bold">{l s='Here is a list of pending merchandise returns' d='Shop.Theme.Customeraccount'}</p>

  {if $ordersReturn && count($ordersReturn)}

    <div class="d-none d-xl-block">
      <table class="table table-bordered">
        <thead class="thead-default">
          <tr>
            <th>{l s='Order' d='Shop.Theme.Customeraccount'}</th>
            <th>{l s='Return' d='Shop.Theme.Customeraccount'}</th>
            <th>{l s='Package status' d='Shop.Theme.Customeraccount'}</th>
            <th>{l s='Date issued' d='Shop.Theme.Customeraccount'}</th>
            <th>{l s='Returns form' d='Shop.Theme.Customeraccount'}</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$ordersReturn item=return}
            <tr>
              <th><a href="{$return.details_url}" class="li-a">{$return.reference}</a></th>
              <td><a href="{$return.return_url}">{$return.return_number}</a></td>
              <td>{$return.state_name}</td>
              <td>{$return.return_date}</td>
              <td class="text-center">
                {if $return.print_url}
                  <a href="{$return.print_url}">{l s='Print out' d='Shop.Theme.Actions'}</a>
                {else}
                  -
                {/if}
              </td>
            </tr>
          {/foreach}
        </tbody>
      </table>
    </div>

    <div class="d-block d-xl-none">
      <div class="order-returns light-box-bg">
        {foreach from=$ordersReturn item=return}
          <div class="order-return">
            <div class="row">
              <div class="col-6"><strong>{l s='Order' d='Shop.Theme.Customeraccount'}</strong></div>
              <div class="col-6"><a href="{$return.details_url}" class="li-a"><strong>{$return.reference}</strong></a></div>

              <div class="col-6"><strong>{l s='Return' d='Shop.Theme.Customeraccount'}</strong></div>
              <div class="col-6"><a href="{$return.return_url}">{$return.return_number}</a></div>

              <div class="col-6"><strong>{l s='Package status' d='Shop.Theme.Customeraccount'}</strong></div>
              <div class="col-6">{$return.state_name}</div>

              <div class="col-6"><strong>{l s='Date issued' d='Shop.Theme.Customeraccount'}</strong></div>
              <div class="col-6">{$return.return_date}</div>

              {if $return.print_url}
                <div class="col-6"><strong>{l s='Returns form' d='Shop.Theme.Customeraccount'}</strong></div>
                <div class="col-6"><a href="{$return.print_url}">{l s='Print out' d='Shop.Theme.Actions'}</a></div>
              {/if}
            </div>
          </div>
        {/foreach}
      </div>
    </div>

  {else}
    <div class="alert alert-info" role="alert" data-alert="info">{l s='You have no merchandise return authorizations.' d='Shop.Notifications.Error'}</div>

  {/if}

{/block}
