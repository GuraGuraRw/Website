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

{if $aslides}
<div class="aone-slideshow {if isset($settings.layout) && $settings.layout == 'boxed'}container{/if}">
  {foreach from=$aslides item=aslide name=aslides}
    <div class="a-banner">
      {if !empty($modules.zonethememanager.lazy_loading)}
        <img
          src = "data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20{$aslide.image_width}%20{$aslide.image_height}%22%3E%3C/svg%3E"
          data-original = "{$image_baseurl}{$aslide.image}"
          alt = "{$aslide.title}"
          title = "{$aslide.title}"
          width = "{$aslide.image_width}"
          height = "{$aslide.image_height}"
          class = "img-fluid js-lazy"
        />
      {else}
        <img
          src = "{$image_baseurl}{$aslide.image}"
          alt = "{$aslide.title}"
          title = "{$aslide.title}"
          width = "{$aslide.image_width}"
          height = "{$aslide.image_height}"
          class = "img-fluid"
        />
      {/if}

      {if $aslide.caption || $aslide.related_products || $aslide.slide_link}
        <div class="nivo-caption">
          {if $aslide.slide_link}<a class="slide-link" href="{$aslide.slide_link}" title=""></a>{/if}

          {if $aslide.caption}
            <div class="caption-wrapper">
              <div class="caption-content">
                {$aslide.caption nofilter} 
              </div>
            </div>
          {/if}

          {if $aslide.related_products}
            <div class="slide-products-related d-none d-xl-block">
              <div class="slide-products-related-wrapper">
                {include file="module:zoneslideshow/views/templates/hook/product-list.tpl" aproducts=$aslide.related_products}
              </div>
            </div>
          {/if}
        </div>
      {/if}
    </div>
  {/foreach}
</div>
{/if}
