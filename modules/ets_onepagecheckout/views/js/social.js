/**
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
 */
$(document).ready(function(){
   $(document).on('click', '.opc_social_item', function () {
        if ($(this).data('auth') != ''){
            ets_opc_authPopup($(this).data('auth'));
        }
    }); 
    if($('#customer-form > div >.opc_social_form').length)
    {
        $('#customer-form footer').after($('#customer-form div .opc_social_form').clone());
        $('#customer-form > div > .opc_social_form').remove();
    }
    if($('#customer-form > section >.opc_social_form').length)
    {
        $('#customer-form footer').after($('#customer-form section .opc_social_form').clone());
        $('#customer-form > section > .opc_social_form').remove();
    }
    if(ETS_OPC_CHECK_BOX_NEWSLETTER && $('input[name="newsletter"]').length && $('input[name="newsletter"]:checked').length==0)
    {
        $('input[name="newsletter"]').prop('checked',true)
    }
    if(ETS_OPC_CHECK_BOX_OFFERS && $('input[name="optin"]').length && $('input[name="optin"]:checked').length==0)
    {
        $('input[name="optin"]').prop('checked',true)
    }
});
function ets_opc_authPopup(provider)
{
    if (ETS_OPC_URL_OAUTH != '' && provider != '')
    {
        var fixURL = ETS_OPC_URL_OAUTH;
        if (ETS_OPC_URL_OAUTH.indexOf('?') !== -1) {
            fixURL += '&provider='+ provider
        } else {
            fixURL += '?provider='+ provider
        }
        if (fixURL)
        {
            window.open(fixURL, 'authWindow', 'width=800,height=auto,scrollbars=yes');
        }
        return false;
    }
}