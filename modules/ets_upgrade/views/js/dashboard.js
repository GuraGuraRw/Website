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

$(document).ready(function () {
    var autoUpgradePanel = $("#autoupgradePhpWarn");

    $(".list-toolbar-btn", autoUpgradePanel).click(function (event) {

        event.preventDefault();
        autoUpgradePanel.fadeOut();

        $.post(
            $(this).attr("href")
        );
    });
    // new code.
    var xhr = null;
    if (typeof request_ajax_link !== "undefined" && request_ajax_link != '') {
        if (xhr !== null)
            xhr.abort();
        xhr = $.ajax({
            type: 'post',
            url: request_ajax_link,
            dataType: 'json',
            success: function (json) {
                if (json) {
                    var php_version = $('#autoupgradePhpVersion'),
                        php_warn = $('#autoupgradePhpWarn')
                    ;
                    if (php_version.length > 0 && json.latestChannelVersion) {
                        php_version.removeClass('hidden').find('.latest_channel_version').html(function () {
                            return $(this).html().replace(/%s/, json.latestChannelVersion);
                        });
                        if (json.upgradeLink) {
                            php_version.find('.upgrade_link').attr('href', json.upgradeLink);
                        }
                    }
                    if (php_warn.length > 0 && json.upgradeNotice) {
                        if (json.ignore_link)
                            php_warn.find('a.ignore_link').attr('href', json.ignore_link);
                        if (json.learn_more_link)
                            php_warn.find('a.learn_more_link').attr('href', json.learn_more_link);
                        php_warn.removeClass('hidden');
                    }
                }
            }
        });
    }
});
