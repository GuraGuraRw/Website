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
{if isset($ENABLED) && $ENABLED}
    {if isset($imgs.imgs) && $imgs.imgs}
        {assign var="IS_LEFT_RIGHT" value=(!$is_17 && $PAGE_TYPE == 'SLIDER' && in_array($YBC_INS_SLIDER_HOOK, array('left', 'right')))}
        {assign var='YBC_INS_POSITION' value=($PAGE_TYPE != 'GALLERY' && $PAGE_TYPE != 'TAG' && (($PAGE_TYPE == 'SLIDER' && in_array($YBC_INS_SLIDER_HOOK, array('left', 'right'))) || ($PAGE_TYPE == 'POPP' && in_array($YBC_INS_POPP_HOOK_TO, array('product_thumbs','additional_info'))) || $PAGE_TYPE == 'SHORT_CODE' ) )}
        {if $YBC_INS_SLIDER_HOOK =='footer'}<div class="col-12">{/if}
        <div class="card card-block {if $YBC_INS_SLIDER_HOOK =='left' or $YBC_INS_SLIDER_HOOK=='right'} block {/if} ybc_instagram{if $IS_RTL} ybc_ins_rtl{/if}{if $YBC_INS_DISPLAY_FULL_WIDTH && ($PAGE_TYPE != 'SLIDER' || ($YBC_INS_SLIDER_HOOK!='left' && $YBC_INS_SLIDER_HOOK!='right')) && $PAGE_TYPE != 'POPP'} ybc_ins_full_width{/if}{if $YBC_INS_LAYOUT_TYPE} {$YBC_INS_LAYOUT_TYPE|escape:'html':'utf-8'}{/if}{if $YBC_INS_ENABLE_ZOOM_HOVER} zooming_enabled{/if}{if $is_17} is_17{/if}{if $YBC_INS_POSITION} block{/if} {$PAGE_TYPE|lower|escape:'html':'utf-8'}{if $PAGE_TYPE == 'POPP'} ybc_ins_hook_{$YBC_INS_POPP_HOOK_TO|escape:'html':'UTF-8'}{elseif $PAGE_TYPE == 'SLIDER'} ybc_ins_hook_{$YBC_INS_SLIDER_HOOK|escape:'html':'UTF-8'}{/if}{if isset($YBC_INS_LAZY_LOAD) && $YBC_INS_LAZY_LOAD} ybc_ins_lazy{/if}"
                {if in_array($PAGE_TYPE, array('SLIDER', 'SHORT_CODE')) && $YBC_INS_LAYOUT_TYPE =='carousel'}
                    data-desktop="{$YBC_INS_PER_ROW_DESKTOP|intval}"
                    data-tablet="{$YBC_INS_PER_ROW_TABLET|intval}"
                    data-mobile="{$YBC_INS_PER_ROW_MOBILE|intval}"
                    data-autoplay="{$YBC_INS_AUTOPLAY_CAROUSEL|intval}"
                    data-lazyload="{$YBC_INS_LAZY_LOAD|intval}"
                    data-speed="{$YBC_INS_CAROUSEL_SPEED|intval}"
                    data-spacing="{$YBC_INS_ITEM_SPACING|intval}"
                {/if}
                {if isset($PAGE_TYPE) && $PAGE_TYPE}data-option="{$PAGE_TYPE|lower|escape:'html':'utf-8'}"{/if}
                {if $PAGE_TYPE == 'SLIDER'}data-position="{$YBC_INS_SLIDER_HOOK|escape:'html':'UTF-8'}"{/if}
                {if isset($TAG) && $TAG && $PAGE_TYPE == 'SHORT_CODE'}data-tag="{$TAG.id|intval}"{/if}
        >

            {if $IS_LEFT_RIGHT}
            <h4 class="title_block">{$YBC_INS_SLIDER_TITLE|escape:'html':'UTF-8'}</h4>
            <div class="block_content {if $YBC_INS_LAYOUT_TYPE == 'carousel'}_{$YBC_INS_LAYOUT_TYPE|escape:'html':'utf-8'}{/if} ">
                {else}
                <div class="ybc_instagram_header{if $YBC_INS_DISPLAY_NAME != ''} ins_has_name{/if}{if $YBC_INS_TEXT_DIRECTION_SLIDER=='center'} style_center{/if}">
                    <div class="ybc_instagram_header_content">
                        {if $PAGE_TYPE == 'SLIDER' || $PAGE_TYPE == 'POPP'}
                            <p class="h3{if $YBC_INS_POSITION} title_block{/if}">
                                {if $PAGE_TYPE == 'SLIDER'}
                                    {$YBC_INS_SLIDER_TITLE|escape:'html':'UTF-8'}
                                {elseif $PAGE_TYPE == 'POPP'}
                                    {$YBC_INS_POPP_TITLE|escape:'html':'UTF-8'}
                                {/if}
                            </p>
                        {elseif $PAGE_TYPE == 'GALLERY'}
                            <h1>{$YBC_INS_GALLERY_TITLE|escape:'html':'UTF-8'}</h1>
                        {elseif ($PAGE_TYPE == 'TAG' || $PAGE_TYPE == 'SHORT_CODE') && isset($TAG) && $TAG}
                            <h1>{$TAG.name|escape:'html':'UTF-8'}</h1>
                        {/if}
                        {/if}
                        {if $YBC_INS_DISPLAY_USERNAME && $YBC_INS_URL && $YBC_INS_DISPLAY_NAME}
                            {if $YBC_INS_TEXT_DIRECTION_SLIDER=='center'}<span class="tex_flow">{l s='Follow us:' mod='ybc_instagram'}</span> {/if}
                            <a class="ybc_instagram_user" target="_self" href="{$YBC_INS_URL|escape:'html':'UTF-8'}">@{$YBC_INS_DISPLAY_NAME|escape:'html':'UTF-8'}</a>
                        {/if}
                        {if $YBC_INS_DISPLAY_USERNAME && ! $YBC_INS_URL && $YBC_INS_DISPLAY_NAME}
                            <span class="name_notlink">@{$YBC_INS_DISPLAY_NAME|escape:'html':'UTF-8'}</span>
                        {/if}
                        {if !$IS_LEFT_RIGHT}</div>{/if}
                    {if $YBC_INS_DISPLAY_FOLLOW && $YBC_INS_URL}
                        <a class="ins_button_grab" style="" class="btn btn-primary button_follow"
                           href="{$YBC_INS_URL|escape:'html':'UTF-8'}"
                           target="_self">{l s='Follow us on Instagram' mod='ybc_instagram'}</a>
                    {/if}
                    {if !$IS_LEFT_RIGHT}</div>{/if}
                {if isset($tags) && $tags && $YBC_INS_DISPLAY_TAG}
                    <div class="ybc_instagram_tags {if $YBC_INS_FILTER_TAG != 'page'}ajax{/if}">
                        <ul class="ybc_ins_list_tags" data-option="{$PAGE_TYPE|lower|escape:'html':'utf-8'}"
                            {if $PAGE_TYPE == 'SLIDER'}data-position="{$YBC_INS_SLIDER_HOOK|escape:'html':'UTF-8'}"{/if}>
                            <li class="ybc_ins_item_tag" data-id="all">
                                <a href="#"><span>{l s='All' mod='ybc_instagram'}</span></a>
                            </li>
                            {foreach from=$tags item='tag'}
                                <li class="ybc_ins_item_tag" data-id="{$tag.id_ets_instagram_tag|intval}">
                                    <a href="{$tag.link|escape:'quotes'}"><span>{$tag.name|escape:'html':'utf-8'}</span></a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
                <div class="ybc_instagram_wrapper {if isset($tags) && $tags && $YBC_INS_DISPLAY_TAG}has_tag{/if}">
                    {if $imgs.imgs}{include file="./insta-block.tpl"}{/if}
                </div>
                <div class="clearfix"></div>
                {if $IS_LEFT_RIGHT}</div>{/if}
        </div>
    {if $YBC_INS_SLIDER_HOOK =='footer'}</div>{/if}
    {elseif $PAGE_TYPE == 'GALLERY' || $PAGE_TYPE == 'TAG'}
        <p class="alert alert-warning">{l s='No photos available!' mod='ybc_instagram'}</p>
    {/if}
{else}
    <p class="alert alert-warning">{l s='This web page is not available. Please contact webmaster for more information' mod='ybc_instagram'}</p>
{/if}
<style type="text/css">
    .ins_button_grab{
        {if isset($YBC_INS_FOLLOWING_BUTTON_COLOR) && $YBC_INS_FOLLOWING_BUTTON_COLOR} background: {$YBC_INS_FOLLOWING_BUTTON_COLOR|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_FOLLOWING_BUTTON_TEXT && $YBC_INS_FOLLOWING_BUTTON_TEXT} color: {$YBC_INS_FOLLOWING_BUTTON_TEXT|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_FOLLOWING_BUTTON_BORDER_COLOR && $YBC_INS_FOLLOWING_BUTTON_BORDER_COLOR} border:1px solid {$YBC_INS_FOLLOWING_BUTTON_BORDER_COLOR|escape:'html':'UTF-8'};{/if}
    }

    .ins_button_grab:hover{
        {if isset($YBC_INS_FOLLOWING_BUTTON_HOVER) && $YBC_INS_FOLLOWING_BUTTON_HOVER} background: {$YBC_INS_FOLLOWING_BUTTON_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_FOLLOWING_BUTTON_TEXT_HOVER && $YBC_INS_FOLLOWING_BUTTON_TEXT_HOVER} color: {$YBC_INS_FOLLOWING_BUTTON_TEXT_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_FOLLOWING_BUTTON_BORDER_HOVER && $YBC_INS_FOLLOWING_BUTTON_BORDER_HOVER} border-color: {$YBC_INS_FOLLOWING_BUTTON_BORDER_HOVER|escape:'html':'UTF-8'};{/if}
    }


    .ybc_ins_product_item, .ybc_ins_product_item span {
    {if isset($YBC_INS_PRODUCT_MARK_COLOR) && $YBC_INS_PRODUCT_MARK_COLOR} background: {$YBC_INS_PRODUCT_MARK_COLOR|escape:'html':'UTF-8'};
    {/if}{if isset($YBC_INS_PRODUCT_MARK_TEXT) && $YBC_INS_PRODUCT_MARK_TEXT} color: {$YBC_INS_PRODUCT_MARK_TEXT|escape:'html':'UTF-8'};
    {/if}
    }

    .ybc_ins_product_item:hover, .ybc_ins_product_item:hover span,
    .ybc_ins_popup_product_sort .ybc_ins_product_item:hover,
    .ybc_ins_popup_product_sort .ybc_ins_product_item.actived,
    .ybc_ins_popup_product_sort .ybc_ins_product_item.actived span,
    .ybc_ins_popup_product_sort .ybc_ins_product_item:hover span {
    {if isset($YBC_INS_PRODUCT_MARK_HOVER) && $YBC_INS_PRODUCT_MARK_HOVER} background: {$YBC_INS_PRODUCT_MARK_HOVER|escape:'html':'UTF-8'} !important;
    {/if}{if isset($YBC_INS_PRODUCT_MARK_TEXT_HOVER) && $YBC_INS_PRODUCT_MARK_TEXT_HOVER} color: {$YBC_INS_PRODUCT_MARK_TEXT_HOVER|escape:'html':'UTF-8'} !important;
    {/if}
    }


    .ybc_ins_item .grab_button_table_cell a.ybc_instagram_fancy {
        {if isset($YBC_INS_GRAB_IT_BUTTON_COLOR) && $YBC_INS_GRAB_IT_BUTTON_COLOR} background: {$YBC_INS_GRAB_IT_BUTTON_COLOR|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_GRAB_IT_BUTTON_TEXT && $YBC_INS_GRAB_IT_BUTTON_TEXT} color: {$YBC_INS_GRAB_IT_BUTTON_TEXT|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_GRAB_IT_BUTTON_BORDER_COLOR && $YBC_INS_GRAB_IT_BUTTON_BORDER_COLOR} border:1px solid {$YBC_INS_GRAB_IT_BUTTON_BORDER_COLOR|escape:'html':'UTF-8'};{/if}
    }

    .ybc_ins_item .grab_button_table_cell a.ybc_instagram_fancy:hover {
        {if isset($YBC_INS_GRAB_IT_BUTTON_HOVER) && $YBC_INS_GRAB_IT_BUTTON_HOVER} background: {$YBC_INS_GRAB_IT_BUTTON_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_GRAB_IT_BUTTON_TEXT_HOVER && $YBC_INS_GRAB_IT_BUTTON_TEXT_HOVER} color: {$YBC_INS_GRAB_IT_BUTTON_TEXT_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_GRAB_IT_BUTTON_BORDER_HOVER && $YBC_INS_GRAB_IT_BUTTON_BORDER_HOVER} border-color:{$YBC_INS_GRAB_IT_BUTTON_BORDER_HOVER|escape:'html':'UTF-8'};{/if}
    }

    .user_flow a{
        {if isset($YBC_INS_POPUP_FOLLOWING_BUTTON_COLOR) && $YBC_INS_POPUP_FOLLOWING_BUTTON_COLOR} background: {$YBC_INS_POPUP_FOLLOWING_BUTTON_COLOR|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT && $YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT} color: {$YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_COLOR && $YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_COLOR} border:1px solid {$YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_COLOR|escape:'html':'UTF-8'};{/if}
    }

    .user_flow a:hover{
        {if isset($YBC_INS_POPUP_FOLLOWING_BUTTON_HOVER) && $YBC_INS_POPUP_FOLLOWING_BUTTON_HOVER} background: {$YBC_INS_POPUP_FOLLOWING_BUTTON_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT_HOVER && $YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT_HOVER} color: {$YBC_INS_POPUP_FOLLOWING_BUTTON_TEXT_HOVER|escape:'html':'UTF-8'};{/if}
        {if $YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_HOVER && $YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_HOVER} border-color: {$YBC_INS_POPUP_FOLLOWING_BUTTON_BORDER_HOVER|escape:'html':'UTF-8'};{/if}
    }
</style>
{if isset($YBC_INS_TOKEN_TIME) && $YBC_INS_TOKEN_TIME}
    <script type="text/javascript">
        var YBC_INS_TOKEN_TIME = {$YBC_INS_TOKEN_TIME|intval};
        var YBC_INS_REFRESH_TOKEN_URL = '{$refresh_token_url nofilter}';
    </script>
{/if}