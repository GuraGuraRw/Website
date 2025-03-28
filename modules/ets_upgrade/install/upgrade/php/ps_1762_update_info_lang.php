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

function ps_1762_update_info_lang()
{
    if (Db::getInstance()->executeS('SHOW TABLES LIKE \'' . _DB_PREFIX_ . 'info_lang\'') && Db::getInstance()->executeS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'info_lang` LIKE \'id_shop\'')) {
        Db::getInstance()->execute('
            INSERT INTO `' . _DB_PREFIX_ . 'info_lang` SELECT
            `entity`.`id_info`, 1, `entity`.`id_lang`, `entity`.`text`
            FROM `' . _DB_PREFIX_ . 'info_lang` entity
            LEFT JOIN `' . _DB_PREFIX_ . 'info_lang` entity2 ON `entity2`.`id_shop` = 1 AND `entity`.`id_info` = `entity2`.`id_info`
            WHERE `entity2`.`id_shop` IS NULL;
        ');
    }
}