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

// js initialization : prepare upgrade and rollback buttons
$(document).ready(function () {

    $(".nobootstrap.no-header-toolbar").removeClass("nobootstrap").addClass("bootstrap");

    $(document).on('click', '.ets_autoup_wrap_content .ets_autoup_close', function (e) {
        e.preventDefault();
        $('.ets_autoup_overload.active').removeClass('active');
        $('.ets_autoup_overload input[type=checkbox]').prop('checked', false);
    });

    $(document).on("click", "a.confirmBeforeDelete", function (e) {
        if (!confirm(ets_autoup_input.translation.confirmDeleteBackup)) {
            e.preventDefault();
        }
    });

    /*---Select chanel---*/
    $("select[name=channel]").change(function (e) {
        $(this).find("option").each(function () {
            var $this = $(this);
            $("#for-" + $this.attr("id"))
                .toggle($this.is(":selected"));
        });

        refreshChannelInfos();
    });

    function refreshChannelInfos() {
        var val = $("select[name=channel]").val();
        $.ajax({
            type: "POST", url: ets_autoup_input.adminUrl + "/ets_upgrade/upgradetab.php", async: true, data: {
                dir: ets_autoup_input.adminDir,
                token: ets_autoup_input.token,
                tab: ets_autoup_input.tab,
                action: "getChannelInfo",
                ajaxMode: "1",
                params: {channel: val}
            }, success: function (res, textStatus, jqXHR) {
                if (isJsonString(res)) {
                    res = $.parseJSON(res);
                } else {
                    res = {nextParams: {status: "error"}};
                }

                var answer = res.nextParams.result;
                if (typeof answer !== "undefined") {
                    var $channelInfos = $("#channel-infos");
                    $channelInfos.replaceWith(answer.div);
                    if (answer.available) {
                        $("#channel-infos .all-infos").show();
                    } else {
                        $channelInfos.html(answer.div);
                        $("#channel-infos .all-infos").hide();
                    }
                }
            }, error: function (res, textStatus, jqXHR) {
                if (textStatus === "timeout" && action === "download") {
                    updateInfoStep(ets_autoup_input.translation.cannotDownloadFile);
                } else {
                    // technical error : no translation needed
                    $("#checkPrestaShopFilesVersion").html("<img src=\"../img/admin/warning.gif\" /> Error Unable to check md5 files");
                }
            }
        });
    }

    $('input[name=channel]').change(function () {
        ets_autoup_fn.channel($(this).val());
    });
    /*--end select chanel---*/


    // the following prevents to leave the page at the inappropriate time
    $.xhrPool = [];
    $.xhrPool.abortAll = function () {
        $.each(this, function (jqXHR) {
            if (jqXHR && (jqXHR.readystate !== 4)) {
                jqXHR.abort();
            }
        });
    };

    $(".upgradestep").click(function (e) {
        e.preventDefault();
    });

    // set timeout to 120 minutes (before aborting an ajax request)
    $.ajaxSetup({timeout: 7200000});

    // prepare available button here, without params ?
    prepareNextButton("#upgradeNow", firstTimeParams);

    /**
     * reset rollbackParams js array (used to init rollback button)
     */
    $("select[name=restoreName]").change(function () {
        var val = $(this).val();

        // show delete button if the value is not 0
        if (val != 0) {
            $("span#buttonDeleteBackup").html("<a class=\"button confirmBeforeDelete\" title=\"" + ets_autoup_input.translation.delete + "\" href=\"index.php?tab=EtsAdminSelfUpgrade&token=" + ets_autoup_input.token + "&amp;deletebackup&amp;name=" + $(this).val() + "\"><img src=\"../img/admin/disabled.gif\" />" + ets_autoup_input.translation.delete + "</a>");
        }

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
            // Note : theses buttons have been removed.
            // they will be available in a future release (when DEV_MODE and MANUAL_MODE enabled)
            // prepareNextButton("#restoreDb", rollbackParams);
            // prepareNextButton("#restoreFiles", rollbackParams);
        } else {
            $("#rollback")
                .unbind()
                .attr("disabled", "disabled");
        }
    });

    /*---End rollback---*/

    $("div[id|=for]").hide();

    if (!ets_autoup_input.ajaxUpgradeTabExists) {
        $("#checkPrestaShopFilesVersion").html("<img src=\"../img/admin/warning.gif\" />" + ets_autoup_input.translation.missingAjaxUpgradeTab);
    }
});

$(document).ready(function () {
    ets_autoup_fn.init();
    if ($('input[name=channel]').is(':checked')) {
        checkFilesVersion();
        compareReleases();
    }
});

$(document).ready(function () {

    /*---Upgrade setting---*/
    $("input[name|=submitConf]").bind("click", function (e) {
        var params = {};
        var $newChannel = $("select[name=channel] option:selected").val();
        var $oldChannel = $("select[name=channel] option.current").val();
        $oldChannel = "";

        if ($oldChannel != $newChannel) {
            var validChannels = ["major", "minor", "rc", "beta", "alpha"];
            if (validChannels.indexOf($newChannel) !== -1 || /^(?:major)[0-9]+\.[0-9]+$/i.test($newChannel)) {
                params.channel = $newChannel;
            }

            if ($newChannel === "private") {
                if (($("input[name=private_release_link]").val() == "") || ($("input[name=private_release_md5]").val() == "")) {
                    showConfigResult(ets_autoup_input.translation.linkAndMd5CannotBeEmpty, "error");
                    return false;
                }
                params.channel = "private";
                params.private_release_link = $("input[name=private_release_link]").val();
                params.private_release_md5 = $("input[name=private_release_md5]").val();
                if ($("input[name=private_allow_major]").is(":checked")) {
                    params.private_allow_major = 1;
                } else {
                    params.private_allow_major = 0;
                }
            } else if ($newChannel === "archive") {
                var archive_prestashop = $("select[name=archive_prestashop]").val();
                var archive_num = $("input[name=archive_num]").val();
                if (archive_num == "") {
                    showConfigResult(ets_autoup_input.translation.needToEnterArchiveVersionNumber, "error");
                    return false;
                }
                if (archive_prestashop == "") {
                    showConfigResult(ets_autoup_input.translation.noArchiveSelected, "error");
                    return false;
                }
                params.channel = "archive";
                params.archive_prestashop = archive_prestashop;
                params.archive_num = archive_num;
            } else if ($newChannel === "directory") {
                params.channel = "directory";
                params.directory_prestashop = $("select[name=directory_prestashop] option:selected").val();
                var directory_num = $("input[name=directory_num]").val();
                if (directory_num == "" || directory_num.indexOf(".") == -1) {
                    showConfigResult(ets_autoup_input.translation.needToEnterDirectoryVersionNumber, "error");
                    return false;
                }
                params.directory_num = $("input[name=directory_num]").val();
            }
        }
        // note: skipBackup is currently not used
        if ($(this).attr("name") == "submitConf-skipBackup") {
            var skipBackup = $("input[name=submitConf-skipBackup]:checked").length;
            if (skipBackup == 0 || confirm(ets_autoup_input.translation.confirmSkipBackup)) {
                params.skip_backup = $("input[name=submitConf-skipBackup]:checked").length;
            } else {
                $("input[name=submitConf-skipBackup]:checked").removeAttr("checked");
                return false;
            }
        }

        // note: preserveFiles is currently not used
        if ($(this).attr("name") == "submitConf-preserveFiles") {
            var preserveFiles = $("input[name=submitConf-preserveFiles]:checked").length;
            if (confirm(ets_autoup_input.translation.confirmPreserveFileOptions)) {
                params.preserve_files = $("input[name=submitConf-preserveFiles]:checked").length;
            } else {
                $("input[name=submitConf-skipBackup]:checked").removeAttr("checked");
                return false;
            }
        }
        var res = doAjaxRequest("updateConfig", params);
    });
    /*---End setting---*/

    /*New code*/

    $('form #upgradeOptionsBlock input').change(function () {
        $('button[name=customSubmitAutoUpgrade]').trigger('click');
    });

    $('button[name=customSubmitAutoUpgrade]').click(function (ev) {
        ev.preventDefault();
        ets_autoup_fn.saveConfig($(this));
    });

    $('.nextStep').click(function () {
        var _self = $(this), _cTab = $('.ets_autoup_steps li.active');
        if (_cTab.hasClass('end')) return 0;
        ets_autoup_fn.nextSteps(_cTab.next());

        // Check version comparison.
        if (_self.hasClass('upgradeNow')) {
            ets_autoup_fn.checkVersionComparison();
        }
    });

    $('.prevStep').click(function () {
        var currentTab = $('.ets_autoup_steps li.active');
        if (currentTab.hasClass('begin')) {
            ets_autoup_fn.nextSteps();
        } else {
            if (!$('#blockRollback').hasClass('active')) {
                currentTab = currentTab.prev();
            }
            ets_autoup_fn.nextSteps(currentTab, 'prev');
        }
    });

    $('button[name=buttonRefresh]').click(function () {
        var btn = $(this);
        if (!btn.hasClass('active')) {
            btn.addClass('active');
            $.ajax({
                type: 'POST',
                url: ets_autoup_input.currentIndex + '&token=' + ets_autoup_input.token,
                data: 'refreshChecklist=1',
                dataType: 'json',
                success: function (json) {
                    btn.removeClass('active');
                    if (json) {
                        if (json.isOkForUpgrade) {
                            $('.ets_autoup_steps li.active').addClass('disabled');
                            ets_autoup_fn.nextSteps($('.ets_autoup_steps li.active').next());
                        }
                        if (json.msg) {
                            showErrorMessage(json.msg);
                        }
                    }
                },
                error: function () {
                    btn.removeClass('active');
                }
            });
        }
    });

    $('.ets_autoup_btn_show_options, .ets_autoup_btn_hide_options').click(function () {
        if ($('.ets_autoup_options').is(':visible')) {
            $('.ets_autoup_options').hide();
        } else {
            $('.ets_autoup_options').show();
        }
    });

    $('.ets_autoup_btn_view_more, .ets_autoup_btn_less_more').click(function () {
        if ($('.ets_autoup_block_viewmore').is(':visible')) {
            $('.ets_autoup_block_viewmore').hide();
        } else {
            $('.ets_autoup_block_viewmore').show();
        }
    });

    $('#currentConfiguration td a').click(function (ev) {

        var btn = $(this), urlLink = $(this).attr('href');

        if (urlLink != '#' && urlLink != '' && urlLink.match(/(?:ignorePsRequirements|ignorePhpOutdated)/)) {
            ev.preventDefault();
            var btn = $(this);
            if (!btn.hasClass('active')) {
                btn.addClass('active');
                $.ajax({
                    type: 'POST', url: urlLink, dataType: 'json', success: function (json) {
                        btn.removeClass('active');
                        if (json) {
                            showSuccessMessage(json.msg);
                            var img = btn.parents('tr').find('td > img'),
                                img_src = img.attr('src').replace(/(warning.gif)/i, 'enabled.gif');
                            img.attr('src', img_src);
                        }
                    }, error: function () {
                        btn.removeClass('active');
                    }
                });
            }
        }

    });

    $('.ets_autoup_rollback_link').click(function (ev) {
        if (!$('#blockResult').hasClass('active') && !$('#blockProcess').hasClass('stepError')) {
            ev.preventDefault();
            $('.ug_block_step.active').removeClass('active');
            $('#blockRollback').addClass('active');
            $('.prevStep').show();
        } else {
            $(this).attr('target', '_blank');
        }
    });

    $('#ets_autoup_confirm_backup, #ets_autoup_warning_upgrade, #ets_autoup_confirm_latest').click(function () {
        var $disabled = true;
        if ($('#ets_autoup_confirm_backup').is(':checked') && $('#ets_autoup_confirm_latest').is(':checked') && (!$('#ets_autoup_warning_upgrade:visible').length > 0 || $('#ets_autoup_warning_upgrade').is(':checked'))) {
            $disabled = false;
        }
        $('#upgradeNow').prop('disabled', $disabled);
    });

    $('label[for=ets_autoup_confirm_backup], label[for=ets_autoup_confirm_latest]').mousedown(function () {
        if (allow_button_upgrade && $('.ets_autoup_options form.active').length <= 0) {
            if (!$('.ets_autoup_block_viewmore').is(':visible')) {
                $('.ets_autoup_btn_view_more').click();
            }
            $('html, body').animate({scrollTop: $('.ets_autoup_btn_view_more').offset().top - 350}, 750);
        }
    });

    $(document).on('change', '#ets_autoup_confirm_backup2, #ets_autoup_confirm_latest2', function (e) {
        e.preventDefault();
        if ($('#ets_autoup_confirm_backup2').is(':checked') && $('#ets_autoup_confirm_latest2').is(':checked')) {
            $('#upgradeNow2').prop('disabled', false);
        } else $('#upgradeNow2').prop('disabled', true);
    });

    $(document).on('click', '#upgradeNow2', function (e) {
        e.preventDefault();
        if (!$('#ets_autoup_confirm_backup2').is(':checked') || !$('#ets_autoup_confirm_latest2').is(':checked')) {
            return;
        }
        $('.ets_autoup_overload').removeClass('active');
        $('#upgradeNow').trigger('click');
    });

    $('button.detail_process').click(function (ev) {
        ev.preventDefault();
        $(this).hide();
        $('.ets_autoup_process_block').slideDown();
        $('button.hide_detail_process').show();
    });

    $('button.hide_detail_process').click(function (ev) {
        ev.preventDefault();
        $(this).hide();
        $('.ets_autoup_process_block').slideUp();
        $('button.detail_process').show();
    });

    $('.ets_autoup_section_copied').click(function () {
        ets_autoup_fn.copyToClipboard($(this));
    });

    $('#PS_AUTOUP_PERFORMANCE').change(function () {
        $(this).parents('span').attr('data-range', $(this).val());
    });
});