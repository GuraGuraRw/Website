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
<div class="aitem">
  {if $category.image && isset($category.image.bySize.category_medium)}
    <p class="category-thumb"><a href="{$category.url}" title="{$category.name}"><img class="img-fluid brightness-hover" src="{$category.image.bySize.category_medium.url}" alt="{$category.meta_title}" width="{$category.image.bySize.category_medium.width}" height="{$category.image.bySize.category_medium.height}" /></a></p>
  {/if}
  {if $category.name}
    <p class="category-title h5"><a href="{$category.url}">{if $category.menu_thumb}<img src="{$category.menu_thumb.url}" alt="{$category.name}" width="{$category.menu_thumb.width}" height="{$category.menu_thumb.height}" />{/if}<span>{$category.name}</span></a></p>
  {/if}
  {if $category.subcategories}
    <ul class="category-subs">
      {foreach from=$category.subcategories item=subcategory}
        <li>
          <a href="{$subcategory.url}">{if $subcategory.menu_thumb}<img src="{$subcategory.menu_thumb.url}" alt="{$subcategory.name}" width="{$subcategory.menu_thumb.width}" height="{$subcategory.menu_thumb.height}" />{/if}<span>{$subcategory.name}</span></a>
        </li>
      {/foreach}
    </ul>
  {/if}
</div>
