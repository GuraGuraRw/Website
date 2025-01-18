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

<div class="blockreassurance-wrapper container">
  <div class="blockreassurance block-reassurance blockreassurance-outside">
    {foreach from=$blocks item=$block key=$key name=blocks}
      <div class="block-reassurance-item" {if $block.type_link !== $LINK_TYPE_NONE && !empty($block.link)}style="cursor:pointer;" onclick="window.open('{$block.link}')"{/if}>
          <p class="item-icon">
            {if $block['icon'] != 'undefined'}
              {if $block['custom_icon']}
                <img {if $block['is_svg']}class="svg invisible" {/if}src="{$block['custom_icon']}">
              {elseif $block['icon']}
                <img class="svg invisible" src="{$block['icon']}">
              {/if}
            {/if}
          </p>
          <div class="item-text" style="color:{$textColor}">
            <strong>{$block.title}</strong>
            {if $block.description}<br><span>{$block.description nofilter}</span>{/if}
          </div>
      </div>
    {/foreach}
  </div>
</div>
