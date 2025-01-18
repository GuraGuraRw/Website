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

{block name='helpers'}
  {include file='_partials/helpers.tpl'}
{/block}

<!doctype html>
<html lang="{$language.locale}">
  <head>
    {block name='head'}
      {include file='_partials/head.tpl'}
    {/block}
  </head>

  <body id="{$page.page_name}"
    class="st-wrapper {$page.body_classes|classnames}
    {if !empty($modules.zonethememanager.body_classes)}{$modules.zonethememanager.body_classes}{/if}
    {if !empty($modules.zonethememanager.progress_bar)}pace-running{/if}"
  >
    {block name='hook_after_body_opening_tag'}
      {hook h='displayAfterBodyOpeningTag'}
    {/block}

    {block name='st_menu_left'}
      {include file="_partials/st-menu-left.tpl"}
    {/block}

    <main id="page" class="st-pusher {if !empty($modules.zonethememanager.boxed_layout)}boxed-layout{/if}">

      {block name='product_activation'}
        {include file='catalog/_partials/product-activation.tpl'}
      {/block}

      {if $page.page_name != 'authentication'}
        <header id="header">
          {block name='header'}
            {include file='_partials/header.tpl'}
          {/block}
        </header>

        {block name='breadcrumb'}
          {include file='_partials/breadcrumb.tpl'}
        {/block}
      {/if}

      <section id="wrapper">
        {block name='notifications'}
          {include file='_partials/notifications.tpl'}
        {/block}

        {hook h="displayWrapperTop"}

        {block name='top_content'}{/block}

        {block name='main_content'}
          <div class="main-content">
            <div class="container">
              <div class="row {if !empty($modules.zonethememanager.is_mobile)}mobile-main-content{/if}">

                {block name='left_column'}
                  <div id="left-column" class="sidebar-column col-12 col-md-4 col-lg-3">
                    <div class="column-wrapper">
                      {hook h="displayLeftColumn"}
                    </div>
                  </div>
                {/block}

                {block name='content_wrapper'}
                  <div id="content-wrapper" class="js-content-wrapper center-column col-12 col-md-8 col-lg-9">
                    <div class="center-wrapper">
                      {hook h="displayContentWrapperTop"}

                      {block name='content'}
                        <p>Hello! This is ZONE theme layout.</p>
                      {/block}

                      {hook h="displayContentWrapperBottom"}
                    </div>
                  </div>
                {/block}

                {block name='right_column'}
                  <div id="right-column" class="sidebar-column col-12 col-md-4 col-lg-3">
                    <div class="column-wrapper">
                      {hook h="displayRightColumn"}
                    </div>
                  </div>
                {/block}

              </div>
            </div>
          </div>
        {/block}

        {block name='bottom-content'}{/block}

        {hook h="displayWrapperBottom"}

      </section>

      {if $page.page_name != 'authentication'}
        <footer id="footer" class="js-footer">
          {block name="footer"}
            {include file="_partials/footer.tpl"}
          {/block}
        </footer>
      {/if}

    </main>

    {block name='hook_outside_main_page'}
      {hook h='displayOutsideMainPage'}
    {/block}

    {block name='st_menu_right'}
      {include file="_partials/st-menu-right.tpl"}
    {/block}

    {include file="_partials/modal-message.tpl"}

    <div class="st-overlay" data-close-st-menu data-close-st-cart></div>

    {block name='external_html'}{/block}

    {block name='javascript_bottom'}
      {include file="_partials/password-policy-template.tpl"}
      {include file="_partials/javascript.tpl" javascript=$javascript.bottom}
    {/block}

    {block name='hook_before_body_closing_tag'}
      {hook h='displayBeforeBodyClosingTag'}
    {/block}

  </body>
</html>
