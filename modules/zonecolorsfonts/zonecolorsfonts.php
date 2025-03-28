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

include_once dirname(__FILE__).'/classes/ZColorsFonts.php';
include_once dirname(__FILE__).'/classes/ZCSSColor.php';

class ZOneColorsFonts extends Module
{
    protected $html = '';
    protected $action;
    protected $currentIndex;
    protected $groups;
    protected $normal_fonts;
    protected $default_font;

    public function __construct()
    {
        $this->name = 'zonecolorsfonts';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ZelaTheme';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Z.One - Colors and Fonts');
        $this->description = $this->l('Customize colors and fonts of ZOne theme.');

        $this->action = Tools::getValue('action', 'general');
        $this->currentIndex = AdminController::$currentIndex.'&configure='.$this->name.'&action='.$this->action;

        $this->groups = array('general', 'header', 'footer', 'content', 'product', 'fonts');
        $this->normal_fonts = array(
            'Arial',
            'Verdana, Geneva',
            'Trebuchet MS',
            'Georgia',
            'Times New Roman',
            'Tahoma, Geneva',
            'Helvetica'
        );
        $this->default_font = '<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">';
    }

    private function installSampleXML()
    {
        $settings = ZColorsFonts::getSettingsByShop();
        $xml_file = Tools::simplexml_load_file($this->local_path.'sql/sample.xml');
        $rows = $xml_file->row;
        $row = $rows[0];

        $settings->general = Tools::unSerialize((string) $row->general);
        $settings->header = Tools::unSerialize((string) $row->header);
        $settings->footer = Tools::unSerialize((string) $row->footer);
        $settings->content = Tools::unSerialize((string) $row->content);
        $settings->product = Tools::unSerialize((string) $row->product);
        $settings->fonts = Tools::unSerialize((string) $row->fonts);
        $settings->fonts_import = (string) $row->fonts_import;
        $settings->custom_css = (string) $row->custom_css;

        if ($settings->validateFields(false)) {
            $settings->save();
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

        Configuration::updateGlobalValue('ZONE_COLORS_LIVE_PREVIEW', 0);

        if (!$this->installSampleXML()) {
            return false;
        }

        return parent::install()
            && $this->registerHook('header')
            && $this->registerHook('displayOutsideMainPage');
    }

    public function uninstall()
    {
        $sql = 'DROP TABLE IF EXISTS
            `'._DB_PREFIX_.'zcolorsfonts`';

        if (!Db::getInstance()->execute($sql)) {
            return false;
        }

        Configuration::deleteByName('ZONE_COLORS_LIVE_PREVIEW');

        $this->_clearCache('*');

        return parent::uninstall();
    }

    public function getContent()
    {
        $this->context->controller->addCSS($this->_path.'views/css/back.css');

        if (Tools::isSubmit('resetColors')) {
            $this->processResetColors();
        } elseif (Tools::isSubmit('submitColors')) {
            $this->processSaveColors();
        } elseif (Tools::isSubmit('submitCSS')) {
            $this->processSaveCustomCSS();
        }

        $this->smarty->assign(array(
            'alert' => $this->html,
            'groups' => $this->groups,
            'action' => Tools::getValue('action', 'general'),
            'panel_href' => AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'doc_url' => $this->_path.'documentation.pdf',
            'settings_form' => $this->renderSettingsForm(),
        ));

        return $this->display(__FILE__, 'views/templates/admin/settings_form.tpl');
    }

    protected function processResetColors()
    {
        $settings = ZColorsFonts::getSettingsByShop();
        $group = Tools::getValue('action', 'general');

        $settings->$group = null;

        if ($group == 'fonts') {
            $settings->fonts_import = null;
        }

        $result = $settings->validateFields(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation(sprintf($this->l('%s reset successfully.'), Tools::strtoupper($group)));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveColors()
    {
        $settings = ZColorsFonts::getSettingsByShop();
        $group = Tools::getValue('action', 'general');

        $xml_colors = Tools::simplexml_load_file(dirname(__FILE__).'/selector.xml');
        if (isset($xml_colors->$group)) {
            $new_values = array();
            foreach ($xml_colors->$group->variable as $v) {
                $value = Tools::getValue((string) $v['name'], false);
                if ($value && $value != (string) $v['default']) {
                    $new_values[(string) $v['name']] = $value;
                }
                if (isset($v['overwrite']) && isset($v['overwrite_variable'])) {
                    $og = (string) $v['overwrite'];
                    $ogv = (string) $v['overwrite_variable'];
                    if (isset($settings->$og)) {
                        $sg = $settings->$og;
                        if (isset($sg[$ogv]) && $sg[$ogv] != (string) $v['default']) {
                            $new_values[(string) $v['name']] = $value;
                        }
                    }
                }
            }

            $settings->$group = $new_values;
        }

        if ($group == 'fonts') {
            $font_import = Tools::getValue('fonts_import', null);
            if ($font_import != $this->default_font) {
                $settings->fonts_import = $font_import;
            }
        }

        if ($group == 'general') {
            Configuration::updateGlobalValue('ZONE_COLORS_LIVE_PREVIEW', Tools::getValue('ZONE_COLORS_LIVE_PREVIEW'));
        }

        $result = $settings->validateFields(false);

        if ($result) {
            if (empty($settings->$group)) {
                $settings->$group = null;
            }
            $settings->save();

            $this->html .= $this->displayConfirmation(sprintf($this->l('%s updated successfully.'), Tools::strtoupper($group)));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Settings.'));
        }

        return $result;
    }

    protected function processSaveCustomCSS()
    {
        $settings = ZColorsFonts::getSettingsByShop();

        $settings->custom_css = Tools::getValue('custom_css');

        $result = $settings->validateFields(false);

        if ($result) {
            $settings->save();

            $this->html .= $this->displayConfirmation($this->l('Custom CSS has been save successfully.'));

            $this->_clearCache('*');
        } else {
            $this->html .= $this->displayError($this->l('An error occurred while attempting to save Custom CSS.'));
        }

        return $result;
    }

    protected function renderSettingsForm()
    {
        $group = Tools::getValue('action', 'general');

        if ($group == 'custom_css') {
            $result = $this->renderCustomCSSForm();
        } else {
            $result = $this->renderColorsForm($group);
        }

        return $result;
    }

    protected function renderColorsForm($group)
    {
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitColors';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getColorsFieldsValues($group),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getColorsForm($group)));
    }

    protected function getColorsForm($group)
    {
        $fields_form_input = array();
        $default_type = 'color';
        $title = $group.' - Colors';

        if ($group == 'fonts') {
            $title = $group;

            $normal_fonts_html = '<p>';
            foreach ($this->normal_fonts as $font) {
                $normal_fonts_html .= '- '.$font.'<br/>';
            }
            $normal_fonts_html .= '...';

            $fields_form_input[] = array(
                'type' => 'html',
                'label' => $this->l('Most Popular Fonts'),
                'name' => $normal_fonts_html,
                'desc' => $this->l('Copy the font name and paste in the font option'),
                'form_group_class' => 'odd',
            );

            $fields_form_input[] = array(
                'type' => 'textarea',
                'label' => $this->l('Import Fonts'),
                'name' => 'fonts_import',
                'desc' => $this->l('Add the stylesheet link into your website').'. E.g. <a href="https://fonts.google.com/" target="_blank">Google Fonts</a>',
                'form_group_class' => 'odd',
            );

            $default_type = 'text';
        }

        $xml_colors = Tools::simplexml_load_file(dirname(__FILE__).'/selector.xml');
        $class = 'odd';
        if (isset($xml_colors->$group)) {
            foreach ($xml_colors->$group->variable as $v) {
                $type = $default_type;
                if (isset($v['type'])) {
                    $type = (string) $v['type'];
                }
                if (!isset($v['not_change_group_class'])) {
                    $class = ($class == 'even' ? 'odd' : 'even');
                }

                if ($type == 'switch') {
                    $fields_form_input[] = array(
                        'type' => $type,
                        'label' => (string) $v['label'],
                        'name' => (string) $v['name'],
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'value' => true,
                                'id' => ((string) $v['name']).'_on',
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'value' => false,
                                'id' => ((string) $v['name']).'_off',
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            ),
                        ),
                        'desc' => (string) $v['desc'],
                        'form_group_class' => $class,
                    );
                } else {
                    $fields_form_input[] = array(
                        'type' => $type,
                        'label' => (string) $v['label'],
                        'name' => (string) $v['name'],
                        'desc' => (string) $v['desc'],
                        'form_group_class' => $class,
                    );
                }
            }
        }
        
        if ($group == 'general') {
            $class = 'live-preview';
            $fields_form_input[] = array(
                'type' => 'switch',
                'label' => $this->l('Live Preview'),
                'name' => 'ZONE_COLORS_LIVE_PREVIEW',
                'is_bool' => true,
                'values' => array(
                    array(
                        'value' => true,
                        'id' => 'live_preview_on',
                        'label' => $this->trans('Yes', array(), 'Admin.Global')
                    ),
                    array(
                        'value' => false,
                        'id' => 'live_preview_off',
                        'label' => $this->trans('No', array(), 'Admin.Global')
                    )
                ),
                'desc' => $this->l('Display the Live Preview of General Colors on the front-end.'),
                'form_group_class' => $class,
            );
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $title,
                    'icon' => 'icon-cogs',
                ),
                'input' => $fields_form_input,
                'submit' => array(
                    'title' => $this->trans(
                        'Save',
                        array(),
                        'Admin.Actions'
                    ),
                ),
                'buttons' => array(
                    array(
                        'href' => $this->currentIndex.'&resetColors&token='.Tools::getAdminTokenLite('AdminModules'),
                        'title' => $this->l('Reset to default'),
                        'icon' => 'process-icon-refresh',
                        'js' => "if (confirm('Reset ".Tools::strtoupper($group)." to defaut?')){return true;}else{event.stopPropagation(); event.preventDefault();};",
                    ),
                ),
            ),
        );

        return $fields_form;
    }

    protected function getColorsFieldsValues($group)
    {
        $settings = ZColorsFonts::getSettingsByShop();
        $new_colors = $settings->$group;
        $fields_value = array();

        if ($group == 'fonts') {
            $default_fonts_import = $settings->fonts_import ? $settings->fonts_import : $this->default_font;
            $fields_value['fonts_import'] = Tools::getValue('fonts_import', $default_fonts_import);
        }

        if ($group == 'general') {
            $fields_value['ZONE_COLORS_LIVE_PREVIEW'] = Configuration::getGlobalValue('ZONE_COLORS_LIVE_PREVIEW');
        }

        $xml_colors = Tools::simplexml_load_file(dirname(__FILE__).'/selector.xml');
        if (isset($xml_colors->$group)) {
            foreach ($xml_colors->$group->variable as $v) {
                $default_value = isset($new_colors[(string) $v['name']]) ? $new_colors[(string) $v['name']] : (string) $v['default'];
                $fields_value[(string) $v['name']] = Tools::getValue((string) $v['name'], $default_value);
            }
        }

        return $fields_value;
    }

    protected function renderCustomCSSForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Custom CSS'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Custom CSS'),
                        'name' => 'custom_css',
                        'desc' => $this->l('Add special stylesheet for your site.'),
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

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->module = $this;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCSS';
        $helper->currentIndex = $this->currentIndex;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $settings = ZColorsFonts::getSettingsByShop();
        $fields_value = array(
            'custom_css' => Tools::getValue('custom_css', $settings->custom_css),
        );

        $helper->tpl_vars = array(
            'fields_value' => $fields_value,
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function hookDisplayHeader()
    {
        $templateFile = 'module:zonecolorsfonts/views/templates/hook/zonecolorsfonts.tpl';
        $cacheId = $this->name.'|customcss';

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $settings = ZColorsFonts::getSettingsByShop();
            $xml_colors = Tools::simplexml_load_file(dirname(__FILE__).'/selector.xml');
            $color_style = '';
            $colorClass = new ZCSSColor();

            foreach ($this->groups as $group) {
                if (isset($settings->$group) && isset($xml_colors->$group)) {
                    $new_colors = $settings->$group;
                    $xml_group = $xml_colors->$group;
                    foreach ($xml_group->variable as $v) {
                        if (isset($new_colors[(string) $v['name']]) && isset($v->style)) {
                            foreach ($v->style as $s) {
                                $value = $new_colors[(string) $v['name']];
                                if (isset($s['lighten'])) {
                                    $value = $colorClass->lighten($value, (int) $s['lighten']);
                                }
                                if (isset($s['darken'])) {
                                    $value = $colorClass->darken($value, (int) $s['darken']);
                                }
                                if (isset($s['box-shadow'])) {
                                    $value = ((string) $s['box-shadow']).' '.$value;
                                }

                                $color_style .= $s->selector.' {'.$s->property.': '.$value.'} ';
                            }
                        }
                    }
                }
            }
            
            $style_link = false;
            if (isset($settings->fonts_import) && $settings->fonts_import) {
                $style_link = $settings->fonts_import;
            }

            $custom_css = $settings->custom_css;

            $this->smarty->assign(array(
                'colorStyle' => $color_style,
                'styleLink' => $style_link,
                'zoneCustomCSS' => $custom_css,
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }

    public function hookDisplayBeforeBodyClosingTag()
    {
        return $this->hookDisplayOutsideMainPage();
    }

    public function hookDisplayOutsideMainPage()
    {
        if ($this->context->isMobile()) {
            return;
        }

        $templateFile = 'module:zonecolorsfonts/views/templates/hook/zonecolorsfonts_preview.tpl';
        $cacheId = $this->name.'|livepreview';

        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $this->smarty->assign(array(
                'active_preview' => (Configuration::getGlobalValue('ZONE_COLORS_LIVE_PREVIEW')),
                'preview_controller' => $this->context->link->getModuleLink($this->name, 'preview', array(), true),
            ));
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }
}
