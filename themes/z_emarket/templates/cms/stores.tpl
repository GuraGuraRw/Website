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
  {l s='Our stores' d='Shop.Theme.Global'}
{/block}

{block name='page_content_container'}

  <section id="content" class="page-content page-stores">

    {foreach $stores as $store}
      <article id="store-{$store.id}" class="store-item box-bg">
        <div class="row align-items-center">
          <div class="col-12 col-lg-3 store-picture">
            <img
              src="{$store.image.bySize.stores_default.url}"
              alt="{$store.image.legend|default: $store.name}"
              title="{$store.image.legend|default: $store.name}"
              class="img-fluid"
            >
          </div>
          <div class="col-12 col-lg-6 store-description">
            <h4>{$store.name}</h4>
            <address>{$store.address.formatted nofilter}</address>
            {if $store.note}<p><strong>{$store.note}</strong></p>{/if}
            {if $store.phone || $store.fax || $store.email}
              <ul class="store-contact-info">
                {if $store.phone}<li><i class="material-icons">phone</i>{$store.phone}</li>{/if}
                {if $store.fax}<li><i class="material-icons">print</i>{$store.fax}</li>{/if}
                {if $store.email}<li><i class="material-icons">mail</i>{$store.email}</li>{/if}
              </ul>
            {/if}
          </div>
          <div class="col-12 col-lg-3 store-working-hours">
            <table>
              {foreach $store.business_hours as $day}
              <tr>
                <th>{$day.day|truncate:4:'.'}</th>
                <td>
                  <ul>
                  {foreach $day.hours as $h}
                    <li>{$h}</li>
                  {/foreach}
                  </ul>
                </td>
              </tr>
              {/foreach}
            </table>
          </div>
        </div>
      </article>
    {/foreach}

  </section>
{/block}
