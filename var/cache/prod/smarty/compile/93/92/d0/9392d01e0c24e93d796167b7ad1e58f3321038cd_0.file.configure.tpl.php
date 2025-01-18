<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:50:11
  from '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/configure.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be9d3b97028_68792343',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9392d01e0c24e93d796167b7ad1e58f3321038cd' => 
    array (
      0 => '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/configure.tpl',
      1 => 1737217526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./connection_tab.tpl' => 1,
    'file:./sms_notification_panel.tpl' => 1,
    'file:./sib_sms_order_confirmation_tab.tpl' => 1,
    'file:./sib_sms_shipment_tab.tpl' => 1,
    'file:./sib_sms_campaign_tab.tpl' => 1,
  ),
),false)) {
function content_678be9d3b97028_68792343 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="content" class="content-div bootstrap sib-content" style="padding-top: 20px !important;">
  <div class="row justify-content-md-center">
    <div id="" class="col-md-12">
      <div id="" class="col-md-10">
        <div class="tabs js-tabs">
          <ul class="nav nav-tabs js-nav-tabs" id="form-nav" role="tablist" style="width: 781.172px;">
            <li id="tab_step1" class="nav-item active">
              <a href="#step1" role="tab" data-toggle="tab" class="nav-link active"
                 aria-selected="true" style=""><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Home','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</a></li>
            <li id="tab_step3" class="nav-item">
              <a href="#sib_sms" role="tab" data-toggle="tab" class="nav-link"
                      <?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['apiKeyV3']->value,'htmlall','UTF-8' ))) {?>
                        style="display:block"
                      <?php } else { ?>
                        style="display:none"
                      <?php }?>
                 aria-selected="false"> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'SMS','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</a></li>
          </ul>

        </div>
        <div id="form_content" class="tab-content">

          <?php $_smarty_tpl->_subTemplateRender('file:./connection_tab.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


          <div role="tabpanel" class="form-contenttab tab-pane" id="sib_sms">
            <div class="row">
              <div class="col-md-12">

                <div class="form-box panel">
                  <div class="form-box-content">
                    <table width="100%" cellspacing="0" cellpadding="0" class="tableblock">
                      <tbody>

                      <tr>
                        <td class="row1" style="border:none; padding-top:10px;">
                          <?php $_smarty_tpl->_subTemplateRender('file:./sms_notification_panel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                        </td>
                      </tr>
                      <tr>
                        <td>

                          <div class="panel">
                            <!-- Tab nav -->
                            <ul class="nav nav-tabs" id="tabOrder">
                              <li class="active">
                                <a href="#sib_sms_order_confirmation_tab" style="">
                                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Order confirmation','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                                </a>
                              </li>
                              <li class="">
                                <a href="#sib_sms_shipment_tab" style="outline-width: 0px !important; user-select: auto !important;">
                                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Shipping confirmation','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                                </a>
                              </li>
                              <li class="">
                                <a href="#sib_sms_campaign_tab" style="outline-width: 0px !important; user-select: auto !important;">
                                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Campaign','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                                </a>
                              </li>
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content panel">

                              <div class="tab-pane active" id="sib_sms_order_confirmation_tab">
                                <?php $_smarty_tpl->_subTemplateRender("file:./sib_sms_order_confirmation_tab.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'test','links'=>array()), 0, false);
?>
                              </div>
                              <!-- Tab documents -->
                              <div class="tab-pane" id="sib_sms_shipment_tab">
                                <?php $_smarty_tpl->_subTemplateRender("file:./sib_sms_shipment_tab.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                              </div>

                              <div class="tab-pane" id="sib_sms_campaign_tab">
                                <?php $_smarty_tpl->_subTemplateRender("file:./sib_sms_campaign_tab.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                              </div>
                            </div>
                          </div>

                        </td>
                      </tr>
                      </tbody>
                    </table>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>
<?php }
}
