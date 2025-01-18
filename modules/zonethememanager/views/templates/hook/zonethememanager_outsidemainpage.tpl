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

{if $cookieMessage}
  <div id="cookieMessage" class="cookie-message js-cookieMessage">
    <div class="cookie-message-wrapper">
      <div class="cookie-message-content">
        {$cookieMessage nofilter}
      </div>
      <a class="cookie-close-button btn js-cookieCloseButton">{l s='Accept' d='Shop.Zonetheme'}</a>
    </div>
  </div>
{/if}

{if $enableScrollTop}
  <div id="scrollTopButton" data-scroll-to-top>
    <a class="scroll-button" href="#scroll-to-top" title="{l s='Back to Top' d='Shop.Zonetheme'}" data-toggle="tooltip" data-placement="top"><i class="fa fa-angle-double-up"></i></a>
  </div>
{/if}
