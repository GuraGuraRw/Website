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
<div class="d-flex flex-wrap">
  {if !empty($modules.zonethememanager.is_mobile)}
    <!-- Does not show on mobile -->
  {else}
    <div class="product-display d-none d-md-block">
      <div class="d-flex">
        <ul class="display-select" id="product_display_control">
          <li class="d-flex">
            <a data-view="grid" href="#grid" title="{l s='Grid' d='Shop.Zonetheme'}" data-toggle="tooltip" data-placement="top">
              <i class="material-icons">view_comfy</i>
            </a>
            <a data-view="list" href="#list" title="{l s='List' d='Shop.Zonetheme'}" data-toggle="tooltip" data-placement="top">
              <i class="material-icons">view_list</i>
            </a>
            <a data-view="table-view" href="#table" title="{l s='Table' d='Shop.Zonetheme'}" data-toggle="tooltip" data-placement="top">
              <i class="material-icons">view_headline</i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  {/if}
  <label class="form-control-label d-none d-lg-block sort-label">{l s='Sort by:' d='Shop.Theme.Global'}</label>
  <div class="sort-select dropdown js-dropdown">
    <button
      class="form-select custom-select select-title dropdown-toggle"
      data-bs-toggle="dropdown"
      aria-label="{l s='Sort by selection' d='Shop.Theme.Global'}"
      aria-expanded="false"
      rel="nofollow"
    >
      {if $listing.sort_selected}{$listing.sort_selected}{else}{l s='Select' d='Shop.Theme.Actions'}{/if}
    </button>
    <div class="dropdown-menu">
      {foreach from=$listing.sort_orders item=sort_order}
        <a
          rel="nofollow"
          href="{$sort_order.url}"
          class="dropdown-item {['current' => $sort_order.current, 'js-search-link' => true]|classnames}"
        >
          {$sort_order.label}
        </a>
      {/foreach}
    </div>
  </div>
</div>
