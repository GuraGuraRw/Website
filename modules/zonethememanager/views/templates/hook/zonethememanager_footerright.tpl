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

<div class="footer-menu js-toggle-linklist-mobile">
{if $cmsLinks || $pageLinks || $staticLinks}
  <div class="row">
    {if $cmsLinks || $pageLinks }
      <div class="linklist col-12 col-lg-4">
        {if $cmsTitle}<p class="h4">{$cmsTitle}</p>{/if}
        <ul>
          {foreach from=$cmsLinks item=page}
            <li><a href="{$page.link}" title="{$page.title}">{$page.title}</a></li>
          {/foreach}
          {foreach from=$pageLinks item=page}
            <li>
            {if $page.id == 'stores'}
              <a href="{$page.link}" title="{l s='Our stores' d='Shop.Theme.Global'}">{l s='Our stores' d='Shop.Theme.Global'}</a>
            {elseif $page.id == 'prices-drop'}
              <a href="{$page.link}" title="{l s='Price drop' d='Shop.Theme.Catalog'}">{l s='Price drop' d='Shop.Theme.Catalog'}</a>
            {elseif $page.id == 'new-products'}
              <a href="{$page.link}" title="{l s='New products' d='Shop.Theme.Catalog'}">{l s='New products' d='Shop.Theme.Catalog'}</a>
            {elseif $page.id == 'best-sales'}
              <a href="{$page.link}" title="{l s='Best sellers' d='Shop.Theme.Catalog'}">{l s='Best sellers' d='Shop.Theme.Catalog'}</a>
            {elseif $page.id == 'contact'}
              <a href="{$page.link}" title="{l s='Contact us' d='Shop.Theme.Global'}">{l s='Contact us' d='Shop.Theme.Global'}</a>
            {elseif $page.id == 'sitemap'}
              <a href="{$page.link}" title="{l s='Sitemap' d='Shop.Theme.Global'}">{l s='Sitemap' d='Shop.Theme.Global'}</a>
            {/if}
            </li>
          {/foreach}
        </ul>
      </div>
    {/if}
    
    {if $staticLinks}
      <div class="linklist col-12 {if $cmsLinks || $pageLinks}col-lg-8{/if}">
        {$staticLinks nofilter}
      </div>
    {/if}
  </div>
{/if}
</div>
