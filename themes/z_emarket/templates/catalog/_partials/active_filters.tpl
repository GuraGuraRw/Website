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
<div id="js-active-search-filters">
{if $activeFilters|count}
<section class="active-filters box-bg">
  <div class="active-search-wrapper">
    {block name='active_filters_title'}
      <p class="active-filter-title">{l s='Active filters' d='Shop.Theme.Global'}</p>
    {/block}

    <ul class="active-filter-list">
      {foreach from=$activeFilters item="filter"}
        {block name='active_filters_item'}
          <li class="filter-block">
            <span>{l s='%1$s: ' d='Shop.Theme.Catalog' sprintf=[$filter.facetLabel]} <strong>{$filter.label}</strong></span>
            <a class="js-search-link" href="{$filter.nextEncodedFacetsURL}"><i class="material-icons">&#xE5CD;</i></a>
          </li>
        {/block}
      {/foreach}
    </ul>
  </div>
</section>
{/if}
</div>
