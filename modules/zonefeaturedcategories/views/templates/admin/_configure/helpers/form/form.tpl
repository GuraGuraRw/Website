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
	{if $input.type == 'color'}
		<div class="form-group">
			<div class="col-lg-2">
				<div class="input-group">
					<input type="color"
					data-hex="true"
					{if isset($input.class)} class="{$input.class}"
					{else} class="color mColorPickerInput"{/if}
					name="{$input.name|escape:'html':'UTF-8'}"
					value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
				</div>
			</div>
		</div>
	{else}
		{$smarty.block.parent}
    {/if}

{/block}
