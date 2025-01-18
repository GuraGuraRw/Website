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

<script>
    if( typeof OCHAT_FRONT_CONTROLLER_URL == 'undefined' ) {
        OCHAT_FRONT_CONTROLLER_URL = "{$OCHAT_FRONT_CONTROLLER_URL}";
    }
    var online = "{$online|intval}";
    OCHAT_UNIQID = "{$ochat_uniqid|escape:'htmlall':'UTF-8'}";
</script>

<div class="row chat-window" id="chat_window_2" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}:40px;">
    <div class="ochat-panel-default">
        <div class="ochat-panel-heading" style="background-color: {$OCHAT_OFFLINE_HEADER_BG_COLOR|escape:'htmlall':'UTF-8'}">
            <div class="col-md-12 col-xs-12">
                <p class="ochat-title" style="color: {$OCHAT_OFFLINE_HEADER_TEXT_COLOR|escape:'htmlall':'UTF-8'}">{$OCHAT_OFFLINE_HEADER_TEXT|escape:'htmlall':'UTF-8'}</p>
            </div>
        </div>
        <div class="offline-form msg_container_base">
            <form role="form" class="form-group" enctype="text/plain" action="#" method="POST" id="offlineForm" name="offlineForm">
                <div class="formoffline" style="background-color: {$OCHAT_ONLINE_BACKGROUND_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_ONLINE_BACKGROUND_TXT_COLOR|escape:'htmlall':'UTF-8'}; background-image: url({$backgroundSrc}{$OCHAT_ONLINE_CLIENT_BG_IMG|escape:'htmlall':'UTF-8'}.png)">
                    <br/>
                    <div class="ochat-alert ochat-alert-success" role="alert" style="display: none;" id="return-message">
                            {$OCHAT_OFFLINE_SEND_MESSAGE|escape:'htmlall':'UTF-8'}
                    </div>
                    <div class="ochat-alert ochat-alert-warning" role="alert" style="display: none;" id="disconnect-message">
                            {l s='An error occured. Please try to send your message later.' mod='onlinechat'}
                    </div>
                    <div class="row">
                        <div class="col-sm-12 OCHAT_OFFLINE_WELCOME_TEXT">
                            {$OCHAT_OFFLINE_WELCOME_TEXT|escape:'htmlall':'UTF-8'}
                        </div>
                    </div>
                    <br/>
                    {if $OCHAT_FORM_NAME == 1}
                        <div class="input">
                            <div class="ochat-form-group clear row">
                                <div class="col-12">
                                    <input type="text" class="ochat-form-control {if isset($ochat_customer['name'])}valid-input{/if}" id="OCHAT_FORM_NAME" name="OCHAT_FORM_NAME" placeholder="{l s='Name' mod='onlinechat'}" value="{if isset($ochat_customer['name'])}{$ochat_customer['name']|escape:'htmlall':'UTF-8'}{/if}" maxlength="40"/>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div class="input">
                        <div class="ochat-form-group ochat-form-email clear row">
                            <div class="col-12">
                                <input type="email" class="ochat-form-control {if isset($ochat_customer['email'])}valid-input{/if}" id="OCHAT_FORM_EMAIL" name="OCHAT_FORM_EMAIL" placeholder="{l s='Email' mod='onlinechat'}" value="{if isset($ochat_customer['email'])}{$ochat_customer['email']|escape:'htmlall':'UTF-8'}{/if}" maxlength="40"/>
                            </div>
                        </div>
                    </div>
                    {if $OCHAT_FORM_PHONE == 1}
                        <div class="input">
                            <div class="ochat-form-group clear row">
                                <div class="col-12">
                                    <input type="text" class="ochat-form-control" id="OCHAT_FORM_PHONE" name="OCHAT_FORM_PHONE" placeholder="{l s='Phone' mod='onlinechat'}" maxlength="40"/>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
                <div class="ochat-footer">
                    <div class="ochat-form-group clear row">
                        <div class="col-10 ochat-offline-form-message">
                            <textarea type="textarea" rows="3" class="hidden-textarea ochat-form-control valid-input" id="OCHAT_FORM_MESSAGE" name="OCHAT_FORM_MESSAGE" placeholder="{l s='Message' mod='onlinechat'}"></textarea>
                        </div>
                        <div class="col-2">
                            <button type="submit" id="send-offline-form" class="ochat-btn ochat-btn-primary  cant-submit" style="color: {$OCHAT_OFFLINE_HEADER_BG_COLOR|escape:'htmlall':'UTF-8'}"><i class="fa fa-send-o"></i></button>
                        </div>
                        {if !isset($is_backoffice)}
                            <div class="gdprochat">
                                {hook h='displayGDPRConsent' mod='psgdpr' id_module=$id_module}
                            </div>
                        {/if}
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div id="open_ochat_conversion" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}:40px;">
    <div id="hello_text-offline" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}: 70px;">
        <span>{$OCHAT_OFFLINE_HEADER_TEXT|escape:'htmlall':'UTF-8'}</span>
    </div>
    <div id="ochat_window_open"  style="float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'};">
        <span class="close_ochat_window" style="display: none; background-color: {$OCHAT_OFFLINE_HEADER_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_OFFLINE_HEADER_TEXT_COLOR|escape:'htmlall':'UTF-8'}; float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'}"><i class="fa fa-times"></i></span>
        <span class="open_ochat_window" style="background-color: {$OCHAT_OFFLINE_HEADER_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_OFFLINE_HEADER_TEXT_COLOR|escape:'htmlall':'UTF-8'}; float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'}"><i class="fa fa-envelope"></i></span>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>