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
{extends file=$layout}

{block name='head' append}
  <meta property="og:type" content="product">
  {if $product.cover}
    <meta property="og:image" content="{$product.cover.large.url}">
  {/if}

  {if $product.show_price}
    <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
    <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
    <meta property="product:price:amount" content="{$product.price_amount}">
    <meta property="product:price:currency" content="{$currency.iso_code}">
  {/if}
  {if isset($product.weight) && ($product.weight != 0)}
    <meta property="product:weight:value" content="{$product.weight}">
    <meta property="product:weight:units" content="{$product.weight_unit}">
  {/if}
{/block}

{block name='head_microdata_special'}
  {include file='_partials/microdata/product-jsonld.tpl'}
{/block}

{block name='content'}
<section>

  {block name='main_product_details'}
    <div class="main-product-details shadow-box md-bottom js-product-container" id="mainProduct">
      {assign var='hook_product_3rd_column' value={hook h='displayProduct3rdColumn'}}
      {if strpos($hook_product_3rd_column, 'data-key-zone-product-extra-fields') == false}
        {assign var='hook_product_3rd_column' value=false}
      {/if}

      <div class="row">
        {block name='product_left'}
          <div class="product-left col-12 col-md-5 {if $hook_product_3rd_column}col-xl-4{/if}">
            <section class="product-left-content">
              {block name='product_cover_thumbnails'}
                {include file='catalog/_partials/product-cover-thumbnails.tpl'}
              {/block}

              {hook h='displayAfterProductThumbs2'}

              {include file='catalog/_partials/product-flags.tpl'}
            </section>
          </div>
        {/block}

        {block name='product_right'}
          <div class="product-right col-12 col-md-7 {if $hook_product_3rd_column}col-xl-8{/if}">
            <section class="product-right-content">
              {block name='page_header_container'}
                {block name='page_header'}
                  <h1 class="page-heading">{block name='page_title'}{$product.name}{/block}</h1>
                {/block}
              {/block}

              <div class="row">
                <div class="col-12 {if $hook_product_3rd_column}col-xl-8{/if}">
                  <div class="product-attributes mb-2 js-product-attributes-destination"></div>

                  <div class="product-availability-top mb-3 js-product-availability-destination"></div>

                  {block name='product_out_of_stock'}
                    <div class="product-out-of-stock">
                      {hook h='actionProductOutOfStock' product=$product}
                    </div>
                  {/block}

                  {block name='product_description_short'}
                    <div id="product-description-short-{$product.id}" class="product-description-short typo sm-bottom">
                      {$product.description_short nofilter}
                    </div>
                  {/block}

                  {include file='catalog/_partials/product-information.tpl'}

                  {block name='product_additional_info'}
                    {include file='catalog/_partials/product-additional-info.tpl'}
                  {/block}

                  {hook h='displayProductAdditionalInfo2' product=$product}
                </div>

                {if $hook_product_3rd_column}
                  <div class="col-12 col-xl-4">
                    {$hook_product_3rd_column nofilter}
                  </div>
                {/if}
              </div>
            </section><!-- /product-right-content -->
          </div><!-- /product-right -->
        {/block}
      </div><!-- /row -->

      {block name='hook_display_reassurance'}
        <div class="reassurance-hook">
          {hook h='displayReassurance'}
        </div>
      {/block}

      <div class="js-product-refresh-pending-query page-loading-overlay main-product-details-loading">
        <div class="page-loading-backdrop d-flex align-items-center justify-content-center">
          <span class="uil-spin-css"><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span></span>
        </div>
      </div>
    </div><!-- /main-product-details -->
  {/block}

  {block name='main_product_bottom'}
    <div class="main-product-bottom md-bottom">
      {if !empty($modules.zonethememanager.product_info_layout)}
        {if $modules.zonethememanager.product_info_layout == 'accordions'}
          {include file='catalog/_partials/product-bottom-accordions.tpl'}

        {elseif $modules.zonethememanager.product_info_layout == 'tabs'}
          {include file='catalog/_partials/product-bottom-tabs.tpl'}

        {else}
          {include file='catalog/_partials/product-bottom-normal.tpl'}

        {/if}
      {/if}
    </div>
  {/block}

  {include file='catalog/_partials/product-accessories.tpl'}

  {block name='product_footer'}
    {if isset($category)}
      {hook h='displayFooterProduct' product=$product category=$category}
    {else}
      {hook h='displayFooterProduct' product=$product}
    {/if}
  {/block}

  {block name='product_images_modal'}
    {include file='catalog/_partials/product-images-modal.tpl'}
  {/block}
</section>
{/block}
