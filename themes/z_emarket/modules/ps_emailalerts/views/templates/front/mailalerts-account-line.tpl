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

<li class="mail-alert-line d-flex align-items-center">
  <a href="{$mailAlert.link}" class="p-image">
    <img src="{$mailAlert.cover_url}" alt=""/>
  </a>
  <a href="{$mailAlert.link}" class="p-name">
    <strong>{$mailAlert.name}</strong>
    <i class="d-block">{$mailAlert.attributes_small}</i>
  </a>

  <a href="#"
     title="{l s='Remove mail alert' d='Modules.Mailalerts.Shop'}"
     class="js-remove-email-alert p-remove"
     rel="js-id-emailalerts-{$mailAlert.id_product|intval}-{$mailAlert.id_product_attribute|intval}"
     data-url="{url entity='module' name='ps_emailalerts' controller='actions' params=['process' => 'remove']}">
    <i class="material-icons">delete</i>
  </a>
</li>
