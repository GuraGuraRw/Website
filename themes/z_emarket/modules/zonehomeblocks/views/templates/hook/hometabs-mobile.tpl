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
{if $homeTabs}
  {foreach from=$homeTabs item=block name=homeTabs}
    <div class="block block_id_{$block.id} clearfix">
      {if $block.block_type == $blocktype_product}
        <div class="title-block d-flex flex-wrap">
          <span>{$block.title}</span>
          {if $block.show_more_link}
            <span class="view-all-link">
              <a href="{$block.show_more_link}">{l s='Show More' d='Shop.Zonetheme'} &nbsp;<i class="material-icons">trending_flat</i></a>
            </span>
          {/if}
        </div>

        {include file="module:zonehomeblocks/views/templates/hook/block-product.tpl" ablock=$block}
        
      {elseif $block.block_type == $blocktype_html}
        {include file="module:zonehomeblocks/views/templates/hook/block-html.tpl" ablock=$block}
      {/if}
    </div>
  {/foreach}
{/if}
