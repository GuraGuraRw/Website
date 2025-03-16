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

function set_stock_available()
{
    $res = true;

    if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && count(Shop::getShops(false, null, true)) !== 1) {
        //Get all products with positive quantity
        $resource = Db::getInstance()->query('
            SELECT quantity, id_product, out_of_stock
            FROM `' . _DB_PREFIX_ . 'product`
            WHERE `active` = 1
        ');

        while ($row = Db::getInstance()->nextRow($resource)) {
            $quantity = 0;

            //Try to get product attribues
            $attributes = Db::getInstance()->executeS('
                SELECT quantity, id_product_attribute
                FROM `' . _DB_PREFIX_ . 'product_attribute`
                WHERE `id_product` = ' . (int)$row['id_product']
            );

            //Add each attribute to stock_available
            foreach ($attributes as $attribute) {
                // add to global quantity
                $quantity += $attribute['quantity'];

                //add stock available for attributes
                $res &= Db::getInstance()->execute('
                    INSERT INTO `' . _DB_PREFIX_ . 'stock_available`
                    (`id_product`, `id_product_attribute`, `id_shop`, `id_shop_group`, `quantity`, `depends_on_stock`, `out_of_stock`)
                    VALUES
                    ("' . (int)$row['id_product'] . '", "' . (int)$attribute['id_product_attribute'] . '", "1", "0", "' . (int)$attribute['quantity'] . '", "0", "' . (int)$row['out_of_stock'] . '")
                ');
                if (!$res) {
                    return array('error' => Db::getInstance()->getNumberError(), 'msg' => '(attributes)' . Db::getInstance()->getMsgError());
                }
            }

            if (count($attributes) == 0) {
                $quantity = (int)$row['quantity'];
            }

            //Add stock available for product;
            $res &= Db::getInstance()->execute('
                INSERT INTO `' . _DB_PREFIX_ . 'stock_available`
                (`id_product`, `id_product_attribute`, `id_shop`, `id_shop_group`, `quantity`, `depends_on_stock`, `out_of_stock`)
                VALUES
                ("' . (int)$row['id_product'] . '", "0", "1", "0", "' . (int)$quantity . '", "0", "' . (int)$row['out_of_stock'] . '")
            ');
            if (!$res) {
                return array('error' => Db::getInstance()->getNumberError(), 'msg' => '(products)' . Db::getInstance()->getMsgError());
            }
        }
    } else {
        $resource = Db::getInstance()->query('
             SELECT * FROM `' . _DB_PREFIX_ . 'stock_available` 
             WHERE id_shop_group = 1;
        ');
        $sql = null;
        $subQuery = 'UPDATE `' . _DB_PREFIX_ . 'stock_available` SET id_shop_group=0 WHERE ';
        while ($row = Db::getInstance()->nextRow($resource)) {
            if (!Db::getInstance()->getValue('
                    SELECT id_stock_available FROM `' . _DB_PREFIX_ . 'stock_available` 
                    WHERE id_product=' . (int)$row['id_product'] . ' 
                        AND id_product_attribute=' . (int)$row['id_product_attribute'] . ' 
                        AND id_shop=' . (int)$row['id_shop'] . '
                        AND id_shop_group=0
                ')) {
                $sql .= $subQuery . 'id_product=' . (int)$row['id_product'] . ' AND id_product_attribute=' . (int)$row['id_product_attribute'] . ' AND id_shop=' . (int)$row['id_shop'] . ';';
            }
        }
        if (null !== $sql) {
            $res = Db::getInstance()->execute($sql);
        }
    }

    return $res;
}
