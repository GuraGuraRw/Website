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

include_once dirname(__FILE__).'/classes/ZPopupNewsletter.php';

class ZOnePopupNewsletter extends Module
{
    protected $html = '';
    public $bg_img_folder = 'views/img/bgImages/';

    public function __construct()
    {
        $this->name = 'zonepopupnewsletter';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ZelaTheme';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Z.One - Popup Newsletter');
        $this->description = $this->l('Displays a popup newsletter when page load.');
    }

    private function installSampleXML()
    {
        $languages = Language::getLanguages(false);
        $iso_lang_default = 'en';
        $zpopupnewsletter = ZPopupNewsletter::getNewsletterByShop();
        $language_fields_name = array(
            'content',
        );
        $xml_file = Tools::simplexml_load_file($this->local_path.'sql/sample.xml');
        $rows = $xml_file->row;
        $row = $rows[0];

        $zpopupnewsletter->active = (int) $row->active;
        $zpopupnewsletter->width = (int) $row->width;
        $zpopupnewsletter->height = (int) $row->height;
        $zpopupnewsletter->bg_color = (string) $row->bg_color;
        $zpopupnewsletter->cookie_time = (int) $row->cookie_time;
        $zpopupnewsletter->subscribe_form = (int) $row->subscribe_form;
        $zpopupnewsletter->save_time = strtotime('now');
        $zpopupnewsletter->bg_image = (string) $row->bg_image;

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
            $zpopupnewsletter->$name = $language_fields[$name];
        }

        if ($zpopupnewsletter->validateFields(false) && $zpopupnewsletter->validateFieldsLang(false)) {
            $zpopupnewsletter->save();
        } else {
            return false;
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

        return parent::install()
            && $this->registerHook('displayOutsideMainPage');
    }

    public function uninstall()
    {
        $sql = 'DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'zpopupnewsletter`,
            `'._DB_PREFIX_.'zpopupnewsletter_lang`';

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

    protected function blockNewsletter()
    {
        $name = 'ps_emailsubscription';
        $module_instance = Module::getInstanceByName($name);

        $enabled = true;
        if (!Module::isInstalled($name) || !Module::isEnabled($name)) {
            $enabled = false;
        }

        $this->smarty->assign(array(
            'module_enabled' => $enabled,
            'module_name' => $module_instance->displayName,
            'module_link' => $this->context->link->getAdminLink('AdminModules', true).'&configure='.urlencode($module_instance->name),
        ));

        return $this->display(__FILE__, 'views/templates/admin/newsletter-message.tpl');
    }

    public function getContent()
    {
        $this->context->controller->addJS($this->_path.'views/js/back.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');

        $about = $this->about();
        $message = $this->blockNewsletter();

        if (Tools::isSubmit('submitSettings')) {
            $this->processSaveSettings();

            return $message.$this->html.$this->renderSettingsForm().$about;
        } elseif (Tools::isSubmit('deleteBackgroundImage')) {
            $zpopupnewsletter = ZPopupNewsletter::getNewsletterByShop();
            if ($zpopupnewsletter->bg_image) {
                $image_path = $this->local_path.$this->bg_img_folder.$zpopupnewsletter->bg_image;

                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $zpopupnewsletter->bg_image = null;
                $zpopupnewsletter->update(false);
                $this->_clearCache('*');
            }

            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&conf=7');
        } else {
            return $message.$this->renderSettingsForm().$about;
        }
    }

    protected function processSaveSettings()
    {
        $zpopupnewsletter = ZPopupNewsletter::getNewsletterByShop();

        $zpopupnewsletter->active = (int) Tools::getValue('active');
        $zpopupnewsletter->width = (int) Tools::getValue('width');
        $zpopupnewsletter->height = (int) Tools::getValue('height');
        $zpopupnewsletter->bg_color = Tools::getValue('bg_color');
        $zpopupnewsletter->cookie_time = (int) Tools::getValue('cookie_time');
        $zpopupnewsletter->subscribe_form = (int) Tools::getValue('subscribe_form');
        $zpopupnewsletter->save_time = strtotime('now');

        $languages = Language::getLanguages(false);
        $id_lang_default = (int) Configuration::get('PS_LANG_DEFAULT');
        $content = array();
        foreach ($languages as $lang) {
            $content[$lang['id_lang']] = Tools::getValue('content_'.$lang['id_lang']);
            if (!$content[$lang['id_lang']]) {
                $content[$lang['id_lang']] = Tools::getValue('content_'.$id_lang_default);
            }
        }
        $zpopupnewsletter->content = $content;

        if (isset($_FILES['bg_image']) && isset($_FILES['bg_image']['tmp_name']) && !empty($_FILES['bg_image']['tmp_name'])) {
            if ($error = ImageManager::validateUpload($_FILES['bg_image'], Tools::convertBytes(ini_get('upload_max_filesize')))) {
                $this->html .= $this->displayError($error);
            } else {
                if (move_uploaded_file($_FILES['bg_image']['tmp_name'], $this->local_path.$this->bg_img_folder.$_FILES['bg_image']['name'])) {
                    $zpopupnewsletter->bg_image = $_FILES['bg_image']['name'];
                } else {
                    $this->html .= $this->displayError($this->l('File upload error.'));
                }
            }
        }

        $result = $zpopupnewsletter->validateFields(false) && $zpopupnewsletter->validateFieldsLang(false);

        if ($result) {
            $zpopupnewsletter->save();

            $this->html .= $this->displayConfirmation($this->l('Settings has been updated successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
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
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
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
        $zpopupnewsletter = ZPopupNewsletter::getNewsletterByShop();

        $image_url = false;
        $image_size = false;
        if ($zpopupnewsletter && file_exists($this->local_path.$this->bg_img_folder.$zpopupnewsletter->bg_image)) {
            if ($zpopupnewsletter->bg_image) {
                $image_url = $this->_path.$this->bg_img_folder.$zpopupnewsletter->bg_image;
                $image_size = filesize($this->local_path.$this->bg_img_folder.$zpopupnewsletter->bg_image) / 1000;
            }
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Popup Newsletter'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->trans(
                            'Displayed',
                            array(),
                            'Admin.Global'
                        ),
                        'name' => 'active',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Popup Width'),
                        'name' => 'width',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Popup Height'),
                        'name' => 'height',
                        'col' => 2,
                        'suffix' => 'px',
                    ),
                    array(
                        'type' => 'color',
                        'label' => $this->l('Background Color'),
                        'name' => 'bg_color',
                        'hint' => $this->l('Background color of Popup Newsletter'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Background Image'),
                        'name' => 'bg_image',
                        'hint' => $this->l('Upload a new background image for Popup Newsletter'),
                        'display_image' => true,
                        'image' => $image_url ? '<img src="'.$image_url.'" alt="" class="img-thumbnail" style="max-width: 430px;" />' : false,
                        'size' => $image_size,
                        'delete_url' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteBackgroundImage',
                        'desc' => $this->l('Recommended dimensions are 670x500 pixels'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Cookie Time'),
                        'name' => 'cookie_time',
                        'col' => 2,
                        'suffix' => $this->l('days'),
                        'hint' => $this->l('How long should be cookie stored?'),
                        'desc' => $this->l('0 = when browser closes'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Newsletter Subscription Form'),
                        'name' => 'subscribe_form',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'subscribe_form_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'subscribe_form_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Content'),
                        'name' => 'content',
                        'autoload_rte' => true,
                        'lang' => true,
                        'rows' => 10,
                        'cols' => 100,
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
        $zpopupnewsletter = ZPopupNewsletter::getNewsletterByShop();

        $fields_value = array(
            'active' => Tools::getValue('active', $zpopupnewsletter->active),
            'width' => Tools::getValue('width', $zpopupnewsletter->width),
            'height' => Tools::getValue('height', $zpopupnewsletter->height),
            'bg_color' => Tools::getValue('bg_color', $zpopupnewsletter->bg_color),
            'cookie_time' => Tools::getValue('cookie_time', $zpopupnewsletter->cookie_time),
            'subscribe_form' => Tools::getValue('subscribe_form', $zpopupnewsletter->subscribe_form),
        );

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang) {
            $default_content = isset($zpopupnewsletter->content[$lang['id_lang']]) ? $zpopupnewsletter->content[$lang['id_lang']] : '';
            $fields_value['content'][$lang['id_lang']] = Tools::getValue('content_'.(int) $lang['id_lang'], $default_content);
        }

        return $fields_value;
    }

    protected function preProcess()
    {
        $popup_save_time = ZPopupNewsletter::getSaveTimeByShop();

        $this->smarty->assign(array(
            'save_time' => $popup_save_time,
            'ajax_subscribe_url' => $this->context->link->getModuleLink($this->name, 'subscribe', array(), true),
            'ajax_modal_newsletter_controller' => $this->context->link->getModuleLink($this->name, 'modalNewsletter', array(), true),
        ));
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        return $this->hookDisplayOutsideMainPage();
    }

    public function hookDisplayOutsideMainPage()
    {
        $templateFile = 'module:zonepopupnewsletter/views/templates/hook/zonepopupnewsletter.tpl';
        $cacheId = $this->name;

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $this->preProcess();
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }
}
