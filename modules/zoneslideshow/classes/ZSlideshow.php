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

class ZSlideshow extends ObjectModel
{
    public $id;
    public $id_zslideshow;
    public $id_shop;
    public $active = 1;
    public $active_mobile = 1;
    public $position;
    public $image;
    public $image_name;
    public $title;
    public $slide_link;
    public $caption;
    public $related_products;

    public static $definition = array(
        'table' => 'zslideshow',
        'primary' => 'id_zslideshow',
        'multilang' => true,
        'multilang_shop' => false,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'active_mobile' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'position' => array('type' => self::TYPE_INT),
            'image' => array('type' => self::TYPE_STRING, 'size' => 100, 'validate' => 'isCleanHtml'),
            'related_products' => array('type' => self::TYPE_STRING, 'size' => 100),
            'title' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 254),
            'image_name' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 100),
            'slide_link' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrlOrEmpty', 'size' => 254),
            'caption' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isAnything'),
        ),
    );

    public function __construct($id_zslideshow = null, $id_lang = null)
    {
        parent::__construct($id_zslideshow, $id_lang);

        if (!$this->id_shop) {
            $this->id_shop = Context::getContext()->shop->id;
        }

        if ($this->related_products) {
            $this->related_products = Tools::unSerialize($this->related_products);
        }

        if (!$this->position) {
            $this->position = 1 + $this->getMaxPosition();
        }
    }

    public function save($null_values = false, $autodate = true)
    {
        if ($this->related_products) {
            $this->related_products = serialize($this->related_products);
        }

        return (int) $this->id > 0 ? $this->update($null_values) : $this->add($autodate, $null_values);
    }

    public static function getList($id_lang = null, $active = false, $active_mobile = false)
    {
        $id_lang = is_null($id_lang) ? Context::getContext()->language->id : (int) $id_lang;
        $id_shop = Context::getContext()->shop->id;

        $query = 'SELECT *
            FROM `'._DB_PREFIX_.'zslideshow` s
            LEFT JOIN `'._DB_PREFIX_.'zslideshow_lang` sl ON s.`id_zslideshow` = sl.`id_zslideshow`
            WHERE s.`id_shop` = '.(int) $id_shop.'
            AND `id_lang` = '.(int) $id_lang.'
            '.($active ? 'AND `active` = 1' : '').'
            '.($active_mobile ? 'AND `active_mobile` = 1' : '').'
            GROUP BY s.`id_zslideshow`
            ORDER BY s.`position` ASC';

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);

        if ($result) {
            foreach ($result as &$row) {
                $row['related_products'] = Tools::unSerialize($row['related_products']);
            }
        }

        return $result;
    }

    public static function getMaxPosition()
    {
        $id_shop = Context::getContext()->shop->id;
        $query = 'SELECT MAX(s.`position`)
            FROM `'._DB_PREFIX_.'zslideshow` s
            WHERE s.`id_shop` = '.(int) $id_shop;

        return (int) Db::getInstance()->getValue($query);
    }

    public static function updatePosition($id_zslideshow, $position)
    {
        $query = 'UPDATE `'._DB_PREFIX_.'zslideshow`
			SET `position` = '.(int) $position.'
			WHERE `id_zslideshow` = '.(int) $id_zslideshow;

        Db::getInstance()->execute($query);
    }

    public function getProductsAutocompleteInfo($id_lang = null)
    {
        if (!$id_lang) {
            $id_lang = Context::getContext()->language->id;
        }

        $products = array();

        if (!empty($this->related_products)) {
            $implode_product_id = implode(',', array_map('intval', $this->related_products));
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

    public static function getProductsByArrayId($array_product_id = null, $id_lang = null, $limit = 2)
    {
        if (empty($array_product_id)) {
            return false;
        }
        $context = Context::getContext();
        if (!$id_lang) {
            $id_lang = $context->language->id;
        }
        $implode_product_id = implode(',', array_map('intval', $array_product_id));

        $sql = new DbQuery();
        $sql->select(
            'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
            pl.`description`, pl.`description_short`, pl.`link_rewrite`,
            pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
            image_shop.`id_image` id_image, il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
            DATEDIFF(
                product_shop.`date_add`,
                DATE_SUB(
                    "' . date('Y-m-d') . ' 00:00:00",
                    INTERVAL ' . (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) . ' DAY
                )
            ) > 0 AS new'
        );

        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->leftJoin('product_lang', 'pl', 'p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int) $id_lang.Shop::addSqlRestrictionOnLang('pl'));
        $sql->leftJoin('image', 'i', 'i.`id_product` = p.`id_product`');
        $sql->join(Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1'));
        $sql->leftJoin('image_lang', 'il', 'i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int) $id_lang);
        $sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');
        $sql->leftJoin('category_lang', 'cl', 'product_shop.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int) $id_lang.Shop::addSqlRestrictionOnLang('cl'));

        $sql->where('p.`id_product` IN ('.pSQL($implode_product_id).')');
        $sql->where('product_shop.`active` = 1 AND product_shop.`visibility` IN ("both", "catalog")');
        $sql->limit((int) $limit);

        $sql->orderBy('FIELD(p.`id_product`, '.pSQL($implode_product_id).')');
        $sql->groupBy('product_shop.id_product');

        if (Combination::isFeatureActive()) {
            $sql->select('product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, IFNULL(product_attribute_shop.id_product_attribute, 0) id_product_attribute');
            $sql->leftJoin('product_attribute_shop', 'product_attribute_shop', 'p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop=' . (int) $context->shop->id);
        }

        $sql->join(Product::sqlStock('p', 0));

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        return Product::getProductsProperties((int) $id_lang, $result);
    }
}
