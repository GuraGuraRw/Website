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
<div id="js-product-list-header">
  {if !empty($modules.zonethememanager.cat_image) && !empty($category.image.large.url)}
    <div class="category-cover mb-4">
      <img class="img-fluid" src="{$category.image.large.url}" alt="{$category.image.legend|default: $category.name}" width="{$category.image.large.width}" height="{$category.image.large.height}">
    </div>
  {/if}

  <h1 class="page-heading js-category-page" data-current-category-id="{$category.id}">{$category.name}</h1>
  
  {if !empty($modules.zonethememanager.cat_description) && $category.description}
    <div class="category-description mb-4">
      {if !empty($modules.zonethememanager.cat_expand_desc)}
        <div class="js-expand-description">
          <div class="descSmall">
            <div class="typo descFull">
              {$category.description nofilter}
            </div>
          </div>
          <div class="descToggle expand">
            <a href="#expand">&nbsp;{l s='Show More' d='Shop.Zonetheme'}<i class="material-icons">expand_more</i></a>
          </div>
          <div class="descToggle collapse">
            <a href="#collapse">&nbsp;{l s='Show Less' d='Shop.Zonetheme'}<i class="material-icons">expand_less</i></a>
          </div>
        </div>

      {else}
      
        <div class="typo">
          {$category.description nofilter}
        </div>
      {/if}
    </div>
  {/if}

  {block name='subcategory_list'}
    {if isset($subcategories) && $subcategories|@count > 0}
      {include file='catalog/_partials/subcategories.tpl' subcategories=$subcategories}

      {hook h='displaySubCategoriesBlock' subcategories=$subcategories id_category=$category.id}
    {/if}
  {/block}
</div>
