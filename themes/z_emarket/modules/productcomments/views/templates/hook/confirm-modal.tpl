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

{assign var='icon' value=$icon|default:'check_circle'}
{assign var='modal_message' value=$modal_message|default:''}

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    const confirmModal = $('#{$modal_id}');
    confirmModal.on('hidden.bs.modal', function () {
      confirmModal.modal('hide');
      confirmModal.trigger('modal:confirm', false);
    });

    $('.confirm-button', confirmModal).on('click', function() {
      confirmModal.trigger('modal:confirm', true);
    });
    $('.refuse-button', confirmModal).on('click', function() {
      confirmModal.trigger('modal:confirm', false);
    });
  });
</script>

<div id="{$modal_id}" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="mb-0 h4">
          <i class="material-icons {$icon}">{$icon}</i> <span>{$modal_title}</span>
        </p>
      </div>
      <div class="modal-body text-center">
        <label class="modal-message" id="{$modal_id}-message">
          {$modal_message}
        </label>
        <div class="post-comment-buttons">
          <button type="button" class="btn btn-small btn-secondary refuse-button mx-2" data-bs-dismiss="modal" aria-label="{l s='No' d='Modules.Productcomments.Shop'}">
            {l s='No' d='Modules.Productcomments.Shop'}
          </button>
          <button type="button" class="btn btn-small btn-primary confirm-button mx-2" data-bs-dismiss="modal" aria-label="{l s='Yes' d='Modules.Productcomments.Shop'}">
            {l s='Yes' d='Modules.Productcomments.Shop'}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
