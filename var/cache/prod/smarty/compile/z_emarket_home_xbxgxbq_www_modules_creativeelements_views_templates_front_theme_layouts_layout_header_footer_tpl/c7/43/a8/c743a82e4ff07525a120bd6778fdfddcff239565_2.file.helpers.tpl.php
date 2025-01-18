<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:41:40
  from '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/helpers.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be7d4cbfb34_33769416',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c743a82e4ff07525a120bd6778fdfddcff239565' => 
    array (
      0 => '/home/xbxgxbq/www/themes/z_emarket/templates/_partials/helpers.tpl',
      1 => 1716929806,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be7d4cbfb34_33769416 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'renderLogo' => 
  array (
    'compiled_filepath' => '/home/xbxgxbq/www/var/cache/prod/smarty/compile/z_emarket_home_xbxgxbq_www_modules_creativeelements_views_templates_front_theme_layouts_layout_header_footer_tpl/c7/43/a8/c743a82e4ff07525a120bd6778fdfddcff239565_2.file.helpers.tpl.php',
    'uid' => 'c743a82e4ff07525a120bd6778fdfddcff239565',
    'call_name' => 'smarty_template_function_renderLogo_617009451678be7d4cb0537_16131815',
  ),
));
?> 

<?php }
/* smarty_template_function_renderLogo_617009451678be7d4cb0537_16131815 */
if (!function_exists('smarty_template_function_renderLogo_617009451678be7d4cb0537_16131815')) {
function smarty_template_function_renderLogo_617009451678be7d4cb0537_16131815(Smarty_Internal_Template $_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}
?>

  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['index'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
    <?php if (!empty($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['svg_logo'])) {?>
      <img class="svg-logo" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['svg_logo'], ENT_QUOTES, 'UTF-8');?>
" style="width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['modules']->value['zonethememanager']['svg_width'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
    <?php } elseif (!empty($_smarty_tpl->tpl_vars['shop']->value['logo_details'])) {?>
      <img class="logo" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['src'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
" width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['width'], ENT_QUOTES, 'UTF-8');?>
" height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo_details']['height'], ENT_QUOTES, 'UTF-8');?>
">
    <?php } else { ?>
      <img class="logo" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
    <?php }?>
  </a>
<?php
}}
/*/ smarty_template_function_renderLogo_617009451678be7d4cb0537_16131815 */
}
