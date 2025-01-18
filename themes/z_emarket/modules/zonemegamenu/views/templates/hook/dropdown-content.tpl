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

{if $dropdowns}
  <div class="dropdown-wrapper" {if $bgcolor}style="{$bgcolor}"{/if}>
    <div class="dropdown-bgimage" {if $bgimage}style="{$bgimage}"{/if}></div>
    {foreach from=$dropdowns item=dropdown}
      {if $dropdown.content_type != 'none' && $dropdown.column}
        <div class="dropdown-content acot{$dropdown.column} {if !empty($dropdown.fullwidth)}{else}notfull{/if} {$dropdown.custom_class}" data-id-dropdown="{$dropdown.id_zdropdown}">
          {if $dropdown.content_type == 'category'}
            {if $dropdown.categories}
              <div class="content-grid acategory-content {$dropdown.selfclass}">
                {foreach from=$dropdown.categories item=category name=categories}
                  {include file="module:zonemegamenu/views/templates/hook/category-item.tpl" category=$category}
                {/foreach}
              </div>
            {/if}

          {elseif $dropdown.content_type == 'product'}
            {if $dropdown.products}
              <div class="content-grid aproduct-content">
                {foreach from=$dropdown.products item=product name=products}
                  {include file="module:zonemegamenu/views/templates/hook/product-simple.tpl" product=$product}
                {/foreach}
              </div>
            {/if}

          {elseif $dropdown.content_type == 'manufacturer'}
            {if $dropdown.manufacturers}
              <div class="content-grid amanufacturer-content">
                {foreach from=$dropdown.manufacturers item=manufacturer name=manufacturers}
                  {include file="module:zonemegamenu/views/templates/hook/manufacturer-item.tpl" manufacturer=$manufacturer}
                {/foreach}
              </div>
            {/if}

          {elseif $dropdown.content_type == 'html'}
            {if $dropdown.static_content}
              <div class="ahtml-content typo">
                {$dropdown.static_content nofilter}
              </div>
            {/if}
          {/if}
        </div>
      {/if}
    {/foreach}
  </div>
{/if}
