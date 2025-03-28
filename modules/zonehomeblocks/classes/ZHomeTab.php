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

class ZHomeTab extends ObjectModel
{
    public $id;
    public $id_zhometab;
    public $id_zhomeblock;
    public $title;
    public $active = 1;
    public $active_mobile = 1;
    public $position;
    public $block_type;
    public $product_filter;
    public $product_options;
    public $static_html;

    public static $definition = array(
        'table' => 'zhometab',
        'primary' => 'id_zhometab',
        'multilang' => true,
        'multilang_shop' => false,
        'fields' => array(
            'id_zhomeblock' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'active_mobile' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'position' => array('type' => self::TYPE_INT),
            'block_type' => array('type' => self::TYPE_STRING, 'size' => 128),
            'product_options' => array('type' => self::TYPE_STRING),
            'product_filter' => array('type' => self::TYPE_STRING, 'size' => 128),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName',
            'required' => true, 'size' => 254),
            'static_html' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isAnything'),
        ),
    );

    public function __construct($id_zhomeblock, $id_zhometab = null, $id_lang = null)
    {
        parent::__construct($id_zhometab, $id_lang);

        if ($id_zhomeblock) {
            $this->id_zhomeblock = $id_zhomeblock;
        }

        $this->product_options = $this->initProductOptions($this->product_options);

        if (!$this->position) {
            $this->position = 1 + $this->getMaxPosition();
        }
    }

    public function save($null_values = false, $autodate = true)
    {
        $this->product_options = serialize($this->product_options);

        return (int) $this->id > 0 ? $this->update($null_values) : $this->add($autodate, $null_values);
    }

    public static function initProductOptions($str)
    {
        $options = Tools::unSerialize($str);
        if (!$options) {
            $options = array();
        }
        $default_options = array(
            'limit' => 10,
            'mobile_limit' => 10,
            'enable_slider' => 0,
            'mobile_enable_slider' => 0,
            'auto_scroll' => 0,
            'number_column' => 5,
            'sort_order' => 'product.position.asc',
        );

        return array_merge($default_options, $options);
    }

    public static function getList($id_zhomeblock, $id_lang = null, $active = false, $active_mobile = false)
    {
        $id_lang = is_null($id_lang) ? Context::getContext()->language->id : $id_lang;

        $query = 'SELECT *
            FROM `'._DB_PREFIX_.'zhometab` b
            LEFT JOIN `'._DB_PREFIX_.'zhometab_lang` bl ON b.`id_zhometab` = bl.`id_zhometab`
            WHERE b.`id_zhomeblock` = '.(int) $id_zhomeblock.'
            AND `id_lang` = '.(int) $id_lang.'
            '.($active ? 'AND `active` = 1' : '').'
            '.($active_mobile ? 'AND `active_mobile` = 1' : '').'
            GROUP BY b.`id_zhometab`
            ORDER BY b.`position` ASC';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        return $result;
    }

    public function getMaxPosition()
    {
        $query = 'SELECT MAX(b.`position`)
            FROM `'._DB_PREFIX_.'zhometab` b
            WHERE b.`id_zhomeblock` = '.(int) $this->id_zhomeblock;

        return (int) Db::getInstance()->getValue($query);
    }

    public static function updatePosition($id_zhometab, $position)
    {
        $query = 'UPDATE `'._DB_PREFIX_.'zhometab`
            SET `position` = '.(int) $position.'
            WHERE `id_zhometab` = '.(int) $id_zhometab;

        Db::getInstance()->execute($query);
    }

    public function getProductsAutocompleteInfo($id_lang = null)
    {
        $id_lang = is_null($id_lang) ? Context::getContext()->language->id : $id_lang;

        $products = array();

        if (!empty($this->product_options['selected_products'])) {
            $implode_product_id = implode(',', array_map('intval', $this->product_options['selected_products']));
            $query = 'SELECT p.`id_product`, p.`reference`, pl.name
                FROM `'._DB_PREFIX_.'product` p
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = p.`id_product` AND pl.`id_lang` = '.(int) $id_lang.')
                '.Shop::addSqlRestrictionOnLang('pl').'
                WHERE p.`id_product` IN ('.pSQL($implode_product_id).')
                ORDER BY FIELD(p.`id_product`, '.pSQL($implode_product_id).')';

            $rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

            foreach ($rows as $row) {
                $products[$row['id_product']] = trim($row['name']).(!empty($row['reference']) ? ' (ref: '.$row['reference'].')' : '');
            }
        }

        return $products;
    }
}
