{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
{extends file='page.tpl'}

{block name='page_content'}
  <!-- Add the Gura logo -->
  <div class="logo-container text-center">
    <img src="{$urls.theme_assets}/img/Gura%20Logo-01.png" alt="Gura Logo" class="gura-logo">
  </div>

  <div class="shadow-box p-4">
    <!-- Add the title inside the box -->
    <h1 class="box-title text-center">{l s='Forgot your password?' d='Shop.Theme.Customeraccount'}</h1>

    <form action="{$urls.pages.password}" class="forgotten-password" method="post">
      {if isset($errors) && $errors}
        <ul class="ps-alert-error">
          {foreach $errors as $error}
            <li class="item">
              <p>{$error}</p>
            </li>
          {/foreach}
        </ul>
      {/if}

      <p class="send-renew-password-link alert alert-info">{l s='Enter your email to receive a password reset link.' d='Shop.Theme.Customeraccount'}</p>

      <div class="form-group">
        <label for="email">{l s='Email address' d='Shop.Forms.Labels'}</label>
        <input type="email" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape}{/if}" required>
      </div>

      <div class="form-footer">
        <button type="submit" name="submit" class="btn btn-primary">{l s='Send reset link' d='Shop.Theme.Actions'}</button>
      </div>
    </form>
  </div>
{/block}
