<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

use CE\ModulesXCatalogXWidgetsXProductXPrice as ProductPrice;

class ModulesXCatalogXWidgetsXProductXMiniatureXPrice extends ProductPrice
{
    public function getName()
    {
        return 'product-miniature-price';
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl('unit_price', ['default' => '']);

        $this->updateControl('price_color', ['scheme' => '']);

        $this->updateControl('typography_font_family', ['scheme' => '']);
        $this->updateControl('typography_font_weight', ['scheme' => '']);
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-product-price';
    }

    protected function render()
    {
        $product = $GLOBALS['smarty']->tpl_vars['product']->value;

        if (!$product['show_price']) {
            return;
        }
        $settings = $this->getSettingsForDisplay();
        ?>
        <div class="ce-product-prices">
        <?php if ($settings['regular'] && $product['has_discount']) { ?>
            <?php echo \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'old_price']); ?>
            <div class="ce-product-price-regular"><?php echo $product['regular_price']; ?></div>
        <?php } ?>
            <?php echo \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'before_price']); ?>
            <div class="ce-product-price<?php $product['has_discount'] && print ' ce-has-discount'; ?>">
                <span><?php echo \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'custom_price', 'hook_origin' => 'products_list']) ?: $product['price']; ?></span>
        <?php if ($settings['discount'] && $product['has_discount']) { ?>
            <?php if ('percentage' === $product['discount_type']) { ?>
                <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-percentage">
                    <?php _e('Save %percentage%', 'Shop.Theme.Catalog', ['%percentage%' => $product['discount_percentage_absolute']]); ?>
                </span>
            <?php } else { ?>
                <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-amount">
                    <?php _e('Save %amount%', 'Shop.Theme.Catalog', ['%amount%' => $product['discount_to_display']]); ?>
                </span>
            <?php } ?>
        <?php } ?>
            </div>
        <?php if ($settings['unit_price'] && $product['unit_price_full']) { ?>
            <div class="ce-product-price-unit"><?php _e('(%unit_price%)', 'Shop.Theme.Catalog', ['%unit_price%' => $product['unit_price_full']]); ?></div>
        <?php } ?>
            <?php echo \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'weight']); ?>
        </div>
        <?php
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();
        ?>
        {if $product.show_price}
            <div class="ce-product-prices">
        <?php if ($settings['regular']) { ?>
            {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type='old_price'}
                <div class="ce-product-price-regular">{$product.regular_price}</div>
            {/if}
        <?php } ?>
                {hook h='displayProductPriceBlock' product=$product type='before_price'}
                {capture assign='ce_price'}{hook h='displayProductPriceBlock' product=$product type='custom_price' hook_origin='products_list'}{/capture}
                <div class="ce-product-price{if $product.has_discount} ce-has-discount{/if}">
                    <span>{if $ce_price}{$ce_price nofilter}{else}{$product.price}{/if}</span>
        <?php if ($settings['discount']) { ?>
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
        <?php } ?>
                </div>
        <?php if ($settings['unit_price']) { ?>
            {if ($product.unit_price_full)}
                <div class="ce-product-price-unit">{l s='(%unit_price%)' sprintf=['%unit_price%' => $product.unit_price_full] d='Shop.Theme.Catalog'}</div>
            {/if}
        <?php } ?>
                {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
        {/if}
        <?php
    }
}
