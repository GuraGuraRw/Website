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

class ZPopupNewsletter extends ObjectModel
{
    public $id;
    public $id_zpopupnewsletter;
    public $id_shop;
    public $active = 1;
    public $width = 670;
    public $height = 500;
    public $bg_color = '#b3dad3';
    public $bg_image;
    public $cookie_time = 0;
    public $save_time = 0;
    public $content;
    public $subscribe_form = 1;

    public static $definition = array(
        'table' => 'zpopupnewsletter',
        'primary' => 'id_zpopupnewsletter',
        'multilang' => true,
        'multilang_shop' => false,
        'fields' => array(
            'id_shop' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'width' => array('type' => self::TYPE_INT),
            'height' => array('type' => self::TYPE_INT),
            'bg_color' => array('type' => self::TYPE_STRING, 'size' => 50, 'validate' => 'isCleanHtml'),
            'bg_image' => array('type' => self::TYPE_STRING, 'size' => 100, 'validate' => 'isCleanHtml'),
            'cookie_time' => array('type' => self::TYPE_INT),
            'save_time' => array('type' => self::TYPE_INT, 'validate' => 'isAnything'),
            'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isAnything'),
            'subscribe_form' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
        ),
    );

    public function __construct($id_zpopupnewsletter = null, $id_lang = null)
    {
        parent::__construct($id_zpopupnewsletter, $id_lang);

        if (!$this->id_shop) {
            $this->id_shop = Context::getContext()->shop->id;
        }
    }

    public static function getSaveTimeByShop($id_lang = null)
    {
        $id_shop = Context::getContext()->shop->id;

        $query = 'SELECT `save_time`
            FROM `'._DB_PREFIX_.'zpopupnewsletter`
            WHERE `id_shop` = '.(int) $id_shop.' AND `active` = 1';

        return Db::getInstance()->getValue($query);
    }

    public static function getNewsletterByShop($id_lang = null)
    {
        $id_shop = Context::getContext()->shop->id;

        $query = 'SELECT id_zpopupnewsletter
            FROM `'._DB_PREFIX_.'zpopupnewsletter` n
            WHERE n.`id_shop` = '.(int) $id_shop;

        $id_zpopupnewsletter = (int) Db::getInstance()->getValue($query);

        if ($id_zpopupnewsletter) {
            return new self($id_zpopupnewsletter, $id_lang);
        } else {
            return new self();
        }
    }
}
