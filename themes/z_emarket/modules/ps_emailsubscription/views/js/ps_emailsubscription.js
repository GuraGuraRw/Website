/**
 * 2007-2020 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
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
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
$(document).ready(function () {
    $('.js-emailsubscription .js-subscription-form').on('submit', function () {
        if (typeof psemailsubscription_subscription === 'undefined') {
            return true;
        }

        var $form = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: psemailsubscription_subscription,
            cache: false,
            data: $(this).serialize(),
            success: function (data) {
                let msg_html = '<p class="alert alert-success">' + data.msg + '</p>';
                if (data.nw_error) {
                    msg_html = '<p class="alert alert-danger">' + data.msg + '</p>';
                }
                $form.find('.newsletter-message').fadeOut(400, function () {
                    $(this).html(msg_html).fadeIn();
                });
            },
            error: function (err) {
                console.log(err);
            }
        });
        
        return false;
    });
});
