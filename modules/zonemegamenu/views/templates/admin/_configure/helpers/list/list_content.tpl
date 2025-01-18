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

{extends file="helpers/list/list_content.tpl"}

{block name="open_td"}
	<td
		{if isset($params.type) && $params.type == 'zposition'}
			id="td_{if !empty($position_group_identifier)}{$position_group_identifier|escape:'html':'UTF-8'}{else}0{/if}_{$tr.$identifier|escape:'html':'UTF-8'}{if $smarty.capture.tr_count > 1}_{($smarty.capture.tr_count - 1)|intval}{/if}"
		{/if}
		class="{strip}{if !$no_link}pointer{/if}
		{if isset($params.type) && $params.type == 'zposition'} dragHandle{/if}
		{if isset($params.class)} {$params.class|escape:'html':'UTF-8'}{/if}
		{if isset($params.align)} {$params.align|escape:'html':'UTF-8'}{/if}{/strip}"
		{if (!isset($params.position) && !$no_link && !isset($params.remove_onclick))}
			onclick="document.location = '{$current_index|escape:'html':'UTF-8'}&amp;{$identifier|escape:'html':'UTF-8'}={$tr.$identifier|escape:'html':'UTF-8'}{if $view}&amp;view{else}&amp;update{/if}{$table|escape:'html':'UTF-8'}&amp;token={$token|escape:'html':'UTF-8'}'">
		{else}
	>
		{/if}
{/block}

{block name="td_content"}
	{if isset($params.type) && $params.type == 'zposition'}
		<div class="dragGroup">
			<div class="positions">
				{$tr.$key.position|intval}
			</div>
		</div>
	{elseif isset($params.type) && $params.type == 'zid_menu'}
		#{$tr.id_zmenu|escape:'htmlall':'UTF-8'}
	{elseif isset($params.type) && $params.type == 'zid_dropdown'}
		#{$tr.id_zdropdown|escape:'htmlall':'UTF-8'}

	{elseif isset($params.type) && $params.type == 'zmenu'}
		<span class="zmenu">
			<span>{$tr.name|escape:'htmlall':'UTF-8'} </span>
			{if $tr.label != ''}<sup style="background-color: {$tr.label_color|escape:'htmlall':'UTF-8'}">{$tr.label|escape:'htmlall':'UTF-8'}</sup>{/if}
		</span>

	{elseif isset($params.type) && $params.type == 'zdropdowncolumn'}
		<span>{if $tr.drop_column == 0}{l s='No Dropdown' mod='zonemegamenu'}{else}{$tr.drop_column|escape:'htmlall':'UTF-8'} {if $tr.drop_column == 1}{l s='column' mod='zonemegamenu'}{else}{l s='columns' mod='zonemegamenu'}{/if}{/if}</span>
		
	{elseif isset($params.type) && $params.type == 'zdropdowntype'}
		<span>{$tr.column|escape:'htmlall':'UTF-8'}-{l s='column' mod='zonemegamenu'}</span><br>
		{if $tr.custom_class}<span>.{$tr.custom_class}</span><br>{/if}
		{if $tr.content_type == 'category'}
			<span>{l s='Categories' mod='zonemegamenu'}{if $tr.categories}:{foreach from=$tr.categories|unserialize item=cat} #{$cat|escape:'htmlall':'UTF-8'}{/foreach}{/if}</span>
		{elseif $tr.content_type == 'product'}
			<span>{l s='Products' mod='zonemegamenu'}{if $tr.products}:{foreach from=$tr.products|unserialize item=pro} #{$pro|escape:'htmlall':'UTF-8'}{/foreach}{/if}</span>
		{elseif $tr.content_type == 'html'}
			<span>{l s='Custom HTML' mod='zonemegamenu'}{if $tr.static_content}: {$tr.static_content|strip_tags|truncate:20:'...'}{/if}</span>
		{elseif $tr.content_type == 'manufacturer'}
			<span>{l s='Manufacturers' mod='zonemegamenu'}{if $tr.manufacturers}:{foreach from=$tr.manufacturers|unserialize item=manu} #{$manu|escape:'htmlall':'UTF-8'}{/foreach}{/if}</span>
		{else}
			{l s='No Content' mod='zonemegamenu'}
		{/if}		
	{else}
		{$smarty.block.parent}
	{/if}
{/block}
