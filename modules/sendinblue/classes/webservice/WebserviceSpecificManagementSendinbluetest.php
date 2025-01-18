<?php
/**
 * 2007-2025 Sendinblue
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@sendinblue.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    Sendinblue <contact@sendinblue.com>
 * @copyright 2007-2025 Sendinblue
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of Sendinblue
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class WebserviceSpecificManagementSendinbluetest extends WebserviceSpecificManagementSendinblueAbstract
{
    public function manage()
    {
        $sendinblueModule = Module::getInstanceByName('sendinblue');

        $shopId = Context::getContext()->shop->id;
        $defaultCurrencyId = Configuration::get('PS_CURRENCY_DEFAULT', null, null, $shopId);
        $currency = new Currency($defaultCurrencyId);

        $this->response = [
            self::SUCCESS => true,
            self::PLUGIN_VERSION => $sendinblueModule->version,
            self::SHOP_VERSION => _PS_VERSION_,
            self::SHOP_CURRENCY => $currency->iso_code,
        ];
    }
}
