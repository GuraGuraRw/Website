<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

class ZOneThemeManagerGetFinalDateMiniatureModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $specific_prices_to = Tools::getValue('specific-prices-to', false);
        $templateFile = 'module:zonethememanager/views/templates/front/price_countdown_miniature.tpl';
        $tpl = $this->context->smarty->createTemplate($templateFile, $this->context->smarty);
        $results = array();

        if ($specific_prices_to) {
            $products_times = json_decode($specific_prices_to);
            foreach ($products_times as $id_product => $time) {
                $tpl->assign(array(
                    'finalDate' => (strtotime($time) * 1000),
                ));
                
                $results[$id_product] = $tpl->fetch();
            }
        }
        
        $this->ajaxDie(json_encode($results));
    }
}
