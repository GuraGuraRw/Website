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
use PrestaShop\Module\ProductComment\Repository\ProductCommentRepository;

class ZOneThemeManagerCommentGradeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $idProducts = Tools::getValue('idProducts', false);
        $results = array();

        if ($idProducts) {
            $id_products = json_decode($idProducts);
            $productCommentRepository = $this->context->controller->getContainer()->get('product_comment_repository');
            $productsCommentsNb = $productCommentRepository->getCommentsNumberForProducts($id_products, Configuration::get('PRODUCT_COMMENTS_MODERATE'));
            $averageGrade = $productCommentRepository->getAverageGrades($id_products, Configuration::get('PRODUCT_COMMENTS_MODERATE'));

            foreach ($id_products as $id) {
                if ($productsCommentsNb[$id]) {
                    $results[$id] = array(
                        'comments_nb' => $productsCommentsNb[$id],
                        'average_grade' => $averageGrade[$id],
                    );
                }
            }
        }
        
        $this->ajaxRender(json_encode($results));
    }
}
