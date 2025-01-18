<?php
/* Smarty version 3.1.43, created on 2025-01-18 18:40:00
  from 'module:productcommentsviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_678be770833198_16400668',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '86a3fbdbbaf4c17b3f3d70f925fe6312d03f2c1c' => 
    array (
      0 => 'module:productcommentsviewstempl',
      1 => 1716929805,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678be770833198_16400668 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="product-comment-list-item" data-product-comment-id="@COMMENT_ID@" data-product-id="@PRODUCT_ID@">
  <div class="comment-infos">
    <div class="grade-stars small-stars" data-grade="@COMMENT_GRADE@"></div>
    <div class="comment-date small">
      @COMMENT_DATE@
    </div>
    <div class="comment-author text-info">
      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'By %1$s','sprintf'=>array('@CUSTOMER_NAME@'),'d'=>'Modules.Productcomments.Shop'),$_smarty_tpl ) );?>

    </div>
  </div>

  <div class="comment-content">
    <p class="h5">@COMMENT_TITLE@</p>
    <p>@COMMENT_COMMENT@</p>
    <ul class="comment-buttons">
      <?php if ($_smarty_tpl->tpl_vars['usefulness_enabled']->value) {?>
        <li><a class="useful-review" href="#like">
          <i class="material-icons thumb_up">thumb_up</i> <span class="useful-review-value">@COMMENT_USEFUL_ADVICES@</span>
        </a></li>
        <li><a class="not-useful-review" href="#dislike">
          <i class="material-icons thumb_down">thumb_down</i> <span class="not-useful-review-value">@COMMENT_NOT_USEFUL_ADVICES@</span>
        </a></li>
      <?php }?>
      <li><a class="report-abuse" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Report abuse','d'=>'Modules.Productcomments.Shop'),$_smarty_tpl ) );?>
" href="#report">
        <i class="material-icons outlined_flag">flag</i>
      </a></li>
    </ul>
  </div>
</div>
<?php }
}
