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

{$alert nofilter}

<div class="row">
  <div class="left-panel col-lg-2 col-md-3">
    <div class="list-group">
      {foreach from=$groups item=group}
        <a class="list-group-item {if $action == $group}active{/if}" href="{$panel_href}&action={$group}">{$group}</a>
      {/foreach}
      <a class="list-group-item dark {if $action == 'custom_css'}active{/if}" href="{$panel_href}&action=custom_css">
        {l s='Custom CSS' mod='zonecolorsfonts'}
      </a>
    </div>
  </div>
  <div class="main-settings col-lg-10 col-md-9">
    {$settings_form nofilter}
  </div>
</div>

<div class="panel" style="clear: both; margin-top: 50px; max-width: 500px;">
  <h3><i class="icon icon-circle"></i> Documentation</h3>
  <p>Please read file <a href="{$doc_url}" target="_blank">documentation.pdf</a> to configure this module.</p>
</div>
