{**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 *}
{if isset($CE_LISTING_BEST_SALES)}
    {$ce_layout=$layout}
{elseif file_exists("{$smarty.const._PS_THEME_DIR_}templates/catalog/listing/best-sales.tpl")}
    {$ce_layout='[1]catalog/listing/best-sales.tpl'}
{elseif $smarty.const._PARENT_THEME_NAME_ && file_exists("{$smarty.const._PS_PARENT_THEME_DIR_}templates/catalog/listing/best-sales.tpl")}
    {$ce_layout='parent:catalog/listing/best-sales.tpl'}
{else}
    {$ce_layout='catalog/listing/product-list.tpl'}
{/if}

{extends $ce_layout}

{if isset($CE_LISTING_BEST_SALES)}
    {block name='head_microdata_special'}{include file='_partials/microdata/product-list-jsonld.tpl' listing=$listing}{/block}

    {block name='content'}<section id="content">{$CE_LISTING_BEST_SALES|cefilter}</section>{/block}
{/if}