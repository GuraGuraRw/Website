{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0
 *}

{if $page_name != 'password-infos'}
  {if !empty($modules.zonethememanager.is_mobile)}
    <!-- mobile header -->
    <div class="mobile-header-version">
      {block name='header_banner'}
        <div class="header-banner clearfix">
          {hook h='displayBanner'}
        </div>
      {/block}

      {block name='header_nav'}
        <div class="header-nav clearfix">
          <div class="container">
            <div class="header-nav-wrapper">
              <div class="left-nav d-flex">
                {hook h='displayNav1'}
              </div>
              <div class="right-nav d-flex">
                {hook h='displayNav2'}
              </div>
            </div>
          </div>
        </div>
      {/block}

      {block name='main_header'}
        <div class="main-header clearfix">
          <div class="container">
            <div class="header-wrapper">
              {block name='header_logo'}
                <div class="header-logo">
                  {renderLogo}
                </div>
              {/block}

              {block name='header_right'}
                <div class="header-right" {if !empty($modules.zonethememanager.sticky_mobile)}data-mobile-sticky{/if}>
                  <div class="mobile-display-left d-flex">
                    <div class="mobile-menu-icon d-flex align-items-center justify-content-center" data-left-nav-trigger>
                      <i class="material-icons">view_headline</i>
                    </div>
                  </div>
                  <div class="display-top align-items-center d-flex justify-content-end">
                    {hook h='displayTop'}
                  </div>
                  <div class="sticky-background"></div>
                </div>
              {/block}
            </div>
          </div>
        </div>
      {/block}

      {block name='header-bottom'}
        <div class="header-bottom clearfix">
          <div class="header-main-menu">
            <div class="container">
              {hook h='displayNavFullWidth'}
            </div>
          </div>
        </div>
      {/block}
    </div>

  {else}
    <!-- desktop header -->
    <div class="desktop-header-version">
      {block name='header_banner'}
        <div class="header-banner clearfix">
          {hook h='displayBanner'}
        </div>
      {/block}

      {block name='header_nav'}
        <div class="header-nav clearfix">
          <div class="container">
            <div class="header-nav-wrapper d-flex align-items-center justify-content-between">
              <div class="left-nav d-flex align-items-center">
                {hook h='displayNav2'}
                <div class="hotline">
                  <p class="no-margin">{l s='Need Help?' d='Shop.Theme.Actions'} <a title="+001 123 456 789"
                      href="tel:+001123456789">+001 123 456 789</a>
                  </p>
                </div>
              </div>
              <div class="right-nav d-flex">
                {hook h='displayNav1'}
              </div>
            </div>
          </div>
        </div>
      {/block}

      {block name='main_header'}
        <div class="main-header clearfix">
          <div class="container">
            <div class="header-wrapper d-flex align-items-center">
              {block name='header_logo'}
                <div class="header-logo">
                  {renderLogo}
                </div>
              {/block}

              {block name='header_right'}
                <div class="header-right">
                  <div class="display-top align-items-center d-flex flex-wrap flex-lg-nowrap justify-content-end">
                    {hook h='displayTop'}
                  </div>
                </div>
              {/block}
            </div>
          </div>
        </div>
      {/block}

      {block name='header-bottom'}
        <div class="header-bottom clearfix">
          <div class="header-main-menu" id="header-main-menu" {if !empty($modules.zonethememanager.sticky_menu)}data-sticky-menu{/if}>
            <div class="container">
              <div class="header-main-menu-wrapper align-items-center d-flex justify-content-between">
                {if !empty($modules.zonethememanager.sidebar_navigation)}
                  <div class="left-nav-trigger" data-left-nav-trigger>
                    <div class="left-nav-icon d-flex align-items-center justify-content-center">
                      <i class="fa fa-bars" aria-hidden="true"></i>
                      <span>{l s='Shop By Department' d='Shop.Theme.Actions'}</span>
                    </div>
                  </div>
                {/if}
                {hook h='displayNavFullWidth'}
                <div class="header-static-text hidden-sticky">
                  <p class="no-margin">{l s='Spend $120 more and get free shipping!' d='Shop.Theme.Actions'}</p>
                </div>
                <div class="sticky-icon-cart" data-sticky-cart data-sidebar-cart-trigger></div>
              </div>
            </div>
          </div>
        </div>
      {/block}
    </div>
  {/if}
{/if}
