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

<div class="thumbs-list {if $images|@count < 2}d-none{/if}">
  <div class="flex-scrollbox-wrapper js-product-thumbs-scrollbox">
    <ul class="product-images" id="js-zoom-gallery">
      {foreach from=$images item=image}
        <li class="thumb-container">
          <a
            class="thumb js-thumb {if $image.id_image == $default_id_image}selected{/if}"
            data-image="{$image.bySize.medium_default.url}"
            data-zoom-image="{$image.bySize.large_default.url}"
            data-id-image="{$image.id_image}"
          >
            <img
              src = "{$image.bySize.small_default.url}"
              {if !empty($image.legend)}
                alt="{$image.legend}"
                title="{$image.legend}"
              {else}
                alt="{$product.name}"
              {/if}
              class = "img-fluid"
              width = "{$image.bySize.small_default.width}"
              height = "{$image.bySize.small_default.height}"
            >
          </a>
        </li>
      {/foreach}
    </ul>
  </div>

  <div class="scroll-box-arrows">
    <i class="material-icons left">chevron_left</i>
    <i class="material-icons right">chevron_right</i>
  </div>
</div>
