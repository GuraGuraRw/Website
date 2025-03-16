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

if (typeof ets_autoup_input === 'undefined') {
    var ets_autoup_input = {
        manualMode: "",
        _PS_MODE_DEV_: true,
        PS_AUTOUP_BACKUP: true,
        adminUrl: "http://test.com/admin",
        adminDir: "/admin",
        token: "de51ba8df069b3691841a5da41b2bb8b",
        txtError: [],
        firstTimeParams: {
            nextParams: {
                firstTime: 1,
            }
        },
        ajaxUpgradeTabExists: true,
        currentIndex: 'page.php',
        tab: 'EtsAdminSelfUpgrade',//ets_autoup_input.tab
        channel: 'major',//minor
        translation: {
            confirmDeleteBackup: "Are you sure you want to delete this backup?",
            "delete": "Delete",
            updateInProgress: "An update is currently in progress... Click \"OK\" to abort.",
            upgradingPrestaShop: "Upgrading PrestaShop",
            upgradeComplete: "Upgrade complete",
            upgradeCompleteWithWarnings: "Upgrade complete, but warning notifications has been found.",

            versionComparisonTitle: 'Analyzing store. Please wait...!',
            startingRestore: "Starting restoration...",
            restoreComplete: "Restoration complete.",
            cannotDownloadFile: "Your server cannot download the file. Please upload it first by ftp in your admin/ets_upgrade directory",
            jsonParseErrorForAction: "Javascript error (parseJSON) detected for action ",
            manuallyGoToButton: "Manually go to %s button",
            endOfProcess: "End of process",
            processCancelledCheckForRestore: "Operation canceled. Checking for restoration...",
            confirmRestoreBackup: "Do you want to restore SomeBackupName?",
            processCancelledWithError: "Operation canceled. An error happened.",
            missingAjaxUpgradeTab: "[TECHNICAL ERROR] upgradetab.php is missing. Please reinstall the module.",
            clickToRefreshAndUseNewConfiguration: "Click to refresh the page and use the new configuration",
            errorDetectedDuring: "Error detected during",
            downloadTimeout: "The request exceeded the max_time_limit. Please change your server configuration.",
            seeOrHideList: "See or hide the list",
            coreFiles: "Core file(s)",
            mailFiles: "Mail file(s)",
            translationFiles: "Translation file(s)",
            linkAndMd5CannotBeEmpty: "Link and MD5 hash cannot be empty",
            needToEnterArchiveVersionNumber: "You need to enter the version number associated with the archive.",
            noArchiveSelected: "No archive has been selected.",
            needToEnterDirectoryVersionNumber: "You need to enter the version number associated with the directory.",
            confirmSkipBackup: "Please confirm that you want to skip the backup.",
            confirmPreserveFileOptions: "Please confirm that you want to preserve file options.",
            lessOptions: "Less options",
            moreOptions: "More options (Expert mode)",
            filesWillBeDeleted: "These files will be deleted",
            filesWillBeReplaced: "These files will be replaced",
        }
    };
}

var firstTimeParams = ets_autoup_input.firstTimeParams.nextParams;
firstTimeParams.firstTime = "1";
var body_class_process = 'ets_autoup_process_upgrade',
    allow_button_upgrade = false,
    checkedFilesVersion = 0,
    comparedReleases = 0,
    checkedChannelChanged = 0;
;

var ets_autoup_fn = {
    init: function () {
        $('#upgradeNow').prop('disabled', true);
        ets_autoup_fn.nextSteps();
        ets_autoup_fn.channel();
    },
    copyToClipboard: function (el) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(el.text()).select();
        document.execCommand("copy");
        $temp.remove();
        showSuccessMessage(ets_autoup_copied_translate);
        setTimeout(function () {
            el.removeClass('copy');
        }, 300);
    },
    nextSteps: function (el, way) {
        if ($('#upgradeBegin').length > 0 || $('#noUpgrade').length > 0 || $('.ets_autoup_resume_wrap.processUpgrade').length > 0) {
            var element = el || $('.ets_autoup_steps li').first(),
                move_way = way || 'next';
            $('.ets_autoup_steps li.active, .ug_block_step.active').removeClass('active');
            if (element.hasClass('disabled')) {
                element = ('next' == move_way ? element.next() : element.prev());
            }
            element.addClass('active');
            var blockId = element.data('id');
            $('#' + blockId).addClass('active');

            var actionValid = [
                'blockProcess',
                'blockResult',
                "upgradeBegin",
                "noUpgrade",
            ];
            if (actionValid.indexOf(blockId) !== -1) {
                $('button.prevStep').hide();
            } else
                $('button.prevStep').show();
        }
    },
    isMajorChannel: function (el) {
        var channel = el || $('input[name=channel]:checked').val();
        return /(?:major)(?:[0-9]+\.[0-9]+)?/.test(channel);
    },
    propOptions: function (el) {
        $('input[id*=PS_AUTOUP_CHANGE_DEFAULT_THEME], input[id*=PS_AUTOUP_UPDATE_DEFAULT_THEME], input[id*=PS_AUTOUP_CUSTOM_MOD_DESACT]').prop('disabled', el);
    },
    channel: function (el) {
        if ($('input[name=channel]').length <= 0)
            return;
        var sl = 0;
        if (!$('input[name=channel]').is(':checked')) {
            $('input[name=channel]:first').prop('checked', true);
            sl = 1;
        }

        var channel = el || $('input[name=channel]:checked').val(),
            isMajor = ets_autoup_fn.isMajorChannel(channel)
        ;
        $("select[name=channel]").val(channel);

        if (!el && 1 > sl)
            $("select[name=channel]").trigger('change');

        if (el)
            checkedChannelChanged = 1;

        //if (el || isMajor) {
        $('#PS_AUTOUP_CHANGE_DEFAULT_THEME_on, #PS_AUTOUP_UPDATE_DEFAULT_THEME_on, #PS_AUTOUP_CUSTOM_MOD_DESACT_on').prop('checked', isMajor);
        $('#PS_AUTOUP_CHANGE_DEFAULT_THEME_off, #PS_AUTOUP_UPDATE_DEFAULT_THEME_off, #PS_AUTOUP_CUSTOM_MOD_DESACT_off').prop('checked', !isMajor);
        //}
        ets_autoup_fn.propOptions(false);
        if (sl) {
            ets_autoup_fn.saveConfig($('button[name=customSubmitAutoUpgrade]'));
        }
    },
    saveConfig: function (el) {
        var button = el || $('button[name=customSubmitAutoUpgrade]'),
            form = button.parents('form');

        if (!form.hasClass('active')) {
            $('#ets_autoup_confirm_backup, #ets_autoup_confirm_latest').prop('checked', false).prop('disabled', true);
            $('#upgradeNow').prop('disabled', true);
            form.addClass('active');
            var formData = new FormData(form.get(0));
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (json) {
                    form.removeClass('active');
                    if (json) {
                        if (json.errors) {
                            showErrorMessage(json.errors);
                        } else {
                            $('#ets_autoup_confirm_backup, #ets_autoup_confirm_latest').prop('disabled', false);
                            $('#upgradeNow').prop('disabled', true);
                            if (json.msg) {
                                showSuccessMessage(json.msg);
                                $("input[name|=submitConf]").trigger('click');
                            }
                            var displayWarning = $('.ets_autoup_php_version');
                            if (displayWarning.length > 0) {
                                if (json.displayWarning) {
                                    displayWarning.addClass('active');
                                } else {
                                    displayWarning.removeClass('active');
                                }

                            }
                        }
                    }
                },
                error: function (res, textStatus, jqXHR) {
                    form.removeClass('active');
                }
            });
        }
        return false;
    },
    allowUpgrade: function (allow_upgrade) {
        $('#ets_autoup_confirm_backup, #ets_autoup_confirm_latest').prop('disabled', !allow_upgrade);
    },
    checkVersionComparison: function () {
        // Only show block setting.
        if (!$('#blockSetting').hasClass('active'))
            return;

        var _bd = $('body'),
            _class = 'ug_version_comparison'
        ;
        if (checkedFilesVersion && comparedReleases) {
            _bd.removeClass(_class)
                .find('.bg_' + _class)
                .remove();
        } else if (!_bd.hasClass(_class))
            _bd.addClass(_class)
                .prepend('<div class="bg_' + _class + '"><span class="pleaseWait">' + ets_autoup_input.translation.versionComparisonTitle + '</span></div>');
        return;
    }
};

function ucFirst(str) {
    if (str.length > 0) {
        return str[0].toUpperCase() + str.substring(1);
    }
    return str;
}

function cleanInfo() {
    $("#infoStep").html("reset<br/>");
}

function updateInfoStep(msg) {
    if (msg) {
        var $infoStep = $("#infoStep");
        $infoStep.append(msg + "<div class=\"clear\"></div>");
        $infoStep.prop({scrollTop: $infoStep.prop("scrollHeight")}, 1);
    }
}

function addError(arrError) {
    if (typeof arrError !== "undefined" && arrError.length) {
        $("#errorDuringUpgrade").show();
        var $infoError = $("#infoError");
        for (var i = 0; i < arrError.length; i++) {
            if (!/execution\b\s+time\b/gi.test(arrError[i])) {
                $infoError.append(arrError[i] + "<div class=\"clear\"></div>");
            }
        }
        // Note: jquery 1.6 makes use of prop() instead of attr()
        $infoError.prop({scrollTop: $infoError.prop("scrollHeight")}, 1);
    }
}

function addQuickInfo(arrQuickInfo) {
    if (arrQuickInfo) {
        var $quickInfo = $("#quickInfo");
        $quickInfo.show();
        for (var i = 0; i < arrQuickInfo.length; i++) {
            $quickInfo.append(arrQuickInfo[i] + "<div class=\"clear\"></div>");
        }
        // Note : jquery 1.6 make uses of prop() instead of attr()
        $quickInfo.prop({scrollTop: $quickInfo.prop("scrollHeight")}, 1);
    }
}

function showConfigResult(msg, type) {
    if (!type) {
        type = "conf";
    }
    var $configResult = $("#configResult");
    $configResult.html("<div class=\"" + type + "\">" + msg + "</div>").show();

    if (type === "conf") {
        $configResult.delay(3000).fadeOut("slow", function () {
            //location.reload();
        });

        reloadNextParams();
        if (checkedChannelChanged) {
            checkFilesVersion();
            compareReleases();

            checkedChannelChanged = !checkedChannelChanged;
        }

        // prepare available button here, without params ?
        prepareNextButton("#upgradeNow", firstTimeParams);
    }
}

// reuse previousParams, and handle xml returns to calculate next step
// (and the correct next param array)
// a case has to be defined for each requests that returns xml
function afterUpdateConfig(res) {
    var params = res.nextParams;
    var config = params.config;
    var $oldChannel = $("select[name=channel] option.current");

    if ($oldChannel.length > 0 && config.channel != $oldChannel.val()) {
        var $newChannel = $("select[name=channel] option[value='" + config.channel + "']");
        $oldChannel
            .removeClass("current")
            .html($oldChannel.html().substr(2));
        if ($newChannel.length > 0)
            $newChannel
                .addClass("current")
                .html("* " + $newChannel.html());
    }

    if (res.error == 1) {
        showConfigResult(res.next_desc, "error");
    } else {
        showConfigResult(res.next_desc);
    }

}

function startProcess(type) {

    $('body').addClass(body_class_process);
    // hide useless divs, show activity log
    $(".autoupgradeSteps a").addClass("button");
    $('.ets_autoup_overload.ets_autoup_popup').addClass('active');

    $(window).bind("beforeunload", function (e) {
        if (confirm(ets_autoup_input.translation.updateInProgress)) {
            $.xhrPool.abortAll();
            $(window).unbind("beforeunload");
            return true;
        } else {
            if (type === "upgrade") {
                e.returnValue = false;
                e.cancelBubble = true;
                if (e.stopPropagation) {
                    e.stopPropagation();
                }
                if (e.preventDefault) {
                    e.preventDefault();
                }
            }
        }
    });
}

function afterUpgradeNow(res) {
    startProcess("upgrade");
    $("#upgradeNow")
        .unbind()
        .replaceWith(
            "<span id=\"upgradeNow\" class=\"button-autoupgrade\">"
            + ets_autoup_input.translation.upgradingPrestaShop
            + " ...</span>"
        );
}

function afterUpgradeComplete(res) {
    var params = res.nextParams;

    $("#pleaseWait").hide();

    if (params.warning_exists == "false") {
        $("#infoStep").html("<p class=\"alert alert-success\">" + ets_autoup_input.translation.upgradeComplete + "</p>");
    } else {
        $("#pleaseWait").hide();
        $("#infoStep").html("<p class=\"alert alert-warning\">" + ets_autoup_input.translation.upgradeCompleteWithWarnings + "</p>");
    }

    if ($('.ets_autoup_latest_version').length > 0 && typeof params.install_version !== typeof undefined && params.install_version) {
        $('.ets_autoup_latest_version').html(params.install_version);
    }

    todoListResult();

    setTimeout(function () {
        ets_autoup_fn.nextSteps($('.ets_autoup_steps li.end'));
    }, 1500);

    $(window).unbind("beforeunload");

    $('body').removeClass(body_class_process);
}

function afterError(res) {
    var params = res.nextParams;
    if (params.next === "") {
        $(window).unbind("beforeunload");
    }
    $("#pleaseWait").hide();

    addQuickInfo(["unbind :) "]);
}

function afterRollback(res) {
    startProcess("rollback");
}

function afterRollbackComplete(res) {
    var params = res.nextParams;
    if ($('.ets_autoup_popup.active').length > 0) {
        $("#pleaseWait img.pleaseWait").hide();
    } else
        $("#pleaseWait").hide();
    updateInfoStep("<p class=\"alert alert-success\">" + ets_autoup_input.translation.restoreComplete + "</p>");
    $(window).unbind();

    if ($('#blockProcess .ets_autoup_rollback_process').is(':visible')) {
        $('.ug_block_step.active').removeClass('active');
        $('#blockResult').addClass('active');
        $('#blockResult .ets_autoup_upgrade_process').hide();
        $('#blockResult .ets_autoup_rollback_process').show();
    }

    todoListResult();

    $('body').removeClass(body_class_process);

    $('.ets_autoup_overload .ets_autoup_actions').show();
    // Downgrade version PHP:
    phpVersionInfo(params);
}

function phpVersionInfo(params) {
    if (params && /^V(1\.[0-9]\.[0-9]+(?:\.[0-9]+))/.test(params.restoreName) && /^1\.7\.[7-9]+(\.[0-9]+)?$/.test(params.install_version) && params.php_version_id >= 70103) {
        var php_version = $('.ets_autoup_downgrade_php_version'),
            warning_php_version = $('.ets_autoup_warning_php_version')
        ;
        if (/^1\.[0-6]\.[0-9]+(\.[0-9]+)?$/.test(params.old_version)) {
            php_version.text('5.6.40');
            warning_php_version.show();
        } else if (/^1\.7\.[0-6]+(\.[0-9]+)?$/.test(params.old_version) && params.php_version_id > 70133) {
            php_version.text('7.1.33');
            warning_php_version.show();
        } else {
            warning_php_version.hide();
        }
    }
}

function todoListResult() {

    $("#upgradeResultToDoList")
        .show();
}

function afterRestoreDb(params) {
    // $("#restoreBackupContainer").hide();
}

function afterRestoreFiles(res) {
    // $("#restoreFilesContainer").hide();
}

function afterBackupFiles(res) {
    var params = res.nextParams;
}

/**
 * afterBackupDb display the button
 */
function afterBackupDb(res) {
    var params = res.nextParams;

    if (res.stepDone && ets_autoup_input.PS_AUTOUP_BACKUP === true) {
        $("#restoreBackupContainer").show();
        $("select[name=restoreName]")
            .append("<option selected=\"selected\" value=\"" + params.backupName + "\">" + params.backupName + "</option>")
            .val('')
            .change();
    }
}

function afterUpgradeFiles(params) {
    if (params && params.php_version_id > 0 && params.install_version && (params.php_version_id < 70103 && /^1\.7\.[7-9]([0-9]+)?(\.[0-9]+)?$/.test(params.install_version) || params.php_version_id < 70205 && /^8\.[0-9]([0-9]+)?(\.[0-9]+)?$/.test(params.install_version))) {
        ets_autoup_process_stop = true;
        if (/^8\.[0-9]([0-9]+)?(\.[0-9]+)?$/.test(params.install_version)) {
            $('.ets_autoup_prestashop_17').hide();
            $('.ets_autoup_prestashop_80').show();
        } else {
            $('.ets_autoup_prestashop_17').show();
            $('.ets_autoup_prestashop_80').hide();
        }
        if (params.config && params.config.PS_AUTOUP_BACKUP === '0' && params.config.PS_AUTOUP_KEEP_IMAGES === '0') {
            $('.ets_autoup_stop_process .ets_autoup_btn_rollback').prop('disabled', true).hide();
        }
        $('.ets_autoup_stop_process').addClass('active');
    }
}

function call_function(func) {
    this[func].apply(this, Array.prototype.slice.call(arguments, 1));
}

var ets_autoup_set_interval_time = 0
    , ets_autoup_process_complete = 0
    , ets_autoup_current_part_step = 0
    , ets_autoup_part_complete = 0
    , ets_autoup_part_total = 0
    , ets_autoup_total_time_current_part = 0
    , ets_autoup_process_estimate_time = 0
    , ets_autoup_process_old_percent = 0
    , ets_autoup_process_part
    , ets_autoup_process_stop = false
;

function processEstimatePart(res) {
    if (ets_autoup_set_interval_time <= 0) {
        clearInterval(ets_autoup_process_part);
        ets_autoup_process_part = setInterval(function () {
            if (!ets_autoup_process_stop && ets_autoup_total_time_current_part > 0 && ets_autoup_part_total > 0 && ets_autoup_set_interval_time <= ets_autoup_total_time_current_part) {

                //Count time.
                ets_autoup_set_interval_time += 5;
                ets_autoup_process_complete = ((ets_autoup_set_interval_time / ets_autoup_total_time_current_part) * ets_autoup_current_part_step + ets_autoup_part_complete) / ets_autoup_part_total;
                if (res.next !== 'upgradeComplete' && 1.0 < ets_autoup_process_complete) {
                    ets_autoup_process_complete = 0.99;
                } else if (1.0 < ets_autoup_process_complete) {
                    ets_autoup_process_complete = 1.0;
                }
                processEstimatePercent();
                //Process percent.
                $('.ets_autoup_percent')
                    .css('width', ets_autoup_process_complete * 100 + '%');
                var percent = (ets_autoup_process_complete * 100).toFixed(0);
                if (1 < percent) {
                    $('.ets_autoup_label_percent')
                        .html('<span>' + (ets_autoup_process_complete * 100).toFixed(0) + '%</span>')
                        .show();
                }
                //Estimate time.
                if (ets_autoup_process_estimate_time > ets_autoup_set_interval_time) {
                    $('.ets_autoup_estimate_time').html(estimateTime(parseInt(ets_autoup_process_estimate_time - ets_autoup_set_interval_time)));
                }
            } else
                clearInterval(ets_autoup_process_part);

        }, 5000);
    }
}

function estimateTime(estimateTime) {
    var estimateTime = parseInt(estimateTime),
        displayEsTime = '';
    var hours = parseInt(estimateTime / 3600);
    if (hours >= 1) {
        displayEsTime = hours + ' ' + (hours > 1 ? ets_autoup_estimate_hours : ets_autoup_estimate_hour);
        var minutes = parseInt((estimateTime - hours * 3600) / 60);
        if (minutes > 0) {
            displayEsTime += ' ' + minutes + ' ' + (minutes > 1 ? ets_autoup_estimate_minutes : ets_autoup_estimate_minute);
        }
    } else {
        var minutes = parseInt(estimateTime / 60);
        if (minutes > 0) {
            displayEsTime += minutes + ' ' + (minutes > 1 ? ets_autoup_estimate_minutes : ets_autoup_estimate_minute);
        } else {
            var seconds = parseInt(estimateTime - minutes * 60);
            displayEsTime += (seconds > 0 ? seconds : 0) + ' ' + (seconds > 1 ? ets_autoup_estimate_seconds : ets_autoup_estimate_second);
        }
    }
    return ets_autoup_estimate_time + ' ' + displayEsTime;
}

function processEstimatePercent() {
    if (ets_autoup_process_old_percent < ets_autoup_process_complete) {
        ets_autoup_process_old_percent = ets_autoup_process_complete;
    } else if (ets_autoup_process_old_percent > 0) {
        ets_autoup_process_complete = ets_autoup_process_old_percent;
    }
}

function processEstimate(res, onResume) {

    clearInterval(ets_autoup_process_part);

    if (res.next) {
        $('.ets_autoup_process').show();
    }
    // Set first variant.
    ets_autoup_current_part_step = ets_autoup_current_part_step > 0 ? ets_autoup_current_part_step : parseInt(res.current_part_step);
    ets_autoup_part_complete = ets_autoup_part_complete > 0 ? ets_autoup_part_complete : parseInt(res.nextParams.totalTimePartDone);
    ets_autoup_part_total = ets_autoup_part_total > 0 ? ets_autoup_part_total : (ets_autoup_part_complete + parseInt(res.nextParams.totalTimePart));
    ets_autoup_total_time_current_part = ets_autoup_total_time_current_part > 0 ? ets_autoup_total_time_current_part : ets_autoup_current_part_step * parseFloat(res.unitTime);
    ets_autoup_process_estimate_time = ets_autoup_process_estimate_time > 0 ? ets_autoup_process_estimate_time : parseInt(res.estimateTime);

    //Set speed 5 seconds change percent.
    processEstimatePart(res);

    if (res.stepDone || onResume) {

        // Stop process.
        clearInterval(ets_autoup_process_part);

        // Set variant.
        ets_autoup_current_part_step = parseInt(res.current_part_step);
        ets_autoup_part_complete = parseInt(res.nextParams.totalTimePartDone);
        ets_autoup_part_total = ets_autoup_part_complete + parseInt(res.nextParams.totalTimePart);
        ets_autoup_total_time_current_part = ets_autoup_current_part_step * parseFloat(res.unitTime);
        ets_autoup_process_estimate_time = parseInt(res.estimateTime);
        ets_autoup_set_interval_time = 0;

        // Update estimate time.
        ets_autoup_process_complete = (ets_autoup_part_complete / ets_autoup_part_total);
        if (res.next && 1.0 < ets_autoup_process_complete) {
            ets_autoup_process_complete = 0.99;
        } else if (!res.next) {
            ets_autoup_process_complete = 1.0;
        }
        processEstimatePercent();

        // Set percent.
        var percent = ets_autoup_process_complete * 100;
        $('.ets_autoup_percent').css('width', percent + '%');
        if (1 < percent) {
            $('.ets_autoup_label_percent').html('<span>' + percent.toFixed(0) + '%</span>');
        }

        // Display timer.
        if (res.next != 'download') {
            $('.ets_autoup_estimate_time').show();
        }
        if (ets_autoup_process_estimate_time > 0) {
            $('.ets_autoup_estimate_time').html(estimateTime(parseInt(ets_autoup_process_estimate_time)));
        }

        // Recursive.
        processEstimatePart(res);
    }
}

var ets_autoup_ps = {
    actionResume: '',
    nextParamsResume: [],
    actionRestore: 'rollback',
    nextParamsRestore: [],
    init: function () {
        ets_autoup_ps.fileZipUploaded();
        ets_autoup_ps.uploadFile();
    },
    offConfirm: function (confirm) {
        $('.ets_autoup_resume.active').removeClass('active');
        if (confirm) {
            $('body').removeClass(body_class_process);
            $('.ets_autoup_process').hide();
            $('#blockProcess').addClass('stepError');
        }
    },
    continueProcess: function () {
        $('.ets_autoup_stop_process.active').removeClass('active');
        ets_autoup_process_stop = false;
    },
    handleConfirm: function () {
        ets_autoup_process_stop = true;
        $('.ets_autoup_resume').addClass('active');
    },
    handleReDownloadFileZip: function () {
        ets_autoup_process_stop = true;
        $('.ets_autoup_re_download_file_zip').addClass('active');
    },
    fileZipUploaded: function (el) {
        var _el = el || $('input[name=fileZipIsUploaded]');
        $('button[name=processReDownloadFileZip]').prop('disabled', !_el.is(':checked'));
    },
    uploadFile: function (el) {
        var _el = el || $('#ets_autoup_upload_form'),
            bar = _el.find('.bar'),
            percent = _el.find('.percent'),
            status = _el.find('.status'),
            _errors = $('.ets_autoup_block_errors'),
            processing = _el.find('.ets_autoup_processing'),
            uploadError = $('.ets_autoup_re_download_btn, .ets_autoup_re_upload_file_zip_ftp')
        ;
        if (!_el.hasClass('uploading') && !_el.hasClass('completed')) {
            _el.ajaxForm({
                beforeSend: function (xhr, o) {
                    uploadError.hide();
                    _errors.html('');
                    processing.show();
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    _el.addClass('uploading');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function (xhr) {
                    _el.removeClass('uploading').addClass('completed');
                    var response = JSON.parse(xhr.responseText);
                    if (response) {
                        if (!response.errors) {
                            ets_autoup_process_stop = false;
                            $('.ets_autoup_re_download_file_zip.active').removeClass('active');
                            if (ets_autoup_ps.nextParamsResume) {
                                doAjaxRequest(ets_autoup_ps.actionResume, ets_autoup_ps.nextParamsResume);
                            }
                        } else {
                            if (response.errors) {
                                var _html = '';
                                $.each(response.errors, function (i, item) {
                                    _html += '<li>' + item + '</li>';
                                });
                                _errors.html('<ul class="alert alert-danger">' + _html + '</ul>');
                            }
                            if (response.upload_err_ok) {
                                ets_autoup_ps.fileZipUploaded();
                                uploadError.show();
                            }
                        }
                    }
                    processing.hide();
                }
            });
        }
    },
    setParams: function (action, nextParams) {
        ets_autoup_ps.actionResume = action;
        ets_autoup_ps.nextParamsResume = nextParams;
        ets_autoup_ps.nextParamsRestore = nextParams;
    }
};

const actionReUpgrade = [
    'unzip',
    'backupFiles',
    'backupDb',
    'restoreDb',
    'restoreFiles',
    'upgradeDb',
    'upgradeFiles',
    'cleanCached',
];
const actionAfterUpgradeFiles = [
    'upgradeDb',
    'upgradeModules',
    'upgradeComplete',
];
const ets_autoup_valid_actions = [
    "rollback",
    "rollbackComplete",
    "restoreFiles",
    "restoreDb",
    "rollback",
    "noRollbackFound",
];

function doAjaxRequest(action, nextParams) {

    // Resume.
    ets_autoup_ps.setParams(action, nextParams);

    if (ets_autoup_input._PS_MODE_DEV_ === true) {
        addQuickInfo(["[DEV] ajax request : " + action]);
    }
    $('#blockProcess.error').removeClass('error');

    // process Display.
    if (ets_autoup_valid_actions.indexOf(action) !== -1 && !$("#pleaseWait").is(':visible')) {
        $("#pleaseWait, .ets_autoup_process_block").show();
        $('button.hide_detail_process, button.detail_process, button.prevStep, .ets_autoup_process_title, .ets_autoup_process, .ets_autoup_overload .ets_autoup_actions').hide();
    }
    if (ets_autoup_process_stop) {
        $.xhrPool.abortAll();
    }
    // do Request.
    var req = $.ajax({
        type: "POST",
        url: ets_autoup_input.adminUrl + "/ets_upgrade/upgradetab.php",
        async: true,
        data: {
            dir: ets_autoup_input.adminDir,
            ajaxMode: "1",
            token: ets_autoup_input.token,
            tab: ets_autoup_input.tab,
            action: action,
            params: nextParams
        },
        beforeSend: function (jqXHR) {
            $.xhrPool.push(jqXHR);
        },
        complete: function (jqXHR) {
            // just remove the item to the "abort list"
            $.xhrPool.pop();
        },
        success: function (res, textStatus, jqXHR) {
            nextParams.forceStep = 0;
            nextParams.timeout = 0;
            if ($('.ets_autoup_popup.active').length > 0) {
                $("#pleaseWait img.pleaseWait").hide();
            } else
                $("#pleaseWait").hide();
            try {
                res = $.parseJSON(res);
            } catch (e) {
                res = {status: "error", nextParams: nextParams};
                alert(
                    ets_autoup_input.translation.jsonParseErrorForAction
                    + action
                    + "\"" + ets_autoup_input.translation.startingRestore + "\""
                );
            }
            if (res) {
                if (ets_autoup_valid_actions.indexOf(action) === -1 && action !== 'updateConfig' && (ets_autoup_current_part_step === 0 || res.stepDone)) {
                    processEstimate(res, 0);
                }
                addQuickInfo(res.nextQuickInfo);
                addError(res.nextErrors);
                updateInfoStep(res.next_desc);
                if (res.status === "ok") {
                    $("#" + action).addClass("done");
                    if (res.stepDone) {
                        $("#" + action).addClass("stepok");
                    }
                    // if a function "after[action name]" exists, it should be called now.
                    // This is used for enabling restore buttons for example
                    var funcName = "after" + ucFirst(action);
                    if (typeof window[funcName] === "function" && (action !== 'upgradeFiles' || res.stepDone)) {
                        call_function(funcName, res);
                    }
                    ets_autoup_ps.setParams(res.next, res.nextParams);
                    if (!ets_autoup_process_stop) {
                        handleSuccess(res, action);
                    }
                } else {
                    $("#" + action).addClass("done steperror");
                    if (ets_autoup_valid_actions.indexOf(action) === -1) {
                        handleError(res, action);
                    } else {
                        alert(ets_autoup_input.translation.errorDetectedDuring + " [" + action + "].");
                    }
                }
            } else {
                nextParams.forceStep = 1;
                doAjaxRequest(action, nextParams);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#pleaseWait").hide();
            nextParams.forceStep = 1;
            if (action === 'cleanCached') {
                nextParams.timeout = 1;
            }
            if (textStatus === "timeout") {
                if (action === "download") {
                    ets_autoup_ps.handleReDownloadFileZip();
                } else {
                    updateInfoStep("[Server Error] Timeout: " + ets_autoup_input.translation.downloadTimeout);
                }
                doAjaxRequest(action, nextParams);
            } else {
                try {
                    res = $.parseJSON(jqXHR.responseText);
                    addQuickInfo(res.nextQuickInfo);
                    addError(res.nextErrors);
                    updateInfoStep(res.next_desc);
                } catch (e) {
                    var responseMsq = "[Ajax / Server Error for action " + action + "] textStatus: \"" + textStatus + " \" errorThrown:\"" + errorThrown + " \" jqXHR: \" " + jqXHR.responseText + "\"";
                    responseMsq = responseMsq.replace(/<\s*style[^\r]+?<\s*\/\s*style.*?>/gi, '');
                    updateInfoStep(responseMsq);
                }
                if (actionAfterUpgradeFiles.indexOf(action) !== -1 && nextParams) {
                    afterUpgradeFiles(nextParams);
                } else if (actionReUpgrade.indexOf(action) !== -1) {
                    doAjaxRequest(action, nextParams);
                } else {
                    $('.ets_autoup_process').hide();
                    $('#blockProcess').addClass('stepError');
                    $('body').removeClass(body_class_process);
                }
            }
        }
    });
    return req;
}

/**
 * prepareNextButton make the button button_selector available, and update the nextParams values
 *
 * @param button_selector $button_selector
 * @param nextParams $nextParams
 * @return void
 */
function prepareNextButton(button_selector, nextParams) {
    $(button_selector)
        .unbind()
        .click(function (e) {
            e.preventDefault();
            if (button_selector === '#upgradeNow') {
                if (!$('#ets_autoup_confirm_backup2').is(':checked') || !$('#ets_autoup_confirm_latest2').is(':checked')) {
                    $('.ets_autoup_overload').addClass('active');
                    return;
                } else
                    $('.ets_autoup_overload').removeClass('active');
            }
            $("#currentlyProcessing").show();
            //Variable.
            var doRequest = 1,
                action = button_selector.substr(1),
                actions = [
                    "rollback",
                ];

            // Validate Request.
            if (actions.indexOf(action) !== -1) {
                if ($('select[name=restoreName]').val()) {
                    $('.ug_block_step.active').removeClass('active');
                    $('#blockProcess').addClass('active');
                    $('#blockProcess .ets_autoup_upgrade_process, #upgradeResultToDoList .item17').hide();
                    $('#blockProcess .ets_autoup_rollback_process').show();
                } else
                    doRequest = 0;
            } else {
                ets_autoup_fn.nextSteps($('.ets_autoup_steps li.active').next());
            }

            //Do Request.
            if (doRequest) {
                doAjaxRequest(action, nextParams);
            } else
                $(this).unbind();
        });
}

/**
 * handleSuccess
 * res = {error:, next:, next_desc:, nextParams:, nextQuickInfo:,status:"ok"}
 * @param res $res
 * @return void
 */
function handleSuccess(res, action) {
    if (res.next !== "") {
        // Resume.
        // ets_autoup_ps.actionResume = res.next;
        $("#" + res.next).addClass("nextStep");
        var validActions = [
            "rollback",
            "rollbackComplete",
            "restoreFiles",
            "restoreDb",
            "rollback",
            "noRollbackFound"
        ];
        if (res.next === 'download' && res.nextParams.isReDownloadFileZip === 1) {
            ets_autoup_ps.handleReDownloadFileZip();
        } else if (ets_autoup_input.manualMode && validActions.indexOf(action) === -1) {
            prepareNextButton("#" + res.next, res.nextParams);
            alert(ets_autoup_input.translation.manuallyGoToButton.replace("%s", res.next));
        } else {
            // if next is rollback, prepare nextParams with rollbackDbFilename and rollbackFilesFilename
            if (res.next === "rollback") {
                res.nextParams.restoreName = "";
            }
            doAjaxRequest(res.next, res.nextParams);
            // 2) remove all step link (or show them only in dev mode)
            // 3) when steps link displayed, they should change color when passed if they are visible
        }
    } else {
        // Way To Go, end of upgrade process
        addQuickInfo([ets_autoup_input.translation.endOfProcess]);
    }
}

// res = {nextParams, next_desc}
function handleError(res, action) {
    // display error message in the main process thing
    // In case the rollback button has been deactivated, just re-enable it
    $("#rollback").removeAttr("disabled");
    // auto rollback only if current action is upgradeFiles or upgradeDb
    var validActions = [
        "upgradeFiles",
        "upgradeDb",
        "upgradeModules"
    ];

    if (validActions.indexOf(action) !== -1) {

        // Restore ignore.
        res.nextParams.restoreName = res.nextParams.backupName;
        ets_autoup_ps.nextParamsRestore = res.nextParams;
        ets_autoup_ps.handleConfirm();

    } else if (action === 'download' && res.next !== 'error') {
        ets_autoup_ps.handleReDownloadFileZip();
    } else {
        $(".button-autoupgrade").html(ets_autoup_input.translation.processCancelledWithError);
        $('body').removeClass(body_class_process);
        $('.ets_autoup_process').hide();
        $('#blockProcess').addClass('stepError');
    }
}

// ajax to check md5 files
function addModifiedFileList(title, fileList, css_class, container) {
    var subList = $("<ul class=\"changedFileList " + css_class + "\"></ul>");

    $(fileList).each(function (k, v) {
        $(subList).append("<li>" + v + "</li>");
    });

    $(container)
        .append("<h3><a class=\"toggleSublist\" href=\"#\" >" + title + "</a> (" + fileList.length + ")</h3>")
        .append(subList);
}

// -- Should be executed only if ajaxUpgradeTabExists
function isJsonString(str) {
    try {
        typeof str !== "undefined" && JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function reloadNextParams() {
    $.ajax({
        type: "POST",
        url: ets_autoup_input.currentIndex + "&token=" + ets_autoup_input.token,
        async: true,
        data: 'refreshCurrentVersion=1',
        success: function (res) {
            if (isJsonString(res)) {
                res = $.parseJSON(res);
            } else {
                res = {nextParams: {status: "error"}};
            }
            //set nextParams.
            ets_autoup_input.nextParams = res.nextParams;
        },
    });
}

function checkFilesVersion() {
    checkedFilesVersion = 0;
    ets_autoup_fn.checkVersionComparison();
    $.ajax({
        type: "POST",
        url: ets_autoup_input.adminUrl + "/ets_upgrade/upgradetab.php",
        async: true,
        data: {
            dir: ets_autoup_input.adminDir,
            token: ets_autoup_input.token,
            tab: ets_autoup_input.tab,
            action: "checkFilesVersion",
            ajaxMode: "1",
            params: {}
        },
        success: function (res, textStatus, jqXHR) {
            if (isJsonString(res)) {
                res = $.parseJSON(res);
            } else {
                res = {nextParams: {status: "error"}};
            }
            var answer = res.nextParams;
            var $checkPrestaShopFilesVersion = $("#checkPrestaShopFilesVersion");

            $checkPrestaShopFilesVersion.html("<span> " + answer.msg + " </span> ");
            if (answer.status === "error" || (typeof answer.result === "undefined")) {
                $checkPrestaShopFilesVersion.prepend("<img src=\"../img/admin/warning.gif\" /> ");
            } else {
                $checkPrestaShopFilesVersion
                    .prepend("<img src=\"../img/admin/warning.gif\" /> ")
                    .append("<a id=\"toggleChangedList\" class=\"button\" href=\"\">" + ets_autoup_input.translation.seeOrHideList + "</a><br/>")
                    .append("<div id=\"changedList\" style=\"display:none \">");

                if (answer.result.core.length) {
                    addModifiedFileList(ets_autoup_input.translation.coreFiles, answer.result.core, "changedImportant", "#changedList");
                }
                if (answer.result.mail.length) {
                    addModifiedFileList(ets_autoup_input.translation.mailFiles, answer.result.mail, "changedNotice", "#changedList");
                }
                if (answer.result.translation.length) {
                    addModifiedFileList(ets_autoup_input.translation.translationFiles, answer.result.translation, "changedNotice", "#changedList");
                }

                $("#toggleChangedList").bind("click", function (e) {
                    e.preventDefault();
                    $("#changedList").toggle();
                });

                $(document).on("click", ".toggleSublist", function (e) {
                    e.preventDefault();
                    $(this).parent().next().toggle();
                });
            }

            ets_autoup_fn.allowUpgrade(true);
            checkedFilesVersion = 1;
            ets_autoup_fn.checkVersionComparison();
        },
        error: function (res, textStatus, jqXHR) {
            if (textStatus === "timeout" && action === "download") {
                updateInfoStep(ets_autoup_input.translation.cannotDownloadFile);
            } else {
                // technical error : no translation needed
                $("#checkPrestaShopFilesVersion").html("<img src=\"../img/admin/warning.gif\" /> Error: Unable to check md5 files");
            }
            checkedFilesVersion = 1;
            ets_autoup_fn.checkVersionComparison();
        }
    });
}

function compareReleases() {
    comparedReleases = 0;
    ets_autoup_fn.checkVersionComparison();
    $.ajax({
        type: "POST",
        url: ets_autoup_input.adminUrl + "/ets_upgrade/upgradetab.php",
        async: true,
        data: {
            dir: ets_autoup_input.adminDir,
            token: ets_autoup_input.token,
            tab: ets_autoup_input.tab,
            action: "compareReleases",
            ajaxMode: "1",
            params: {}
        },
        success: function (res, textStatus, jqXHR) {
            check_version_comparison = false;
            if (isJsonString(res)) {
                res = $.parseJSON(res);
            } else {
                res = {nextParams: {status: "error"}};
            }
            var answer = res.nextParams;
            var $checkPrestaShopModifiedFiles = $("#checkPrestaShopModifiedFiles");

            $checkPrestaShopModifiedFiles.html("<span> " + answer.msg + " </span> ");
            if (answer.status === "error" || typeof answer.result === "undefined") {
                $checkPrestaShopModifiedFiles.prepend("<img src=\"../img/admin/warning.gif\" /> ");
            } else {
                $checkPrestaShopModifiedFiles
                    .prepend("<img src=\"../img/admin/warning.gif\" /> ")
                    .append("<a id=\"toggleDiffList\" class=\"button\" href=\"\">" + ets_autoup_input.translation.seeOrHideList + "</a><br/>")
                    .append("<div class='clearfix'></div><div id=\"diffList\" style=\"display:none \">");

                if (answer.result.deleted.length) {
                    addModifiedFileList(ets_autoup_input.translation.filesWillBeDeleted, answer.result.deleted, "diffImportant", "#diffList");
                }
                if (answer.result.modified.length) {
                    addModifiedFileList(ets_autoup_input.translation.filesWillBeReplaced, answer.result.modified, "diffImportant", "#diffList");
                }

                $("#toggleDiffList").bind("click", function (e) {
                    e.preventDefault();
                    $("#diffList").toggle();
                });

                $(document).on("click", ".toggleSublist", function (e) {
                    e.preventDefault();
                    // this=a, parent=h3, next=ul
                    $(this).parent().next().toggle();
                });
            }

            //de-active option.
            ets_autoup_fn.propOptions(ets_autoup_fn.isMajorChannel());

            //update version.
            if (typeof answer.install_version !== "undefined" && answer.install_version) {
                $('.ets_autoup_latest_version').html(answer.install_version);
                var todoList17 = $('#upgradeResultToDoList .item17');
                if (answer.install_version && /^1\.7((\.[0-9]{1,2}){2})?$/.test(answer.install_version)) {
                    todoList17.show();
                } else {
                    todoList17.hide();
                }
            }

            $('.ets_autoup_options form.active').removeClass('active');

            ets_autoup_fn.allowUpgrade(true);
            comparedReleases = 1;
            ets_autoup_fn.checkVersionComparison();
        },
        error: function (res, textStatus, jqXHR) {
            if (textStatus === "timeout" && action === "download") {
                updateInfoStep(ets_autoup_input.translation.cannotDownloadFile);
            } else {
                // technical error : no translation needed
                $("#checkPrestaShopFilesVersion").html("<img src=\"../img/admin/warning.gif\" /> Error: Unable to check md5 files");
            }
            comparedReleases = 1;
            ets_autoup_fn.checkVersionComparison();
        }
    });
}

$(document).ready(function () {
    ets_autoup_ps.init();
    // Resume.
    $('.processResume').click(function () {
        if (ets_autoup_ps.nextParamsResume) {
            doAjaxRequest(ets_autoup_ps.actionResume, ets_autoup_ps.nextParamsResume);
        }
        ets_autoup_ps.offConfirm(0);
    });
    // Continue.
    $('.ets_autoup_process_continue').click(function () {
        if (ets_autoup_ps.nextParamsResume) {
            doAjaxRequest(ets_autoup_ps.actionResume, ets_autoup_ps.nextParamsResume);
        }
        ets_autoup_ps.continueProcess();
    });

    $('#ets_autoup_accept_condition').change(function () {
        var btn = $('.ets_autoup_process_continue');
        if ($(this).is(':checked')) {
            btn.prop('disabled', false);
        } else {
            btn.prop('disabled', true)
        }
    });

    $('.ets_autoup_resume .ets_autoup_close').click(function () {
        ets_autoup_ps.offConfirm(1);
    });

    $('input[name=fileZipIsUploaded]').click(function () {
        ets_autoup_ps.fileZipUploaded($(this));
    });

    $('button[name=processReDownloadFileZip]').click(function (ev) {
        ev.preventDefault();

        var _el = $(this),
            _ac = _el.parents('form').attr('action'),
            _err = $('.ets_autoup_block_errors')
        ;
        if (!_el.hasClass('active') && _ac != '') {
            _err.html('');
            _el.addClass('active');
            $.ajax({
                type: 'post',
                url: _ac.replace('uploadFileZip', 'testFileZip'),
                dataType: 'json',
                success: function (json) {
                    _el.removeClass('active');
                    if (json) {
                        if (json.errors) {
                            var _html = '';
                            $.each(json.errors, function (i, item) {
                                _html += '<li>' + item + '</li>';
                            });
                            _err.html('<ul class="alert alert-danger">' + _html + '</ul>');
                        } else {
                            ets_autoup_process_stop = false;
                            $('.ets_autoup_re_download_file_zip.active').removeClass('active');
                            if (ets_autoup_ps.nextParamsResume) {
                                doAjaxRequest(ets_autoup_ps.actionResume, ets_autoup_ps.nextParamsResume);
                            }
                        }
                    }
                },
                error: function () {
                    _el.removeClass('active');
                }
            });
        }
    });
    $('#upload_file_zip').change(function () {
        var _form = $('#ets_autoup_upload_form');
        if (!_form.hasClass('uploading')) {
            _form
                .removeClass('completed')
                .submit();
        }
    });
});

// -- END