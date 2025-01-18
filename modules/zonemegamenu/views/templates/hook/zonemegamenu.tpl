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

{if $zmenus}
  <div id="amegamenu" class="{if $is_rtl}amegamenu_rtl{/if}">
    <ul class="anav-top js-ajax-mega-menu">
    {foreach from=$zmenus item=menu}
      <li class="amenu-item {if $menu.dropdowns}plex{/if} {$menu.custom_class}" data-id-menu="{$menu.id_zmenu}">
        {if $menu.link}<a href="{$menu.link}" class="amenu-link" {if $menu.link_newtab}target="_blank"{/if}>{else}<span class="amenu-link">{/if}
          {if !empty($menu.title_image)}<img src="{$menu.title_image.url}" alt="{$menu.name}" width="{$menu.title_image.width}" height="{$menu.title_image.height}" />{/if}
          <span>{$menu.name nofilter}</span>
          {if $menu.label}<sup {if $menu.label_color}style="{$menu.label_color}"{/if}>{$menu.label}</sup>{/if}
        {if $menu.link}</a>{else}</span>{/if}

        {if $menu.dropdowns}
          <div class="adropdown adrd{$menu.drop_column}">
            <div class="js-dropdown-content" data-id-menu="{$menu.id_zmenu}"></div>
          </div>
        {/if}
      </li>
    {/foreach}
    </ul>
  </div>
{/if}
