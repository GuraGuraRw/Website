<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

use CE\ModulesXCustomerXWidgetsXAccountLink as AccountLink;
use CE\ModulesXCustomerXWidgetsXRegisterForm as RegisterForm;
use CE\ModulesXThemeXDocumentsXThemePageDocument as ThemePageDocument;

class ModulesXCustomerXDocumentsXPageRegistration extends ThemePageDocument
{
    public function getName()
    {
        return 'page-registration';
    }

    public static function getTitle()
    {
        return __('Registration Page');
    }

    protected function getRemoteLibraryConfig()
    {
        $config = parent::getRemoteLibraryConfig();

        $config['category'] = 'registration';

        return $config;
    }

    protected static function getEditorPanelCategories()
    {
        return [
            'customer-elements' => ['title' => __('Customer')],
        ] + parent::getEditorPanelCategories();
    }

    protected function getPermalinkUrl($id_lang, $id_shop, array $args, $relative = true)
    {
        if ((int) _PS_VERSION_ < 8) {
            $page = 'authentication';
            $args = ['create_account' => 1] + $args;
        } else {
            $page = 'registration';
        }

        return Helper::$link->getPageLink($page, true, $id_lang, $args, false, $id_shop, $relative);
    }

    public static function registerWidgets($widgets_manager)
    {
        $widgets_manager->registerWidgetType(new RegisterForm());
        $widgets_manager->registerWidgetType(new AccountLink([], null, [
            'title' => __('Login Link'),
            'keywords' => ['log in', 'sign in', 'link'],
            'icon_list_default' => [
                [
                    'text' => Helper::$translator->trans('Already have an account?', [], 'Shop.Theme.Customeraccount'),
                    'selected_icon' => [
                        'value' => '',
                        'library' => '',
                    ],
                ],
                [
                    '__dynamic__' => [
                        'link' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'internal-url', ['type' => 'authentication']),
                    ],
                    'text' => Helper::$translator->trans('Log in instead!', [], 'Shop.Theme.Customeraccount'),
                    'selected_icon' => [
                        'value' => 'fas fa-arrow-right-to-bracket',
                        'library' => 'fa-solid',
                    ],
                ],
            ],
        ]));
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        did_action('elementor/widgets/widgets_registered')
            ? static::registerWidgets(Plugin::$instance->widgets_manager)
            : add_action('elementor/widgets/widgets_registered', [static::class, 'registerWidgets']);

        if (!_CE_ADMIN_ && version_compare(_PS_VERSION_, '1.7.7', '<')) {
            // BC Fix for Breadcrumb & Page Title
            $vars = &$GLOBALS['smarty']->tpl_vars;
            $breadcrumb = &$vars['breadcrumb']->value;
            $breadcrumb['links'][1] = [
                'title' => __('Create an account', 'Shop.Theme.Customeraccount'),
                'url' => $vars['urls']->value['pages']['register'],
            ];
            $breadcrumb['count'] = 2;
        }
    }
}
