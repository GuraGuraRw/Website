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
{if $js_file && $css_file}
    <script type="text/javascript">
        var request_ajax_link = "{$request_ajax_link nofilter}";
    </script>
    <link rel="stylesheet" href="{$css_file|escape:'html':'UTF-8'}" type="text/css" media="all">
    <script src="{$js_file|escape:'html':'UTF-8'}" type="text/javascript"></script>
{/if}
<section id="autoupgradePhpVersion" class="panel widget ets_upgrade_dashboad hidden">
    <div class="panel-heading">
        <span class="icon-update"></span>
        {l s='New Prestashop version was released' mod='ets_upgrade'}
    </div>
    <p class="latest_channel_version">{l s='Prestashop %s is available!' mod='ets_upgrade'}</p>{*$latestChannelVersion*}
    <a class="btn btn-primary upgrade_link" target="_blank" href="{if isset($upgrade_link)}{$upgrade_link nofilter}{else}#{/if}">
        <i class="fa fa-arrow-alt-circle-up"></i>
        {l s='Upgrade Now' mod='ets_upgrade'}
    </a>
</section>