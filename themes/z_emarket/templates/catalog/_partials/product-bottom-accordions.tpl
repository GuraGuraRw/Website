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
<div id="productAccordions" class="product-accordions js-product-accordions" role="tablist" aria-multiselectable="true">
  <div class="panel active">
    <div class="panel-heading" role="tab" id="headingDescription">
      <p class="panel-title h5">
        <a href="#collapseDescription" data-bs-toggle="collapse" data-parent="#productAccordions" aria-expanded="true" aria-controls="collapseDescription">
          <span>{l s='Description' d='Shop.Theme.Catalog'}</span><span><i class="caret-down-icon"></i></span>
        </a>
      </p>
    </div>
    <div id="collapseDescription" class="product-description-block panel-collapse collapse show" role="tabpanel" aria-labelledby="headingDescription">
      <div class="panel-content">
        {include file='catalog/_partials/product-description.tpl'}
      </div>
    </div>
  </div>

  <div class="panel {if !$product.grouped_features}d-none{/if}">
    <div class="panel-heading" role="tab" id="headingDetails">
      <p class="panel-title h5">
        <a href="#collapseDetails" data-bs-toggle="collapse" data-parent="#productAccordions" aria-expanded="false" aria-controls="collapseDetails">
          <span>{l s='Data sheet' d='Shop.Theme.Catalog'}</span><span><i class="caret-down-icon"></i></span>
        </a>
      </p>
    </div>
    <div id="collapseDetails" class="product-features-block panel-collapse collapse" role="tabpanel" aria-labelledby="headingDetails">
      <div class="panel-content">
        {include file='catalog/_partials/product-details.tpl'}
      </div>
    </div>
  </div>

  {if $product.attachments}
  <div class="panel">
    <div class="panel-heading" role="tab" id="headingAttachments">
      <p class="panel-title h5">
        <a href="#collapseAttachments" data-bs-toggle="collapse" data-parent="#productAccordions" aria-expanded="false" aria-controls="collapseAttachments">
          <span>{l s='Attachments' d='Shop.Theme.Catalog'}</span><span><i class="caret-down-icon"></i></span>
        </a>
      </p>
    </div>
    <div id="collapseAttachments" class="product-attachments-block panel-collapse collapse" role="tabpanel" aria-labelledby="headingAttachments">
      <div class="panel-content">
        {include file='catalog/_partials/product_attachments.tpl'}
      </div>
    </div>
  </div>
  {/if}

  {if $product.extraContent}
    {foreach from=$product.extraContent item=extra key=extraKey}
      <div class="panel">
        <div class="panel-heading" role="tab" id="headingExtra{$extraKey}">
          <div class="panel-title h5">
            <a href="#collapseExtra{$extraKey}" data-bs-toggle="collapse" data-parent="#productAccordions" aria-expanded="false" aria-controls="collapseExtra{$extraKey}">
              <span>{$extra.title}</span><span><i class="caret-down-icon"></i></span>
            </a>
          </div>
        </div>
        <div id="collapseExtra{$extraKey}" class="product-extra-block panel-collapse collapse" role="tabpanel" aria-labelledby="headingExtra{$extraKey}" {foreach $extra.attr as $key => $val}{if $val}{$key}="{$val}" {/if}{/foreach}>
        <div class="panel-content">
          <div class="extra-content typo">
            {$extra.content nofilter}
          </div>
        </div>
        </div>
      </div>
    {/foreach}
  {/if}
</div><!-- /accordions -->
