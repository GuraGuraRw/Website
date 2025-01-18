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
    var id_customer = null;
    if( typeof OCHAT_FRONT_CONTROLLER_URL == 'undefined' ) {
        OCHAT_FRONT_CONTROLLER_URL = "{$OCHAT_FRONT_CONTROLLER_URL}";
    }
    {if isset($id_lang)} var id_lang = "{$id_lang|intval}"; {/if}
    {if isset($id_shop)} var id_shop = "{$id_shop|intval}" ;{/if}

    {if isset($ochat_customer['name'])} var customer_name = "{$ochat_customer['name']|escape:'htmlall':'UTF-8'}" ;{/if}
    {if isset($ochat_customer['email'])} var customer_email = "{$ochat_customer['email']|escape:'htmlall':'UTF-8'}" ;{/if}
    {if isset($ochat_customer['id_customer'])} var customer_id = "{$ochat_customer['id_customer']|intval}" ;{/if}
    {if isset($ochat_customer['id_guest'])} var customer_id_guest = "{$ochat_customer['id_guest']|intval}" ;{/if}


    {if isset($id_customer)}
        id_customer = "{$id_customer|intval}";
        if (id_customer == '0') {
            id_customer = null;
        }
    {/if}
    {if isset($id_guest)} var id_guest = "{$id_guest|intval}";{/if}
    {if isset($online)} var online = "{$online|intval}";{/if}
    {if isset($json_handler_url)} var json_handler_url = "{$json_handler_url|escape:'quotes':'UTF-8'}";{/if}
    {if isset($advisorFinalName)} var OCHAT_ADVISOR_NAME = "{$advisorFinalName|escape:'htmlall':'UTF-8'}";{/if}
    {if isset($OCHAT_TIME_DELAY)} var OCHAT_TIME_DELAY = "{$OCHAT_TIME_DELAY|intval}";{/if}
    {if isset($OCHAT_ADVISOR_IMAGE_TYPE)} var OCHAT_ADVISOR_IMAGE_TYPE = "{$OCHAT_ADVISOR_IMAGE_TYPE|escape:'htmlall':'UTF-8'}";{/if}
    {if isset($OCHAT_ADVISOR_IMAGE_SRC)} var OCHAT_ADVISOR_IMAGE_SRC = "{$OCHAT_ADVISOR_IMAGE_SRC|escape:'htmlall':'UTF-8'}";{/if}

    var cant_create_thread_message = '{l s='Sorry, we are currently busy, please try contact us shortly...' mod='onlinechat' js=1}',
        cant_create_thread_time = '{l s='Now' mod='onlinechat' js=1}';
    OCHAT_UNIQID = "{$ochat_uniqid|escape:'htmlall':'UTF-8'}";
</script>

<style>
    #chat_window_1 .msg_sent,
    #chat_window_1 .msg_sent p {
        background-color: {$OCHAT_ONLINE_CLIENT_BG_COLOR|escape:'htmlall':'UTF-8'};
        color : {$OCHAT_ONLINE_CLIENT_TXT_COLOR|escape:'htmlall':'UTF-8'};
    }
    #chat_window_1 .msg_receive,
    #chat_window_1 .msg_receive p {
        background-color: {$OCHAT_ONLINE_ADVISOR_BG_COLOR|escape:'htmlall':'UTF-8'};
        color : {$OCHAT_ONLINE_ADVISOR_TXT_COLOR|escape:'htmlall':'UTF-8'};
    }
</style>

<div class="row chat-window " id="chat_window_1" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}:40px; display: none;">
    <div class="ochat-panel-default">
        <div class="ochat-panel-heading" style="background-color: {$OCHAT_ONLINE_ACTION_BG_COLOR|escape:'htmlall':'UTF-8'}">
            <div class="col-12">
                <p class="ochat-title" style="color: #ffffff;">{$OCHAT_ONLINE_HEADER_TEXT|escape:'htmlall':'UTF-8'}</p>
            </div>
            <div class="">
                <a href="#"><span id="minim_chat_window" class="" style="color: #ffffff;"></span></a>
            </div>
        </div>
        <div class="ochat-alert-warning" role="alert" style="display: none;" id="error-message">
                {l s='An error occured. Please try to send your message later.' mod='onlinechat'}
        </div>
        <div class="msg_container_base" style="background-color: {$OCHAT_ONLINE_BACKGROUND_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_ONLINE_BACKGROUND_TXT_COLOR|escape:'htmlall':'UTF-8'}; background-image: url({$backgroundSrc}{$OCHAT_ONLINE_CLIENT_BG_IMG|escape:'htmlall':'UTF-8'}.png)" data-thread="">
            <br/>
            <div class="row msg_container base_receive">
                {if $OCHAT_ADVISOR_IMAGE_TYPE == 'default'}
                    <div class="ochat_advisor_img col-2"><i class="fa fa-user" aria-hidden="true"></i></div>
                {else}
                    <div class="ochat_advisor_img col-2"><img src="{$OCHAT_ADVISOR_IMAGE_SRC}"/></div>
                {/if}
                <div class="col-9">
                    <div class="messages msg_receive">
                        <p class="OCHAT_ONLINE_WELCOME_TEXT">
                            {$OCHAT_ONLINE_WELCOME_TEXT|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                </div>
            </div>
            <div class="ochat-alert ochat-alert-info ochat-closed-thread" role="alert" style="display: none;">
                {$OCHAT_ONLINE_DELETED_THREAD_MESSAGE|escape:'htmlall':'UTF-8'}
            </div>
        </div>
        <div class="ochat-footer">
            <div class="ochat-form-group">
                <div class="ochat-online-form-message">
                    <textarea id="btn-input" class="ochat-form-control chat-input" rows="3" placeholder="{$OCHAT_ONLINE_INPUT_PLACEHOLDER|escape:'htmlall':'UTF-8'}"></textarea>
                </div>
            </div>
            <input type="hidden" value="{$timezone}" name="timezone" id="otimezone"/>
            <button type="submit" id="btn-chat" class="ochat-btn ochat-btn-primary ochat-disabled" style="color: {$OCHAT_ONLINE_ACTION_BG_COLOR|escape:'htmlall':'UTF-8'}"><i class="fa fa-send-o"></i></button>
            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="open_ochat_conversion" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}:40px;">
    <div id="hello_text-online" style="{$OCHAT_POSITION|escape:'htmlall':'UTF-8'}: 70px;">
        <span>{$OCHAT_ONLINE_HEADER_TEXT|escape:'htmlall':'UTF-8'}</span>
    </div>
    <div id="ochat_window_open"  style="float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'}">
        <span class="close_ochat_window" style="display: none; background-color: {$OCHAT_ONLINE_ACTION_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_ONLINE_ACTION_TXT_COLOR|escape:'htmlall':'UTF-8'}; float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'}"><i class="fa fa-times"></i></span>
        <span class="open_ochat_window" style="background-color: {$OCHAT_ONLINE_ACTION_BG_COLOR|escape:'htmlall':'UTF-8'}; color: {$OCHAT_ONLINE_ACTION_TXT_COLOR|escape:'htmlall':'UTF-8'}; float: {$OCHAT_POSITION|escape:'htmlall':'UTF-8'}"><i class="fa fa-comments"></i></span>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>