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
{block name='product_details'}
  <div class="product-details js-product-details" id="product-details" data-product="{$product.embedded_attributes|json_encode}">
    
    <div class="js-product-attributes-source d-none">
      {block name='product_manufacturer'}
        {if isset($product_manufacturer->id)}
          <div class="attribute-item product-manufacturer">
            <label>{l s='Brand' d='Shop.Theme.Catalog'}</label>
            <a href="{$product_brand_url}" class="li-a"><span>{$product_manufacturer->name}</span></a>

            {if isset($manufacturer_image_url)}
              <div class="brand-logo">
                <a href="{$product_brand_url}">
                  <img src="{$manufacturer_image_url}" class="img-fluid" alt="{$product_manufacturer->name}" />
                </a>
              </div>
            {/if}
          </div>
        {/if}
      {/block}

      {block name='product_reference'}
        {if isset($product.reference_to_display) && $product.reference_to_display neq ''}
          <div class="attribute-item product-reference">
            <label>{l s='Reference' d='Shop.Theme.Catalog'}</label>
            <span>{$product.reference_to_display}</span>
          </div>
        {/if}
      {/block}

      {block name='product_condition'}
        {if $product.condition}
          <div class="attribute-item product-condition">
            <label>{l s='Condition' d='Shop.Theme.Catalog'}</label>
            <span>{$product.condition.label}</span>
          </div>
        {/if}
      {/block}

      {block name='product_quantities'}
        {if $product.show_quantities}
          <div class="attribute-item product-quantities">
            <label>{l s='In stock' d='Shop.Theme.Catalog'}</label>
            <span data-stock="{$product.quantity}" data-allow-oosp="{$product.allow_oosp}">{$product.quantity} {$product.quantity_label}</span>
          </div>
        {/if}
      {/block}

      {block name='product_availability_date'}
        {if $product.availability_date}
          <div class="attribute-item product-availability-date">
            <label>{l s='Availability date:' d='Shop.Theme.Catalog'}</label>
            <span>{$product.availability_date}</span>
          </div>
        {/if}
      {/block}

      {block name='product_specific_references'}
        {if !empty($product.specific_references)}
          {foreach from=$product.specific_references item=reference key=key}
            <div class="attribute-item product-specific-references {$key}">
              <label>{$key}</label>
              <span>{$reference}</span>
            </div>
          {/foreach}
        {else}
          {if $product.ean13}
            <div class="attribute-item product-specific-references ean13">
              <label>{l s='ean13' d='Shop.Theme.Catalog'}</label>
              <span>{$product.ean13}</span>
            </div>
          {/if}
          {if $product.isbn}
            <div class="attribute-item product-specific-references isbn">
              <label>{l s='isbn' d='Shop.Theme.Catalog'}</label>
              <span>{$product.isbn}</span>
            </div>
          {/if}
          {if $product.upc}
            <div class="attribute-item product-specific-references upc">
              <label>{l s='upc' d='Shop.Theme.Catalog'}</label>
              <span>{$product.upc}</span>
            </div>
          {/if}
        {/if}
      {/block}
    </div>

    {block name='product_features'}
      {if $product.grouped_features}
        <section class="product-features">
          <dl class="data-sheet">
            {foreach from=$product.grouped_features item=feature}
              <dt class="name">{$feature.name}</dt>
              <dd class="value">{$feature.value|escape:'htmlall'|nl2br nofilter}</dd>
            {/foreach}
          </dl>
        </section>
      {/if}
    {/block}
  </div>
{/block}
