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
<script type="text/javascript">
    {if isset($ets_opc_link_back) && $ets_opc_link_back}
        {if isset($ph_conn_back_link) && $ph_conn_back_link}
            {if isset($error) && $error}
                alert('{$error|escape:'html':'UTF-8'}');
                window.close();
            {else}
                window.open('{$ets_opc_link_back nofilter}', '_self');
            {/if}
        {else}
            window.opener.document.location.href = '{$ets_opc_link_back nofilter}';
            window.close();
        {/if}
    {else}
        window.opener.location.reload();
        window.close();
    {/if}

</script>