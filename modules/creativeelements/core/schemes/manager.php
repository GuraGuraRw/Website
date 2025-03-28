<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks, Elementor
 * @copyright 2019-2024 WebshopWorks.com & Elementor.com
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

use CE\CoreXCommonXModulesXAjaxXModule as Ajax;
use CE\CoreXSchemesXBaseUI as BaseUI;
use CE\TemplateLibraryXSourceLocal as SourceLocal;

/**
 * Elementor scheme manager.
 *
 * Elementor scheme manager handler class is responsible for registering and
 * initializing all the supported schemes.
 *
 * @since 1.0.0
 */
class CoreXSchemesXManager
{
    /**
     * Registered schemes.
     *
     * Holds the list of all the registered schemes.
     *
     * @var Base[]
     */
    protected $_registered_schemes = [];

    /**
     * Enabled schemes.
     *
     * Holds the list of all the enabled schemes.
     *
     * @static
     *
     * @var array
     */
    private static $_enabled_schemes;

    /**
     * Schemes types.
     *
     * Holds the list of the schemes types. Default types are `color`,
     * `typography` and `color-picker`.
     *
     * @static
     *
     * @var array
     */
    private static $_schemes_types = [
        'color',
        'typography',
        'color-picker',
    ];

    /**
     * Register new scheme.
     *
     * Add a new scheme to the schemes list. The method creates a new scheme
     * instance for any given scheme class and adds the scheme to the registered
     * schemes list.
     *
     * @since 1.0.0
     *
     * @param string $scheme_class Scheme class name
     */
    public function registerScheme($scheme_class)
    {
        /* @var Base $scheme_instance */
        $scheme_instance = new $scheme_class();

        $this->_registered_schemes[$scheme_instance::getType()] = $scheme_instance;
    }

    /**
     * Unregister scheme.
     *
     * Removes a scheme from the list of registered schemes.
     *
     * @since 1.0.0
     *
     * @param string $id Scheme ID
     *
     * @return bool True if the scheme was removed, False otherwise
     */
    public function unregisterScheme($id)
    {
        if (!isset($this->_registered_schemes[$id])) {
            return false;
        }
        unset($this->_registered_schemes[$id]);

        return true;
    }

    /**
     * Get registered schemes.
     *
     * Retrieve the registered schemes list from the current instance.
     *
     * @since 1.0.0
     *
     * @return Base[] Registered schemes
     */
    public function getRegisteredSchemes()
    {
        return $this->_registered_schemes;
    }

    /**
     * Get schemes data.
     *
     * Retrieve all the registered schemes with data for each scheme.
     *
     * @since 1.0.0
     *
     * @return array Registered schemes with each scheme data
     */
    public function getRegisteredSchemesData()
    {
        $data = [];

        foreach ($this->getRegisteredSchemes() as $scheme) {
            $type = $scheme::getType();

            $data[$type] = [
                'items' => $scheme->getScheme(),
            ];

            if ($scheme instanceof BaseUI) {
                $data[$type]['title'] = $scheme->getTitle();
                $data[$type]['disabled_title'] = $scheme->getDisabledTitle();
            }
        }

        return $data;
    }

    /**
     * Get default schemes.
     *
     * Retrieve all the registered schemes with default scheme for each scheme.
     *
     * @since 1.0.0
     *
     * @return array Registered schemes with with default scheme for each scheme
     */
    public function getSchemesDefaults()
    {
        $data = [];

        foreach ($this->getRegisteredSchemes() as $scheme) {
            $type = $scheme::getType();

            $data[$type] = [
                'items' => $scheme->getDefaultScheme(),
            ];

            if ($scheme instanceof BaseUI) {
                $data[$type]['title'] = $scheme->getTitle();
            }
        }

        return $data;
    }

    /**
     * Get system schemes.
     *
     * Retrieve all the registered ui schemes with system schemes for each scheme.
     *
     * @since 1.0.0
     *
     * @return array Registered ui schemes with with system scheme for each scheme
     */
    public function getSystemSchemes()
    {
        $data = [];

        foreach ($this->getRegisteredSchemes() as $scheme) {
            if ($scheme instanceof BaseUI) {
                $data[$scheme::getType()] = $scheme->getSystemSchemes();
            }
        }

        return $data;
    }

    /**
     * Get scheme.
     *
     * Retrieve a single scheme from the list of all the registered schemes in
     * the current instance.
     *
     * @since 1.0.0
     *
     * @param string $id Scheme ID
     *
     * @return false|Base Scheme instance if scheme exist, False otherwise
     */
    public function getScheme($id)
    {
        $schemes = $this->getRegisteredSchemes();

        if (!isset($schemes[$id])) {
            return false;
        }

        return $schemes[$id];
    }

    /**
     * Get scheme value.
     *
     * Retrieve the scheme value from the list of all the registered schemes in
     * the current instance.
     *
     * @since 1.0.0
     *
     * @param string $scheme_type Scheme type
     * @param string $scheme_value Scheme value
     *
     * @return false|string Scheme value if scheme exist, False otherwise
     */
    public function getSchemeValue($scheme_type, $scheme_value)
    {
        $scheme = $this->getScheme($scheme_type);

        if (!$scheme) {
            return false;
        }

        return $scheme->getSchemeValue()[$scheme_value];
    }

    /**
     * Ajax apply scheme.
     *
     * Ajax handler for Elementor apply_scheme.
     *
     * Fired by `wp_ajax_elementor_apply_scheme` action.
     *
     * @since 1.0.0
     *
     * @param array $data
     *
     * @return bool
     */
    public function ajaxApplyScheme(array $data)
    {
        if (!User::isCurrentUserCanEditPostType(SourceLocal::CPT)) {
            return false;
        }

        if (!isset($data['scheme_name'])) {
            return false;
        }

        $scheme_obj = $this->getScheme($data['scheme_name']);

        if (!$scheme_obj) {
            return false;
        }

        $posted = json_decode($data['data'], true);

        $scheme_obj->saveScheme($posted);

        return true;
    }

    /**
     * Print ui schemes templates.
     *
     * Used to generate the scheme templates on the editor using Underscore JS
     * template, for all the registered ui schemes.
     *
     * @since 1.0.0
     */
    public function printSchemesTemplates()
    {
        foreach ($this->getRegisteredSchemes() as $scheme) {
            if ($scheme instanceof BaseUI) {
                $scheme->printTemplate();
            }
        }
    }

    /**
     * @param Ajax $ajax
     *
     * @since 2.3.0
     */
    public function registerAjaxActions(Ajax $ajax)
    {
        $ajax->registerAjaxAction('apply_scheme', [$this, 'ajaxApplyScheme']);
    }

    /**
     * Get enabled schemes.
     *
     * Retrieve all enabled schemes from the list of the registered schemes in
     * the current instance.
     *
     * @since 1.0.0
     * @static
     *
     * @return array Enabled schemes
     */
    public static function getEnabledSchemes()
    {
        if (null === self::$_enabled_schemes) {
            $enabled_schemes = [];

            foreach (self::$_schemes_types as $schemes_type) {
                if (get_option('elementor_disable_' . $schemes_type . '_schemes')) {
                    continue;
                }
                $enabled_schemes[] = $schemes_type;
            }

            // $enabled_schemes = apply_filters('elementor/schemes/enabled_schemes', $enabled_schemes);

            self::$_enabled_schemes = $enabled_schemes;
        }

        return self::$_enabled_schemes;
    }

    /**
     * Register default schemes.
     *
     * Add a default schemes to the register schemes list.
     *
     * This method is used to set initial schemes when initializing the class.
     *
     * @since 1.7.12
     */
    private function registerDefaultSchemes()
    {
        foreach (self::$_schemes_types as $scheme_type) {
            $this->registerScheme(__NAMESPACE__ . '\CoreXSchemesX' . str_replace('-', '', ucwords($scheme_type, '-')));
        }
    }

    /**
     * Schemes manager constructor.
     *
     * Initializing Elementor schemes manager and register default schemes.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->registerDefaultSchemes();

        add_action('elementor/ajax/register_actions', [$this, 'registerAjaxActions']);
    }
}
