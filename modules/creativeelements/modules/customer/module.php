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

use CE\CoreXBaseXModule as BaseModule;
use CE\ModulesXThemeXWidgetsXPageTitle as PageTitle;

class ModulesXCustomerXModule extends BaseModule
{
    public function getName()
    {
        return 'customer';
    }

    public function registerDocuments($documents)
    {
        $documents->registerDocumentType('page-authentication', 'CE\ModulesXCustomerXDocumentsXPageAuthentication');
        $documents->registerDocumentType('page-password', 'CE\ModulesXCustomerXDocumentsXPagePassword');
        $documents->registerDocumentType('page-registration', 'CE\ModulesXCustomerXDocumentsXPageRegistration');
    }

    public function registerWidgets($widgets_manager)
    {
        $widgets_manager->registerWidgetType(new PageTitle([], null, [
            'categories' => ['customer-elements'],
        ]));
    }

    public function __construct()
    {
        add_action('elementor/documents/register', [$this, 'registerDocuments']);
        add_action('elementor/widgets/widgets_registered', [$this, 'registerWidgets']);
    }
}
