{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0
 *}

{extends file='page.tpl'}

{block name='page_content'}
  <div class="login-container">
    <!-- Logo Above the Form -->
    <div class="logo-container">
      <img src="{$urls.theme_assets}/img/Gura%20Logo-01.png" alt="Gura Logo" class="gura-logo">
    </div>

    <!-- Sign In Form -->
    <div class="sign-in-form">
      {render file='customer/_partials/login-form.tpl' ui=$login_form}

      <!-- No Account Link (Moved Inside the White Box) -->
      <div class="no-account">
        <a href="{$urls.pages.register}" data-link-action="display-register-form">
          Don’t have an account? <strong>Sign up</strong>
        </a>
      </div>
    </div>
  </div>
{/block}
