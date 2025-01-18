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

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

include_once dirname(__FILE__).'/classes/ZSlideshow.php';

class ZOneSlideshow extends Module
{
    protected $slide_img_folder = 'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'slideImages'.DIRECTORY_SEPARATOR;
    protected $slide_thumb_folder = 'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'slideImages'.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR;
    protected $slide_mobile_folder = 'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'slideImages'.DIRECTORY_SEPARATOR.'mobiles'.DIRECTORY_SEPARATOR;
    protected $html = '';
    protected $currentIndex;
    protected $nivo_effects = array(
        array('id' => 'random', 'name' => 'random', 'val' => 1),
        array('id' => 'sliceDown', 'name' => 'sliceDown', 'val' => 1),
        array('id' => 'sliceDownLeft', 'name' => 'sliceDownLeft', 'val' => 1),
        array('id' => 'sliceUp', 'name' => 'sliceUp', 'val' => 1),
        array('id' => 'sliceUpLeft', 'name' => 'sliceUpLeft', 'val' => 1),
        array('id' => 'sliceUpDown', 'name' => 'sliceUpDown', 'val' => 1),
        array('id' => 'sliceUpDownLeft', 'name' => 'sliceUpDownLeft', 'val' => 1),
        array('id' => 'fold', 'name' => 'fold', 'val' => 1),
        array('id' => 'fade', 'name' => 'fade', 'val' => 1),
        array('id' => 'slideInRight', 'name' => 'slideInRight', 'val' => 1),
        array('id' => 'slideInLeft', 'name' => 'slideInLeft', 'val' => 1),
        array('id' => 'boxRandom', 'name' => 'boxRandom', 'val' => 1),
        array('id' => 'boxRain', 'name' => 'boxRain', 'val' => 1),
        array('id' => 'boxRainReverse', 'name' => 'boxRainReverse', 'val' => 1),
        array('id' => 'boxRainGrow', 'name' => 'boxRainGrow', 'val' => 1),
        array('id' => 'boxRainGrowReverse', 'name' => 'boxRainGrowReverse', 'val' => 1),
    );
    protected $nivoSettings = array(
        'layout' => 'wide',
        'caption_effect' => 'opacity',
        'disable_slider' => false,
        'mobile_disable_slider' => false,
        'slices' => 15,
        'boxCols' => 8,
        'boxRows' => 4,
        'animSpeed' => 500,
        'pauseTime' => 5000,
        'startSlide' => 0,
        'directionNav' => true,
        'controlNav' => true,
        'controlNavThumbs' => false,
        'pauseOnHover' => true,
        'manualAdvance' => false,
        'randomStart' => false,
        'effect' => array('random'),
    );
    protected $is_mobile;

    public function __construct()
    {
        $this->name = 'zoneslideshow';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ZelaTheme';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Z.One - Nivo Slideshow');
        $this->description = $this->l('Add a jQuery Nivo slideshow on the homepage.');

        $this->is_mobile = ($this->context->isMobile()  && !$this->context->isTablet());

        $this->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    }

    private function installSampleXML()
    {
        $languages = Language::getLanguages(false);
        $iso_lang_default = 'en';
        $xml_file = Tools::simplexml_load_file($this->local_path.'sql/sample.xml');

        $language_fields_name = array(
            'title',
            'slide_link',
            'caption',
            'image_name',
        );

        $sql = new DbQuery();
        $sql->select('p.`id_product`');
        $sql->from('product', 'p');
        $sql->join(Shop::addSqlAssociation('product', 'p'));
        $sql->where('product_shop.`active` = 1 AND product_shop.`visibility` IN ("both", "catalog")');
        $sql->orderBy('product_shop.`date_add` DESC');
        $sql->limit(2);
        $sample_products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $zslideshows = array();
        $rows = $xml_file->row;
        foreach ($rows as $row) {
            $slide = new ZSlideshow();
            
            $slide->position = (int) $row->position;
            $slide->active = (int) $row->active;
            $slide->active_mobile = (int) $row->active_mobile;
            $related_products = Tools::unSerialize((string) $row->related_products);
            if ($related_products) {
                for ($x = 0; $x < count($related_products); $x++) {
                    if (isset($sample_products[$x%2])) {
                        $related_products[$x] = $sample_products[$x%2]['id_product'];
                    }
                }
            }
            $slide->related_products = $related_products;

            $language_fields = array();
            foreach ($language_fields_name as $name) {
                $language_fields[$name] = array();
            }
            $xml_lang_fields = $row->lang_fields;
            foreach ($languages as $lang) {
                $iso_code = $lang['iso_code'];
                $id_lang = $lang['id_lang'];
                if (!isset($xml_lang_fields->$iso_code)) {
                    $iso_code = $iso_lang_default;
                }
                $fields = $xml_lang_fields->$iso_code;

                foreach ($language_fields_name as $name) {
                    $language_fields[$name][$id_lang] = str_replace('BASE_URL', $this->context->shop->getBaseURL(true), (string) $fields->$name);
                }
            }
            foreach ($language_fields_name as $name) {
                $slide->$name = $language_fields[$name];
            }
            $slide->image = reset($slide->image_name);

            if ($slide->validateFields(false) && $slide->validateFieldsLang(false)) {
                $zslideshows[] = $slide;
            } else {
                return false;
            }
        }

        foreach ($zslideshows as $slide) {
            $slide->save();
        }

        return true;
    }

    public function install()
    {
        Configuration::updateGlobalValue('ZONESLIDESHOW_SETTINGS', serialize($this->nivoSettings));

        if (!file_exists(dirname(__FILE__).'/sql/install.sql')) {
            return false;
        } elseif (!$sql = Tools::file_get_contents(dirname(__FILE__).'/sql/install.sql')) {
            return false;
        }
        $sql = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $sql);
        $sql = preg_split("/;\s*[\r\n]+/", trim($sql));

        foreach ($sql as $query) {
            if (!Db::getInstance()->execute(trim($query))) {
                return false;
            }
        }

        if (!$this->installSampleXML()) {
            return false;
        }

        return parent::install()
            && $this->registerHook('addproduct')
            && $this->registerHook('updateproduct')
            && $this->registerHook('deleteproduct')
            && $this->registerHook('displayTopColumn')
        ;
    }

    public function uninstall()
    {
        Configuration::deleteByName('ZONESLIDESHOW_SETTINGS');

        $sql = 'DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'zslideshow`,
            `'._DB_PREFIX_.'zslideshow_lang`';

        if (!Db::getInstance()->execute($sql)) {
            return false;
        }

        $this->_clearCache('*');

        return parent::uninstall();
    }

    protected function about()
    {
        $this->smarty->assign(array(
            'doc_url' => $this->_path.'documentation.pdf',
        ));

        return $this->display(__FILE__, 'views/templates/admin/about.tpl');
    }

    public function backOfficeHeader()
    {
        $this->context->controller->addJqueryPlugin('tablednd');
        $this->context->controller->addJS($this->_path.'views/js/position.js');
        $this->context->controller->addJS($this->_path.'views/js/back.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
    }

    public function getContent()
    {
        $this->backOfficeHeader();

        $about = $this->about();

        if (Tools::isSubmit('submitSettings')) {
            $this->processSaveSettings();

            return $this->html.$this->renderSlideshowList().$this->renderSettingsForm().$about;
        } elseif (Tools::isSubmit('savezslideshow')) {
            if ($this->processSaveSlideshow()) {
                return $this->html.$this->renderSlideshowList().$this->renderSettingsForm().$about;
            } else {
                return $this->html.$this->renderSlideshowForm();
            }
        } elseif (Tools::isSubmit('addzslideshow') || Tools::isSubmit('updatezslideshow')) {
            return $this->renderSlideshowForm();
        } elseif (Tools::isSubmit('deletezslideshow')) {
            $zslideshow = new ZSlideshow((int) Tools::getValue('id_zslideshow'));
            $zslideshow->delete();
            $this->_clearCache('*');
            Tools::redirectAdmin($this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'));
        } elseif (Tools::isSubmit('statuszslideshow')) {
            $this->ajaxStatus('active');
        } elseif (Tools::isSubmit('statusmobilezslideshow')) {
            $this->ajaxStatus('active_mobile');
        } elseif (Tools::getValue('updatePositions') == 'zslideshow') {
            $this->ajaxPositions();
        } elseif (Tools::isSubmit('ajaxProductsList')) {
            $this->ajaxProductsList();
        } else {
            return $this->renderSlideshowList().$this->renderSettingsForm().$about;
        }
    }

    protected function ajaxProductsList()
    {
        $query = Tools::getValue('q', false);
        if (!$query || $query == '' || Tools::strlen($query) < 1) {
            die();
        }

        $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, pl.`name`
            FROM `'._DB_PREFIX_.'product` p
            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                ON (pl.id_product = p.id_product
                AND pl.id_lang = '.(int) Context::getContext()->language->id.Shop::addSqlRestrictionOnLang('pl').')
            WHERE (pl.name LIKE \'%'.pSQL($query).'%\'
                OR p.reference LIKE \'%'.pSQL($query).'%\'
                OR p.id_product = '.(int) $query.')
            GROUP BY p.`id_product`';

        $items = Db::getInstance()->executeS($sql);

        if ($items) {
            foreach ($items as $item) {
                $item['name'] = str_replace('|', '-', $item['name']);
                echo trim($item['name']).(!empty($item['reference']) ? ' (ref: '.$item['reference'].')' : '').'|'.(int) $item['id_product']."\n";
            }
        } else {
            json_encode(new stdClass());
        }
    }

    protected function ajaxPositions()
    {
        $positions = Tools::getValue('zslideshow');

        if (empty($positions)) {
            return;
        }

        foreach ($positions as $position => $value) {
            $pos = explode('_', $value);

            if (isset($pos[2])) {
                ZSlideshow::updatePosition($pos[2], $position + 1);
            }
        }

        $this->_clearCache('*');
    }

    protected function ajaxStatus($field = 'active')
    {
        $id_zslideshow = (int)Tools::getValue('id_zslideshow');
        if (!$id_zslideshow) {
            die(json_encode(array(
                'success' => false,
                'error' => true,
                'text' => $this->trans(
                    'Failed to update the status',
                    array(),
                    'Admin.Notifications.Error'
                )
            )));
        } else {
            $zslideshow = new ZSlideshow($id_zslideshow);
            $zslideshow->$field = !(int)$zslideshow->$field;
            if ($zslideshow->save()) {
                $this->_clearCache('*');
                die(json_encode(array(
                    'success' => true,
                    'text' => $this->trans(
                        'The status has been updated successfully',
                        array(),
                        'Admin.Notifications.Success'
                    )
                )));
            } else {
                die(json_encode(array(
                    'success' => false,
                    'error' => true,
                    'text' => $this->trans(
                        'Failed to update the status',
                        array(),
                        'Admin.Notifications.Error'
                    )
                )));
            }
        }
    }

    protected function processSaveSettings()
    {
        $settings = array();
        $settings['layout'] = Tools::getValue('layout');
        $settings['disable_slider'] = Tools::getValue('disable_slider');
        $settings['mobile_disable_slider'] = Tools::getValue('mobile_disable_slider');
        $settings['animSpeed'] = Tools::getValue('animSpeed');
        $settings['pauseTime'] = Tools::getValue('pauseTime');
        $settings['directionNav'] = Tools::getValue('directionNav');
        $settings['controlNav'] = Tools::getValue('controlNav');
        $settings['pauseOnHover'] = Tools::getValue('pauseOnHover');
        $settings['manualAdvance'] = Tools::getValue('manualAdvance');
        $settings['randomStart'] = Tools::getValue('randomStart');

        $effects = array();
        foreach ($this->nivo_effects as $effect) {
            if (Tools::getValue('effect_'.$effect['id'], false)) {
                $effects[] = $effect['id'];
            }
        }
        if (empty($effects)) {
            $effects[] = 'random';
        }
        $settings['effect'] = $effects;

        Configuration::updateGlobalValue('ZONESLIDESHOW_SETTINGS', serialize($settings));

        $this->_clearCache('*');

        $this->html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    protected function processSaveSlideshow()
    {
        $zslideshow = new ZSlideshow();
        $id_zslideshow = (int) Tools::getValue('id_zslideshow');
        if ($id_zslideshow) {
            $zslideshow = new ZSlideshow($id_zslideshow);
        }

        $zslideshow->position = (int) Tools::getValue('position');
        $zslideshow->active = (int) Tools::getValue('active');
        $zslideshow->active_mobile = (int) Tools::getValue('active_mobile');

        $zslideshow->related_products = null;
        if (Tools::getValue('related_products')) {
            $zslideshow->related_products = array_slice(Tools::getValue('related_products'), 0, 2);
        }

        $languages = Language::getLanguages(false);
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $title = array();
        $slide_link = array();
        $caption = array();
        $image_name = $zslideshow->image_name;
        foreach ($languages as $lang) {
            $title[$lang['id_lang']] = Tools::getValue('title_'.$lang['id_lang']);
            if (!$title[$lang['id_lang']]) {
                $title[$lang['id_lang']] = Tools::getValue('title_'.$id_lang_default);
            }
            $slide_link[$lang['id_lang']] = Tools::getValue('slide_link_'.$lang['id_lang']);
            if (!$slide_link[$lang['id_lang']]) {
                $slide_link[$lang['id_lang']] = Tools::getValue('slide_link_'.$id_lang_default);
            }
            $caption[$lang['id_lang']] = Tools::getValue('caption_'.$lang['id_lang']);
            if (!$caption[$lang['id_lang']]) {
                $caption[$lang['id_lang']] = Tools::getValue('caption_'.$id_lang_default);
            }

            $file = false;
            if (isset($_FILES['image_name_'.$lang['id_lang']]) && !empty($_FILES['image_name_'.$lang['id_lang']]['tmp_name'])) {
                $file = $_FILES['image_name_'.$lang['id_lang']];
            }
            if (!$file && !isset($image_name[$lang['id_lang']]) && isset($image_name[$id_lang_default])) {
                $image_name[$lang['id_lang']] = $image_name[$id_lang_default];
            }

            if ($file) {
                if ($error = ImageManager::validateUpload($file, Tools::getMaxUploadSize())) {
                    $this->html .= $this->displayError($error);
                } else {
                    $file_name = strtotime('now').'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
                    if (move_uploaded_file($file['tmp_name'], $this->local_path.$this->slide_img_folder.$file_name)) {
                        $image_name[$lang['id_lang']] = $file_name;
                        $this->generateThumbs($file_name);
                    } else {
                        $this->html .= $this->displayError($this->trans('An error occurred during the image upload process.', array(), 'Admin.Notifications.Error'));
                    }
                }
            }
        }
        $zslideshow->title = $title;
        $zslideshow->slide_link = $slide_link;
        $zslideshow->caption = $caption;
        $zslideshow->image_name = $image_name;
        if (isset($image_name[$id_lang_default])) {
            $zslideshow->image = $image_name[$id_lang_default];
        }
        
        $result = $zslideshow->validateFields(false) && $zslideshow->validateFieldsLang(false);

        if ($result) {
            $zslideshow->save();

            if ($id_zslideshow) {
                $this->html .= $this->displayConfirmation($this->l('Slide has been updated.'));
            } else {
                $this->html .= $this->displayConfirmation($this->l('Slide has been created successfully.'));
            }

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Slide.'));
        }

        return $result;
    }

    private function generateThumbs($image)
    {
        list($tmpWidth, $tmpHeight, $type) = getimagesize($this->local_path.$this->slide_img_folder.$image);

        $thumb_h = 120 * $tmpHeight / $tmpWidth;
        ImageManager::resize(
            $this->local_path.$this->slide_img_folder.$image,
            $this->local_path.$this->slide_thumb_folder.$image,
            120,
            $thumb_h
        );
        $mobile_h = 767 * $tmpHeight / $tmpWidth;
        ImageManager::resize(
            $this->local_path.$this->slide_img_folder.$image,
            $this->local_path.$this->slide_mobile_folder.$image,
            767,
            $mobile_h
        );
    }

    protected function renderSettingsForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getSettingsFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getSettingsForm()));
    }

    protected function getSettingsForm()
    {
        $layout_values = array(
            array(
                'id' => 'layout_wide',
                'value' => 'wide',
                'label' => $this->l('Wide')
            ),
            array(
                'id' => 'layout_boxed',
                'value' => 'boxed',
                'label' => $this->l('Boxed')
            ),
        );

        $effect_options = array(
            'query' => $this->nivo_effects,
            'id' => 'id',
            'name' => 'name',
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Nivo Slider Options'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Slideshow Layout'),
                        'name' => 'layout',
                        'values' => $layout_values,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Disable Slider Effect on Desktop'),
                        'name' => 'disable_slider',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'disable_slider_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'disable_slider_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Disable the Nivo Slider effect and show all images on Desktop'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Disable Slider Effect on Mobile'),
                        'name' => 'mobile_disable_slider',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'mobile_disable_slider_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'mobile_disable_slider_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Disable the Nivo Slider effect and show all images on Mobile device'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'label' => $this->l('Slide Effect'),
                        'name' => 'effect',
                        'values' => $effect_options,
                        'col' => 7,
                    ),  
                    array(
                        'type' => 'text',
                        'label' => $this->l('Animation Speed'),
                        'name' => 'animSpeed',
                        'col' => 2,
                        'hint' => $this->l('Slide transition speed'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Pause Time'),
                        'name' => 'pauseTime',
                        'col' => 2,
                        'hint' => $this->l('How long each slide will show'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Direction Navigation'),
                        'name' => 'directionNav',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'directionNav_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'directionNav_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Next & Prev navigation'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Control Navigation'),
                        'name' => 'controlNav',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'controlNav_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'controlNav_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('1,2,3... navigation'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Pause on Hover'),
                        'name' => 'pauseOnHover',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'pauseOnHover_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'pauseOnHover_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Stop animation while hovering'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Manual Advance'),
                        'name' => 'manualAdvance',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'manualAdvance_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'manualAdvance_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Force manual transitions'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Random Start'),
                        'name' => 'randomStart',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'randomStart_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'randomStart_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'hint' => $this->l('Start on a random slide'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans(
                        'Save',
                        array(),
                        'Admin.Actions'
                    ),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getSettingsFieldsValues()
    {
        $settings = array_merge(
            $this->nivoSettings,
            Tools::unSerialize(Configuration::getGlobalValue('ZONESLIDESHOW_SETTINGS'))
        );

        $fields_value = array(
            'layout' => Tools::getValue('layout', $settings['layout']),
            'disable_slider' => Tools::getValue('disable_slider', $settings['disable_slider']),
            'mobile_disable_slider' => Tools::getValue('mobile_disable_slider', $settings['mobile_disable_slider']),
            'animSpeed' => Tools::getValue('animSpeed', $settings['animSpeed']),
            'pauseTime' => Tools::getValue('pauseTime', $settings['pauseTime']),
            'directionNav' => Tools::getValue('directionNav', $settings['directionNav']),
            'controlNav' => Tools::getValue('controlNav', $settings['controlNav']),
            'pauseOnHover' => Tools::getValue('pauseOnHover', $settings['pauseOnHover']),
            'manualAdvance' => Tools::getValue('manualAdvance', $settings['manualAdvance']),
            'randomStart' => Tools::getValue('randomStart', $settings['randomStart']),
        );

        foreach ($this->nivo_effects as $effect) {
            $effect_id = 'effect_'.$effect['id'];
            $current_value = in_array($effect['id'], $settings['effect']);
            $fields_value[$effect_id] = Tools::getValue($effect_id, $current_value);
        }

        return $fields_value;
    }

    protected function renderSlideshowList()
    {
        $slides = ZSlideshow::getList((int) $this->context->language->id);

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->toolbar_btn['new'] = array(
            'href' => $this->currentIndex.'&addzslideshow&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->trans(
                'Add New',
                array(),
                'Admin.Actions'
            ),
        );
        $helper->simple_header = false;
        $helper->listTotal = count($slides);
        $helper->identifier = 'id_zslideshow';
        $helper->table = 'zslideshow';
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->no_link = true;
        $helper->module = $this;
        $helper->title = $this->l('Slides List');
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = $this->currentIndex;
        $helper->position_identifier = 'zslideshow';
        $helper->position_group_identifier = 0;

        $helper->tpl_vars = array(
            'image_baseurl' => $this->_path.$this->slide_thumb_folder,
        );

        return $helper->generateList($slides, $this->getSlideshowList());
    }

    protected function getSlideshowList()
    {
        $fields_list = array(
            'position' => array(
                'title' => $this->trans(
                    'Position',
                    array(),
                    'Admin.Global'
                ),
                'align' => 'center',
                'orderby' => false,
                'search' => false,
                'class' => 'fixed-width-md',
                'position' => true,
                'type' => 'zposition',
            ),
            'image' => array(
                'title' => $this->l('Image'),
                'align' => 'center',
                'orderby' => false,
                'search' => false,
                'type' => 'zimage',
            ),
            'details' => array(
                'title' => $this->l('Details'),
                'orderby' => false,
                'search' => false,
                'type' => 'zdetails',
            ),
            'active' => array(
                'title' => $this->trans(
                    'Desktop',
                    array(),
                    'Admin.Global'
                ),
                'active' => 'status',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'ajax' => true,
                'orderby' => false,
                'search' => false,
            ),
            'active_mobile' => array(
                'title' => $this->trans(
                    'Mobile',
                    array(),
                    'Admin.Global'
                ),
                'active' => 'statusmobile',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'ajax' => true,
                'orderby' => false,
                'search' => false,
            ),
        );

        return $fields_list;
    }

    protected function renderSlideshowForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'savezslideshow';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getSlideshowFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getSlideshowForm()));
    }

    protected function getSlideshowForm()
    {
        $id_zslideshow = (int) Tools::getValue('id_zslideshow');

        $legent_title = $this->l('Add New Slide');
        if ($id_zslideshow) {
            $legent_title = $this->l('Edit Slide');
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $legent_title,
                    'icon' => 'icon-book',
                ),
                'input' => array(
                    array(
                        'type' => 'hidden',
                        'name' => 'id_zslideshow',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans(
                            'Enable on Desktop',
                            array(),
                            'Admin.Global'
                        ),
                        'name' => 'active',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'active_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'active_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans(
                            'Enable on Mobile',
                            array(),
                            'Admin.Global'
                        ),
                        'name' => 'active_mobile',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_mobile_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'active_mobile_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title'),
                        'name' => 'title',
                        'lang' => true,
                        'required' => true,
                        'col' => 5,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Link'),
                        'name' => 'slide_link',
                        'lang' => true,
                        'col' => 5,
                    ),
                    array(
                        'type' => 'file_lang',
                        'label' => $this->l('Image'),
                        'name' => 'image_name',
                        'desc' => $this->l('Upload a image from your computer.'),
                        'required' => true,
                        'image_folder' => $this->_path.$this->slide_img_folder,
                        'lang' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Caption'),
                        'name' => 'caption',
                        'autoload_rte' => true,
                        'lang' => true,
                        'rows' => 10,
                        'cols' => 100,
                    ),
                    array(
                        'type' => 'product_autocomplete',
                        'label' => $this->trans(
                            'Related Products',
                            array(),
                            'Admin.Global'
                        ),
                        'name' => 'related_products',
                        'ajax_path' => AdminController::$currentIndex.'&configure='.$this->name.'&ajax=1&ajaxProductsList&token='.Tools::getAdminTokenLite('AdminModules'),
                        'desc' => $this->l('You can add up to 2 related products for each slide.'),
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => 'position',
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans(
                        'Save',
                        array(),
                        'Admin.Actions'
                    ),
                ),
                'buttons' => array(
                    array(
                        'href' => $this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Back to Slides List'),
                        'icon' => 'process-icon-back',
                    ),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getSlideshowFormValues()
    {
        $fields_value = array();

        $id_zslideshow = (int) Tools::getValue('id_zslideshow');
        $zslideshow = new ZSlideshow($id_zslideshow);

        $fields_value['id_zslideshow'] = $id_zslideshow;
        $fields_value['active'] = Tools::getValue('active', $zslideshow->active);
        $fields_value['active_mobile'] = Tools::getValue('active_mobile', $zslideshow->active_mobile);
        $fields_value['position'] = Tools::getValue('position', $zslideshow->position);
        $fields_value['image'] = Tools::getValue('image', $zslideshow->image);
        $fields_value['related_products'] = $zslideshow->getProductsAutocompleteInfo($this->context->language->id);

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $default_title = isset($zslideshow->title[$lang['id_lang']]) ? $zslideshow->title[$lang['id_lang']] : '';
            $fields_value['title'][$lang['id_lang']] = Tools::getValue('title_'.(int) $lang['id_lang'], $default_title);
            $default_image_name = isset($zslideshow->image_name[$lang['id_lang']]) ? $zslideshow->image_name[$lang['id_lang']] : '';
            $fields_value['image_name'][$lang['id_lang']] = Tools::getValue('image_name_'.(int) $lang['id_lang'], $default_image_name);
            $default_link = isset($zslideshow->slide_link[$lang['id_lang']]) ? $zslideshow->slide_link[$lang['id_lang']] : '';
            $fields_value['slide_link'][$lang['id_lang']] = Tools::getValue('slide_link_'.(int) $lang['id_lang'], $default_link);
            $default_caption = isset($zslideshow->caption[$lang['id_lang']]) ? $zslideshow->caption[$lang['id_lang']] : '';
            $fields_value['caption'][$lang['id_lang']] = Tools::getValue('caption_'.(int) $lang['id_lang'], $default_caption);
        }

        return $fields_value;
    }

    public function hookAddProduct($params)
    {
        $this->_clearCache('*');
    }

    public function hookUpdateProduct($params)
    {
        $this->_clearCache('*');
    }

    public function hookDeleteProduct($params)
    {
        $this->_clearCache('*');
    }

    protected function getRelatedProducts($array_product_id, $id_lang)
    {
        $products = ZSlideshow::getProductsByArrayId($array_product_id, $id_lang);
        $present_products = array();

        if ($products) {
            $assembler = new ProductAssembler($this->context);

            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever($this->context->link),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );

            foreach ($products as $rawProduct) {
                $present_products[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
                );
            }
        }

        return $present_products;
    }

    protected function preProcess()
    {
        $id_lang = (int) $this->context->language->id;
        $settings = array_merge(
            $this->nivoSettings,
            Tools::unSerialize(Configuration::getGlobalValue('ZONESLIDESHOW_SETTINGS'))
        );
        $slides = ZSlideshow::getList($id_lang, !$this->is_mobile, $this->is_mobile);
        $slideshow = array();
        $img_folder = $this->slide_img_folder;
        if ($this->is_mobile) {
            $img_folder = $this->slide_mobile_folder;
        }

        if ($slides) {
            foreach ($slides as $slide) {
                if (isset($slide['image_name'])) {
                    $slide['image'] = $slide['image_name'];
                }
                if (file_exists($this->local_path.$img_folder.$slide['image'])) {
                    list($tmpWidth, $tmpHeight, $type) = getimagesize($this->local_path.$img_folder.$slide['image']);
                    $slide['image_width'] = $tmpWidth;
                    $slide['image_height'] = $tmpHeight;

                    if ($this->is_mobile) {
                        $slide['related_products'] = false;
                    } else {
                        $slide['related_products'] = $this->getRelatedProducts($slide['related_products'], $id_lang);
                    }

                    $slideshow[] = $slide;
                }
            }
        }

        if ($this->is_mobile) {
            $settings['effect'] = 'fade';
        } else {
            $settings['effect'] = implode(',', $settings['effect']);
        }

        $show_all_images = false;
        if (!$this->is_mobile && isset($settings['disable_slider']) && $settings['disable_slider']) {
            $show_all_images = true;
        }
        if ($this->is_mobile && isset($settings['mobile_disable_slider']) && $settings['mobile_disable_slider']) {
            $show_all_images = true;
        }
        if (count($slideshow) < 2) {
            $show_all_images = true;
        }
        
        $this->smarty->assign(array(
            'aslides' => $slideshow,
            'showAllImages' => $show_all_images,
            'settings' => $settings,
            'image_baseurl' => Tools::getCurrentUrlProtocolPrefix().Tools::getMediaServer($this->_path.$img_folder).$this->_path.$img_folder,
            'thumb_baseurl' => Tools::getCurrentUrlProtocolPrefix().Tools::getMediaServer($this->_path.$this->slide_thumb_folder).$this->_path.$this->slide_thumb_folder,
        ));
    }

    public function hookDisplayHome()
    {
        $templateFile = 'module:zoneslideshow/views/templates/hook/zoneslideshow.tpl';
        $cacheId = $this->name.'|'.'device'.(int) $this->is_mobile;

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $this->preProcess();
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayTopColumn()
    {
        return $this->hookDisplayHome();
    }
}
