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

use CE\CoreXBaseXBaseObject as BaseObject;
use CE\CoreXSchemesXManager as SchemesManager;

/**
 * Elementor controls stack.
 *
 * An abstract class that provides the needed properties and methods to
 * manage and handle controls in the editor panel to inheriting classes.
 *
 * @since 1.4.0
 * @abstract
 */
abstract class ControlsStack extends BaseObject
{
    /**
     * Responsive 'desktop' device name.
     */
    const RESPONSIVE_DESKTOP = 'desktop';

    /**
     * Responsive 'tablet' device name.
     */
    const RESPONSIVE_TABLET = 'tablet';

    /**
     * Responsive 'mobile' device name.
     */
    const RESPONSIVE_MOBILE = 'mobile';

    /**
     * Generic ID.
     *
     * Holds the unique ID.
     *
     * @var string
     */
    private $id;

    private $active_settings;

    private $parsed_active_settings;

    /**
     * Parsed Dynamic Settings.
     *
     * @var array|null
     */
    private $parsed_dynamic_settings;

    /**
     * Raw Data.
     *
     * Holds all the raw data including the element type, the child elements,
     * the user data.
     *
     * @var array|null
     */
    private $data;

    /**
     * The configuration.
     *
     * Holds the configuration used to generate the Elementor editor. It includes
     * the element name, icon, categories, etc.
     *
     * @var array|null
     */
    private $config;

    /**
     * Current section.
     *
     * Holds the current section while inserting a set of controls sections.
     *
     * @var array|null
     */
    private $current_section;

    /**
     * Current tab.
     *
     * Holds the current tab while inserting a set of controls tabs.
     *
     * @var array|null
     */
    private $current_tab;

    /**
     * Current popover.
     *
     * Holds the current popover while inserting a set of controls.
     *
     * @var array|null
     */
    private $current_popover;

    /**
     * Injection point.
     *
     * Holds the injection point in the stack where the control will be inserted.
     *
     * @var array|null
     */
    private $injection_point;

    /**
     * Data sanitized.
     *
     * @var bool
     */
    private $settings_sanitized = false;

    /**
     * Get element name.
     *
     * Retrieve the element name.
     *
     * @since 1.4.0
     * @abstract
     *
     * @return string The name
     */
    abstract public function getName();

    /**
     * Get unique name.
     *
     * Some classes need to use unique names, this method allows you to create
     * them. By default it retrieves the regular name.
     *
     * @since 1.6.0
     *
     * @return string Unique name
     */
    public function getUniqueName()
    {
        return $this->getName();
    }

    /**
     * Get element ID.
     *
     * Retrieve the element generic ID.
     *
     * @since 1.4.0
     *
     * @return string The ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get element ID.
     *
     * Retrieve the element generic ID as integer.
     *
     * @since 1.8.0
     *
     * @return string The converted ID
     */
    public function getIdInt()
    {
        return hexdec($this->id);
    }

    /**
     * Get the type.
     *
     * Retrieve the type, e.g. 'stack', 'section', 'widget' etc.
     *
     * @since 1.4.0
     * @static
     *
     * @return string The type
     */
    public static function getType()
    {
        return 'stack';
    }

    /**
     * @since 2.9.0
     *
     * @return bool
     */
    public function isEditable()
    {
        return true;
    }

    /**
     * Get current section.
     *
     * When inserting new controls, this method will retrieve the current section.
     *
     * @since 1.7.1
     *
     * @return array|null Current section
     */
    public function getCurrentSection()
    {
        return $this->current_section;
    }

    /**
     * Get current tab.
     *
     * When inserting new controls, this method will retrieve the current tab.
     *
     * @since 1.7.1
     *
     * @return array|null Current tab
     */
    public function getCurrentTab()
    {
        return $this->current_tab;
    }

    /**
     * Get controls.
     *
     * Retrieve all the controls or, when requested, a specific control.
     *
     * @since 1.4.0
     *
     * @param string $control_id The ID of the requested control. Optional field,
     *                           when set it will return a specific control.
     *                           Default is null.
     *
     * @return mixed Controls list
     */
    public function getControls($control_id = null)
    {
        return self::getItems($this->getStack()['controls'], $control_id);
    }

    /**
     * Get active controls.
     *
     * Retrieve an array of active controls that meet the condition field.
     *
     * If specific controls was given as a parameter, retrieve active controls
     * from that list, otherwise check for all the controls available.
     *
     * @since 1.4.0
     * @since 2.0.9 Added the `controls` and the `settings` parameters.
     *
     * @param array $controls Optional. An array of controls. Default is an empty array
     * @param array $settings Optional. Controls settings. Default is an empty array
     *
     * @return array Active controls
     */
    public function getActiveControls(array $controls = [], array $settings = [])
    {
        if (!$controls) {
            $controls = $this->getControls();
        }

        if (!$settings) {
            $settings = $this->getControlsSettings();
        }

        $active_controls = array_reduce(
            array_keys($controls),
            function ($active_controls, $control_key) use ($controls, $settings) {
                $control = $controls[$control_key];

                if ($this->isControlVisible($control, $settings)) {
                    $active_controls[$control_key] = $control;
                }

                return $active_controls;
            },
            []
        );

        return $active_controls;
    }

    /**
     * Get controls settings.
     *
     * Retrieve the settings for all the controls that represent them.
     *
     * @since 1.5.0
     *
     * @return array Controls settings
     */
    public function getControlsSettings()
    {
        return array_intersect_key($this->getSettings(), $this->getControls());
    }

    /**
     * Add new control to stack.
     *
     * Register a single control to allow the user to set/update data.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     *
     * @param string $id Control ID
     * @param array $args Control arguments
     * @param array $options Optional. Control options. Default is an empty array
     *
     * @return bool True if control added, False otherwise
     */
    public function addControl($id, array $args, $options = [])
    {
        $default_options = [
            'overwrite' => false,
            'position' => null,
        ];

        $options = array_merge($default_options, $options);

        if ($options['position']) {
            $this->startInjection($options['position']);
        }

        if ($this->injection_point) {
            $options['index'] = $this->injection_point['index']++;
        }

        if (empty($args['type']) || $args['type'] !== ControlsManager::SECTION) {
            $target_section_args = $this->current_section;

            $target_tab = $this->current_tab;

            if ($this->injection_point) {
                $target_section_args = $this->injection_point['section'];

                if (!empty($this->injection_point['tab'])) {
                    $target_tab = $this->injection_point['tab'];
                }
            }

            if (null !== $target_section_args) {
                if (!empty($args['section']) || !empty($args['tab'])) {
                    _doing_it_wrong(sprintf('%s::%s', get_called_class(), __FUNCTION__), sprintf('Cannot redeclare control with `tab` or `section` args inside section "%s".', $id), '1.0.0');
                }

                $args = array_replace_recursive($target_section_args, $args);

                if (null !== $target_tab) {
                    $args = array_replace_recursive($target_tab, $args);
                }
            } elseif (empty($args['section']) && (!$options['overwrite'] || is_wp_error(Plugin::$instance->controls_manager->getControlFromStack($this->getUniqueName(), $id)))) {
                exit(sprintf('%s::%s: Cannot add a control outside of a section (use `startControlsSection`).', get_called_class(), __FUNCTION__));
            }
        }

        if ($options['position']) {
            $this->endInjection();
        }

        unset($options['position']);

        if ($this->current_popover && !$this->current_popover['initialized']) {
            $args['popover'] = [
                'start' => true,
            ];

            $this->current_popover['initialized'] = true;
        }

        return Plugin::$instance->controls_manager->addControlToStack($this, $id, $args, $options);
    }

    /**
     * Remove control from stack.
     *
     * Unregister an existing control and remove it from the stack.
     *
     * @since 1.4.0
     *
     * @param string $control_id Control ID
     *
     * @return bool|WPError
     */
    public function removeControl($control_id)
    {
        return Plugin::$instance->controls_manager->removeControlFromStack($this->getUniqueName(), $control_id);
    }

    /**
     * Update control in stack.
     *
     * Change the value of an existing control in the stack. When you add new
     * control you set the `$args` parameter, this method allows you to update
     * the arguments by passing new data.
     *
     * @since 1.4.0
     * @since 1.8.1 New `$options` parameter added.
     *
     * @param string $control_id Control ID
     * @param array $args Control arguments. Only the new fields you want
     *                    to update.
     * @param array $options Optional. Some additional options. Default is
     *                       an empty array.
     *
     * @return bool
     */
    public function updateControl($control_id, array $args, array $options = [])
    {
        $is_updated = Plugin::$instance->controls_manager->updateControlInStack($this, $control_id, $args, $options);

        if (!$is_updated) {
            return false;
        }

        $control = $this->getControls($control_id);

        if (ControlsManager::SECTION === $control['type']) {
            $section_args = $this->getSectionArgs($control_id);

            $section_controls = $this->getSectionControls($control_id);

            foreach ($section_controls as $section_control_id => $section_control) {
                $this->updateControl($section_control_id, $section_args, $options);
            }
        }

        return true;
    }

    /**
     * Get stack.
     *
     * Retrieve the stack of controls.
     *
     * @since 1.9.2
     *
     * @return array Stack of controls
     */
    public function getStack()
    {
        $stack = Plugin::$instance->controls_manager->getElementStack($this);

        if (null === $stack) {
            $this->initControls();

            return Plugin::$instance->controls_manager->getElementStack($this);
        }

        return $stack;
    }

    /**
     * Get position information.
     *
     * Retrieve the position while injecting data, based on the element type.
     *
     * @since 1.7.0
     *
     * @param array $position The injection position {
     *
     * @var string $type    injection type, either `control` or `section` Default is `control`
     * @var string $at      Where to inject. If `$type` is `control` accepts `before` and `after`. If `$type` is `section` accepts `start` and `end`. Default values based on the `type`.
     * @var string $of      Control/Section ID
     * @var array $fallback Fallback injection position. When the position is not found it will try to fetch the fallback position.
     *
     * }
     *
     * @return bool|array Position info
     */
    final public function getPositionInfo(array $position)
    {
        $default_position = [
            'type' => 'control',
            'at' => 'after',
        ];

        if (!empty($position['type']) && 'section' === $position['type']) {
            $default_position['at'] = 'end';
        }

        $position = array_merge($default_position, $position);

        if ('control' === $position['type'] && in_array($position['at'], ['start', 'end'], true) || 'section' === $position['type'] && in_array($position['at'], ['before', 'after'], true)) {
            _doing_it_wrong(sprintf('%s::%s', get_called_class(), __FUNCTION__), 'Invalid position arguments. Use `before` / `after` for control or `start` / `end` for section.', '1.7.0');

            return false;
        }

        $target_control_index = $this->getControlIndex($position['of']);

        if (false === $target_control_index) {
            if (!empty($position['fallback'])) {
                return $this->getPositionInfo($position['fallback']);
            }

            return false;
        }

        $target_section_index = $target_control_index;

        $registered_controls = $this->getControls();

        $controls_keys = array_keys($registered_controls);

        while (ControlsManager::SECTION !== $registered_controls[$controls_keys[$target_section_index]]['type']) {
            --$target_section_index;
        }

        if ('section' === $position['type']) {
            ++$target_control_index;

            if ('end' === $position['at']) {
                while (ControlsManager::SECTION !== $registered_controls[$controls_keys[$target_control_index]]['type']) {
                    if (++$target_control_index >= count($registered_controls)) {
                        break;
                    }
                }
            }
        }

        $target_control = $registered_controls[$controls_keys[$target_control_index]];

        if ('after' === $position['at']) {
            ++$target_control_index;
        }

        $section_id = $registered_controls[$controls_keys[$target_section_index]]['name'];

        $position_info = [
            'index' => $target_control_index,
            'section' => $this->getSectionArgs($section_id),
        ];

        if (!empty($target_control['tabs_wrapper'])) {
            $position_info['tab'] = [
                'tabs_wrapper' => $target_control['tabs_wrapper'],
                'inner_tab' => $target_control['inner_tab'],
            ];
        }

        return $position_info;
    }

    /**
     * Get control key.
     *
     * Retrieve the key of the control based on a given index of the control.
     *
     * @since 1.9.2
     *
     * @param string $control_index Control index
     *
     * @return int Control key
     */
    final public function getControlKey($control_index)
    {
        $registered_controls = $this->getControls();

        $controls_keys = array_keys($registered_controls);

        return $controls_keys[$control_index];
    }

    /**
     * Get control index.
     *
     * Retrieve the index of the control based on a given key of the control.
     *
     * @since 1.7.6
     *
     * @param string $control_key Control key
     *
     * @return false|int Control index
     */
    final public function getControlIndex($control_key)
    {
        $controls = $this->getControls();

        $controls_keys = array_keys($controls);

        return array_search($control_key, $controls_keys);
    }

    /**
     * Get section controls.
     *
     * Retrieve all controls under a specific section.
     *
     * @since 1.7.6
     *
     * @param string $section_id Section ID
     *
     * @return array Section controls
     */
    final public function getSectionControls($section_id)
    {
        $section_index = $this->getControlIndex($section_id);

        $section_controls = [];

        $registered_controls = $this->getControls();

        $controls_keys = array_keys($registered_controls);

        while (true) {
            ++$section_index;

            if (!isset($controls_keys[$section_index])) {
                break;
            }

            $control_key = $controls_keys[$section_index];

            if (ControlsManager::SECTION === $registered_controls[$control_key]['type']) {
                break;
            }

            $section_controls[$control_key] = $registered_controls[$control_key];
        }

        return $section_controls;
    }

    /**
     * Add new group control to stack.
     *
     * Register a set of related controls grouped together as a single unified
     * control. For example grouping together like typography controls into a
     * single, easy-to-use control.
     *
     * @since 1.4.0
     *
     * @param string $group_name Group control name
     * @param array $args Group control arguments. Default is an empty array
     * @param array $options Optional. Group control options. Default is an
     *                       empty array.
     */
    final public function addGroupControl($group_name, array $args = [], array $options = [])
    {
        $group = Plugin::$instance->controls_manager->getControlGroups($group_name);

        if (!$group) {
            exit(sprintf('%s::%s: Group "%s" not found.', get_called_class(), __FUNCTION__, $group_name));
        }

        $group->addControls($this, $args, $options);
    }

    /**
     * Get scheme controls.
     *
     * Retrieve all the controls that use schemes.
     *
     * @since 1.4.0
     *
     * @return array Scheme controls
     */
    final public function getSchemeControls()
    {
        $enabled_schemes = SchemesManager::getEnabledSchemes();

        return array_filter(
            $this->getControls(),
            function ($control) use ($enabled_schemes) {
                return !empty($control['scheme']) && in_array($control['scheme']['type'], $enabled_schemes);
            }
        );
    }

    /**
     * Get style controls.
     *
     * Retrieve style controls for all active controls or, when requested, from
     * a specific set of controls.
     *
     * @since 1.4.0
     * @since 2.0.9 Added the `settings` parameter.
     *
     * @param array $controls Optional. Controls list. Default is an empty array
     * @param array $settings Optional. Controls settings. Default is an empty array
     *
     * @return array Style controls
     */
    final public function getStyleControls(array $controls = [], array $settings = [])
    {
        $controls = $this->getActiveControls($controls, $settings);

        $style_controls = [];

        foreach ($controls as $control_name => $control) {
            $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

            if (!$control_obj instanceof BaseDataControl) {
                continue;
            }

            $control = array_merge($control_obj->getSettings(), $control);

            $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

            if ($control_obj instanceof ControlRepeater) {
                $style_fields = [];

                foreach ($this->getSettings($control_name) as $item) {
                    $style_fields[] = $this->getStyleControls($control['fields'], $item);
                }

                $control['style_fields'] = $style_fields;
            }

            // if (!empty($control['selectors']) || !empty($control['dynamic']) || !empty($control['style_fields'])) {
            if (!empty($control['selectors']) || ControlsManager::ICONS === $control['type'] || !empty($control['style_fields'])) {
                $style_controls[$control_name] = $control;
            }
        }

        return $style_controls;
    }

    /**
     * Get tabs controls.
     *
     * Retrieve all the tabs assigned to the control.
     *
     * @since 1.4.0
     *
     * @return array Tabs controls
     */
    final public function getTabsControls()
    {
        return $this->getStack()['tabs'];
    }

    /**
     * Add new responsive control to stack.
     *
     * Register a set of controls to allow editing based on user screen size.
     * This method registers three screen sizes: Desktop, Tablet and Mobile.
     *
     * @since 1.4.0
     *
     * @param string $id Responsive control ID
     * @param array $args Responsive control arguments
     * @param array $options Optional. Responsive control options. Default is
     *                       an empty array.
     */
    final public function addResponsiveControl($id, array $args, $options = [])
    {
        $args['responsive'] = [];

        $devices = [
            self::RESPONSIVE_DESKTOP,
            self::RESPONSIVE_TABLET,
            self::RESPONSIVE_MOBILE,
        ];

        if (isset($args['devices'])) {
            $devices = array_intersect($devices, $args['devices']);

            $args['responsive']['devices'] = $devices;

            unset($args['devices']);
        }

        if (isset($args['default'])) {
            $args['desktop_default'] = $args['default'];

            unset($args['default']);
        }

        foreach ($devices as $device_name) {
            $control_args = $args;

            if (isset($control_args['device_args'])) {
                if (!empty($control_args['device_args'][$device_name])) {
                    $control_args = array_merge($control_args, $control_args['device_args'][$device_name]);
                }

                unset($control_args['device_args']);
            }

            if (!empty($args['prefix_class'])) {
                $device_to_replace = self::RESPONSIVE_DESKTOP === $device_name ? '' : '-' . $device_name;

                $control_args['prefix_class'] = sprintf($args['prefix_class'], $device_to_replace);
            }

            $control_args['responsive']['max'] = $device_name;

            if (isset($control_args['min_affected_device'])) {
                if (!empty($control_args['min_affected_device'][$device_name])) {
                    $control_args['responsive']['min'] = $control_args['min_affected_device'][$device_name];
                }

                unset($control_args['min_affected_device']);
            }

            if (isset($control_args[$device_name . '_default'])) {
                $control_args['default'] = $control_args[$device_name . '_default'];
            }

            unset($control_args['desktop_default']);
            unset($control_args['tablet_default']);
            unset($control_args['mobile_default']);

            $id_suffix = self::RESPONSIVE_DESKTOP === $device_name ? '' : '_' . $device_name;

            if (!empty($options['overwrite'])) {
                $this->updateControl($id . $id_suffix, $control_args, [
                    'recursive' => !empty($options['recursive']),
                ]);
            } else {
                $this->addControl($id . $id_suffix, $control_args, $options);
            }
        }
    }

    /**
     * Update responsive control in stack.
     *
     * Change the value of an existing responsive control in the stack. When you
     * add new control you set the `$args` parameter, this method allows you to
     * update the arguments by passing new data.
     *
     * @since 1.4.0
     *
     * @param string $id Responsive control ID
     * @param array $args Responsive control arguments
     * @param array $options Optional. Additional options
     */
    final public function updateResponsiveControl($id, array $args, array $options = [])
    {
        $this->addResponsiveControl($id, $args, [
            'overwrite' => true,
            'recursive' => !empty($options['recursive']),
        ]);
    }

    /**
     * Remove responsive control from stack.
     *
     * Unregister an existing responsive control and remove it from the stack.
     *
     * @since 1.4.0
     *
     * @param string $id Responsive control ID
     */
    final public function removeResponsiveControl($id)
    {
        $devices = [
            self::RESPONSIVE_DESKTOP,
            self::RESPONSIVE_TABLET,
            self::RESPONSIVE_MOBILE,
        ];

        foreach ($devices as $device_name) {
            $id_suffix = self::RESPONSIVE_DESKTOP === $device_name ? '' : '_' . $device_name;

            $this->removeControl($id . $id_suffix);
        }
    }

    /**
     * Get class name.
     *
     * Retrieve the name of the current class.
     *
     * @since 1.4.0
     *
     * @return string Class name
     */
    final public function getClassName()
    {
        return get_called_class();
    }

    /**
     * Get the config.
     *
     * Retrieve the config or, if non set, use the initial config.
     *
     * @since 1.4.0
     *
     * @return array|null The config
     */
    final public function getConfig()
    {
        if (null === $this->config) {
            $this->config = $this->getInitialConfig();
        }

        return $this->config;
    }

    /**
     * Get frontend settings keys.
     *
     * Retrieve settings keys for all frontend controls.
     *
     * @since 1.6.0
     *
     * @return array Settings keys for each control
     */
    final public function getFrontendSettingsKeys()
    {
        $controls = [];

        foreach ($this->getControls() as $control) {
            if (!empty($control['frontend_available'])) {
                $controls[] = $control['name'];
            }
        }

        return $controls;
    }

    /**
     * Get controls pointer index.
     *
     * Retrieve pointer index where the next control should be added.
     *
     * While using injection point, it will return the injection point index.
     * Otherwise index of the last control plus one.
     *
     * @since 1.9.2
     *
     * @return int Controls pointer index
     */
    public function getPointerIndex()
    {
        if (null !== $this->injection_point) {
            return $this->injection_point['index'];
        }

        return count($this->getControls());
    }

    /**
     * Get the raw data.
     *
     * Retrieve all the items or, when requested, a specific item.
     *
     * @since 1.4.0
     *
     * @param string $item Optional. The requested item. Default is null
     *
     * @return mixed The raw data
     */
    public function getData($item = null)
    {
        if (!$this->settings_sanitized && (!$item || 'settings' === $item)) {
            $this->data['settings'] = $this->sanitizeSettings($this->data['settings']);

            $this->settings_sanitized = true;
        }

        return self::getItems($this->data, $item);
    }

    /**
     * @since 2.0.14
     */
    public function getParsedDynamicSettings($setting = null)
    {
        if (null === $this->parsed_dynamic_settings) {
            $this->parsed_dynamic_settings = $this->parseDynamicSettings($this->getSettings());
        }

        return self::getItems($this->parsed_dynamic_settings, $setting);
    }

    /**
     * Get active settings.
     *
     * Retrieve the settings from all the active controls.
     *
     * @since 1.4.0
     * @since 2.1.0 Added the `controls` and the `settings` parameters.
     *
     * @param array $controls Optional. An array of controls. Default is null
     * @param array $settings Optional. Controls settings. Default is null
     *
     * @return array Active settings
     */
    public function getActiveSettings($settings = null, $controls = null)
    {
        $is_first_request = !$settings && !$this->active_settings;

        if (!$settings) {
            if ($this->active_settings) {
                return $this->active_settings;
            }

            $settings = $this->getControlsSettings();

            $controls = $this->getControls();
        }

        $active_settings = [];

        foreach ($settings as $setting_key => $setting) {
            if (!isset($controls[$setting_key])) {
                $active_settings[$setting_key] = $setting;

                continue;
            }

            $control = $controls[$setting_key];

            if ($this->isControlVisible($control, $settings)) {
                $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

                if ($control_obj instanceof ControlRepeater && $setting) {
                    foreach ($setting as &$item) {
                        $item = $this->getActiveSettings($item, $control['fields']);
                    }
                }

                $active_settings[$setting_key] = $setting;
            } else {
                $active_settings[$setting_key] = null;
            }
        }

        if ($is_first_request) {
            $this->active_settings = $active_settings;
        }

        return $active_settings;
    }

    /**
     * Get settings for display.
     *
     * Retrieve all the settings or, when requested, a specific setting for display.
     *
     * Unlike `getSettings()` method, this method retrieves only active settings
     * that passed all the conditions, rendered all the shortcodes and all the dynamic
     * tags.
     *
     * @since 2.0.0
     *
     * @param string $setting_key Optional. The key of the requested setting
     *                            Default is null.
     *
     * @return mixed The settings
     */
    public function getSettingsForDisplay($setting_key = null)
    {
        if (!$this->parsed_active_settings) {
            $this->parsed_active_settings = $this->getActiveSettings($this->getParsedDynamicSettings(), $this->getControls());
        }

        return self::getItems($this->parsed_active_settings, $setting_key);
    }

    /**
     * Parse dynamic settings.
     *
     * Retrieve the settings with rendered dynamic tags.
     *
     * @since 2.0.0
     *
     * @param array $settings Optional. The requested setting. Default is null
     * @param array $controls Optional. The controls array. Default is null
     * @param array $all_settings Optional. All the settings. Default is null
     *
     * @return array The settings with rendered dynamic tags
     */
    public function parseDynamicSettings($settings, $controls = null, $all_settings = null)
    {
        if (null === $all_settings) {
            $all_settings = $this->getSettings();
        }

        if (null === $controls) {
            $controls = $this->getControls();
        }

        foreach ($controls as $control) {
            $control_name = $control['name'];
            $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

            if (!$control_obj instanceof BaseDataControl) {
                continue;
            }

            if ($control_obj instanceof ControlRepeater) {
                foreach ($settings[$control_name] as &$field) {
                    $field = $this->parseDynamicSettings($field, $control['fields'], $field);
                }
                // Dynamic support for Repeater
                // continue;
            }

            $dynamic_settings = $control_obj->getSettings('dynamic') ?: [];

            if (!empty($control['dynamic'])) {
                $dynamic_settings = array_merge($dynamic_settings, $control['dynamic']);
            }

            if (empty($dynamic_settings) || !isset($all_settings['__dynamic__'][$control_name])) {
                continue;
            }

            if (!empty($dynamic_settings['active']) && !empty($all_settings['__dynamic__'][$control_name])) {
                $parsed_value = $control_obj->parseTags($all_settings['__dynamic__'][$control_name], $dynamic_settings);

                $dynamic_property = !empty($dynamic_settings['property']) ? $dynamic_settings['property'] : null;

                if ($dynamic_property) {
                    $settings[$control_name][$dynamic_property] = $parsed_value;
                } else {
                    $settings[$control_name] = $parsed_value;
                }
            }
        }

        return $settings;
    }

    /**
     * Get frontend settings.
     *
     * Retrieve the settings for all frontend controls.
     *
     * @since 1.6.0
     *
     * @return array Frontend settings
     */
    public function getFrontendSettings()
    {
        $frontend_settings = array_intersect_key($this->getSettingsForDisplay(), array_flip($this->getFrontendSettingsKeys()));

        foreach ($frontend_settings as $key => $setting) {
            if (in_array($setting, [null, ''], true)) {
                unset($frontend_settings[$key]);
            }
        }

        return $frontend_settings;
    }

    /**
     * Filter controls settings.
     *
     * Receives controls, settings and a callback function to filter the settings by
     * and returns filtered settings.
     *
     * @since 1.5.0
     *
     * @param callable $callback The callback function
     * @param array $settings Optional. Control settings. Default is an empty
     *                        array.
     * @param array $controls Optional. Controls list. Default is an empty
     *                        array.
     *
     * @return array Filtered settings
     */
    public function filterControlsSettings(callable $callback, array $settings = [], array $controls = [])
    {
        if (!$settings) {
            $settings = $this->getSettings();
        }

        if (!$controls) {
            $controls = $this->getControls();
        }

        return array_reduce(
            array_keys($settings),
            function ($filtered_settings, $setting_key) use ($controls, $settings, $callback) {
                if (isset($controls[$setting_key])) {
                    $result = $callback($settings[$setting_key], $controls[$setting_key]);

                    if (null !== $result) {
                        $filtered_settings[$setting_key] = $result;
                    }
                }

                return $filtered_settings;
            },
            []
        );
    }

    /**
     * Whether the control is visible or not.
     *
     * Used to determine whether the control is visible or not.
     *
     * @since 1.4.0
     *
     * @param array $control The control
     * @param array $values Optional. Condition values. Default is null
     *
     * @return bool Whether the control is visible
     */
    public function isControlVisible($control, $values = null)
    {
        if (null === $values) {
            $values = $this->getSettings();
        }

        if (!empty($control['conditions']) && !Conditions::check($control['conditions'], $values)) {
            return false;
        }

        if (empty($control['condition'])) {
            return true;
        }

        foreach ($control['condition'] as $condition_key => $condition_value) {
            preg_match('/([\w\-]+)(?:\[([a-z_]+)])?(!?)$/i', $condition_key, $condition_key_parts);

            $pure_condition_key = $condition_key_parts[1];
            $condition_sub_key = $condition_key_parts[2];
            $is_negative_condition = (bool) $condition_key_parts[3];

            if (!isset($values[$pure_condition_key]) || null === $values[$pure_condition_key]) {
                return false;
            }

            $instance_value = $values[$pure_condition_key];

            if ($condition_sub_key && is_array($instance_value)) {
                if (!isset($instance_value[$condition_sub_key])) {
                    return false;
                }

                $instance_value = $instance_value[$condition_sub_key];
            }

            /*
             * If the $condition_value is a non empty array - check if the $condition_value contains the $instance_value,
             * If the $instance_value is a non empty array - check if the $instance_value contains the $condition_value
             * otherwise check if they are equal. ( and give the ability to check if the value is an empty array )
             */
            if (is_array($condition_value) && !empty($condition_value)) {
                $is_contains = in_array($instance_value, $condition_value, true);
            } elseif (is_array($instance_value) && !empty($instance_value)) {
                $is_contains = in_array($condition_value, $instance_value, true);
            } else {
                $is_contains = $instance_value === $condition_value;
            }

            if ($is_negative_condition && $is_contains || !$is_negative_condition && !$is_contains) {
                return false;
            }
        }

        return true;
    }

    /**
     * Start controls section.
     *
     * Used to add a new section of controls. When you use this method, all the
     * registered controls from this point will be assigned to this section,
     * until you close the section using `end_controls_section()` method.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     *
     * @param string $section_id Section ID
     * @param array $args Section arguments Optional
     */
    public function startControlsSection($section_id, array $args = [])
    {
        $section_name = $this->getName();

        // do_action('elementor/element/before_section_start', $this, $section_id, $args);

        /*
         * Before section start.
         *
         * Fires before Elementor section starts in the editor panel.
         *
         * The dynamic portions of the hook name, `$section_name` and `$section_id`, refers to the section name and section ID, respectively.
         *
         * @since 1.4.0
         *
         * @param ControlsStack $this The control
         * @param array          $args Section arguments
         */
        do_action("elementor/element/{$section_name}/{$section_id}/before_section_start", $this, $args);

        $args['type'] = ControlsManager::SECTION;

        $this->addControl($section_id, $args);

        if (null !== $this->current_section) {
            exit(sprintf('Creative Elements: You can\'t start a section before the end of the previous section "%s".', $this->current_section['section'])); // XSS ok.
        }

        $this->current_section = $this->getSectionArgs($section_id);

        if ($this->injection_point) {
            $this->injection_point['section'] = $this->current_section;
        }

        // do_action('elementor/element/after_section_start', $this, $section_id, $args);

        /*
         * After section start.
         *
         * Fires after Elementor section starts in the editor panel.
         *
         * The dynamic portions of the hook name, `$section_name` and `$section_id`, refers to the section name and section ID, respectively.
         *
         * @since 1.4.0
         *
         * @param ControlsStack $this The control
         * @param array          $args Section arguments
         */
        do_action("elementor/element/{$section_name}/{$section_id}/after_section_start", $this, $args);
    }

    /**
     * End controls section.
     *
     * Used to close an existing open controls section. When you use this method
     * it stops adding new controls to this section.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     */
    public function endControlsSection()
    {
        $stack_name = $this->getName();

        // Save the current section for the action.
        $current_section = $this->current_section;
        $section_id = $current_section['section'];
        $args = [
            'tab' => $current_section['tab'],
        ];

        // do_action('elementor/element/before_section_end', $this, $section_id, $args);

        /*
         * Before section end.
         *
         * Fires before Elementor section ends in the editor panel.
         *
         * The dynamic portions of the hook name, `$stack_name` and `$section_id`, refers to the stack name and section ID, respectively.
         *
         * @since 1.4.0
         *
         * @param ControlsStack $this The control
         * @param array          $args Section arguments
         */
        do_action("elementor/element/{$stack_name}/{$section_id}/before_section_end", $this, $args);

        $this->current_section = null;

        // do_action('elementor/element/after_section_end', $this, $section_id, $args);

        /*
         * After section end.
         *
         * Fires after Elementor section ends in the editor panel.
         *
         * The dynamic portions of the hook name, `$stack_name` and `$section_id`, refers to the section name and section ID, respectively.
         *
         * @since 1.4.0
         *
         * @param ControlsStack $this The control
         * @param array          $args Section arguments
         */
        do_action("elementor/element/{$stack_name}/{$section_id}/after_section_end", $this, $args);
    }

    /**
     * Start controls tabs.
     *
     * Used to add a new set of tabs inside a section. You should use this
     * method before adding new individual tabs using `start_controls_tab()`.
     * Each tab added after this point will be assigned to this group of tabs,
     * until you close it using `end_controls_tabs()` method.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     *
     * @param string $tabs_id Tabs ID
     * @param array $args Tabs arguments
     */
    public function startControlsTabs($tabs_id, array $args = [])
    {
        if (null !== $this->current_tab) {
            exit(sprintf('Creative Elements: You can\'t start tabs before the end of the previous tabs "%s".', $this->current_tab['tabs_wrapper'])); // XSS ok.
        }

        $args['type'] = ControlsManager::TABS;

        $this->addControl($tabs_id, $args);

        $this->current_tab = [
            'tabs_wrapper' => $tabs_id,
        ];

        foreach (['condition', 'conditions'] as $key) {
            if (!empty($args[$key])) {
                $this->current_tab[$key] = $args[$key];
            }
        }

        if ($this->injection_point) {
            $this->injection_point['tab'] = $this->current_tab;
        }
    }

    /**
     * End controls tabs.
     *
     * Used to close an existing open controls tabs. When you use this method it
     * stops adding new controls to this tabs.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     */
    public function endControlsTabs()
    {
        $this->current_tab = null;
    }

    /**
     * Start controls tab.
     *
     * Used to add a new tab inside a group of tabs. Use this method before
     * adding new individual tabs using `start_controls_tab()`.
     * Each tab added after this point will be assigned to this group of tabs,
     * until you close it using `end_controls_tab()` method.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     *
     * @param string $tab_id Tab ID
     * @param array $args Tab arguments
     */
    public function startControlsTab($tab_id, $args)
    {
        if (!empty($this->current_tab['inner_tab'])) {
            exit(sprintf('Creative Elements: You can\'t start a tab before the end of the previous tab "%s".', $this->current_tab['inner_tab'])); // XSS ok.
        }

        $args['type'] = ControlsManager::TAB;
        $args['tabs_wrapper'] = $this->current_tab['tabs_wrapper'];

        $this->addControl($tab_id, $args);

        $this->current_tab['inner_tab'] = $tab_id;

        if ($this->injection_point) {
            $this->injection_point['tab']['inner_tab'] = $this->current_tab['inner_tab'];
        }
    }

    /**
     * End controls tab.
     *
     * Used to close an existing open controls tab. When you use this method it
     * stops adding new controls to this tab.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.4.0
     */
    public function endControlsTab()
    {
        unset($this->current_tab['inner_tab']);
    }

    /**
     * Start popover.
     *
     * Used to add a new set of controls in a popover. When you use this method,
     * all the registered controls from this point will be assigned to this
     * popover, until you close the popover using `end_popover()` method.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.9.0
     */
    final public function startPopover()
    {
        $this->current_popover = [
            'initialized' => false,
        ];
    }

    /**
     * End popover.
     *
     * Used to close an existing open popover. When you use this method it stops
     * adding new controls to this popover.
     *
     * This method should be used inside `_register_controls()`.
     *
     * @since 1.9.0
     */
    final public function endPopover()
    {
        $this->current_popover = null;

        $last_control_key = $this->getControlKey($this->getPointerIndex() - 1);

        $args = [
            'popover' => [
                'end' => true,
            ],
        ];

        $options = [
            'recursive' => true,
        ];

        $this->updateControl($last_control_key, $args, $options);
    }

    /**
     * Print element template.
     *
     * Used to generate the element template on the editor.
     *
     * @since 2.0.0
     */
    public function printTemplate()
    {
        ob_start();

        $this->contentTemplate();

        $template_content = ob_get_clean();

        // $element_type = $this->getType();

        /*
         * Template content.
         *
         * Filters the controls stack template content before it's printed in the editor.
         *
         * The dynamic portion of the hook name, `$element_type`, refers to the element type.
         *
         * @since 1.0.0
         *
         * @param string         $content_template The controls stack template in the editor
         * @param ControlsStack $this             The controls stack
         */
        // $template_content = apply_filters("elementor/{$element_type}/print_template", $template_content, $this);

        if (!$template_content) {
            return;
        } ?>
        <script type="text/html" id="tmpl-elementor-<?php echo esc_attr($this->getName()); ?>-content">
            <?php $this->printTemplateContent($template_content); ?>
        </script>
        <?php
    }

    /**
     * Start injection.
     *
     * Used to inject controls and sections to a specific position in the stack.
     *
     * When you use this method, all the registered controls and sections will
     * be injected to a specific position in the stack, until you stop the
     * injection using `end_injection()` method.
     *
     * @since 1.7.1
     *
     * @param array $position The position where to start the injection {
     *
     * @var string $type injection type, either `control` or `section` Default is `control`
     * @var string $at   Where to inject. If `$type` is `control` accepts `before` and `after`. If `$type` is `section` accepts `start` and `end`. Default values based on the `type`.
     * @var string $of   Control/Section ID
     *
     * }
     */
    final public function startInjection(array $position)
    {
        if ($this->injection_point) {
            exit('A controls injection is already opened. Please close current injection before starting a new one (use `endInjection`).');
        }

        $this->injection_point = $this->getPositionInfo($position);
    }

    /**
     * End injection.
     *
     * Used to close an existing opened injection point.
     *
     * When you use this method it stops adding new controls and sections to
     * this point and continue to add controls to the regular position in the
     * stack.
     *
     * @since 1.7.1
     */
    final public function endInjection()
    {
        $this->injection_point = null;
    }

    /**
     * Get injection point.
     *
     * Retrieve the injection point in the stack where new controls and sections
     * will be inserted.
     *
     * @since 1.9.2
     *
     * @return array|null an array when an injection point is defined, null
     *                    otherwise
     */
    final public function getInjectionPoint()
    {
        return $this->injection_point;
    }

    /**
     * Register controls.
     *
     * Used to add new controls to any element type. For example, external
     * developers use this method to register controls in a widget.
     *
     * Should be inherited and register new controls using `add_control()`,
     * `add_responsive_control()` and `add_group_control()`, inside control
     * wrappers like `start_controls_section()`, `start_controls_tabs()` and
     * `start_controls_tab()`.
     *
     * @since 1.4.0
     */
    protected function _registerControls()
    {
    }

    /**
     * Get default data.
     *
     * Retrieve the default data. Used to reset the data on initialization.
     *
     * @since 1.4.0
     *
     * @return array Default data
     */
    protected function getDefaultData()
    {
        return [
            'id' => 0,
            'settings' => [],
        ];
    }

    /**
     * @since 2.3.0
     */
    protected function getInitSettings()
    {
        $settings = $this->getData('settings');

        foreach ($this->getControls() as $control) {
            $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

            if (!$control_obj instanceof BaseDataControl) {
                continue;
            }

            $control = array_merge_recursive($control_obj->getSettings(), $control);

            $settings[$control['name']] = $control_obj->getValue($control, $settings);
        }

        return $settings;
    }

    /**
     * Get initial config.
     *
     * Retrieve the current element initial configuration - controls list and
     * the tabs assigned to the control.
     *
     * @since 2.9.0
     *
     * @return array The initial config
     */
    protected function getInitialConfig()
    {
        return [
            'controls' => $this->getControls(),
        ];
    }

    /**
     * Get section arguments.
     *
     * Retrieve the section arguments based on section ID.
     *
     * @since 1.4.0
     *
     * @param string $section_id Section ID
     *
     * @return array Section arguments
     */
    protected function getSectionArgs($section_id)
    {
        $section_control = $this->getControls($section_id);

        $section_args_keys = ['tab', 'condition'];

        $args = array_intersect_key($section_control, array_flip($section_args_keys));

        $args['section'] = $section_id;

        return $args;
    }

    /**
     * Render element.
     *
     * Generates the final HTML on the frontend.
     *
     * @since 2.0.0
     */
    protected function render()
    {
    }

    /**
     * Print content template.
     *
     * Used to generate the content template on the editor, using a
     * Backbone JavaScript template.
     *
     * @since 2.0.0
     *
     * @param string $template_content Template content
     */
    protected function printTemplateContent($template_content)
    {
        echo $template_content;
    }

    /**
     * Render element output in the editor.
     *
     * Used to generate the live preview, using a Backbone JavaScript template.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
    }

    /**
     * Initialize controls.
     *
     * Register the all controls added by `_register_controls()`.
     *
     * @since 2.0.0
     */
    protected function initControls()
    {
        Plugin::$instance->controls_manager->openStack($this);

        // TODO: This is for backwards compatibility starting from 2.9.0
        // This `if` statement should be removed when the method is removed
        if (method_exists($this, '_registerControls')) {
            $this->_registerControls();
        } else {
            $this->registerControls();
        }
    }

    /**
     * Initialize the class.
     *
     * Set the raw data, the ID and the parsed settings.
     *
     * @since 2.9.0
     *
     * @param array $data Initial data
     */
    protected function init($data)
    {
        $this->data = array_merge($this->getDefaultData(), $data);

        $this->id = $data['id'];
    }

    /**
     * Sanitize initial data.
     *
     * Performs settings cleaning and sanitization.
     *
     * @since 2.1.5
     *
     * @param array $settings Settings to sanitize
     * @param array $controls Optional. An array of controls. Default is an
     *                        empty array.
     *
     * @return array Sanitized settings
     */
    private function sanitizeSettings(array $settings, array $controls = [])
    {
        if (!$controls) {
            $controls = $this->getControls();
        }

        foreach ($controls as $control) {
            $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

            if ($control_obj instanceof ControlRepeater) {
                if (empty($settings[$control['name']])) {
                    continue;
                }

                foreach ($settings[$control['name']] as $index => $repeater_row_data) {
                    $sanitized_row_data = $this->sanitizeSettings($repeater_row_data, $control['fields']);

                    $settings[$control['name']][$index] = $sanitized_row_data;
                }

                continue;
            }

            $is_dynamic = isset($settings['__dynamic__'][$control['name']]);

            if (!$is_dynamic) {
                continue;
            }

            $value_to_check = $settings['__dynamic__'][$control['name']];

            $tag_text_data = Plugin::$instance->dynamic_tags->tagTextToTagData($value_to_check);

            if (!Plugin::$instance->dynamic_tags->getTagInfo($tag_text_data['name'])) {
                unset($settings['__dynamic__'][$control['name']]);
            }
        }

        return $settings;
    }

    /**
     * Controls stack constructor.
     *
     * Initializing the control stack class using `$data`. The `$data` is required
     * for a normal instance. It is optional only for internal `type instance`.
     *
     * @since 1.4.0
     *
     * @param array $data Optional. Control stack data. Default is an empty array
     */
    public function __construct(array $data = [])
    {
        if ($data) {
            $this->init($data);
        }
    }
}
