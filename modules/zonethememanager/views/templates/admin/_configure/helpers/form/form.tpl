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

{extends file="helpers/form/form.tpl"}

{block name="input"}
	{if $input.type == 'checkbox_array'}
	<div id="{if isset($input.id)}{$input.id|escape:'htmlall':'UTF-8'}{else}{$input.name|escape:'htmlall':'UTF-8'}{/if}">
		{foreach from=$input.values item=value}
		<div class="checkbox">
			<label for="{$input.name|escape:'htmlall':'UTF-8'}_{$value.id|escape:'htmlall':'UTF-8'}">
				<input type="checkbox" name="{$input.name|escape:'htmlall':'UTF-8'}[]" value="{$value.val|escape:'html':'UTF-8'}" id="{$input.name|escape:'htmlall':'UTF-8'}_{$value.id|escape:'htmlall':'UTF-8'}" {if $value.val|in_array:$fields_value[$input.name]}checked="checked"{/if} />
				{$value.name|escape:'html':'UTF-8'}
			</label>
		</div>
		{/foreach}
	</div>
	
	{else}
		{$smarty.block.parent}
    {/if}

{/block}
