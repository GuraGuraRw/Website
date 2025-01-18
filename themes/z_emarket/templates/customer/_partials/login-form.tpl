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
 * @author    PrestaShop SA and Contributors
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
 
{block name='login_form'}
 
  {block name='login_form_errors'}
    {include file='_partials/form-errors.tpl' errors=$errors['']}
  {/block}
 
  <form id="login-form" action="{$urls.pages.authentication}" method="post" class="styled-login-form">
    <!-- Email Field -->
    <div class="form-group">
      <label for="email">Your email</label>
      <input type="text" id="email" name="email" placeholder="Enter your email" required>
    </div>
 
    <!-- Password Field -->
    <div class="form-group">
      <label for="password">Your password</label>
      <input type="password" id="password" name="password" placeholder="Type your password here" required>
    </div>
 
    <!-- Forgot Password Link -->
    <div class="form-group forgot-password">
      <a href="{$urls.pages.password}" class="forgot-link">
        Forgot your password?
      </a>
    </div>
 
    <!-- Continue Button -->
    <div class="form-group">
      <button type="submit" class="btn continue-btn">Continue</button>
    </div>
 
    <!-- Hidden CSRF Token Field -->
    <input type="hidden" name="csrf_token" value="{$csrf_token}">
 
    <!-- Hidden Submit Identifier -->
    <input type="hidden" name="submitLogin" value="1">
  </form>
 
{/block}