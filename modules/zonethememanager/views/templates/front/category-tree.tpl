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

{if $sidebarMenus}
  <div class="category-tree sidebar-category-tree js-sidebar-categories">
    <ul>
    {foreach from=$sidebarMenus item=menu}
      <li>
        <a href="{$menu.link}" title="{$menu.name}" data-category-id="{$menu.id}" {if $menu.menu_thumb}class="name-with-icon"{/if}>{if $menu.menu_thumb}<img src="{$menu.menu_thumb.url}" alt="{$menu.name}" width="{$menu.menu_thumb.width}" height="{$menu.menu_thumb.height}" />{/if}<span>{$menu.name}</span></a>

        {if isset($menu.children) && $menu.children}
          {include file="module:zonethememanager/views/templates/front/sub_category_tree.tpl" submenus=$menu.children}
        {/if}
      </li>
    {/foreach}
    </ul>
  </div>
{/if}
