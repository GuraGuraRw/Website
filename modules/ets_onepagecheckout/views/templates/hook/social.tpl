{*
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*}
{if $list_socials }
    <div class="opc_social_form col-xs-12 col-sm-12">
        <div class="opc_solo_or"><span>{l s='OR log in with' mod='ets_onepagecheckout'}</span></div>
        <ul class="opc_social">
            {if $list_socials}
                {foreach from=$list_socials item='social'}
                    <li class="opc_social_item {$social|strtolower|escape:'html':'UTF-8'} active{if strtolower($social) == 'google'}{if $ETS_OPC_GOOGLE_STYLE} {$ETS_OPC_GOOGLE_STYLE|escape:'html':'UTF-8'}{else} light{/if}{/if}" data-auth="{$social|escape:'html':'UTF-8'}"
                        title="{if strtolower($social) == 'paypal'}{l s='Sign in with Paypal' mod='ets_onepagecheckout'}{elseif strtolower($social) == 'facebook'}{l s='Sign in with Facebook' mod='ets_onepagecheckout'}{elseif strtolower($social) == 'google'}{l s='Sign in with Google' mod='ets_onepagecheckout'}{/if}">
                        <span class="opc_social_btn medium rounded custom">
                            {if strtolower($social) == 'paypal'}
                                <i class="ets_svg_icon">
                                    <svg width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1647 646q18 84-4 204-87 444-565 444h-44q-25 0-44 16.5t-24 42.5l-4 19-55 346-2 15q-5 26-24.5 42.5t-44.5 16.5h-251q-21 0-33-15t-9-36q9-56 26.5-168t26.5-168 27-167.5 27-167.5q5-37 43-37h131q133 2 236-21 175-39 287-144 102-95 155-246 24-70 35-133 1-6 2.5-7.5t3.5-1 6 3.5q79 59 98 162zm-172-282q0 107-46 236-80 233-302 315-113 40-252 42 0 1-90 1l-90-1q-100 0-118 96-2 8-85 530-1 10-12 10h-295q-22 0-36.5-16.5t-11.5-38.5l232-1471q5-29 27.5-48t51.5-19h598q34 0 97.5 13t111.5 32q107 41 163.5 123t56.5 196z"/></svg>
                                </i>
                            {else if strtolower($social) == 'facebook'}
                                <i class="ets_svg_icon">
                                    <svg width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1343 12v264h-157q-86 0-116 36t-30 108v189h293l-39 296h-254v759h-306v-759h-255v-296h255v-218q0-186 104-288.5t277-102.5q147 0 228 12z"/></svg>
                                </i>
                            {else if strtolower($social) == 'google'}
                                <i class="ets_svg_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="16" height="16">
                                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                                    </svg>
                                </i>
                            {else}
                                <i class="icon icon-{strtolower($social)|escape:'html':'UTF-8'} fa fa-{strtolower($social)|escape:'html':'UTF-8'}"></i>
                            {/if} {$social|escape:'html':'UTF-8'}
                        </span>
                    </li>
                {/foreach}
            {/if}
        </ul>
    </div>
{/if}