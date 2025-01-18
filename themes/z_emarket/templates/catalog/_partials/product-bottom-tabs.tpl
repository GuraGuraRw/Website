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

<div class="product-tabs">
  <ul class="nav nav-tabs flex-lg-nowrap">
    {if $product.description}
    <li class="nav-item product-description-nav-item">
      <a class="nav-link active" data-bs-toggle="tab" href="#collapseDescription">
        <span>{l s='Description' d='Shop.Theme.Catalog'}</span>
      </a>
    </li>
    {/if}
    {if $product.grouped_features}
    <li class="nav-item product-features-nav-item">
      <a class="nav-link {if !$product.description}active{/if}" data-bs-toggle="tab" href="#collapseDetails">
        <span>{l s='Data sheet' d='Shop.Theme.Catalog'}</span>
      </a>
    </li>
    {/if}
    {if $product.attachments}
    <li class="nav-item product-attachments-nav-item">
      <a class="nav-link {if !$product.description && $product.grouped_features}active{/if}" data-bs-toggle="tab" href="#collapseAttachments">
        <span>{l s='Attachments' d='Shop.Theme.Catalog'}</span>
      </a>
    </li>
    {/if}
    {if $product.extraContent}
    {foreach from=$product.extraContent item=extra key=extraKey name=productExtraContent}
      <li class="nav-item product-extra-nav-item">
        <a class="nav-link {if !$product.description && !$product.grouped_features && !$product.attachments && $smarty.foreach.productExtraContent.first}active{/if}" data-bs-toggle="tab" href="#collapseExtra{$extraKey}">
          <span>{$extra.title}</span>
        </a>
      </li>
    {/foreach}
    {/if}
  </ul>
  <div class="tab-content light-box-bg">
    <div id="collapseDescription" class="product-description-block tab-pane fade {if $product.description}show active{/if}">
      <div class="panel-content">
        {include file='catalog/_partials/product-description.tpl'}
      </div>
    </div>
    <div id="collapseDetails" class="product-features-block tab-pane fade {if $product.grouped_features && !$product.description}show active{/if}">
      <div class="panel-content">
        {include file='catalog/_partials/product-details.tpl'}
      </div>
    </div>
    {if $product.attachments}
    <div id="collapseAttachments" class="product-attachments-block tab-pane fade {if !$product.description && !$product.grouped_features}show active{/if}">
      <div class="panel-content">
        {include file='catalog/_partials/product_attachments.tpl'}
      </div>
    </div>
    {/if}
    {if $product.extraContent}
    {foreach from=$product.extraContent item=extra key=extraKey name=productExtraContent}
      <div id="collapseExtra{$extraKey}" class="product-extra-block tab-pane fade {if !$product.description && !$product.grouped_features && !$product.attachments && $smarty.foreach.productExtraContent.first}show active{/if}">
        <div class="panel-content" {foreach $extra.attr as $key => $val}{if $val}{$key}="{$val}" {/if}{/foreach}>
          <div class="extra-content typo">
            {$extra.content nofilter}
          </div>
        </div>
      </div>
    {/foreach}
    {/if}
  </div>
</div><!-- /tabs -->
