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
              <i>
                <svg viewBox="0 0 24 24">
                  <path fill="#fff" d="M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20Z"></path>
                </svg>
              </i>
              <p>{$error}</p>
            </li>
          {/foreach}
        </ul>
      {/if}

      <p class="send-renew-password-link alert alert-info">{l s='To forgot is human. What is your email address? We will send you a link within a few minutes to set a new password!' d='Shop.Theme.Customeraccount'}</p>

      <section class="form-fields">
        <div class="form-group center-email-fields row">
          <label class="col-lg-3 form-control-label required">{l s='Email address' d='Shop.Forms.Labels'}</label>
          <div class="col-lg-6 email">
            <input type="email" name="email" id="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes}{/if}" class="form-control" required>
          </div>
        </div>
      </section>

      <div class="form-footer row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 text-center">
          <button id="send-reset-link" class="form-control-submit btn btn-primary" name="submit" type="submit">
            {l s='Send reset link' d='Shop.Theme.Actions'}
          </button>
        </div>
      </div>
    </form>
  </div>
{/block}

{block name='page_footer'}
  <ul class="box-bg">
    <li>
      <a id="back-to-login" href="{$urls.pages.my_account}" class="account-link">
        <i class="material-icons">chevron_left</i>
        <span>{l s='Back to Login' d='Shop.Theme.Actions'}</span>
      </a>
    </li>
  </ul>
{/block}
