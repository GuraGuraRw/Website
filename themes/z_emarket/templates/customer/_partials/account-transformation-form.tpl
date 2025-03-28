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
{block name='account_transformation_form'}
  <h4>{l s='Save time on your next order, sign up now' d='Shop.Theme.Checkout'}</h4>
  <ul>
    <li> - {l s='Personalized and secure access' d='Shop.Theme.Customeraccount'}</li>
    <li> - {l s='Fast and easy checkout' d='Shop.Theme.Customeraccount'}</li>
    <li> - {l s='Easier merchandise return' d='Shop.Theme.Customeraccount'}</li>
  </ul>
  <form method="post">
    <div class="form-group col-12 col-lg-6">
      <label class="form-control-label required" for="field-email">
        {l s='Set your password:' d='Shop.Forms.Labels'}
      </label>
      <input type="password" class="form-control" data-validate="isPasswd" required name="password" value="">
    </div>
    <footer class="form-footer">
      <input type="hidden" name="submitTransformGuestToCustomer" value="1">
      <button class="btn btn-primary" type="submit">{l s='Create account' d='Shop.Theme.Actions'}</button>
    </footer>
  </form>
{/block}
