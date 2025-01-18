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

<div id="aone-popup-newsletter-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-hidepopup-time="{$cookie_time|intval}">
  <div class="modal-dialog" role="document" style="max-width: {$width + 16}px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="aone-popupnewsletter" style="min-height:{$height|intval}px;">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i class="material-icons">close</i>
          </button>

          <div class="popup-background" style="background-color:{$bg_color}; background-image:url('{$bg_image}');"></div>
          <div class="popup-content">
            <div class="clearfix newsletter-content">
              {$content nofilter}
            </div>
            <div class="ps-email-subscription-module js-popupemailsubscription">
              {$subscribe_form nofilter}
            </div>
          </div>
          <div class="noshow">
            <a href="#no-thanks" class="js-newsletter-nothanks" rel="nofollow"><i class="fa fa-minus-circle"></i>{l s='Do not show this popup again.' d='Shop.Zonetheme'}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
