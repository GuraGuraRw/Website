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
{block name='product_attachments'}
  <section class="product-attachments">
    <div class="row">
    {foreach from=$product.attachments item=attachment}
      <div class="attachment col-12 col-lg-4">
        <div class="box-bg my-2">
          <p class="h5"><a class="li-a" href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}" target="_self">{$attachment.name}</a></p>
          <p class="atta-desc">{$attachment.description}</p>
          <p class="mb-0"><a href="{url entity='attachment' params=['id_attachment' => $attachment.id_attachment]}" target="_self">
            <i class="material-icons">&#xE2C4;</i> {l s='Download' d='Shop.Theme.Actions'} ({$attachment.file_size_formatted})
          </a></p>
        </div>
      </div>
    {/foreach}
    </div>
  </section>
{/block}
