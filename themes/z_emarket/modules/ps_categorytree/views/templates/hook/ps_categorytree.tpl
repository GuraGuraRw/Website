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

{function name="categories" nodes=[] depth=0}
  {strip}
    {if $nodes|count}
      <ul>
        {foreach from=$nodes item=node}
          <li data-depth="{$depth}">
              <a href="{$node.link}" title="{$node.name}" data-category-id="{$node.id}"><span>{$node.name}</span></a>
              {if $node.children}
                <div data-bs-toggle="collapse" data-bs-target="#exCollapsingNavbar{$node.id}">
                  <i class="material-icons collapse-icon add">add</i>
                  <i class="material-icons collapse-icon remove">remove</i>
                </div>
                <div class="category-sub-menu collapse" id="exCollapsingNavbar{$node.id}">
                  {categories nodes=$node.children depth=$depth+1}
                </div>
              {/if}
          </li>
        {/foreach}
      </ul>
    {/if}
  {/strip}
{/function}

<div class="left-categories column-block md-bottom">
  <p class="column-title">{$categories.name}</p>
  {if !empty($categories.children)}
    <div class="category-tree js-category-tree">
      {categories nodes=$categories.children}
    </div>
  {/if}
</div>
