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
<div id="quickview-modal-{$product.id}-{$product.id_product_attribute}" class="modal fade quickview in" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-bs-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
      <div class="main-product-details" id="quickviewProduct">
        <div class="row">
          <div class="product-left col-12 col-md-5">          
            <section class="product-left-content">
              {block name='product_cover_thumbnails'}
                {include file='catalog/_partials/product-cover-thumbnails.tpl' is_quickview=true}
              {/block}
              
              {include file='catalog/_partials/product-flags.tpl'}
            </section>
          </div>
          <div class="product-right col-12 col-md-7">
            <section class="product-right-content">
              <h2 class="page-heading">{$product.name}</h2>

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

              {include file='catalog/_partials/product-information.tpl' is_quickview=true}
            </section>
          </div>
        </div>
        <div class="js-product-refresh-pending-query page-loading-overlay main-product-details-loading">
          <div class="page-loading-backdrop d-flex align-items-center justify-content-center">
            <span class="uil-spin-css"><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span><span><span></span></span></span>
          </div>
        </div>
      </div>

      <div class="d-none">
        {include file='catalog/_partials/product-details.tpl'}
      </div>
    </div>
    <div class="modal-footer">
      <div class="d-flex flex-wrap justify-content-between">
        {widget name='ps_sharebuttons' product=$product}
        
        <a class="btn btn-secondary view-details" href="{$product.url}"><span>{l s='View details' d='Shop.Zonetheme'}</span> &nbsp;<i class="caret-right"></i></a>
      </div>
    </div>
  </div>
  </div>
</div>
