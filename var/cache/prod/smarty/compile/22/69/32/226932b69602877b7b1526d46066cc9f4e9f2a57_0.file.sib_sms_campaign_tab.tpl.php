<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:50:11
  from '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/sib_sms_campaign_tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be9d3c9ecb6_33529324',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '226932b69602877b7b1526d46066cc9f4e9f2a57' => 
    array (
      0 => '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/sib_sms_campaign_tab.tpl',
      1 => 1737217526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be9d3c9ecb6_33529324 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="row">

    <div class="col-lg-12 panel">

        <form id="" class="defaultForm form-horizontal AdminCustomers"
              action="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['formUrl']->value,'htmlall','UTF-8' ));?>
"
              method="POST" enctype="multipart/form-data" novalidate="" _lpchecked="1">
                        <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="sib_sms_campaign_toggle"
                               value="0" <?php echo !(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['Api_Sms_Campaign_Status']->value,'htmlall','UTF-8' ))) ? 'checked="checked"' : '';?>
>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Disable','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                    </label>
                    <label>
                        <input type="radio" name="sib_sms_campaign_toggle"
                               value="1" <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['Api_Sms_Campaign_Status']->value,'htmlall','UTF-8' )) ? 'checked="checked"' : '';?>
>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                    </label>
                </div>
            </div>
            
            <div id="sib_sms_campaign" style=" <?php echo !(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['Api_Sms_Campaign_Status']->value,'htmlall','UTF-8' ))) ? 'display: none;' : '';?>
">
                <div class="form-wrapper">

                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input name="Sendin_Sms_Choice" id="r1_Sendin_Sms_Choice" type="radio"
                                       value="0" <?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['Sms_Campaign_Type']->value,'htmlall','UTF-8' )) == 0) {?> checked="checked" <?php }?>>
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'A single contact','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                            </label>
                            <label>
                                <input name="Sendin_Sms_Choice" id="r3_Sendin_Sms_Choice"
                                       class="Sendin_Sms_Choice radio_spaceing" type="radio"
                                       value="1" <?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['Sms_Campaign_Type']->value,'htmlall','UTF-8' )) == 1) {?> checked="checked" <?php }?>>
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Only subscribed customers','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="sib_single_phone_number">
                        <label class="control-label col-lg-4" for="sib_campaign_phone_number">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Phone number of the contact','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </label>
                        <div class="col-lg-4">
                            <input type="text" name="single_campaign_phone_number" id="single_campaign_phone_number"
                                   class="sms_campaign_phone_number input-text"
                                   autocomplete="off" maxlength="17"
                                   value=""><span class="toolTip"
                                                  title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' The phone number should be in this form: 0033663309741 for this France mobile 06 63 30 97 41 (0033 is France prefix)','mod'=>'sendinblue'),$_smarty_tpl ) );?>
">&nbsp;</span>
                        </div>
                    </div>

                    <div class="form-group" id="sib_subscribed_campaign_option">
                        <label class="control-label col-lg-4" for="sib_datetimepicker">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Schedule your sms campaign','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </label>
                        <div class="col-lg-8">
                            <div class="form-group">
                                <div class="col-lg-4">
                                    <input name="sib_datetimepicker_date" id="sib_datetimepicker_date" type="date"
                                           value=""
                                           class="sib_datetimepicker_date hasDatepicker" data-provide="datepicker"/>
                                </div>
                                <div class="col-lg-3">
                                    <select name="hour" id="sib_datetimepicker_hour"
                                            class="sib_datetimepicker_hour">
                                        <option value=''><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Hour','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</option>
                                        <?php
$_smarty_tpl->tpl_vars['counter'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['counter']->step = 1;$_smarty_tpl->tpl_vars['counter']->total = (int) ceil(($_smarty_tpl->tpl_vars['counter']->step > 0 ? 23+1 - (0) : 0-(23)+1)/abs($_smarty_tpl->tpl_vars['counter']->step));
if ($_smarty_tpl->tpl_vars['counter']->total > 0) {
for ($_smarty_tpl->tpl_vars['counter']->value = 0, $_smarty_tpl->tpl_vars['counter']->iteration = 1;$_smarty_tpl->tpl_vars['counter']->iteration <= $_smarty_tpl->tpl_vars['counter']->total;$_smarty_tpl->tpl_vars['counter']->value += $_smarty_tpl->tpl_vars['counter']->step, $_smarty_tpl->tpl_vars['counter']->iteration++) {
$_smarty_tpl->tpl_vars['counter']->first = $_smarty_tpl->tpl_vars['counter']->iteration === 1;$_smarty_tpl->tpl_vars['counter']->last = $_smarty_tpl->tpl_vars['counter']->iteration === $_smarty_tpl->tpl_vars['counter']->total;?>
                                            <option value=<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['counter']->value,'htmlall','UTF-8' ));?>
><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['counter']->value,'htmlall','UTF-8' ));?>
</option>
                                        <?php }
}
?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="minute" id="sib_datetimepicker_minute"
                                            class="sib_datetimepicker_minute">
                                        <option value=''><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Minute','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</option>
                                        <?php
$_smarty_tpl->tpl_vars['counter'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['counter']->step = 5;$_smarty_tpl->tpl_vars['counter']->total = (int) ceil(($_smarty_tpl->tpl_vars['counter']->step > 0 ? 55+1 - (0) : 0-(55)+1)/abs($_smarty_tpl->tpl_vars['counter']->step));
if ($_smarty_tpl->tpl_vars['counter']->total > 0) {
for ($_smarty_tpl->tpl_vars['counter']->value = 0, $_smarty_tpl->tpl_vars['counter']->iteration = 1;$_smarty_tpl->tpl_vars['counter']->iteration <= $_smarty_tpl->tpl_vars['counter']->total;$_smarty_tpl->tpl_vars['counter']->value += $_smarty_tpl->tpl_vars['counter']->step, $_smarty_tpl->tpl_vars['counter']->iteration++) {
$_smarty_tpl->tpl_vars['counter']->first = $_smarty_tpl->tpl_vars['counter']->iteration === 1;$_smarty_tpl->tpl_vars['counter']->last = $_smarty_tpl->tpl_vars['counter']->iteration === $_smarty_tpl->tpl_vars['counter']->total;?>
                                            <option value=<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['counter']->value,'htmlall','UTF-8' ));?>
><?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['counter']->value,'htmlall','UTF-8' ));?>
</option>
                                        <?php }
}
?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4" for="sib_sms_campaign_sender">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sender','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </label>
                        <div class="col-lg-4">
                            <input type="text" name="sib_sms_campaign_sender" id="sib_sms_campaign_sender"
                                   class="sms_campaign_sender input-text"
                                   autocomplete="off" maxlength="11" value="">
                            <span class="toolTip"
                                  title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'This field allows you to customize the SMS sender. The number of characters is limited to 11 alphanumeric characters. You can´t configure your Sender with a phone number.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
">&nbsp;</span>
                            <div class="hintmsg"><em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Number of characters left: ','mod'=>'sendinblue'),$_smarty_tpl ) );?>
<span
                                            id="sender_campaign_text">11</span></em></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4" for="sib_sms_campaign_message">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Message','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </label>

                        <div class="col-lg-4">
                            <textarea name="sib_sms_campaign_message" id="sib_sms_campaign_message"
                                      cols="45" rows="5" class="sms_campaign_message"
                                      style="resize: both"></textarea>
                            <span style="line-height:16px; margin-bottom:15px; width:333px;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Number of SMS used: ','mod'=>'sendinblue'),$_smarty_tpl ) );?>
<span
                                        id="sib_sms_campaign_message_text_count">0</span>
                                             <div class="hintmsg"><em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Number of characters left: ','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em><span
                                                         id="sib_sms_campaign_message_text">160</span></div></span>
                            <div class="hintmsg">
                                <em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Attention line break is counted as a single character.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em>
                            </div>
                            <br>
                            <div class="hintmsg">
                                <em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'If you want to personalize the SMS, you can use the variables below:','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em>
                            </div>
                            <div class="hintmsg"><em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'- For civility use {civility}','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em></div>
                            <div class="hintmsg"><em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'- For first name use {first_name}','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em>
                            </div>
                            <div class="hintmsg"><em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'- For last name use {last_name}','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</em></div>
                            <button type="button" style="margin-top:10px;"
                                    class="btn btn-outline-secondary btn-submit hidden-xs uppercase duplicate sms_campaign_send"
                                    value="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send the campaign','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    name="sms_campaign_send"
                                    senderAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the sender field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    numberAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the phone number field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    messageAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the message field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    dateAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the scheduled date fields','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    hourAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the scheduled hour fields','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    minuteAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the scheduled minute fields','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    scheduleAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Scheduled date may not be prior to the current date','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    listAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please first select the list from the plugin settings','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    contactAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'SMS has not been sent because the number is not registered in your shops customer base','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    successAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Campaign message has been sent successfully','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                    failAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Campaign message has not been sent successfully','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send the campaign','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                            </button>
                        </div>
                        <span class="toolTip" style="padding-left: 5px;"
                              title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Create the content of your SMS with the limit of 160-character.Beyond 160 characters, it will be counted as a second SMS. Thus, if you write  SMS of 240 characters, it will be recorded using two SMS.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
">&nbsp;</span>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-4" for="sib_sms_campaign_test">
                            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send a Test SMS','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </label>
                        <div class="col-lg-4">
                            <div class="">
                                <input type="text" name="sms_campaign_test_number"
                                       id="sms_campaign_test_number" class="sms_campaign_test_number input-text"
                                       autocomplete="off"
                                       maxlength="17" value=""/>
                            </div>
                            <br>
                            <div class="hintmsg"><em>Sending a test SMS will be deducted from your SMS credits</em>
                            </div>
                        </div>

                        <button name="sms_campaign_test_submit"
                                class="btn btn-outline-secondary btn-submit hidden-xs uppercase duplicate sms_campaign_test_submit"
                                id="sms_campaign_test_submit" type="button" value="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                senderAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the sender field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                numberAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the test phone number field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                messageAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please fill the message field','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                successAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Test SMS message has been sent successfully','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                                failAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Test SMS message has not been sent successfully','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                        </button>
                        <span class="toolTip"
                              title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' The phone number should be in this form: 0033663309741 for this France mobile 06 63 30 97 41 (0033 is France prefix)','mod'=>'sendinblue'),$_smarty_tpl ) );?>
">&nbsp;</span>
                    </div>
                </div><!-- /.form-wrapper -->
            </div>
        </form>
        <div>
            <button type="submit" value="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Update','mod'=>'sendinblue'),$_smarty_tpl ) );?>
" id="customer_form_submit_btn"
                    name="submitAddcustomer"
                    class="btn btn-default pull-right sms_campaign_update"
                    successAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Settings updated','mod'=>'sendinblue'),$_smarty_tpl ) );?>
"
                    failAlert="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Update failed','mod'=>'sendinblue'),$_smarty_tpl ) );?>
">
                <i class="process-icon-save"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Update','mod'=>'sendinblue'),$_smarty_tpl ) );?>

            </button>
        </div>

    </div>

</div>
<?php }
}
