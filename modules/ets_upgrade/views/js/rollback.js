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
if (typeof firstTimeParams !== "undefined") {
    firstTimeParams.forceFromFile = 1;
}
$(document).ready(function () {
    // the following prevents to leave the page at the inappropriate time
    $.xhrPool = [];
    $.xhrPool.abortAll = function () {
        $.each(this, function (jqXHR) {
            if (jqXHR && (jqXHR.readystate !== 4)) {
                jqXHR.abort();
            }
        });
    };
    // set timeout to 120 minutes (before aborting an ajax request)
    $.ajaxSetup({timeout: 7200000});

    /**
     * reset rollbackParams js array (used to init rollback button)
    */
    $("select[name=restoreName]").change(function () {
        var val = $(this).val();
        if (val != 0) {
            $("#rollback").removeAttr("disabled");
            var rollbackParams = $.extend(true, {}, firstTimeParams);

            delete rollbackParams.backupName;
            delete rollbackParams.backupFilesFilename;
            delete rollbackParams.backupDbFilename;
            delete rollbackParams.restoreFilesFilename;
            delete rollbackParams.restoreDbFilenames;

            // init new name to backup
            rollbackParams.restoreName = val;
            prepareNextButton("#rollback", rollbackParams);
        } else {
            $("#rollback").attr("disabled", "disabled");
        }
    });
});