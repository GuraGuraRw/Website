{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

<div class="block md-bottom module-product-comments-list">
  <div class="comments-nb title-block">
    <span>{l s='Comments' d='Modules.Productcomments.Shop'} ({$nb_comments})</span>
  </div>

  {include file='module:productcomments/views/templates/hook/empty-product-comment.tpl'}

  <div class="js-parent-comments-list">
    <div id="product-comments-list-header">
      {if $average_grade}
        <div class="product-comments-summary mb-3">
          {include file='module:productcomments/views/templates/hook/average-grade-stars.tpl' grade=$average_grade}
          {if $post_allowed && $nb_comments != 0}
            <button class="btn btn-comment post-product-comment btn-primary">
              <i class="material-icons">edit</i> <span>{l s='Write your review' d='Modules.Productcomments.Shop'}</span>
            </button>
          {/if}
        </div>
      {/if}
    </div>

    {include file='module:productcomments/views/templates/hook/product-comment-item-prototype.tpl' assign="comment_prototype"}
    
    <div class="product-comments-list box-bg py-0">
      <div id="product-comments-list"
           data-list-comments-url="{$list_comments_url nofilter}"
           data-update-comment-usefulness-url="{$update_comment_usefulness_url nofilter}"
           data-report-comment-url="{$report_comment_url nofilter}"
           data-comment-item-prototype="{$comment_prototype|escape:'html'}"
      ></div>
      <div id="product-comments-list-pagination"></div>
    </div>

    <div class="product-comments-list-footer">
      <div id="product-comments-list-footer"></div>
    </div>
    
    <script type="text/javascript">
      var productCommentUpdatePostErrorMessage = '{l|escape:'javascript' s='Sorry, your review appreciation cannot be sent.' d='Modules.Productcomments.Shop'}';
      var productCommentAbuseReportErrorMessage = '{l|escape:'javascript' s='Sorry, your abuse report cannot be sent.' d='Modules.Productcomments.Shop'}';
    </script>

    {* Appreciation post error modal *}
    {include file='module:productcomments/views/templates/hook/alert-modal.tpl'
      modal_id='update-comment-usefulness-post-error'
      modal_title={l s='Your review appreciation cannot be sent' d='Modules.Productcomments.Shop'}
      icon='error'
    }

    {* Confirm report modal *}
    {include file='module:productcomments/views/templates/hook/confirm-modal.tpl'
      modal_id='report-comment-confirmation'
      modal_title={l s='Report comment' d='Modules.Productcomments.Shop'}
      modal_message={l s='Are you sure that you want to report this comment?' d='Modules.Productcomments.Shop'}
      icon='feedback'
    }

    {* Report comment posted modal *}
    {include file='module:productcomments/views/templates/hook/alert-modal.tpl'
      modal_id='report-comment-posted'
      modal_title={l s='Report sent' d='Modules.Productcomments.Shop'}
      modal_message={l s='Your report has been submitted and will be considered by a moderator.' d='Modules.Productcomments.Shop'}
    }

    {* Report abuse error modal *}
    {include file='module:productcomments/views/templates/hook/alert-modal.tpl'
      modal_id='report-comment-post-error'
      modal_title={l s='Your report cannot be sent' d='Modules.Productcomments.Shop'}
      icon='error'
    }
  </div>
</div>
