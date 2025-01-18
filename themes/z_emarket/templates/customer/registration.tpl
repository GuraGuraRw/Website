{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
{extends file='page.tpl'}

{block name='page_content'}
  <!-- Center wrapper for logo and form -->
  <div class="center-wrapper">
    <!-- Add the Gura logo -->
    <div class="logo-container">
      <img src="{$urls.theme_assets}/img/Gura%20Logo-01.png" alt="Gura Logo" class="gura-logo">
    </div>

    <!-- Shadow box for form -->
    <div class="shadow-box">
      <!-- Move the title here -->
      <h1 class="form-title">{l s='Create an Account' d='Shop.Theme.Customeraccount'}</h1>
 
      {block name='register_form_container'}
        {$hook_create_account_top nofilter}
        <section class="register-form">
          {render file='customer/_partials/customer-form.tpl' ui=$register_form}
        </section>
      {/block}
    </div>
  </div>
{/block}

{block name='page_footer'}
  <div class="text-center">
    <a class="btn btn-secondary btn-wrap" href="{$urls.pages.authentication}">
      {l s='Already have an account?' d='Shop.Theme.Customeraccount'} 
      {l s='Log in instead!' d='Shop.Theme.Customeraccount'}
    </a>
  </div>
{/block}
