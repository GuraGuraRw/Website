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
{block name='address_selector_blocks'}
  <div class="row">
    {foreach $addresses as $address}
      <div class="col-12 col-md-6">
        <article
          class="js-address-item address-item light-box-bg{if $address.id == $selected} selected{/if}"
          id="{$name|classname}-address-{$address.id}"
        >
          <div class="address-header">
            <label class="custom-radio">
              <span class="check-wrap">
                <input
                  type="radio"
                  name="{$name}"
                  value="{$address.id}"
                  {if $address.id == $selected}checked{/if}
                >
                <span class="check-shape"><i class="material-icons check-icon">check</i></span>
              </span>
              <div>
                <p class="address-alias h5">{$address.alias}</p>
                <div class="address">{$address.formatted nofilter}</div>
              </div>
            </label>
          </div>
          <div class="address-footer">
            {if $interactive}
              <a
                class="edit-address"
                data-link-action="edit-address"
                href="{url entity='order' params=['id_address' => $address.id, 'editAddress' => $type, 'token' => $token]}"
              >
                <i class="material-icons edit">edit</i> {l s='Edit' d='Shop.Theme.Actions'}
              </a>
              <a
                class="delete-address"
                data-link-action="delete-address"
                href="{url entity='order' params=['id_address' => $address.id, 'deleteAddress' => true, 'token' => $token]}"
              >
                <i class="material-icons delete">delete</i> {l s='Delete' d='Shop.Theme.Actions'}
              </a>
            {/if}
          </div>
        </article>
      </div>
    {/foreach}
  </div>

  {if $interactive}
    <p class="w-100 d-none">
      <button class="form-control-submit btn btn-primary" type="submit">{l s='Save' d='Shop.Theme.Actions'}</button>
    </p>
  {/if}
{/block}
