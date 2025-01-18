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

<div class="product-normal-layout">
  <div class="block md-bottom product-description-block {if !$product.description}d-none{/if}">
    <div class="title-block">{l s='Description' d='Shop.Theme.Catalog'}</div>
    <div class="block-content box-bg">
      {include file='catalog/_partials/product-description.tpl'}
    </div>
  </div>

  <div class="block md-bottom product-features-block {if !$product.grouped_features}d-none{/if}">
    <div class="title-block">{l s='Data sheet' d='Shop.Theme.Catalog'}</div>
    <div class="block-content box-bg">
      {include file='catalog/_partials/product-details.tpl'}
    </div>
  </div>


  {if $product.attachments}
  <div class="block product-attachments-block sm-bottom">
    <div class="title-block">{l s='Attachments' d='Shop.Theme.Catalog'}</div>
    <div class="block-content">
      {include file='catalog/_partials/product_attachments.tpl'}
    </div>
  </div>
  {/if}

  {if $product.extraContent}
    {foreach from=$product.extraContent item=extra key=extraKey}
      <div class="block md-bottom product-extra-block">
        <div class="title-block">{$extra.title}</div>
        <div class="block-content" {foreach $extra.attr as $key => $val}{if $val}{$key}="{$val}" {/if}{/foreach}>
          <div class="extra-content box-bg typo">
            {$extra.content nofilter}
          </div>
        </div>
      </div>
    {/foreach}
  {/if}
</div>
<!-- /normal -->
