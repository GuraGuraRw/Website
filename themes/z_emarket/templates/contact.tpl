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
{extends file='page.tpl'}

{block name='page_title'}
  {l s='Contact us' d='Shop.Theme.Global'}
{/block}

{block name='left_column'}
  {if $layout == 'layouts/layout-left-column.tpl'}
    <div id="left-column" class="sidebar-column col-12 col-md-4 col-lg-3">
      <div class="column-wrapper">
        {widget name="ps_contactinfo" hook='displayLeftColumn'}
        {hook h='displayContactLeftColumn'}
      </div>
    </div>
  {/if}
{/block}

{block name="right_column"}
  {if $layout == 'layouts/layout-right-column.tpl'}
    <div id="right-column" class="sidebar-column col-12 col-md-4 col-lg-3">
      <div class="column-wrapper">
        {widget name="ps_contactinfo" hook='displayRightColumn'}
        {hook h='displayContactRightColumn'}
      </div>
    </div>
  {/if}
{/block}

{block name='page_content'}
  {widget name="contactform"}
  {hook h='displayContactContent'}
{/block}
