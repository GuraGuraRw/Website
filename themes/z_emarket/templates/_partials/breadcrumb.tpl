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

<nav class="breadcrumb-wrapper {if !empty($modules.zonethememanager.is_mobile)}mobile-breadcrumb-wrapper{/if}">
  <div class="container">
    <ol class="breadcrumb" data-depth="{$breadcrumb.count}">
      {foreach from=$breadcrumb.links item=path name=breadcrumb}
        {block name='breadcrumb_item'}
          {if $path.url && $path.title}
            <li class="breadcrumb-item">
              {if !$smarty.foreach.breadcrumb.first}
                <span class="separator material-icons">chevron_right</span>
              {/if}
              {if $smarty.foreach.breadcrumb.first or !$smarty.foreach.breadcrumb.last}
                <a href="{$path.url}" class="item-name">
                  {if $smarty.foreach.breadcrumb.first}
                    <i class="fa fa-home home" aria-hidden="true"></i>
                  {/if}
                    <span>{$path.title}</span>
                </a>
              {else}
                <span class="item-name">{$path.title}</span>
              {/if}
            </li>
          {/if}
        {/block}
      {/foreach}
    </ol>
  </div>
</nav>
