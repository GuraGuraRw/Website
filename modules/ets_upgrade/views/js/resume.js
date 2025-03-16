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

var input = input || [],
    ets_autoup_resume_input = ets_autoup_resume_input || []
;
if (ets_autoup_resume_input.nextParams)
    ets_autoup_resume_input.nextParams.forceFromFile = 1;

$(document).ready(function () {

    $('.ets_autoup_btn_resume').click(function (ev) {
        ev.preventDefault();
        if (ets_autoup_resume_input.next)
            $(this).attr('id', '#' + ets_autoup_resume_input.next);

        $('.ets_autoup_resume_wrap .ets_autoup_panel').hide();
        $('.ets_autoup_resume_wrap').addClass('processUpgrade');
        $("#currentlyProcessing").show();

        //Variable.
        var doRequest = 1,
            action = ets_autoup_resume_input.next,
            actions = [
                "rollback",
            ],
            stepFlow = $('.ets_autoup_steps li.active').length > 0 ? $('.ets_autoup_steps li.active') : $('.ets_autoup_steps li:first')
        ;

        // Validate Request.
        if (actions.indexOf(action) !== -1) {
            if ($('select[name=restoreName]').val()) {
                $('.ug_block_step.active').removeClass('active');
                $('#blockProcess').addClass('active');
                $('#blockProcess .ets_autoup_upgrade_process').hide();
                $('#blockProcess .ets_autoup_rollback_process').show();
            } else
                doRequest = 0;
        } else {
            ets_autoup_fn.nextSteps(stepFlow);
        }

        //Do Request.
        if (doRequest) {
            doAjaxRequest(action, ets_autoup_resume_input.nextParams);
            processEstimate(ets_autoup_resume_input, 1);
        } else
            $(this).unbind();
    });
});