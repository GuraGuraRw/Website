        {* Generated by Creative Elements, do not modify it *}
        {ce_enqueue_miniature(11170101)}
        <div data-elementor-type="product-miniature" data-elementor-id="11170101" class="elementor elementor-11170101{if !empty($productClasses)} {$productClasses}{/if}">
            <article class="elementor-section-wrap" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
                    <section class="elementor-element elementor-element-820d0ce elementor-section-full_width elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="820d0ce" data-element_type="section">
                  <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                <div class="elementor-element elementor-element-2d1242b elementor-column elementor-col-100 elementor-top-column" data-id="2d1242b" data-element_type="column" data-settings="{literal}{&quot;background_background&quot;:&quot;classic&quot;}{/literal}">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-c7cb9fb elementor-widget elementor-widget-product-miniature-image elementor-widget-image" data-id="c7cb9fb" data-element_type="widget" data-widget_type="product-miniature-image.default">
        <div class="elementor-widget-container">{if $product.cover}{$image = $product.cover}{else}{$image = call_user_func("CE\Helper::getNoImage")}{/if}        {$caption = ""}
        {$image_by_size = $image.bySize['large_default']}
        {$srcset = ["{$image_by_size.url} {$image_by_size.width}w"]}
        {foreach $image.bySize as $size => $img}
            {if 'large_default' !== $size}
                {$srcset[] = "{$img.url} {$img.width}w"}
            {/if}
        {/foreach}
        <div class="ce-product-image elementor-image">
        {if $caption}
            <figure class="ce-caption">
        {/if}
            <a href="{$product.url}">
                <img src="{$image_by_size.url}" srcset="{implode(', ', $srcset)}" alt="{$caption}" loading="lazy"
                                    width="{$image_by_size.width}" height="{$image_by_size.height}"
                    sizes="(max-width: {$image_by_size.width}px) 100vw, {$image_by_size.width}px">
            </a>
        {if $caption}
            <figcaption class="widget-image-caption ce-caption-text">{$caption}</figcaption>
            </figure>
        {/if}
        </div>
        </div>        </div>
                        </div>
            </div>
        </div>
                        </div>
            </div>
        </section>
                <section class="elementor-element elementor-element-6b39201 my-pro-mini elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-id="6b39201" data-element_type="section">
                  <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-row">
                <div class="elementor-element elementor-element-0d47dd3 elementor-column elementor-col-100 elementor-top-column" data-id="0d47dd3" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                <div class="elementor-element elementor-element-3478069 elementor-widget elementor-widget-product-miniature-name elementor-widget-heading" data-id="3478069" data-element_type="widget" data-widget_type="product-miniature-name.default">
        <div class="elementor-widget-container"><h3 class="ce-product-name elementor-heading-title"><a href="{$product.url}">{$product.name}</a></h3></div>        </div>
                <div class="elementor-element elementor-element-5a9cbef ce-product-prices--layout-stacked elementor-widget elementor-widget-product-miniature-price elementor-overflow-hidden elementor-widget-product-price" data-id="5a9cbef" data-element_type="widget" data-widget_type="product-miniature-price.default">
        <div class="elementor-widget-container">        {if $product.show_price}
            <div class="ce-product-prices">
                    {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type='old_price'}
                <div class="ce-product-price-regular">{$product.regular_price}</div>
            {/if}
                        {hook h='displayProductPriceBlock' product=$product type='before_price'}
                {capture assign='ce_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                <div class="ce-product-price{if $product.has_discount} ce-has-discount{/if}">
                    <span>{if $ce_price}{$ce_price nofilter}{else}{$product.price}{/if}</span>
                    {if $product.has_discount}
                {if 'percentage' === $product['discount_type']}
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-percentage">
                        {l s='Save %percentage%' sprintf=['%percentage%' => $product.discount_percentage_absolute] d='Shop.Theme.Catalog'}
                    </span>
                {else}
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-amount">
                        {l s='Save %amount%' sprintf=['%amount%' => $product.discount_to_display] d='Shop.Theme.Catalog'}
                    </span>
                {/if}
            {/if}
                        </div>
                        {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
        {/if}
        </div>        </div>
                <div class="elementor-element elementor-element-db51891 elementor-view-default elementor-widget elementor-widget-product-add-to-wishlist elementor-widget-icon" data-id="db51891" data-element_type="widget" data-widget_type="product-add-to-wishlist.default">
        <div class="elementor-widget-container">        {$atw_class = 'ce-add-to-wishlist'}
        {$atw_icon = 'ceicon-heart-o'}
        {if !isset($js_custom_vars.productsAlreadyTagged)}
            {$js_custom_vars.productsAlreadyTagged = []}
            {$js_custom_vars.blockwishlistController = {url entity='module' name='blockwishlist' controller='action'}}
        {/if}
        {foreach $js_custom_vars.productsAlreadyTagged as $tagged}
            {if $tagged.id_product == $product.id && $tagged.id_product_attribute == $product.id_product_attribute}
                {$atw_icon = 'ceicon-heart'}
                {$atw_class = 'ce-add-to-wishlist elementor-active'}
                {break}
            {/if}
        {/foreach}
        <div class="elementor-icon-wrapper">
            <a class="elementor-icon {$atw_class}" data-product-id="{$product.id}" data-product-attribute-id="{$product.id_product_attribute}" href="{$js_custom_vars.blockwishlistController}">
                <i class="{$atw_icon}" aria-hidden="true"></i>
            </a>
        </div>
        </div>        </div>
                        </div>
            </div>
        </div>
                        </div>
            </div>
        </section>
                    </article>
        </div>
        