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

{if !empty($subcategories)}
  {if !empty($modules.zonethememanager.cat_subcategories)}
    <div class="subcategories mb-2">
      <h3 class="page-subheading">{l s='Subcategories' d='Shop.Theme.Category'}</h3>
      <div class="subcategories-wrapper row">
        {foreach from=$subcategories item="subcategory"}
          <div class="subcategory-miniature {if !$subcategory.image}no-image{/if} col-6 col-sm-4 col-md-4 col-lg-3">
            {if !empty($subcategory.image.medium.url)}
              <div class="subcategory-image">
                <a href="{$subcategory.url}">
                  <img
                    class = "img-fluid img-thumbnail"
                    src = "{$subcategory.image.medium.url}"
                    alt = "{$subcategory.image.legend|default: $subcategory.name}"
                    title = "{$subcategory.image.legend|default: $subcategory.name}"
                    width = "{$subcategory.image.medium.width}"
                    height = "{$subcategory.image.medium.height}"
                  >
                </a>
              </div>
            {/if}

            <h5 class="subcategory-name">
              <a href="{$subcategory.url}" class="li-a">{$subcategory.name}</a>
            </h5>
          </div>
        {/foreach}
      </div>
    </div>
  {/if}
{/if}
