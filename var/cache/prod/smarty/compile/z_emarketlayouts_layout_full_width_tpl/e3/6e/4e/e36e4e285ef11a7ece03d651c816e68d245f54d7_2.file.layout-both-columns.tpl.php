<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:01
  from '/home/xbxgxbq/www/themes/z_emarket/templates/layouts/layout-both-columns.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be771317b72_16208926',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e36e4e285ef11a7ece03d651c816e68d245f54d7' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/layouts/layout-both-columns.tpl',
      1 => 1734380495,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_partials/helpers.tpl' => 1,
    'file:_partials/head.tpl' => 1,
    'file:_partials/st-menu-left.tpl' => 1,
    'file:catalog/_partials/product-activation.tpl' => 1,
    'file:_partials/header.tpl' => 1,
    'file:_partials/breadcrumb.tpl' => 1,
    'file:_partials/notifications.tpl' => 1,
    'file:_partials/footer.tpl' => 1,
    'file:_partials/st-menu-right.tpl' => 1,
    'file:_partials/modal-message.tpl' => 1,
    'file:_partials/password-policy-template.tpl' => 1,
    'file:_partials/javascript.tpl' => 1,
  ),
),false)) {
function content_678be771317b72_16208926 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_292047530678be7712ffb57_12124023', 'helpers');
?>


<!doctype html>
<html lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['locale'], ENT_QUOTES, 'UTF-8');?>
">
  <head>
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_671679096678be771301675_79885999', 'head');
?>

  </head>

  <body id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page']->value['page_name'], ENT_QUOTES, 'UTF-8');?>
"
    class="st-wrapper <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'classnames' ][ 0 ], array( $_smarty_tpl->tpl_vars['page']->value['body_classes'] )), ENT_QUOTES, 'UTF-8');?>

    <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['body_classes'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['body_classes'], ENT_QUOTES, 'UTF-8');
}?>
    <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['progress_bar'])) {?>pace-running<?php }?>"
  >
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1228510181678be771304e59_06511326', 'hook_after_body_opening_tag');
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_615844870678be771305a27_97310992', 'st_menu_left');
?>


    <main id="page" class="st-pusher <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['boxed_layout'])) {?>boxed-layout<?php }?>">

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_215562454678be771307418_17259657', 'product_activation');
?>


      <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] != 'authentication') {?>
        <header id="header">
          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1044376881678be7713086d5_05880840', 'header');
?>

        </header>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1818275082678be771309248_76668538', 'breadcrumb');
?>

      <?php }?>

      <section id="wrapper">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1034985153678be771309f16_06624777', 'notifications');
?>


        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayWrapperTop"),$_smarty_tpl ) );?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_539224304678be77130af91_09475001', 'top_content');
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1659045410678be77130b5f1_97066797', 'main_content');
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_365302298678be77130fa06_91423697', 'bottom-content');
?>


        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayWrapperBottom"),$_smarty_tpl ) );?>


      </section>

      <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] != 'authentication') {?>
        <footer id="footer" class="js-footer">
          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2062101383678be771311948_16819068', "footer");
?>

        </footer>
      <?php }?>

    </main>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_858827525678be771312853_08407090', 'hook_outside_main_page');
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_229581049678be771313388_43915237', 'st_menu_right');
?>


    <?php $_smarty_tpl->_subTemplateRender("file:_partials/modal-message.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="st-overlay" data-close-st-menu data-close-st-cart></div>

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_744648266678be771314687_18964345', 'external_html');
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1738660582678be771314cf9_47281250', 'javascript_bottom');
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1194918562678be7713166a7_80392051', 'hook_before_body_closing_tag');
?>


  </body>
</html>
<?php }
/* {block 'helpers'} */
class Block_292047530678be7712ffb57_12124023 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'helpers' => 
  array (
    0 => 'Block_292047530678be7712ffb57_12124023',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php $_smarty_tpl->_subTemplateRender('file:_partials/helpers.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
/* {/block 'helpers'} */
/* {block 'head'} */
class Block_671679096678be771301675_79885999 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_671679096678be771301675_79885999',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php $_smarty_tpl->_subTemplateRender('file:_partials/head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <?php
}
}
/* {/block 'head'} */
/* {block 'hook_after_body_opening_tag'} */
class Block_1228510181678be771304e59_06511326 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_after_body_opening_tag' => 
  array (
    0 => 'Block_1228510181678be771304e59_06511326',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAfterBodyOpeningTag'),$_smarty_tpl ) );?>

    <?php
}
}
/* {/block 'hook_after_body_opening_tag'} */
/* {block 'st_menu_left'} */
class Block_615844870678be771305a27_97310992 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'st_menu_left' => 
  array (
    0 => 'Block_615844870678be771305a27_97310992',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php $_smarty_tpl->_subTemplateRender("file:_partials/st-menu-left.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <?php
}
}
/* {/block 'st_menu_left'} */
/* {block 'product_activation'} */
class Block_215562454678be771307418_17259657 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_activation' => 
  array (
    0 => 'Block_215562454678be771307418_17259657',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php $_smarty_tpl->_subTemplateRender('file:catalog/_partials/product-activation.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php
}
}
/* {/block 'product_activation'} */
/* {block 'header'} */
class Block_1044376881678be7713086d5_05880840 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header' => 
  array (
    0 => 'Block_1044376881678be7713086d5_05880840',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php $_smarty_tpl->_subTemplateRender('file:_partials/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php
}
}
/* {/block 'header'} */
/* {block 'breadcrumb'} */
class Block_1818275082678be771309248_76668538 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'breadcrumb' => 
  array (
    0 => 'Block_1818275082678be771309248_76668538',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php $_smarty_tpl->_subTemplateRender('file:_partials/breadcrumb.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php
}
}
/* {/block 'breadcrumb'} */
/* {block 'notifications'} */
class Block_1034985153678be771309f16_06624777 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'notifications' => 
  array (
    0 => 'Block_1034985153678be771309f16_06624777',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php $_smarty_tpl->_subTemplateRender('file:_partials/notifications.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <?php
}
}
/* {/block 'notifications'} */
/* {block 'top_content'} */
class Block_539224304678be77130af91_09475001 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'top_content' => 
  array (
    0 => 'Block_539224304678be77130af91_09475001',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'top_content'} */
/* {block 'left_column'} */
class Block_2130125667678be77130c5d2_69455248 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                  <div id="left-column" class="sidebar-column col-12 col-md-4 col-lg-3">
                    <div class="column-wrapper">
                      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayLeftColumn"),$_smarty_tpl ) );?>

                    </div>
                  </div>
                <?php
}
}
/* {/block 'left_column'} */
/* {block 'content'} */
class Block_1627744094678be77130db96_32997370 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                        <p>Hello! This is ZONE theme layout.</p>
                      <?php
}
}
/* {/block 'content'} */
/* {block 'content_wrapper'} */
class Block_1022742549678be77130d221_69016434 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                  <div id="content-wrapper" class="js-content-wrapper center-column col-12 col-md-8 col-lg-9">
                    <div class="center-wrapper">
                      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayContentWrapperTop"),$_smarty_tpl ) );?>


                      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1627744094678be77130db96_32997370', 'content', $this->tplIndex);
?>


                      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayContentWrapperBottom"),$_smarty_tpl ) );?>

                    </div>
                  </div>
                <?php
}
}
/* {/block 'content_wrapper'} */
/* {block 'right_column'} */
class Block_1132370752678be77130ea71_43894089 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                  <div id="right-column" class="sidebar-column col-12 col-md-4 col-lg-3">
                    <div class="column-wrapper">
                      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayRightColumn"),$_smarty_tpl ) );?>

                    </div>
                  </div>
                <?php
}
}
/* {/block 'right_column'} */
/* {block 'main_content'} */
class Block_1659045410678be77130b5f1_97066797 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'main_content' => 
  array (
    0 => 'Block_1659045410678be77130b5f1_97066797',
  ),
  'left_column' => 
  array (
    0 => 'Block_2130125667678be77130c5d2_69455248',
  ),
  'content_wrapper' => 
  array (
    0 => 'Block_1022742549678be77130d221_69016434',
  ),
  'content' => 
  array (
    0 => 'Block_1627744094678be77130db96_32997370',
  ),
  'right_column' => 
  array (
    0 => 'Block_1132370752678be77130ea71_43894089',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <div class="main-content">
            <div class="container">
              <div class="row <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['is_mobile'])) {?>mobile-main-content<?php }?>">

                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2130125667678be77130c5d2_69455248', 'left_column', $this->tplIndex);
?>


                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1022742549678be77130d221_69016434', 'content_wrapper', $this->tplIndex);
?>


                <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1132370752678be77130ea71_43894089', 'right_column', $this->tplIndex);
?>


              </div>
            </div>
          </div>
        <?php
}
}
/* {/block 'main_content'} */
/* {block 'bottom-content'} */
class Block_365302298678be77130fa06_91423697 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'bottom-content' => 
  array (
    0 => 'Block_365302298678be77130fa06_91423697',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'bottom-content'} */
/* {block "footer"} */
class Block_2062101383678be771311948_16819068 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'footer' => 
  array (
    0 => 'Block_2062101383678be771311948_16819068',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php $_smarty_tpl->_subTemplateRender("file:_partials/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
          <?php
}
}
/* {/block "footer"} */
/* {block 'hook_outside_main_page'} */
class Block_858827525678be771312853_08407090 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_outside_main_page' => 
  array (
    0 => 'Block_858827525678be771312853_08407090',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayOutsideMainPage'),$_smarty_tpl ) );?>

    <?php
}
}
/* {/block 'hook_outside_main_page'} */
/* {block 'st_menu_right'} */
class Block_229581049678be771313388_43915237 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'st_menu_right' => 
  array (
    0 => 'Block_229581049678be771313388_43915237',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php $_smarty_tpl->_subTemplateRender("file:_partials/st-menu-right.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <?php
}
}
/* {/block 'st_menu_right'} */
/* {block 'external_html'} */
class Block_744648266678be771314687_18964345 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'external_html' => 
  array (
    0 => 'Block_744648266678be771314687_18964345',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'external_html'} */
/* {block 'javascript_bottom'} */
class Block_1738660582678be771314cf9_47281250 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'javascript_bottom' => 
  array (
    0 => 'Block_1738660582678be771314cf9_47281250',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php $_smarty_tpl->_subTemplateRender("file:_partials/password-policy-template.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
      <?php $_smarty_tpl->_subTemplateRender("file:_partials/javascript.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('javascript'=>$_smarty_tpl->tpl_vars['javascript']->value['bottom']), 0, false);
?>
    <?php
}
}
/* {/block 'javascript_bottom'} */
/* {block 'hook_before_body_closing_tag'} */
class Block_1194918562678be7713166a7_80392051 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_before_body_closing_tag' => 
  array (
    0 => 'Block_1194918562678be7713166a7_80392051',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayBeforeBodyClosingTag'),$_smarty_tpl ) );?>

    <?php
}
}
/* {/block 'hook_before_body_closing_tag'} */
}
