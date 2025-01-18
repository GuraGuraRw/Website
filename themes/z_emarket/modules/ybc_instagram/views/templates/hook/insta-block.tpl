{*
* 2007-2020 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2020 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}

{assign var='YBC_INS_POSITION' value=($PAGE_TYPE != 'GALLERY' && $PAGE_TYPE != 'TAG' && ( ($PAGE_TYPE == 'SLIDER' && in_array($YBC_INS_SLIDER_HOOK, array('left', 'right'))) || ($PAGE_TYPE == 'POPP' && in_array($YBC_INS_POPP_HOOK_TO, array('product_thumbs','additional_info'))) || $PAGE_TYPE == 'SHORT_CODE' ) )}
<div class="ybc_ins_img_list{if $YBC_INS_DISPLAY_TAG && $PAGE_TYPE != 'TAG' && !(isset($AJAX_TAG))} all{elseif isset($AJAX_TAG) && $AJAX_TAG} item{$AJAX_TAG.id|intval}{else} active{/if}" {if isset($YBC_INS_ITEM_SPACING) && $YBC_INS_ITEM_SPACING}style="margin-right: -{$YBC_INS_ITEM_SPACING|intval}px;"{/if}>
    {if $imgs.imgs}
    <ul {if isset($YBC_INS_ITEM_SPACING) && $YBC_INS_ITEM_SPACING}style="width:calc(100% + {$YBC_INS_ITEM_SPACING|intval}px);" {/if} class="ybc_ins_medias{if $YBC_INS_INIT_FILTER} ins_init_filter_{$YBC_INS_INIT_FILTER|escape:'html':'UTF-8'}{/if}{if $YBC_INS_HOVER_FILTER} ins_hover_filter_{$YBC_INS_HOVER_FILTER|escape:'html':'UTF-8'}{/if} {if $YBC_INS_LAYOUT_TYPE}{$YBC_INS_LAYOUT_TYPE|escape:'html':'utf-8'}{/if}{if $YBC_INS_POSITION} products-block{/if} {if $YBC_INS_THUMBNAIL_SIZE}{$YBC_INS_THUMBNAIL_SIZE|escape:'html':'utf-8'}{/if} {if $YBC_INS_LAYOUT_TYPE == 'grid' && $YBC_INS_FORCE_SLIDER_MOBIE} force_slider_mobie {/if}">
        {if $YBC_INS_LAYOUT_TYPE == 'masonry' }
            <li class="grid-sizer-ins col-lg-{(12/$YBC_INS_PER_ROW_DESKTOP)|intval} col-sm-{(12/$YBC_INS_PER_ROW_TABLET)|intval} col-xs-{(12/$YBC_INS_PER_ROW_MOBILE)|intval}"></li>
        {/if}
        {hook h='displayInstaImgList' imgs=$imgs.imgs PAGE_TYPE=$PAGE_TYPE YBC_INS_LAYOUT_TYPE=$YBC_INS_LAYOUT_TYPE YBC_INS_PER_ROW_DESKTOP=$YBC_INS_PER_ROW_DESKTOP YBC_INS_PER_ROW_TABLET=$YBC_INS_PER_ROW_TABLET YBC_INS_PER_ROW_MOBILE=$YBC_INS_PER_ROW_MOBILE}
    </ul>
    
    {if $YBC_INS_LAYOUT_TYPE != 'carousel' && isset($imgs.next_url) && $imgs.next_url}
        <a rel="nofollow" data-type="{$PAGE_TYPE|lower|escape:'html':'utf-8'}" class="ybc_ins_{$PAGE_TYPE|lower|escape:'html':'utf-8'}_load_more ybc_ins_loadmore{if $YBC_INS_LOADMORE_TYPE=='scroll'} auto_load_more {/if}" href="{$imgs.next_url|escape:'html':'UTF-8'}">
        <span class="ybc_ins_load_more">{l s='More photos' mod='ybc_instagram'}</span>
        <span class="ybc_ins_loading_more">
            <span id="squaresWaveG">
                <span id="squaresWaveG_1" class="squaresWaveG"></span>
                <span id="squaresWaveG_2" class="squaresWaveG"></span>
                <span id="squaresWaveG_3" class="squaresWaveG"></span>
                <span id="squaresWaveG_4" class="squaresWaveG"></span>
                <span id="squaresWaveG_5" class="squaresWaveG"></span>
            </span>
        </span></a>
    {/if}{else}<p class="alert alert-info">{l s='No photos available.' mod='ybc_instagram'}</p>{/if}

</div>
