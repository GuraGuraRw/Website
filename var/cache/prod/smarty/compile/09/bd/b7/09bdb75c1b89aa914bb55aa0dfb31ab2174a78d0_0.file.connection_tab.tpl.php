<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:50:11
  from '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/connection_tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be9d3bbe271_61864817',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09bdb75c1b89aa914bb55aa0dfb31ab2174a78d0' => 
    array (
      0 => '/home/xbxgxbq/www/modules/sendinblue/views/templates/admin/connection_tab.tpl',
      1 => 1737217526,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be9d3bbe271_61864817 (Smarty_Internal_Template $_smarty_tpl) {
?><div role="tabpanel" class="form-contenttab tab-pane active" id="step1">
  <div class="row">
    <div class="col-md-12">


      <div class="panel" id="about-sendinblue">
        <div class="form-box">
          <img src="../modules/sendinblue/views/img/sendinblue.png?v1"/>
          <h2 class="heading">
          </h2>
          <div class="form-box-content">
            <div class="contact-box">
              <h2 style="color:#044A75;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Contact Brevo Team','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</h2>
              <div style="clear: both;"></div>
              <p>
                <a href="https://addons.prestashop.com/en/contact-us?id_product=8300"
                   target="_blank"
                   style="color:#044A75;"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Click here','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</a>
              </p>
              <p style="padding-top:20px;">
                <b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'For further informations, please visit our website:','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</b><br/><a
                        href="https://www.brevo.com?utm_source=prestashop_plugin&utm_medium=plugin&utm_campaign=module_link"
                        target="_blank"
                        style="color:#044A75;">https://www.brevo.com</a></p>
            </div>
            <p class="sub-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'With Brevo, you can build and grow relationships with your contacts and customers. ','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</p>
            <ul class="listt">
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Automatically sync your Prestashop opt-in contacts with your Brevo Account','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Easily create engaging, mobile-friendly emails','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Schedule email and text message campaigns','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Manage transactional emails with better deliverability, custom templates, and real-time analytics','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            </ul>
            <p class="sub-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Why use Brevo ?','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</p>
            <ul class="listt">
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Reach the inbox with optimized deliverability','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Unbeatable pricing - the best value in email marketing','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
              <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Friendly customer support by phone and email','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading"><i class="icon-cogs" style="margin-right: 10px"></i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Integration','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</div>
        <p class="sub-heading"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Before making connection, remember these points:','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</p>
        <div class="col-md-12">
          <ul class="listt">
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Internet service should be available and shop should be publicly accessible from the browser. (without login credentials)','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Check that URL rewriting is available on your server, as it’s required by Prestashop’s webservice.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Please whitelist the following Brevo domain: https://plugin.brevo.com/integrations/api/.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Please whitelist all the IPs comprised in the range from 185.107.232.0/24 and 1.179.112.0/20.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Local development environment will not connected.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Shop should be secure with SSL.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Please clear shop cache.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</li>
          </ul>
        </div>
        <p><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Note:','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' For the above points, contact your hosting provider or developer.','mod'=>'sendinblue'),$_smarty_tpl ) );?>
</p>
        <div class="form-wrapper row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="form-group">
              <a href="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['connection_url']->value,'htmlall','UTF-8' ));?>
" target="_blank" class="btn btn-success btn-block">
                <?php if (call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['userConnectionId']->value,'htmlall','UTF-8' ))) {?>
                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Settings','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                <?php } else { ?>
                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Connect','mod'=>'sendinblue'),$_smarty_tpl ) );?>

                <?php }?>
              </a>
            </div>
          </div>
          <div class="col-md-4"></div>

        </div>
      </div>

    </div>
  </div>
</div>
<?php }
}
