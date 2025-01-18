{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}

{if $page_name != 'password-infos'}
  {block name='footer_before'}
    <div class="footer-top clearfix">
      {block name='hook_footer_before'}
        <div class="container">
          {hook h='displayFooterBefore'}
        </div>
      {/block}
    </div>
  {/block}

  {block name='footer_main'}
    <div class="footer-main clearfix">
      <div class="container">
        <div class="row main-main">
          {block name='hook_footer_left'}
            <div class="footer-left col-sm-12 col-md-6 col-lg-4">
              {hook h='displayFooterLeft'}
            </div>
          {/block}
          {block name='hook_footer_right'}
            <div class="footer-right col-sm-12 col-md-6 col-lg-8">
              {hook h='displayFooterRight'}
            </div>
          {/block}
        </div>

        {block name='hook_footer'}
          <div class="row hook-display-footer">
            {hook h='displayFooter'}
          </div>
        {/block}
      </div>
    </div>
  {/block}

  {block name='footer_after'}
    <div class="footer-bottom clearfix">
      {block name='hook_footer_after'}
        <div class="container">
          {hook h='displayFooterAfter'}
        </div>
      {/block}
    </div>
  {/block}
{/if}
