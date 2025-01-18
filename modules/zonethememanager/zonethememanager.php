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

use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;

include_once dirname(__FILE__).'/classes/ZManager.php';

class ZOneThemeManager extends Module
{
    protected $html = '';
    protected $action;
    protected $currentIndex;
    protected $image_folder = 'views/img/front/';
    protected $static_pages;
    protected $zonetheme_version = '2.6.6';

    public function __construct()
    {
        $this->name = 'zonethememanager';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ZelaTheme';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Z.One - Theme Manager');
        $this->description = $this->l('Configure the main elements of ZOne theme.');

        $this->static_pages = array(
            'stores' => $this->trans(
                'Our Stores',
                array(),
                'Shop.Theme.Global'
            ),
            'prices-drop' => $this->trans(
                'Price Drop',
                array(),
                'Shop.Theme.Catalog'
            ),
            'new-products' => $this->trans(
                'New Products',
                array(),
                'Shop.Theme.Catalog'
            ),
            'best-sales' => $this->trans(
                'Best Sales',
                array(),
                'Shop.Theme.Catalog'
            ),
            'contact' => $this->trans(
                'Contact us',
                array(),
                'Shop.Theme.Global'
            ),
            'sitemap' => $this->trans(
                'Sitemap',
                array(),
                'Shop.Theme.Global'
            ),
        );

        $this->action = Tools::getValue('action', 'general');
        $this->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&action='.$this->action;
    }

    private function installSampleXML()
    {
        $languages = Language::getLanguages(false);
        $iso_lang_default = 'en';
        $settings = ZManager::getSettingsByShop();
        $language_fields_name = array(
            'header_top',
            'header_phone',
            'footer_about_us',
            'footer_cms_title',
            'footer_static_links',
            'footer_bottom',
            'cookie_message',
            'checkout_header',
            'checkout_footer',
        );
        $xml_file = Tools::simplexml_load_file($this->local_path.'sql/sample.xml');
        $rows = $xml_file->row;
        $row = $rows[0];

        $settings->general_settings = Tools::unSerialize((string) $row->general_settings);
        $settings->category_settings = Tools::unSerialize((string) $row->category_settings);
        $settings->product_settings = Tools::unSerialize((string) $row->product_settings);
        $settings->checkout_settings = Tools::unSerialize((string) $row->checkout_settings);
        $settings->header_top_bg_color = (string) $row->header_top_bg_color;
        $settings->footer_cms_links = explode(',', (string) $row->footer_cms_links);

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
            $settings->$name = $language_fields[$name];
        }

        if ($settings->validateFields(false) && $settings->validateFieldsLang(false)) {
            $settings->save();
        } else {
            return false;
        }

        // extra
        $img_folder = $this->local_path.'views/img/cms/';
        $cms_folder = _PS_IMG_DIR_.'cms/';
        $cms_imgs = glob($img_folder.'*.{jpg,png}', GLOB_BRACE);
        foreach ($cms_imgs as $img) {
            $file_to_go = str_replace($img_folder, $cms_folder, $img);
            Tools::copy($img, $file_to_go);
        }

        return true;
    }

    public function install()
    {
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

        Configuration::updateGlobalValue('ZONETHEME_VERSION', $this->zonetheme_version);

        return parent::install()
            && $this->registerHook('header')
            && $this->registerHook('displayFooterLeft')
            && $this->registerHook('displayFooterRight')
            && $this->registerHook('displayFooter')
            && $this->registerHook('displayFooterAfter')
            && $this->registerHook('displayBanner')
            && $this->registerHook('displayNav1')
            && $this->registerHook('displaySidebarNavigation')
            && $this->registerHook('displayOutsideMainPage')
            && $this->registerHook('displayProductCombinationsBlock')
            && $this->registerHook('displayCheckoutHeader')
            && $this->registerHook('displayCheckoutFooter')
            && $this->registerHook('actionCategoryAdd')
            && $this->registerHook('actionCategoryUpdate')
            && $this->registerHook('actionCategoryDelete')
            && $this->registerHook('addproduct')
            && $this->registerHook('updateproduct')
            && $this->registerHook('deleteproduct')
            && $this->registerHook('actionAttributeDelete')
            && $this->registerHook('actionAttributeSave')
            && $this->registerHook('actionAttributeGroupDelete')
            && $this->registerHook('actionAttributeGroupSave')
            && $this->registerHook('actionAttributeCombinationDelete')
            && $this->registerHook('actionAttributeCombinationSave')
            && $this->registerHook('actionFrontControllerSetVariables')
        ;
    }

    public function uninstall()
    {
        $sql = 'DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'zthememanager`,
            `'._DB_PREFIX_.'zthememanager_lang`';

        if (!Db::getInstance()->execute($sql)) {
            return false;
        }

        Configuration::deleteByName('ZONETHEME_VERSION');

        $this->_clearCache('*');

        return parent::uninstall();
    }

    private function upgradeThemeVersion()
    {
        $theme_version = Configuration::getGlobalValue('ZONETHEME_VERSION');
        if (!$theme_version) {
            $theme_version = '1.0.0';
        }
        if (version_compare($theme_version, $this->zonetheme_version) == -1) {
            include_once dirname(__FILE__).'/classes/ZUpdateDatabase.php';
            
            $update_db = new ZUpdateDatabase();
            $update_db->updateDatabase();
            Configuration::updateGlobalValue('ZONETHEME_VERSION', $this->zonetheme_version);

            foreach (glob(_PS_CONFIG_DIR_ . 'themes/ZOneTheme/*.json') as $filename) {
                Tools::deleteFile($filename);
            }
        }
    }

    public function getContent()
    {
        $this->upgradeThemeVersion();
        
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
        $this->context->controller->addJS($this->_path.'views/js/back.js');

        if (Tools::isSubmit('submitGeneralSettings')) {
            $this->processSaveGeneralSettings();
        } elseif (Tools::isSubmit('deleteBoxedBackgroundImage')) {
            $this->processDeleteBoxedBackgroundImage();
        } elseif (Tools::isSubmit('deleteSVGLogo')) {
            $this->processDeleteSVGLogo();
        } elseif (Tools::isSubmit('submitHeaderSettings')) {
            $this->processSaveHeaderSettings();
        } elseif (Tools::isSubmit('submitFooterSettings')) {
            $this->processSaveFooterSettings();
        } elseif (Tools::isSubmit('submitCategorySettings')) {
            $this->processSaveCategorySettings();
        } elseif (Tools::isSubmit('submitProductSettings')) {
            $this->processSaveProductSettings();
        } elseif (Tools::isSubmit('submitCheckoutSettings')) {
            $this->processSaveCheckoutSettings();
        }

        $this->smarty->assign(array(
            'alert' => $this->html,
            'action' => Tools::getValue('action', 'general'),
            'panel_href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'doc_url' => $this->_path.'documentation.pdf',
            'settings_form' => $this->renderSettingsForm(),
            'theme_version' => $this->zonetheme_version,
        ));

        return $this->display(__FILE__, 'views/templates/admin/settings_form.tpl');
    }

    protected function clearZoneHomeBlocksCache()
    {
        $module_zonehomeblocks = Module::getInstanceByName('zonehomeblocks');
        $module_zonehomeblocks->_clearCache('*');
    }

    protected function processDeleteBoxedBackgroundImage()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;
        if ($general_settings['boxed_bg_img']) {
            $image_path = $this->local_path.$this->image_folder.$general_settings['boxed_bg_img'];

            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $general_settings['boxed_bg_img'] = false;
            $settings->general_settings = $general_settings;
            $settings->save();
            $this->_clearCache('*');
        }

        Tools::redirectAdmin($this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules').'&conf=7');
    }

    protected function processDeleteSVGLogo()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;
        if ($general_settings['svg_logo']) {
            $image_path = _PS_IMG_DIR_.$general_settings['svg_logo'];

            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $general_settings['svg_logo'] = false;
            $settings->general_settings = $general_settings;
            $settings->save();
            $this->_clearCache('*');
        }

        Tools::redirectAdmin($this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules').'&conf=7');
    }

    protected function processSaveGeneralSettings()
    {
        $settings = ZManager::getSettingsByShop();

        $general_settings = array(
            'layout' => Tools::getValue('layout'),
            'boxed_bg_color' => Tools::getValue('boxed_bg_color', '#bdbdbd'),
            'boxed_bg_img_style' => Tools::getValue('boxed_bg_img_style'),
            'lazy_loading' => (int) Tools::getValue('lazy_loading'),
            'progress_bar' => (int) Tools::getValue('progress_bar'),
        );

        if (isset($_FILES['boxed_bg_img']) && !empty($_FILES['boxed_bg_img']['tmp_name'])) {
            if ($error = ImageManager::validateUpload($_FILES['boxed_bg_img'], Tools::getMaxUploadSize())) {
                $this->html .= $this->displayError($error);
            } else {
                $file_name = $_FILES['boxed_bg_img']['name'];
                if (move_uploaded_file($_FILES['boxed_bg_img']['tmp_name'], $this->local_path.$this->image_folder.$file_name)) {
                    $general_settings['boxed_bg_img'] = $file_name;
                } else {
                    $this->html .= $this->displayError($this->trans('An error occurred during the image upload process.', array(), 'Admin.Notifications.Error'));
                }
            }
        }

        $settings->general_settings = array_merge($settings->general_settings, $general_settings);

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('General Settings has been updated successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveHeaderSettings()
    {
        $settings = ZManager::getSettingsByShop();

        $general_settings = array(
            'svg_width' => (int) Tools::getValue('svg_width'),
            'sticky_menu' => (int) Tools::getValue('sticky_menu'),
            'sticky_mobile' => (int) Tools::getValue('sticky_mobile'),
            'sidebar_cart' => (int) Tools::getValue('sidebar_cart'),
            'sidebar_navigation' => (int) Tools::getValue('sidebar_navigation'),
            'sidebar_categories' => Tools::getValue('sidebar_categories', array()),
            'mobile_menu' => Tools::getValue('mobile_menu'),
        );

        $home_categories = Category::getHomeCategories(Configuration::get('PS_LANG_DEFAULT'), true, false);
        if (count($home_categories) == count($general_settings['sidebar_categories'])) {
            $general_settings['sidebar_categories'] = 'ALL';
        }

        if (isset($_FILES['svg_logo']) && !empty($_FILES['svg_logo']['tmp_name'])) {
            if ($_FILES['svg_logo']['size'] > Tools::getMaxUploadSize()) {
                $this->html .= $this->displayError($this->trans('The uploaded file exceeds the post_max_size directive in php.ini', array(), 'Admin.Notifications.Error'));
            } else {
                $file_name = strtotime('now').'.'.pathinfo($_FILES['svg_logo']['name'], PATHINFO_EXTENSION);
                if (move_uploaded_file($_FILES['svg_logo']['tmp_name'], _PS_IMG_DIR_.$file_name)) {
                    $general_settings['svg_logo'] = $file_name;
                } else {
                    $this->html .= $this->displayError($this->trans('An error occurred during the image upload process.', array(), 'Admin.Notifications.Error'));
                }
            }
        }
        $settings->general_settings = array_merge($settings->general_settings, $general_settings);

        $settings->header_top_bg_color = Tools::getValue('header_top_bg_color');

        $languages = Language::getLanguages(false);
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $header_top = array();
        $header_phone = array();
        foreach ($languages as $lang) {
            $header_top[$lang['id_lang']] = Tools::getValue('header_top_'.$lang['id_lang']);
            if (!$header_top[$lang['id_lang']]) {
                $header_top[$lang['id_lang']] = Tools::getValue('header_top_'.$id_lang_default);
            }
            $header_phone[$lang['id_lang']] = Tools::getValue('header_phone_'.$lang['id_lang']);
            if (!$header_phone[$lang['id_lang']]) {
                $header_phone[$lang['id_lang']] = Tools::getValue('header_phone_'.$id_lang_default);
            }
        }
        $settings->header_top = $header_top;
        $settings->header_phone = $header_phone;

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Header Settings has been updated successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveFooterSettings()
    {
        $settings = ZManager::getSettingsByShop();

        $general_settings = array(
            'scroll_top' => (int) Tools::getValue('scroll_top'),
        );
        $settings->general_settings = array_merge($settings->general_settings, $general_settings);

        $settings->footer_cms_links = Tools::getValue('footer_cms_links', array());

        $languages = Language::getLanguages(false);
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $footer_about_us = array();
        $footer_cms_title = array();
        $footer_static_links = array();
        $footer_bottom = array();
        $cookie_message = array();
        foreach ($languages as $lang) {
            $footer_about_us[$lang['id_lang']] = Tools::getValue('footer_about_us_'.$lang['id_lang']);
            if (!$footer_about_us[$lang['id_lang']]) {
                $footer_about_us[$lang['id_lang']] = Tools::getValue('footer_about_us_'.$id_lang_default);
            }
            $footer_cms_title[$lang['id_lang']] = Tools::getValue('footer_cms_title_'.$lang['id_lang']);
            if (!$footer_cms_title[$lang['id_lang']]) {
                $footer_cms_title[$lang['id_lang']] = Tools::getValue('footer_cms_title_'.$id_lang_default);
            }
            $footer_static_links[$lang['id_lang']] = Tools::getValue('footer_static_links_'.$lang['id_lang']);
            if (!$footer_static_links[$lang['id_lang']]) {
                $footer_static_links[$lang['id_lang']] = Tools::getValue('footer_static_links_'.$id_lang_default);
            }
            $footer_bottom[$lang['id_lang']] = Tools::getValue('footer_bottom_'.$lang['id_lang']);
            if (!$footer_bottom[$lang['id_lang']]) {
                $footer_bottom[$lang['id_lang']] = Tools::getValue('footer_bottom_'.$id_lang_default);
            }
            $cookie_message[$lang['id_lang']] = Tools::getValue('cookie_message_'.$lang['id_lang']);
            if (!$cookie_message[$lang['id_lang']]) {
                $cookie_message[$lang['id_lang']] = Tools::getValue('cookie_message_'.$id_lang_default);
            }
        }
        $settings->footer_about_us = $footer_about_us;
        $settings->footer_cms_title = $footer_cms_title;
        $settings->footer_static_links = $footer_static_links;
        $settings->footer_bottom = $footer_bottom;
        $settings->cookie_message = $cookie_message;

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);
        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Footer Settings has been updated successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveCategorySettings()
    {
        $settings = ZManager::getSettingsByShop();

        $category_settings = array(
            'show_image' => (int) Tools::getValue('show_image'),
            'show_description' => (int) Tools::getValue('show_description'),
            'expand_description' => (int) Tools::getValue('expand_description'),
            'show_subcategories' => (int) Tools::getValue('show_subcategories'),
            'product_grid_columns' => (int) Tools::getValue('product_grid_columns'),
            'default_product_view' => Tools::getValue('default_product_view'),
            'addtocart_button' => (int) Tools::getValue('addtocart_button'),
            'details_button' => (int) Tools::getValue('details_button'),
            'product_quickview' => (int) Tools::getValue('product_quickview'),
            'product_button_new_line' => (int) Tools::getValue('product_button_new_line'),
            'product_description' => Tools::getValue('product_description'),
            'product_availability' => (int) Tools::getValue('product_availability'),
            'product_colors' => (int) Tools::getValue('product_colors'),
        );
        $settings->category_settings = array_merge($settings->category_settings, $category_settings);

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Category Page Settings has been updated successfully.'));

            $this->_clearCache('*');
            $this->clearZoneHomeBlocksCache();
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveProductSettings()
    {
        $settings = ZManager::getSettingsByShop();

        $product_settings = array(
            'product_info_layout' => Tools::getValue('product_info_layout'),
            'product_add_to_cart_layout' => Tools::getValue('product_add_to_cart_layout'),
            'product_actions_position' => Tools::getValue('product_actions_position'),
            'product_image_zoom' => (int) Tools::getValue('product_image_zoom'),
            'product_countdown' => (int) Tools::getValue('product_countdown'),
            'product_attributes_layout' => Tools::getValue('product_attributes_layout'),
            'combination_price' => (int) Tools::getValue('combination_price'),
            'combination_separator' => Tools::getValue('combination_separator'),
        );

        $settings->product_settings = array_merge($settings->product_settings, $product_settings);

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Product Page Settings has been updated successfully.'));

            $this->_clearCache('*');
            $this->clearZoneHomeBlocksCache();
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveCheckoutSettings()
    {
        $settings = ZManager::getSettingsByShop();

        $checkout_settings = array(
            'login_first' => (int) Tools::getValue('login_first'),
        );

        $settings->checkout_settings = array_merge($settings->checkout_settings, $checkout_settings);

        $languages = Language::getLanguages(false);
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $checkout_header = array();
        $checkout_footer = array();
        foreach ($languages as $lang) {
            $checkout_header[$lang['id_lang']] = Tools::getValue('checkout_header_'.$lang['id_lang']);
            if (!$checkout_header[$lang['id_lang']]) {
                $checkout_header[$lang['id_lang']] = Tools::getValue('checkout_header_'.$id_lang_default);
            }
            $checkout_footer[$lang['id_lang']] = Tools::getValue('checkout_footer_'.$lang['id_lang']);
            if (!$checkout_footer[$lang['id_lang']]) {
                $checkout_footer[$lang['id_lang']] = Tools::getValue('checkout_footer_'.$id_lang_default);
            }
        }
        $settings->checkout_header = $checkout_header;
        $settings->checkout_footer = $checkout_footer;

        $result = $settings->validateFields(false) && $settings->validateFieldsLang(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Checkout Settings has been updated successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function renderSettingsForm()
    {
        $action = Tools::getValue('action');
        if ($action == 'header') {
            $result = $this->renderHeaderForm();
        } elseif ($action == 'footer') {
            $result = $this->renderFooterForm();
        } elseif ($action == 'category') {
            $result = $this->renderCategoryForm();
        } elseif ($action == 'product') {
            $result = $this->renderProductForm();
        } elseif ($action == 'checkout') {
            $result = $this->renderCheckoutForm();
        } elseif ($action == 'configure_zone') {
            $result = $this->renderConfigureZOneForm();
        } else {
            $result = $this->renderGeneralForm();
        }

        return $result;
    }

    // General
    protected function renderGeneralForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGeneralSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getGeneralFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getGeneralForm()));
    }

    protected function getGeneralForm()
    {
        $layout_options = array(
            'query' => array(
                array('id' => 'wide', 'name' => 'Wide'),
                array('id' => 'boxed', 'name' => 'Boxed'),
            ),
            'id' => 'id',
            'name' => 'name',
        );

        $boxed_bg_img_style_options = array(
            'query' => array(
                array('id' => 'repeat', 'name' => 'Repeat'),
                array('id' => 'stretch', 'name' => 'Stretch'),
            ),
            'id' => 'id',
            'name' => 'name',
        );

        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;
        $bg_image_url = false;
        $bg_image_size = false;
        if ($general_settings['boxed_bg_img']) {
            $bg_image_url = $this->_path.$this->image_folder.$general_settings['boxed_bg_img'];
            $bg_image_size = filesize($this->local_path.$this->image_folder.$general_settings['boxed_bg_img']) / 1000;
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('General'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Page Layout'),
                        'name' => 'layout',
                        'options' => $layout_options,
                        'desc' => 'Set wide or boxed layout to your site.',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Boxed Background Color'),
                        'name' => 'boxed_bg_color',
                        'form_group_class' => 'odd',
                        'desc' => $this->l('Set the background color to boxed layout.'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Boxed Background Image'),
                        'name' => 'boxed_bg_img',
                        'display_image' => true,
                        'image' => $bg_image_url ? '<img src="'.$bg_image_url.'" alt="" class="img-thumbnail" style="max-width: 100px;" />' : false,
                        'size' => $bg_image_size,
                        'delete_url' => $this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteBoxedBackgroundImage',
                        'form_group_class' => 'odd',
                        'desc' => $this->l('Set the background image to boxed layout.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Background Image Style'),
                        'name' => 'boxed_bg_img_style',
                        'options' => $boxed_bg_img_style_options,
                        'form_group_class' => 'odd',
                        'desc' => $this->l('How a background image will be displayed.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Lazy Loading Images'),
                        'name' => 'lazy_loading',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'lazy_loading_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'lazy_loading_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Enable the Lazy Load Effect for Product Images'),
                    ),
                    /*array(
                        'type' => 'switch',
                        'label' => $this->l('Progress Bar'),
                        'name' => 'progress_bar',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'progress_bar_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'progress_bar_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Page load progress bar.'),
                        'form_group_class' => 'odd',
                    ),*/
                ),
                'submit' => array(
                    'title' => $this->l('Save General Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getGeneralFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;

        $fields_value = array(
            'layout' => Tools::getValue('layout', $general_settings['layout']),
            'boxed_bg_color' => Tools::getValue('boxed_bg_color', $general_settings['boxed_bg_color']),
            'boxed_bg_img_style' => Tools::getValue('boxed_bg_img_style', $general_settings['boxed_bg_img_style']),
            'lazy_loading' => Tools::getValue('lazy_loading', $general_settings['lazy_loading']),
            'progress_bar' => Tools::getValue('progress_bar', $general_settings['progress_bar']),
        );

        return $fields_value;
    }

    // Header
    protected function renderHeaderForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitHeaderSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getHeaderFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getHeaderForm()));
    }

    protected function getHeaderForm()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;
        $logo_url = false;
        $logo_size = false;
        if ($general_settings['svg_logo']) {
            $logo_url = _PS_IMG_.$general_settings['svg_logo'];
            $logo_size = filesize(_PS_IMG_DIR_.$general_settings['svg_logo']) / 1000;
        }

        $mobile_menu_values = array(
            array('id' => 'categorytree', 'value' => 'categorytree', 'label' => $this->l('Category Tree')),
            array('id' => 'megamenu', 'value' => 'megamenu', 'label' => $this->l('Mega Menu')),
        );

        $home_categories = Category::getHomeCategories(Configuration::get('PS_LANG_DEFAULT'), true, false);
        if ($general_settings['sidebar_categories'] == 'ALL') {
            $selected_categories = array();
            foreach ($home_categories as $cat) {
                $selected_categories[] = $cat['id_category'];
            }
        } else {
            $selected_categories = $general_settings['sidebar_categories'];
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Header'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'color',
                        'label' => $this->l('Header Top Background Color'),
                        'name' => 'header_top_bg_color',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Header Top'),
                        'name' => 'header_top',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Displays a event at the top of page'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Header Links'),
                        'name' => 'header_phone',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Displays some custom links on Header.'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('SVG Logo'),
                        'name' => 'svg_logo',
                        'display_image' => true,
                        'image' => $logo_url ? '<img src="'.$logo_url.'" alt="" class="img-thumbnail" style="max-width: 100px;" />' : false,
                        'size' => $logo_size,
                        'delete_url' => $this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteSVGLogo',
                        'desc' => $this->l('Using SVG logo instead of image logo for your site'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('SVG Width'),
                        'name' => 'svg_width',
                        'col' => 2,
                        'suffix' => 'px',
                        'desc' => $this->l('Set width of SVG Logo'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Sticky Menu'),
                        'name' => 'sticky_menu',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'sticky_menu_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'sticky_menu_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Make the menu "sticky" as soon as it hits the top of the page when you scroll down.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Sticky Menu on Mobile'),
                        'name' => 'sticky_mobile',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'sticky_mobile_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'sticky_mobile_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Enable the sticky menu on mobile device.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Sidebar Mini Cart'),
                        'name' => 'sidebar_cart',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'sidebar_cart_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'sidebar_cart_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Enable the Sidebar Mini Cart instead of the Dropdown Cart on the header.'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Sidebar Navigation'),
                        'name' => 'sidebar_navigation',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'sidebar_navigation_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'sidebar_navigation_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Enable the Sidebar Navigation on desktop version.'),
                    ),
                    array(
                        'type' => 'categories',
                        'label' => $this->l('Sidebar Category Tree'),
                        'name' => 'sidebar_categories',
                        'tree' => array(
                            'use_search' => false,
                            'id' => 'sidebar_category_tree',
                            'use_checkbox' => true,
                            'selected_categories' => $selected_categories,
                            'set_data' => $home_categories
                        ),
                        'desc' => $this->l('Choose categories you want to display in the Sidebar Navigation.'),
                        'form_group_class' => 'sidebar-category-tree',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Mobile Menu'),
                        'name' => 'mobile_menu',
                        'is_bool' => true,
                        'values' => $mobile_menu_values,
                        'desc' => 'Choose a menu type on mobile version.',
                        'form_group_class' => 'odd',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save Header Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getHeaderFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;

        $fields_value = array(
            'header_top_bg_color' => Tools::getValue('header_top_bg_color', $settings->header_top_bg_color),
            'svg_width' => (int) Tools::getValue('svg_width', $general_settings['svg_width']),
            'sticky_menu' => Tools::getValue('sticky_menu', $general_settings['sticky_menu']),
            'sticky_mobile' => Tools::getValue('sticky_mobile', $general_settings['sticky_mobile']),
            'sidebar_cart' => Tools::getValue('sidebar_cart', $general_settings['sidebar_cart']),
            'sidebar_navigation' => Tools::getValue('sidebar_navigation', $general_settings['sidebar_navigation']),
            'mobile_menu' => Tools::getValue('mobile_menu', $general_settings['mobile_menu']),
        );

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $default_header_top = '';
            if (isset($settings->header_top[$lang['id_lang']])) {
                $default_header_top = $settings->header_top[$lang['id_lang']];
            }
            $fields_value['header_top'][$lang['id_lang']] = Tools::getValue('header_top_'.(int) $lang['id_lang'], $default_header_top);

            $default_header_phone = '';
            if (isset($settings->header_phone[$lang['id_lang']])) {
                $default_header_phone = $settings->header_phone[$lang['id_lang']];
            }
            $fields_value['header_phone'][$lang['id_lang']] = Tools::getValue('header_phone_'.(int) $lang['id_lang'], $default_header_phone);
        }

        return $fields_value;
    }

    // Footer
    protected function renderFooterForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitFooterSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getFooterFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getFooterForm()));
    }

    protected function getFooterForm()
    {
        $footer_cms_links_values = array();
        $cms_pages = CMS::listCms(null, false, true);
        if ($cms_pages) {
            foreach ($cms_pages as $cms) {
                $footer_cms_links_values[] = array(
                    'id' => $cms['id_cms'],
                    'name' => $this->l('CMS Page: ').$cms['meta_title'],
                    'val' => $cms['id_cms'],
                );
            }
        }
        foreach ($this->static_pages as $controller => $title) {
            $footer_cms_links_values[] = array(
                'id' => $controller,
                'name' => $title,
                'val' => $controller,
            );
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Footer'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Footer About Us'),
                        'name' => 'footer_about_us',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('About your store and contact information'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Footer CMS Title'),
                        'name' => 'footer_cms_title',
                        'lang' => true,
                        'col' => 5,
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'checkbox_array',
                        'label' => $this->l('Footer CMS Links'),
                        'name' => 'footer_cms_links',
                        'values' => $footer_cms_links_values,
                        'desc' => $this->l('CMS Pages and some useful for your Store'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Footer Static Links'),
                        'name' => 'footer_static_links',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Use the List format (ul & li HTML tag) for this field'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Footer Bottom'),
                        'name' => 'footer_bottom',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('CopyRight, Payment,...'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Cookie Message'),
                        'name' => 'cookie_message',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Cookie Compliance Acceptance Messages'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Scroll to Top Button'),
                        'name' => 'scroll_top',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'scroll_top_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'scroll_top_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Allow your visitors to easily scroll back to the top of your page.'),
                        'form_group_class' => 'odd',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save Footer Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getFooterFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;

        $fields_value = array(
            'footer_cms_links' => Tools::getValue('footer_cms_links', $settings->footer_cms_links),
            'scroll_top' => Tools::getValue('scroll_top', $general_settings['scroll_top']),
        );

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $default_footer_about_us = '';
            if (isset($settings->footer_about_us[$lang['id_lang']])) {
                $default_footer_about_us = $settings->footer_about_us[$lang['id_lang']];
            }
            $fields_value['footer_about_us'][$lang['id_lang']] = Tools::getValue('footer_about_us_'.(int) $lang['id_lang'], $default_footer_about_us);

            $default_footer_cms_title = '';
            if (isset($settings->footer_about_us[$lang['id_lang']])) {
                $default_footer_cms_title = $settings->footer_cms_title[$lang['id_lang']];
            }
            $fields_value['footer_cms_title'][$lang['id_lang']] = Tools::getValue('footer_cms_title_'.(int) $lang['id_lang'], $default_footer_cms_title);

            $default_footer_static_links = '';
            if (isset($settings->footer_static_links[$lang['id_lang']])) {
                $default_footer_static_links = $settings->footer_static_links[$lang['id_lang']];
            }
            $fields_value['footer_static_links'][$lang['id_lang']] = Tools::getValue('footer_static_links_'.(int) $lang['id_lang'], $default_footer_static_links);

            $default_footer_bottom = '';
            if (isset($settings->footer_bottom[$lang['id_lang']])) {
                $default_footer_bottom = $settings->footer_bottom[$lang['id_lang']];
            }
            $fields_value['footer_bottom'][$lang['id_lang']] = Tools::getValue('footer_bottom_'.(int) $lang['id_lang'], $default_footer_bottom);

            $default_cookie_message = '';
            if (isset($settings->cookie_message[$lang['id_lang']])) {
                $default_cookie_message = $settings->cookie_message[$lang['id_lang']];
            }
            $fields_value['cookie_message'][$lang['id_lang']] = Tools::getValue('cookie_message_'.(int) $lang['id_lang'], $default_cookie_message);
        }

        return $fields_value;
    }

    // Category
    protected function renderCategoryForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCategorySettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getCategoryFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getCategoryForm()));
    }

    protected function getCategoryForm()
    {
        $product_grid_columns_values = array(
            array('id' => '2', 'value' => '2', 'label' => $this->l('2 columns')),
            array('id' => '3', 'value' => '3', 'label' => $this->l('3 columns')),
            array('id' => '4', 'value' => '4', 'label' => $this->l('4 columns')),
            array('id' => '5', 'value' => '5', 'label' => $this->l('5 columns')),
        );

        $default_product_view_values = array(
            array('id' => 'grid', 'value' => 'grid', 'label' => $this->l('Grid View')),
            array('id' => 'list', 'value' => 'list', 'label' => $this->l('List View')),
            array('id' => 'table-view', 'value' => 'table-view', 'label' => $this->l('Table View')),
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Category Page'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'name' => 'category_option_title',
                        'html_content' => '<h4>'.$this->l('Category').'</h4>',
                        'form_group_class' => 'odd sub-title',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Category Image'),
                        'name' => 'show_image',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'show_image_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'show_image_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => ' ',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Category Description'),
                        'name' => 'show_description',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'show_description_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'show_description_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => ' ',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Toggle Description'),
                        'name' => 'expand_description',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'expand_description_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'expand_description_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display Category Description with Expand Effect',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Subcategories'),
                        'name' => 'show_subcategories',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'show_subcategories_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'show_subcategories_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => ' ',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'html',
                        'name' => 'product_list_option_title',
                        'html_content' => '<h4>'.$this->l('Product List').'</h4>',
                        'form_group_class' => 'sub-title',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Quick View Window'),
                        'name' => 'product_quickview',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_quickview_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_quickview_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => $this->l('Display quick view window on homepage and category pages'),
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Default Product View'),
                        'name' => 'default_product_view',
                        'is_bool' => true,
                        'values' => $default_product_view_values,
                        'desc' => 'Default product list view in the category page.',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('"Add to cart" button'),
                        'name' => 'addtocart_button',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'addtocart_button_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'addtocart_button_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display Add To Cart button in Product List Pages.',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('"Details" button'),
                        'name' => 'details_button',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'details_button_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'details_button_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display Details button in Product List Pages.',
                    ),
                    array(
                        'type' => 'html',
                        'name' => 'product_grid_option_title',
                        'html_content' => '<h4>'.$this->l('Product Grid View').'</h4>',
                        'form_group_class' => 'odd sub-title',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Grid Columns'),
                        'name' => 'product_grid_columns',
                        'is_bool' => true,
                        'values' => $product_grid_columns_values,
                        'desc' => 'Number of columns in Product Grid view.',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Availability'),
                        'name' => 'product_availability',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_availability_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_availability_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display product availability label in Product Grid view.',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Description'),
                        'name' => 'product_description',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_description_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_description_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display product description in Product Grid view.',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Color Attributes'),
                        'name' => 'product_colors',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_colors_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_colors_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Display product color attributes in Product Grid view.',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Button in new line'),
                        'name' => 'product_button_new_line',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_button_new_line_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_button_new_line_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'In Product Grid view, put the button in a new line.',
                        'form_group_class' => 'odd',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save Category Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getCategoryFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $category_settings = $settings->category_settings;
        $general_settings = $settings->general_settings;

        $fields_value = array(
            'show_image' => Tools::getValue('show_image', $category_settings['show_image']),
            'show_description' => Tools::getValue('show_description', $category_settings['show_description']),
            'expand_description' => Tools::getValue('expand_description', $category_settings['expand_description']),
            'show_subcategories' => Tools::getValue('show_subcategories', $category_settings['show_subcategories']),
            'product_grid_columns' => Tools::getValue('product_grid_columns', $category_settings['product_grid_columns']),
            'default_product_view' => Tools::getValue('default_product_view', $category_settings['default_product_view']),
            'addtocart_button' => Tools::getValue('addtocart_button', $category_settings['addtocart_button']),
            'details_button' => Tools::getValue('details_button', $category_settings['details_button']),
            'product_button_new_line' => Tools::getValue('product_button_new_line', $category_settings['product_button_new_line']),
            'product_quickview' => Tools::getValue('product_quickview', $category_settings['product_quickview']),
            'product_description' => Tools::getValue('product_description', $category_settings['product_description']),
            'product_availability' => Tools::getValue('product_availability', $category_settings['product_availability']),
            'product_colors' => Tools::getValue('product_colors', $category_settings['product_colors']),
        );

        return $fields_value;
    }

    // Product
    protected function renderProductForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitProductSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getProductFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getProductForm()));
    }

    protected function getProductForm()
    {
        $product_info_layout_values = array(
            array('id' => 'product_info_normal', 'value' => 'normal', 'label' => $this->l('Normal')),
            array('id' => 'product_info_tabs', 'value' => 'tabs', 'label' => $this->l('Tabs')),
            array('id' => 'product_info_accordions', 'value' => 'accordions', 'label' => $this->l('Accordion')),
        );
        $product_add_to_cart_layout_values = array(
            array('id' => 'addtocart_normal', 'value' => 'normal', 'label' => $this->l('Normal')),
            array('id' => 'addtocart_inline', 'value' => 'inline', 'label' => $this->l('Inline')),
        );
        $product_actions_position_values = array(
            array('id' => 'left', 'value' => 'left', 'label' => $this->l('Left')),
            array('id' => 'right', 'value' => 'right', 'label' => $this->l('Right')),
        );
        $product_attributes_layout_values = array(
            array(
                'id' => 'attributes_layout_default',
                'value' => 'default',
                'label' => $this->l('Default')
            ),
            array(
                'id' => 'attributes_layout_swatches',
                'value' => 'swatches',
                'label' => $this->l('Swatches')
            ),
            array(
                'id' => 'attributes_layout_combinations',
                'value' => 'combinations',
                'label' => $this->l('Combinations')
            ),
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Product Page'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Product Image Zoom'),
                        'name' => 'product_image_zoom',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_image_zoom_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_image_zoom_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Show a bigger size product image on mouseover',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Product Countdown'),
                        'name' => 'product_countdown',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'product_countdown_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'product_countdown_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'Enable a countdown box for Product Special Price.',
                        'form_group_class' => 'odd',
                    ),
                    /*array(
                        'type' => 'radio',
                        'label' => $this->l('Product Actions Position'),
                        'name' => 'product_actions_position',
                        'is_bool' => true,
                        'values' => $product_actions_position_values,
                        'desc' => 'Position of the "Product actions" box',
                    ),*/
                    array(
                        'type' => 'radio',
                        'label' => $this->l('"Add to cart" button'),
                        'name' => 'product_add_to_cart_layout',
                        'is_bool' => true,
                        'values' => $product_add_to_cart_layout_values,
                        'desc' => 'Quantity box and "add to cart" button layout',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Product Details Layout'),
                        'name' => 'product_info_layout',
                        'is_bool' => true,
                        'values' => $product_info_layout_values,
                        'desc' => 'Select a product informations layout',
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Product Attributes Layout'),
                        'name' => 'product_attributes_layout',
                        'values' => $product_attributes_layout_values,
                        'desc' => ' ',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Combinations Price'),
                        'name' => 'combination_price',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'combination_price_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'combination_price_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                        'desc' => $this->l('Display Product Price in Combinations.'),
                        'form_group_class' => 'product_attributes_combinations',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Combinations Separator'),
                        'name' => 'combination_separator',
                        'col' => 3,
                        'desc' => $this->l('Attributes Separator in Combinations.'),
                        'form_group_class' => 'product_attributes_combinations',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save Product Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getProductFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $product_settings = $settings->product_settings;

        $fields_value = array(
            'product_info_layout' => Tools::getValue('product_info_layout', $product_settings['product_info_layout']),
            'product_add_to_cart_layout' => Tools::getValue('product_add_to_cart_layout', $product_settings['product_add_to_cart_layout']),
            'product_actions_position' => Tools::getValue('product_actions_position', $product_settings['product_actions_position']),
            'product_image_zoom' => Tools::getValue('product_image_zoom', $product_settings['product_image_zoom']),
            'product_countdown' => Tools::getValue('product_countdown', $product_settings['product_countdown']),
            'product_attributes_layout' => Tools::getValue('product_attributes_layout', $product_settings['product_attributes_layout']),
            'combination_price' => Tools::getValue('combination_price', $product_settings['combination_price']),
            'combination_separator' => Tools::getValue('combination_separator', $product_settings['combination_separator']),
        );

        return $fields_value;
    }

    // Checkout
    protected function renderCheckoutForm()
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCheckoutSettings';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getCheckoutFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getCheckoutForm()));
    }

    protected function getCheckoutForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Checkout Page'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Header Content'),
                        'name' => 'checkout_header',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Header content on Checkout page'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Footer Content'),
                        'name' => 'checkout_footer',
                        'autoload_rte' => true,
                        'lang' => true,
                        'desc' => $this->l('Footer content on Checkout page'),
                        'form_group_class' => 'odd',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Login Form First'),
                        'name' => 'login_first',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => 'login_first_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => 'login_first_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => 'If it is disabled, "Registration Form" will display first.',
                    ),
                    
                ),
                'submit' => array(
                    'title' => $this->l('Save Checkout Settings'),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getCheckoutFieldsValues()
    {
        $settings = ZManager::getSettingsByShop();
        $checkout_settings = $settings->checkout_settings;

        $fields_value = array(
            'login_first' => Tools::getValue('login_first', $checkout_settings['login_first']),
        );

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $default_checkout_header = '';
            if (isset($settings->checkout_header[$lang['id_lang']])) {
                $default_checkout_header = $settings->checkout_header[$lang['id_lang']];
            }
            $fields_value['checkout_header'][$lang['id_lang']] = Tools::getValue('checkout_header_'.(int) $lang['id_lang'], $default_checkout_header);

            $default_checkout_footer = '';
            if (isset($settings->checkout_footer[$lang['id_lang']])) {
                $default_checkout_footer = $settings->checkout_footer[$lang['id_lang']];
            }
            $fields_value['checkout_footer'][$lang['id_lang']] = Tools::getValue('checkout_footer_'.(int) $lang['id_lang'], $default_checkout_footer);
        }

        return $fields_value;
    }

    // Hook process

    public function hookActionCategoryAdd($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionCategoryUpdate($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionCategoryDelete($params)
    {
        $this->_clearCache('*');
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
    public function hookActionAttributeDelete($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionAttributeSave($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionAttributeGroupDelete($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionAttributeGroupSave($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionAttributeCombinationDelete($params)
    {
        $this->_clearCache('*');
    }
    public function hookActionAttributeCombinationSave($params)
    {
        $this->_clearCache('*');
    }

    public function getBoxedBackgroundCSS($force = false)
    {
        $settings = ZManager::getSettingsByShop();
        
        $general_settings = $settings->general_settings;
        $boxed_bg_css = false;
        if ($general_settings['layout'] == 'boxed' || $force) {
            $boxed_bg_css = 'body { background-color: '.$general_settings['boxed_bg_color'].';';
            if ($general_settings['boxed_bg_img']) {
                $bg_img_url = $this->_path.$this->image_folder.$general_settings['boxed_bg_img'];
                $bg_img_url = Tools::getCurrentUrlProtocolPrefix().Tools::getMediaServer($bg_img_url).$bg_img_url;
                $boxed_bg_css .= 'background-image: url('.$bg_img_url.');';
                if ($general_settings['boxed_bg_img_style'] == 'repeat') {
                    $boxed_bg_css .= 'background-repeat: repeat;';
                } elseif ($general_settings['boxed_bg_img_style'] == 'stretch') {
                    $boxed_bg_css .= 'background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-size: cover;';
                }
            }
            $boxed_bg_css .= '}';
        }

        return $boxed_bg_css;
    }

    public function hookActionFrontControllerSetVariables()
    {
        $context = $this->context;

        $content_only = (int) Tools::getValue('content_only');
        $is_mobile = ($context->isMobile() && !$context->isTablet());
        $settings = ZManager::getSettingsByShop();
        $general_settings = $settings->general_settings;
        $category_settings = $settings->category_settings;
        $product_settings = $settings->product_settings;
        $checkout_settings = $settings->checkout_settings;
        $body_classes = ZManager::getStyleClassesByShop();

        if ($is_mobile) {
            $general_settings['sidebar_navigation'] = 1;
            $general_settings['progress_bar'] = 0;
            $general_settings['sticky_menu'] = 0;
            $product_settings['product_image_zoom'] = 0;
            $body_classes[] = 'a-mobile-device';
            $category_settings['default_product_view'] = 'grid';
        } else {
            $general_settings['sticky_mobile'] = 0;
        }

        if ($context->customer->isLogged(true)) {
            $body_classes[] = 'customer-has-logged';
        }
        if (!$context->customer->isLogged(true) || !Customer::getAddressesTotalById($context->customer->id)) {
            $body_classes[] = 'no-customer-address';
        }
        if (Configuration::isCatalogMode()) {
            $body_classes[] = 'catalog-mode';
        }
        if ((Configuration::get('PS_CATALOG_MODE') && !Configuration::get('PS_CATALOG_MODE_WITH_PRICES')) || (Group::isFeatureActive() && !Group::getCurrent()->show_prices)) {
            $body_classes[] = 'disable-price-mode';
        }
        if ($context->isMobile()) {
            $body_classes[] = 'touch-screen';
        }

        $svg_logo = false;
        if ($general_settings['svg_logo'] && file_exists(_PS_IMG_DIR_.$general_settings['svg_logo'])) {
            $path = _PS_IMG_.$general_settings['svg_logo'];
            $svg_logo = Tools::getCurrentUrlProtocolPrefix().Tools::getMediaServer($path).$path;
        }

        if ($category_settings['product_description']) {
            $body_classes[] = 'pg-epd';
        }
        if ($category_settings['product_availability']) {
            $body_classes[] = 'pg-eal';
        }
        if ($category_settings['product_colors']) {
            $body_classes[] = 'pg-evl';
        }
        if ($category_settings['product_button_new_line'] || $is_mobile || (!$category_settings['addtocart_button'] && !$category_settings['details_button'])) {
            $body_classes[] = 'pg-bnl';
        }

        return array(
            'progress_bar' => 0,
            'boxed_layout' => ($general_settings['layout'] == 'boxed'),
            'lazy_loading' => ($general_settings['lazy_loading'] && !$context->controller->ajax && !$content_only),
            'sidebar_cart' => $general_settings['sidebar_cart'],
            'sidebar_navigation' => $general_settings['sidebar_navigation'],
            'product_countdown' => $product_settings['product_countdown'],
            'svg_logo' => $svg_logo,
            'svg_width' => $general_settings['svg_width'].'px',
            'sticky_menu' => $general_settings['sticky_menu'],
            'sticky_mobile' => $general_settings['sticky_mobile'],
            'mobile_megamenu' => ($is_mobile && $general_settings['mobile_menu'] == 'megamenu'),
            'product_quickview' => $category_settings['product_quickview'],
            'product_addtocart' => $category_settings['addtocart_button'],
            'product_details' => $category_settings['details_button'],
            'product_grid_columns' => $category_settings['product_grid_columns'],
            'body_classes' => implode(' ', $body_classes),
            'is_mobile' => $is_mobile,
            'product_grid_desc' => $category_settings['product_description'],
            'product_grid_available' => $category_settings['product_availability'],
            'product_grid_colors' => $category_settings['product_colors'],
            'cat_image' => $category_settings['show_image'],
            'cat_description' => $category_settings['show_description'],
            'cat_expand_desc' => $category_settings['expand_description'],
            'cat_subcategories' => $category_settings['show_subcategories'],
            'cat_default_view' => $category_settings['default_product_view'],
            'product_info_layout' => $product_settings['product_info_layout'],
            'product_qty_add_inline' => ($product_settings['product_add_to_cart_layout'] == 'inline'),
            'product_actions_position' => $product_settings['product_actions_position'],
            'product_image_zoom' => $product_settings['product_image_zoom'],
            'product_attr_combinations' => ($product_settings['product_attributes_layout'] == 'combinations'),
            'product_attr_swatches' => ($product_settings['product_attributes_layout'] == 'swatches'),
            'product_attr_default' => ($product_settings['product_attributes_layout'] == 'default'),
            'checkout_login_first' => $checkout_settings['login_first'],
            'is_quickview' => ('1' === Tools::getValue('quickview')),
            'ps_legalcompliance_spl' => (Module::isEnabled('ps_legalcompliance') && (Configuration::get('AEUC_LABEL_SPECIFIC_PRICE') || Configuration::get('AEUC_LABEL_UNIT_PRICE'))),
            'enabled_pm_advancedsearch4' => (Module::isInstalled('pm_advancedsearch4') && Module::isEnabled('pm_advancedsearch4')),
            'psDimensionUnit' => Configuration::get('PS_DIMENSION_UNIT'),
        );
    }

    public function hookDisplayHeader()
    {
        $context = $this->context;
        $context->controller->registerJavascript(
            'modules-shoppingcart',
            'modules/ps_shoppingcart/ps_shoppingcart.js',
            array('position' => 'bottom', 'priority' => 150)
        );

        Media::addJsDef(array(
            'varPSAjaxCart' => (int) Configuration::get('PS_BLOCK_CART_AJAX', null, null, null, 1),
            'varGetFinalDateMiniatureController' => $context->link->getModuleLink($this->name, 'getFinalDateMiniature', array(), true),
            'varGetFinalDateController' => $context->link->getModuleLink($this->name, 'getFinalDate', array(), true),
            'varProductCommentGradeController' => $context->link->getModuleLink($this->name, 'CommentGrade', array(), true),
            'varProductCommentGradeController' => $context->link->getModuleLink($this->name, 'CommentGrade', array(), true),
            'varCategoryTreeController' => $context->link->getModuleLink($this->name, 'categoryTree', array(), true),
            //'varCustomActionAddVoucher' => 1,
            //'varCustomActionAddToCart' => 1,
            //'varProductPendingRefreshIcon' => 1,
        ));

        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_header.tpl';
        $cacheId = $this->name.'|header';

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $boxed_bg_css = $this->getBoxedBackgroundCSS(false);
            $this->smarty->assign(array(
                'boxed_bg_css' => $boxed_bg_css,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayNav1()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_nav1.tpl';
        $cacheId = $this->name.'|nav1';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'header_phone' => $settings->header_phone,
            ));
        }
        
        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayBanner()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_banner.tpl';
        $cacheId = $this->name.'|banner';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'header_top' => $settings->header_top,
                'header_top_bg_color' => (Tools::strtolower($settings->header_top_bg_color) != "#f9f2e8") ? $settings->header_top_bg_color : false,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayFooterLeft()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_footerleft.tpl';
        $cacheId = $this->name.'|footerleft';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'aboutUs' => $settings->footer_about_us,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayFooterRight()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_footerright.tpl';
        $cacheId = $this->name.'|footerright';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);
            $cms_links = array();
            $page_links = array();

            $cms_pages = CMS::listCms($id_lang, false, true);
            if ($cms_pages) {
                foreach ($cms_pages as $cms) {
                    if (in_array($cms['id_cms'], $settings->footer_cms_links)) {
                        $cms_links[] = array(
                            'link' => $this->context->link->getCMSLink($cms['id_cms']),
                            'title' => $cms['meta_title'],
                        );
                    }
                }
            }

            foreach ($this->static_pages as $controller => $title) {
                if (in_array($controller, $settings->footer_cms_links)) {
                    $page_links[] = array(
                        'link' => $this->context->link->getPageLink($controller),
                        'id' => $controller,
                    );
                }
            }

            $this->smarty->assign(array(
                'cmsTitle' => $settings->footer_cms_title,
                'cmsLinks' => $cms_links,
                'pageLinks' => $page_links,
                'staticLinks' => $settings->footer_static_links,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayFooterAfter()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_footerafter.tpl';
        $cacheId = $this->name.'|footerafter';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'footerBottom' => $settings->footer_bottom,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayFooter()
    {
        return false;
    }

    public function hookDisplaySidebarNavigation()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_sidebar_navigation.tpl';
        $cacheId = $this->name.'|navigation';
        
        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayOutsideMainPage()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_outsidemainpage.tpl';
        $cacheId = $this->name.'|outsidemainpage';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);
            $empty_cookie_message = trim(Tools::getDescriptionClean($settings->cookie_message));

            $this->smarty->assign(array(
                'cookieMessage' => $empty_cookie_message == '' ? false : $settings->cookie_message,
                'enableScrollTop' => $settings->general_settings['scroll_top'],
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayCheckoutHeader()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_checkoutheader.tpl';
        $cacheId = $this->name.'|checkoutheader';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'checkoutHeader' => $settings->checkout_header,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }
    public function hookDisplayCheckoutFooter()
    {
        $templateFile = 'module:zonethememanager/views/templates/hook/zonethememanager_checkoutfooter.tpl';
        $cacheId = $this->name.'|checkoutfooter';
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $id_lang = (int) $this->context->language->id;
            $settings = ZManager::getSettingsByShop($id_lang);

            $this->smarty->assign(array(
                'checkoutFooter' => $settings->checkout_footer,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    protected function preProcessProductCombinations($combinations, $groups, $id_product, $id_product_attribute, $minimal_quantity)
    {
        $result_combinations = array();
        $settings = ZManager::getSettingsByShop();
        $product_settings = $settings->product_settings;
        $disp_unvailable_attr = Configuration::get('PS_DISP_UNAVAILABLE_ATTR');
        $out_of_stock = StockAvailable::outOfStock($id_product);
        $allow_oosp = Product::isAvailableWhenOutOfStock($out_of_stock);

        if ($product_settings['product_attributes_layout'] == 'combinations') {
            $priceFormatter = new PriceFormatter();
            $usetax = false;
            $tax_calc = Product::getTaxCalculationMethod();
            if ($tax_calc == 0 || $tax_calc == 2) {
                $usetax = true;
            }

            foreach ($combinations as $id_pro_attr => $combination) {
                if (!$disp_unvailable_attr && $combination['quantity'] < 1) {
                    continue;
                }
                $exist = true;
                foreach ($combination['attributes_values'] as $k => $value) {
                    if (empty($groups[$k]) || empty($groups[$k]['attributes'])) {
                        $exist = false;
                    }
                }

                if ($exist) {
                    $combination['title'] = implode("<span>".$product_settings['combination_separator']."</span>", $combination['attributes_values']);

                    if ($product_settings['combination_price']) {
                        $price = Product::getPriceStatic(
                            (int) $id_product,
                            $usetax,
                            $id_pro_attr,
                            6,
                            null,
                            false,
                            true,
                            $minimal_quantity
                        );
                        $combination['price'] = $priceFormatter->format($price);

                        $regular_price = Product::getPriceStatic(
                            (int) $id_product,
                            $usetax,
                            $id_pro_attr,
                            6,
                            null,
                            false,
                            false,
                            $minimal_quantity
                        );
                        if ($regular_price > $price) {
                            $combination['regular_price'] = $priceFormatter->format($regular_price);
                        } else {
                            $combination['regular_price'] = false;
                        }
                    } else {
                        $combination['price'] = false;
                    }

                    $combination['disable'] = false;
                    if (!$combination['quantity'] && !$allow_oosp) {
                        $combination['disable'] = true;
                    }

                    if ($product_settings['combination_quantity']) {
                        $combination['quantity_label'] = ($combination['quantity'] > 1) ? $this->trans('Items', array(), 'Shop.Theme.Catalog') : $this->trans('Item', array(), 'Shop.Theme.Catalog');
                    } else {
                        $combination['quantity'] = false;
                    }
                    
                    $combination['groups'] = array();
                    $i = 0;
                    foreach ($combination['attributes_values'] as $k => $value) {
                        $combination['groups'][$k] = $combination['attributes'][$i++];
                    }

                    $result_combinations[$id_pro_attr] = $combination;
                }
            }
        }

        $this->smarty->assign(array(
            'combinations' => $result_combinations,
            'id_product_attribute' => $id_product_attribute,
        ));
    }

    public function hookDisplayProductCombinationsBlock($param)
    {
        $combinations = $param['combinations'];
        $groups = $param['groups'];
        $id_product = (int) $param['id_product'];
        $id_product_attribute = (int) $param['id_product_attribute'];
        $minimal_quantity = $param['minimal_quantity'];

        if (empty($combinations) || empty($groups)) {
            return;
        }

        $templateFile = 'module:zonethememanager/views/templates/hook/product_combinations.tpl';
        $cacheId = $this->name.'|combinations|'.$id_product.'|'.$id_product_attribute;

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $this->preProcessProductCombinations($combinations, $groups, $id_product, $id_product_attribute, $minimal_quantity);
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function displayCategoryTree()
    {
        $templateFile = 'module:zonethememanager/views/templates/front/category-tree.tpl';
        $cacheId = $this->name.'|categorytree';
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $settings = ZManager::getSettingsByShop();
            $general_settings = $settings->general_settings;
            $sidebar_menus = $this->getHomeCategoryTree($general_settings['sidebar_categories']);

            $this->smarty->assign(array(
                'sidebarMenus' => $sidebar_menus,
            ));
        }
        
        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    protected function getHomeCategoryTree($id_sidebar_categories)
    {
        $id_root_category = Configuration::get('PS_HOME_CATEGORY');
        $root_category = new Category((int) $id_root_category, $this->context->language->id);
        $range = '';

        $maxdepth = 5;
        if (Validate::isLoadedObject($root_category)) {
            $maxdepth += $root_category->level_depth;
            $range = 'AND nleft >= '.(int) $root_category->nleft.' AND nright <= '.(int) $root_category->nright;
        }

        $treeIds = array();
        $treeParents = array();
        $category_row = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
            SELECT c.`id_parent`, c.`id_category`, cl.`name`, cl.`link_rewrite`
            FROM `'._DB_PREFIX_.'category` c
            INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.(int) $this->context->language->id.Shop::addSqlRestrictionOnLang('cl').')
            INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int) $this->context->shop->id.')
            WHERE (c.`active` = 1 OR c.`id_category` = '.(int) $id_root_category.')
            AND c.`id_category` != '.(int) Configuration::get('PS_ROOT_CATEGORY').'
            '.((int) $maxdepth != 0 ? ' AND `level_depth` <= '.(int) $maxdepth : '').'
            '.pSQL($range).'
            AND c.`id_category` IN (
                SELECT id_category
                FROM `'._DB_PREFIX_.'category_group`
                WHERE `id_group` IN ('.pSQL(implode(', ', Customer::getGroupsStatic((int) $this->context->customer->id))).')
            )
            ORDER BY `level_depth` ASC, '.(Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`').' '.(Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC')
        );
        foreach ($category_row as $row) {
            $treeParents[$row['id_parent']][] = $row;
            $treeIds[$row['id_category']] = $row;
        }

        $results = array();
        if ($id_sidebar_categories == 'ALL') {
            $tree = $this->getTree($treeParents, $treeIds, $maxdepth, $id_root_category);
            $results = $tree['children'];
        } else {
            foreach ($id_sidebar_categories as $id) {
                if (isset($treeIds[$id])) {
                    $results[] = $this->getTree($treeParents, $treeIds, $maxdepth, $id);
                }
            }
        }

        return $results;
    }

    protected function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0)
    {
        if (is_null($id_category)) {
            $id_category = $this->context->shop->getCategory();
        }

        $children = array();

        if (isset($resultParents[$id_category]) && count($resultParents[$id_category]) && ($maxDepth == 0 || $currentDepth < $maxDepth)) {
            foreach ($resultParents[$id_category] as $subcat) {
                $children[] = $this->getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
            }
        }

        $menu_thumb = false;
        $link = $name = '';
        if (isset($resultIds[$id_category])) {
            $link = $this->context->link->getCategoryLink($id_category, $resultIds[$id_category]['link_rewrite']);
            $name = $resultIds[$id_category]['name'];

            $thumb = false;
            for ($i = 0; $i < 3; ++$i) {
                if (file_exists(_PS_CAT_IMG_DIR_.$id_category.'-'.$i.'_thumb.jpg')) {
                    $thumb = $i;
                    break;
                }
            }
            if ($thumb !== false) {
                list($tmpWidth, $tmpHeight, $type) = getimagesize(_PS_CAT_IMG_DIR_.$id_category.'-'.$thumb.'_thumb.jpg');
                $menu_thumb = array(
                    'url' => $this->context->link->getCatImageLink($resultIds[$id_category]['link_rewrite'], $id_category, $thumb.'_thumb'),
                    'width' => $tmpWidth,
                    'height' => $tmpHeight,
                );
            }
        }

        return array(
            'id' => $id_category,
            'link' => $link,
            'name' => $name,
            'menu_thumb' => $menu_thumb,
            'children' => $children
        );
    }
}
