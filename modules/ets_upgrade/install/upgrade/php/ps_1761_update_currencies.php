<?php
/**
  * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

//use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Localization\CLDR\LocaleRepository;

/**
 * On PrestaShop 1.7.6.0, two new columns have been introduced in the PREFIX_currency table: precision & numeric_iso_code
 * A fresh install would add the proper data in these columns, however an upgraded shop to 1.7.6.0 would not get the
 * corresponding values of each currency.
 *
 * This upgrade script will cover this need by loading the CLDR data and update the currency if it still has the default table values.
 */
function ps_1761_update_currencies()
{
    // Force cache reset of languages (load locale column)
    ObjectModel::disableCache();

    /** @var Currency[] $currencies */
    $currencies = Currency::getCurrencies(true, false);
    $context = Context::getContext();
    $container = isset($context->controller) ? $context->controller->getContainer() : null;
    if (null === $container) {
        $container = call_user_func(array('PrestaShop\\PrestaShop\\Adapter\\SymfonyContainer', 'getInstance'));
    }

    /** @var LocaleRepository $localeRepoCLDR */
    $localeRepoCLDR = $container->get('prestashop.core.localization.cldr.locale_repository');
    // CLDR locale give us the CLDR reference specification
    $cldrLocale = $localeRepoCLDR->getLocale($context->language->getLocale());

    foreach ($currencies as $currency) {
        if ((int)$currency->precision !== 6 || !empty((int)$currency->numeric_iso_code)) {
            continue;
        }
        // CLDR currency gives data from CLDR reference, for the given language
        $cldrCurrency = $cldrLocale->getCurrency($currency->iso_code);
        if (!empty($cldrCurrency)) {
            $numeric_iso_code = $cldrCurrency->getNumericIsoCode();
            if (Tools::strlen($numeric_iso_code) < 2) {
                $numeric_iso_code = '0' . $numeric_iso_code;
            }
            $currency->precision = (int)$cldrCurrency->getDecimalDigits();
            $currency->numeric_iso_code = $numeric_iso_code;
        }
        //$currency->save();
        Db::getInstance()->execute(
            'UPDATE `' . _DB_PREFIX_ . 'currency`
            SET `precision` = ' . $currency->precision . ', `numeric_iso_code` = ' . $currency->numeric_iso_code . '
            WHERE `id_currency` = ' . $currency->id
        );
    }

    ObjectModel::enableCache();


}
