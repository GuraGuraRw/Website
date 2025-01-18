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

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\ObjectPresenter;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;

class ZOneFeaturedCategories extends Module implements WidgetInterface
{
    protected $is_mobile;
    protected $settings = array(
        'enableSlider' => true,
        'enableSliderMobile' => false,
        'categoriesPerRow' => 4,
        'imageName' => 'category_home',
        'featuredCategories' => array(),
        'layoutStyle' => 'medium',
        'subCategoriesLimit' => 10,
    );

    public function __construct()
    {
        $this->name = 'zonefeaturedcategories';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ZelaTheme';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Z.One - Featured Categories');
        $this->description = $this->l('Displays featured Categories on the Homepage.');

        $this->is_mobile = ($this->context->isMobile()  && !$this->context->isTablet());
    }

    private function installSample()
    {
        $sql_cats = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT *
            FROM `'._DB_PREFIX_.'category` c
            '.Shop::addSqlAssociation('category', 'c').'
            WHERE c.`id_parent` != 0 AND c.`id_parent` != 1
            AND `active` = 1
            ORDER BY c.`id_parent` ASC
            LIMIT 3'
        );
        if ($sql_cats) {
            $array_cats = array();
            foreach ($sql_cats as $row) {
                $array_cats[] = $row['id_category'];
            }
            $afc_settings = Tools::unSerialize(Configuration::get('ZONEFEATUREDCATEGORIES_SETTINGS', null, null, null, 'a:0:{}'));
            $afc_settings['featuredCategories'] = $array_cats;
            Configuration::updateValue('ZONEFEATUREDCATEGORIES_SETTINGS', serialize($afc_settings));
        }

        return true;
    }

    public function install()
    {
        Configuration::updateValue('ZONEFEATUREDCATEGORIES_SETTINGS', serialize($this->settings));

        if (!$this->installSample()) {
            return false;
        }

        return parent::install()
            && $this->registerHook('categoryAddition')
            && $this->registerHook('categoryUpdate')
            && $this->registerHook('categoryDeletion')
            && $this->registerHook('displayBottomColumn')
        ;
    }

    public function uninstall()
    {
        Configuration::deleteByName('ZONEFEATUREDCATEGORIES_SETTINGS');

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
        $this->context->controller->addJS($this->_path.'views/js/back.js');
        $this->context->controller->addCSS($this->_path.'views/css/back.css');
    }

    public function getContent()
    {
        $this->backOfficeHeader();

        $about = $this->about();

        if (Tools::isSubmit('submitSettings')) {
            $this->processSaveSettings();

            return $this->displayConfirmation($this->l('Settings updated')).$this->renderSettingsForm().$about;
        } else {
            return $this->renderSettingsForm().$about;
        }
    }

    protected function processSaveSettings()
    {
        $settings = array(
            'enableSlider' => Tools::getValue('enableSlider'),
            'enableSliderMobile' => Tools::getValue('enableSliderMobile'),
            'categoriesPerRow' => (int)Tools::getValue('categoriesPerRow'),
            'imageName' => Tools::getValue('imageName', ImageType::getFormattedName('category')),
            'featuredCategories' => Tools::getValue('featuredCategories', array()),
            'layoutStyle' => Tools::getValue('layoutStyle'),
            'subCategoriesLimit' => (int)Tools::getValue('subCategoriesLimit'),
        );

        Configuration::updateValue('ZONEFEATUREDCATEGORIES_SETTINGS', serialize($settings));

        $this->_clearCache('*');
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

        $form = $helper->generateForm(array($this->getSettingsForm()));

        Context::getContext()->smarty->assign('token', Tools::getAdminTokenLite('AdminModules'));
        
        return $form;
    }

    protected function getSettingsForm()
    {
        $categories_per_row_options = array(
            'query' => array(
                array('id' => 2, 'name' => 2),
                array('id' => 3, 'name' => 3),
                array('id' => 4, 'name' => 4),
            ),
            'id' => 'id',
            'name' => 'name'
        );
        $layout_style_options = array(
            'query' => array(
                array('id' => 'small', 'name' => $this->l('Category and Thumbnail')),
                array('id' => 'medium', 'name' => $this->l('Category, Thumbnail and Subcategories')),
            ),
            'id' => 'id',
            'name' => 'name'
        );

        $selected_categories = array();
        $settings = array_merge(
            $this->settings,
            Tools::unSerialize(Configuration::get('ZONEFEATUREDCATEGORIES_SETTINGS', null, null, null, 'a:0:{}'))
        );
        if (isset($settings['featuredCategories'])) {
            $selected_categories = $settings['featuredCategories'];
        }

        $cats_images_types = ImageType::getImagesTypes('categories');
        if ($cats_images_types) {
            foreach ($cats_images_types as &$cit) {
                $cit['label'] = $cit['name'].' ('.$cit['width'].'x'.$cit['height'].'px)';
            }
        } else {
            $cats_images_types = array(array('name' => '', 'label' => $this->l('Not found!')));
        }

        $image_name_options = array(
            'query' => $cats_images_types,
            'id' => 'name',
            'name' => 'label'
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Slider'),
                        'name' => 'enableSlider',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enableSlider_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'id' => 'enableSlider_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Slider on Mobile'),
                        'name' => 'enableSliderMobile',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enableSliderMobile_on',
                                'value' => true,
                                'label' => $this->trans('Yes', array(), 'Admin.Global')
                            ),
                            array(
                                'id' => 'enableSliderMobile_off',
                                'value' => false,
                                'label' => $this->trans('No', array(), 'Admin.Global')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Categories per Row'),
                        'name' => 'categoriesPerRow',
                        'options' => $categories_per_row_options,
                        'hint' => $this->l('The number of category block per row.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Category Image Type'),
                        'name' => 'imageName',
                        'options' => $image_name_options,
                    ),
                    array(
                        'type' => 'categories',
                        'label' => $this->l('Category Selection'),
                        'name' => 'featuredCategories',
                        'tree' => array(
                            'use_search' => false,
                            'id' => 'featuredCategories',
                            'use_checkbox' => true,
                            'selected_categories' => $selected_categories,
                        ),
                        'form_group_class' => 'categories_tree',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Layout Style'),
                        'name' => 'layoutStyle',
                        'options' => $layout_style_options,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Number of Subcategories'),
                        'name' => 'subCategoriesLimit',
                        'hint' => $this->l('Limit number of subcategories of a category. If set to zero, no limit is imposed.'),
                        'col' => 1,
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans(
                        'Save',
                        array(),
                        'Admin.Actions'
                    ),
                )
            ),
        );

        return $fields_form;
    }

    protected function getSettingsFieldsValues()
    {
        $settings = array_merge(
            $this->settings,
            Tools::unSerialize(Configuration::get('ZONEFEATUREDCATEGORIES_SETTINGS', null, null, null, 'a:0:{}'))
        );

        $fields_value = array(
            'enableSlider' => Tools::getValue('enableSlider', $settings['enableSlider']),
            'enableSliderMobile' => Tools::getValue('enableSliderMobile', $settings['enableSliderMobile']),
            'categoriesPerRow' => Tools::getValue('categoriesPerRow', $settings['categoriesPerRow']),
            'imageName' => Tools::getValue('imageName', $settings['imageName']),
            'layoutStyle' => Tools::getValue('layoutStyle', $settings['layoutStyle']),
            'subCategoriesLimit' => Tools::getValue('subCategoriesLimit', $settings['subCategoriesLimit']),
        );

        return $fields_value;
    }

    public function hookCategoryAddition()
    {
        $this->_clearCache('*');
    }

    public function hookCategoryUpdate()
    {
        $this->_clearCache('*');
    }

    public function hookCategoryDeletion()
    {
        $this->_clearCache('*');
    }

    public function getWidgetVariables($hookName = null, array $configuration = array())
    {
        $id_lang = (int)$this->context->language->id;
        $settings = array_merge(
            $this->settings,
            Tools::unSerialize(Configuration::get('ZONEFEATUREDCATEGORIES_SETTINGS', null, null, null, 'a:0:{}'))
        );
        $featured_categories = false;

        if (!ImageType::typeAlreadyExists($settings['imageName']) && $settings['imageName'] == 'category_home') {
            $image_type = new ImageType();
            $image_type->name = 'category_home';
            $image_type->width = 384;
            $image_type->height = 150;
            $image_type->products = false;
            $image_type->manufacturers = false;
            $image_type->suppliers = false;
            $image_type->stores = false;
            $image_type->categories = true;
            $image_type->save();
        }

        if (!empty($settings['featuredCategories']) && is_array($settings['featuredCategories'])) {
            $objectPresenter = new ObjectPresenter();
            $retriever = new ImageRetriever($this->context->link);
            $featured_categories = array();

            foreach ($settings['featuredCategories'] as $id_category) {
                $object_category = new Category($id_category, $id_lang);

                if (Validate::isLoadedObject($object_category)) {
                    $category = $objectPresenter->present($object_category);

                    $image = $retriever->getImage($object_category, $object_category->id_image);
                    if (isset($image['bySize'][$settings['imageName']])) {
                        $category['image'] = $image['bySize'][$settings['imageName']];
                    } elseif (isset($image['medium'])) {
                        $category['image'] = $image['medium'];
                    } else {
                        $category['image'] = false;
                    }

                    $category['url'] = $this->context->link->getCategoryLink(
                        $object_category->id_category,
                        $object_category->link_rewrite
                    );

                    $subCategories = false;
                    if ($settings['layoutStyle'] == 'medium') {
                        $subCategories = $object_category->getSubCategories($id_lang);
                        if ((int)$settings['subCategoriesLimit']) {
                            $subCategories = array_slice($subCategories, 0, (int)$settings['subCategoriesLimit']);
                        }

                        if ($subCategories) {
                            foreach ($subCategories as &$sub) {
                                $sub['url'] = $this->context->link->getCategoryLink(
                                    $sub['id_category'],
                                    $sub['link_rewrite']
                                );
                            }
                        }
                    }

                    $featured_categories[] = array(
                        'category' => $category,
                        'subCategories' => $subCategories,
                    );
                }
            }
        }

        $enable_slider = $settings['enableSlider'];
        if ($this->is_mobile && isset($settings['enableSliderMobile'])) {
            $enable_slider = $settings['enableSliderMobile'];
        }

        $this->smarty->assign(array(
            'enableSlider' => $enable_slider,
            'categoriesPerRow' => $settings['categoriesPerRow'],
            'featuredCategories' => $featured_categories,
            'hookName' => $hookName,
            'mobile_device' => $this->is_mobile,
        ));
    }

    public function renderWidget($hookName = null, array $configuration = array())
    {
        $templateFile = 'module:zonefeaturedcategories/views/templates/hook/zonefeaturedcategories.tpl';
        $cacheId = $this->name.'|'.$hookName.'|'.'device'.(int) $this->is_mobile;
        
        if (!$this->isCached($templateFile, $this->getCacheId($cacheId))) {
            $this->getWidgetVariables($hookName, $configuration);
        }

        return $this->fetch($templateFile, $this->getCacheId($cacheId));
    }
}
