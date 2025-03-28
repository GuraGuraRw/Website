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

use CE\CoreXDynamicTagsXTag as Tag;
use CE\CoreXFilesXBase as BaseFile;
use CE\CoreXResponsiveXResponsive as Responsive;

/**
 * Elementor CSS file.
 *
 * Elementor CSS file handler class is responsible for generating CSS files.
 *
 * @since 1.2.0
 * @abstract
 */
abstract class CoreXFilesXCSSXBase extends BaseFile
{
    /**
     * Elementor CSS file generated status.
     *
     * The parsing result after generating CSS file.
     */
    const CSS_STATUS_FILE = 'file';

    /**
     * Elementor inline CSS status.
     *
     * The parsing result after generating inline CSS.
     */
    const CSS_STATUS_INLINE = 'inline';

    /**
     * Elementor CSS empty status.
     *
     * The parsing result when an empty CSS returned.
     */
    const CSS_STATUS_EMPTY = 'empty';

    /**
     * Fonts.
     *
     * Holds the list of fonts.
     *
     * @var array
     */
    private $fonts = [];

    private $icons_fonts = [];

    private $preloads = [];

    /**
     * Stylesheet object.
     *
     * Holds the CSS file stylesheet instance.
     *
     * @var Stylesheet
     */
    protected $stylesheet_obj;

    /**
     * Printed.
     *
     * Holds the list of printed files.
     *
     * @var array
     */
    private static $printed = [];

    /**
     * Get CSS file name.
     *
     * Retrieve the CSS file name.
     *
     * @since 1.6.0
     * @abstract
     */
    abstract public function getName();

    /**
     * CSS file constructor.
     *
     * Initializing Elementor CSS file.
     *
     * @since 1.2.0
     */
    public function __construct($file_name)
    {
        parent::__construct($file_name);

        $this->initStylesheet();
    }

    /**
     * Use external file.
     *
     * Whether to use external CSS file of not. When there are new schemes or settings
     * updates.
     *
     * @since 1.9.0
     *
     * @return bool True if the CSS requires an update, False otherwise
     */
    protected function useExternalFile()
    {
        return 'internal' !== get_option('elementor_css_print_method');
    }

    /**
     * Update the CSS file.
     *
     * Delete old CSS, parse the CSS, save the new file and update the database.
     *
     * This method also sets the CSS status to be used later on in the render posses.
     *
     * @since 1.2.0
     */
    public function update()
    {
        $this->updateFile();

        $meta = $this->getMeta();

        $meta['time'] = time();

        $content = $this->getContent();

        if (empty($content)) {
            $meta['status'] = self::CSS_STATUS_EMPTY;
            $meta['css'] = '';
        } else {
            $use_external_file = $this->useExternalFile();

            if ($use_external_file) {
                $meta['status'] = self::CSS_STATUS_FILE;
                $meta['css'] = '';
            } else {
                $meta['status'] = self::CSS_STATUS_INLINE;
                $meta['css'] = $content;
            }
        }

        $this->updateMeta($meta);
    }

    /**
     * @since 2.1.0
     */
    public function write()
    {
        if ($this->useExternalFile()) {
            parent::write();
        }
    }

    /**
     * Enqueue CSS.
     *
     * Either enqueue the CSS file in Elementor or add inline style.
     *
     * This method is also responsible for loading the fonts.
     *
     * @since 1.2.0
     */
    public function enqueue()
    {
        $handle_id = $this->getFileHandleId();

        if (isset(self::$printed[$handle_id])) {
            return;
        }

        self::$printed[$handle_id] = true;

        $meta = $this->getMeta();

        if (self::CSS_STATUS_EMPTY === $meta['status']) {
            return;
        }

        // First time after clear cache and etc.
        if ('' === $meta['status'] || $this->isUpdateRequired()) {
            $this->update();

            $meta = $this->getMeta();
        }

        if (self::CSS_STATUS_INLINE === $meta['status']) {
            // $dep = $this->get_inline_dependency();
            $handle = method_exists($this, 'getPostId') && $this->getPostId() == (string) \CreativeElements::getPreviewUId()
                ? $this->getFileHandleId()
                : $this->getInlineDependency();
            wp_add_inline_style($handle, $meta['css']);
        } elseif (self::CSS_STATUS_FILE === $meta['status']) {
            $handle = $this->getFileHandleId();
            // Force inline post CSS in preview to ignore CCC
            'elementor-post-' . \CreativeElements::getPreviewUId(false) === $handle
                ? wp_add_inline_style($this->getInlineDependency(), @call_user_func('file_get_contents', $this->getPath()))
                : wp_enqueue_style($handle, $this->getUrl(), $this->getEnqueueDependencies(), $meta['time']);
        }

        // Handle fonts.
        if (!empty($meta['fonts'])) {
            foreach ($meta['fonts'] as $font) {
                Plugin::$instance->frontend->enqueueFont($font);
            }
        }

        if (!empty($meta['icons'])) {
            $icons_types = IconsManager::getIconManagerTabs();
            foreach ($meta['icons'] as $icon_font) {
                if (!isset($icons_types[$icon_font])) {
                    continue;
                }
                Plugin::$instance->frontend->enqueueFont($icon_font);
            }
        }

        if (!empty($meta['preloads'])) {
            add_action('wp_head', function () use (&$meta) {
                foreach ($meta['preloads'] as &$preload) {
                    echo '<link rel="preload" ' . Utils::renderHtmlAttributes($preload) . '>';
                }
            });
        }

        $name = $this->getName();

        /*
         * Enqueue CSS file.
         *
         * Fires when CSS file is enqueued on Elementor.
         *
         * The dynamic portion of the hook name, `$name`, refers to the CSS file name.
         *
         * @since 2.0.0
         *
         * @param Base $this The current CSS file
         */
        do_action("elementor/css-file/{$name}/enqueue", $this);
    }

    /**
     * Print CSS.
     *
     * Output the final CSS inside the `<style>` tags and all the frontend fonts in
     * use.
     *
     * @since 1.9.4
     */
    public function printCss()
    {
        echo '<style>' . $this->getContent() . '</style>'; // XSS ok.
        Plugin::$instance->frontend->printFontsLinks();
    }

    /**
     * Add control rules.
     *
     * Parse the CSS for all the elements inside any given control.
     *
     * This method recursively renders the CSS for all the selectors in the control.
     *
     * @since 1.2.0
     *
     * @param array $control The controls
     * @param array $controls_stack The controls stack
     * @param callable $value_callback Callback function for the value
     * @param array $placeholders Placeholders
     * @param array $replacements Replacements
     */
    public function addControlRules(array $control, array $controls_stack, callable $value_callback, array $placeholders, array $replacements)
    {
        $value = $value_callback($control);

        if (null === $value || empty($control['selectors'])) {
            return;
        }

        foreach ($control['selectors'] as $selector => $css_property) {
            try {
                $output_css_property = preg_replace_callback(
                    '/\{\{(?:([^.}]+)\.)?([^}| ]*)(?: *\|\| *(?:([^.}]+)\.)?([^}| ]*) *)*}}/',
                    function ($matches) use ($control, $value_callback, $controls_stack, $value) {
                        $external_control_missing = $matches[1] && !isset($controls_stack[$matches[1]]);

                        $parsed_value = '';

                        if (!$external_control_missing) {
                            $parsed_value = $this->parsePropertyPlaceholder($control, $value, $controls_stack, $value_callback, $matches[2], $matches[1]);
                        }

                        if ('' === $parsed_value) {
                            if (isset($matches[4])) {
                                $parsed_value = $matches[4];

                                $is_string_value = preg_match('/^([\'"])(.*)\1$/', $parsed_value, $string_matches);

                                if ($is_string_value) {
                                    $parsed_value = $string_matches[2];
                                } elseif (!is_numeric($parsed_value)) {
                                    if ($matches[3] && !isset($controls_stack[$matches[3]])) {
                                        return '';
                                    }

                                    $parsed_value = $this->parsePropertyPlaceholder($control, $value, $controls_stack, $value_callback, $matches[4], $matches[3]);
                                }
                            }

                            if ('' === $parsed_value) {
                                if ($external_control_missing) {
                                    return '';
                                }

                                throw new \Exception();
                            }
                        }

                        return $parsed_value;
                    },
                    $css_property
                );
            } catch (\Exception $e) {
                return;
            }

            if (!$output_css_property) {
                continue;
            }

            $device_pattern = '/^(?:\([^\)]+\)){1,2}/';

            preg_match($device_pattern, $selector, $device_rules);

            $query = [];

            if ($device_rules) {
                $selector = preg_replace($device_pattern, '', $selector);

                preg_match_all('/\(([^\)]+)\)/', $device_rules[0], $pure_device_rules);

                $pure_device_rules = $pure_device_rules[1];

                foreach ($pure_device_rules as $device_rule) {
                    if (ElementBase::RESPONSIVE_DESKTOP === $device_rule) {
                        continue;
                    }

                    $device = preg_replace('/\+$/', '', $device_rule);

                    $endpoint = $device === $device_rule ? 'max' : 'min';

                    $query[$endpoint] = $device;
                }
            }

            $parsed_selector = str_replace($placeholders, $replacements, $selector);

            if (!$query && !empty($control['responsive'])) {
                $query = array_intersect_key($control['responsive'], array_flip(['min', 'max']));

                if (!empty($query['max']) && ElementBase::RESPONSIVE_DESKTOP === $query['max']) {
                    unset($query['max']);
                }
            }

            $this->stylesheet_obj->addRules($parsed_selector, $output_css_property, $query);
        }
    }

    /**
     * @param array $control
     * @param mixed $value
     * @param array $controls_stack
     * @param callable $value_callback
     * @param string $placeholder
     * @param string $parser_control_name
     *
     * @return string
     */
    public function parsePropertyPlaceholder(array $control, $value, array $controls_stack, $value_callback, $placeholder, $parser_control_name = null)
    {
        if ($parser_control_name) {
            $control = $controls_stack[$parser_control_name];

            $value = $value_callback($control);
        }

        if (ControlsManager::FONT === $control['type']) {
            $this->fonts[] = $value;
        }

        /* @var BaseDataControl $control_obj */
        $control_obj = Plugin::$instance->controls_manager->getControl($control['type']);

        return (string) $control_obj->getStyleValue($placeholder, $value, $control);
    }

    /**
     * Get the fonts.
     *
     * Retrieve the list of fonts.
     *
     * @since 1.9.0
     *
     * @return array Fonts
     */
    public function getFonts()
    {
        return $this->fonts;
    }

    /**
     * Get stylesheet.
     *
     * Retrieve the CSS file stylesheet instance.
     *
     * @since 1.2.0
     *
     * @return Stylesheet The stylesheet object
     */
    public function getStylesheet()
    {
        return $this->stylesheet_obj;
    }

    /**
     * Add controls stack style rules.
     *
     * Parse the CSS for all the elements inside any given controls stack.
     *
     * This method recursively renders the CSS for all the child elements in the stack.
     *
     * @since 1.6.0
     *
     * @param ControlsStack $controls_stack The controls stack
     * @param array $controls Controls array
     * @param array $values Values array
     * @param array $placeholders Placeholders
     * @param array $replacements Replacements
     * @param array $all_controls All controls
     */
    public function addControlsStackStyleRules(ControlsStack $controls_stack, array $controls, array $values, array $placeholders, array $replacements, array $all_controls = [])
    {
        if (!$all_controls) {
            $all_controls = $controls_stack->getControls();
        }

        $parsed_dynamic_settings = $controls_stack->parseDynamicSettings($values, $controls);

        foreach ($controls as $control) {
            if (!empty($control['style_fields'])) {
                $this->addRepeaterControlStyleRules($controls_stack, $control, $values[$control['name']], $placeholders, $replacements);
            }

            if (!empty($control['__dynamic__'][$control['name']])) {
                $this->addDynamicControlStyleRules($control, $control['__dynamic__'][$control['name']]);
            }

            if (ControlsManager::ICONS === $control['type']) {
                // $this->icons_fonts[] = $values[$control['name']]['library'];
                if (isset($control['fa4compatibility'], $values[$fa4 = $control['fa4compatibility']]) && !isset($values['__fa4_migrated'][$control['name']])) {
                    $values[$fa4] && $this->icons_fonts += [
                        'fa-solid' => true,
                        'fa-regular' => true,
                        'fa-brands' => true,
                    ];
                } elseif ($library = $values[$control['name']]['library']) {
                    $this->icons_fonts[$library] = true;
                }
            } elseif (ControlsManager::SELECT === $control['type'] && 'preload' === $values[$control['name']]) {
                $prefix = substr($control['name'], 0, -8);

                if ('classic' === $control['of_type']) {
                    $preload = [
                        'as' => 'image',
                        'href' => Helper::getMediaLink($values[$prefix . '_image']['url']),
                    ];
                    $this->preloads[] = &$preload;

                    if (!empty($values[$prefix . '_image_tablet']['url'])) {
                        $min = \Configuration::get('elementor_viewport_lg');
                        $preload['media'] = "(min-width:{$min}px)";

                        $max = $min - 1;
                        $preload_tablet = [
                            'as' => 'image',
                            'href' => Helper::getMediaLink($values[$prefix . '_image_tablet']['url']),
                            'media' => "(max-width:{$max}px)",
                        ];
                        $this->preloads[] = &$preload_tablet;
                    }
                    if (!empty($values[$prefix . '_image_mobile']['url'])) {
                        $min = \Configuration::get('elementor_viewport_md');
                        isset($preload['media']) || $preload['media'] = "(min-width:{$min}px)";
                        isset($preload_tablet) && $preload_tablet['media'] .= " and (min-width:{$min}px)";

                        $max = $min - 1;
                        $preload_mobile = [
                            'as' => 'image',
                            'href' => Helper::getMediaLink($values[$prefix . '_image_mobile']['url']),
                            'media' => "(max-width:{$max}px)",
                        ];
                        $this->preloads[] = &$preload_mobile;
                    }
                } elseif (!empty($values[$prefix . '_gallery'][0]['image']['url'])) {
                    $this->preloads[] = [
                        'as' => 'image',
                        'href' => Helper::getMediaLink($values[$prefix . '_gallery'][0]['image']['url']),
                    ];
                }
            }

            if (!empty($parsed_dynamic_settings['__dynamic__'][$control['name']])) {
                // Dynamic CSS should not be added to the CSS files.
                // Instead it's handled by CE\CoreXDynamicTagsXDynamicCSS and printed in a style tag.
                unset($parsed_dynamic_settings[$control['name']]);
                continue;
            }

            if (empty($control['selectors'])) {
                continue;
            }

            $this->addControlStyleRules($control, $parsed_dynamic_settings, $all_controls, $placeholders, $replacements);
        }
    }

    /**
     * Get file handle ID.
     *
     * Retrieve the file handle ID.
     *
     * @since 1.2.0
     * @abstract
     *
     * @return string CSS file handle ID
     */
    abstract protected function getFileHandleId();

    /**
     * Render CSS.
     *
     * Parse the CSS.
     *
     * @since 1.2.0
     * @abstract
     */
    abstract protected function renderCss();

    protected function getDefaultMeta()
    {
        return array_merge(parent::getDefaultMeta(), [
            'fonts' => array_unique($this->fonts),
            // 'icons' => array_unique($this->icons_fonts),
            'icons' => array_keys($this->icons_fonts),
            'preloads' => $this->preloads,
            'status' => '',
        ]);
    }

    /**
     * Get enqueue dependencies.
     *
     * Retrieve the name of the stylesheet used by `wp_enqueue_style()`.
     *
     * @since 1.2.0
     *
     * @return array Name of the stylesheet
     */
    protected function getEnqueueDependencies()
    {
        return [];
    }

    /**
     * Get inline dependency.
     *
     * Retrieve the name of the stylesheet used by `wp_add_inline_style()`.
     *
     * @since 1.2.0
     *
     * @return string Name of the stylesheet
     */
    protected function getInlineDependency()
    {
        return '';
    }

    /**
     * Is update required.
     *
     * Whether the CSS requires an update. When there are new schemes or settings
     * updates.
     *
     * @since 1.2.0
     *
     * @return bool True if the CSS requires an update, False otherwise
     */
    protected function isUpdateRequired()
    {
        return false;
    }

    /**
     * Parse CSS.
     *
     * Parsing the CSS file.
     *
     * @since 1.2.0
     */
    protected function parseContent()
    {
        $this->renderCss();

        $name = $this->getName();

        /*
         * Parse CSS file.
         *
         * Fires when CSS file is parsed on Elementor.
         *
         * The dynamic portion of the hook name, `$name`, refers to the CSS file name.
         *
         * @since 2.0.0
         *
         * @param Base $this The current CSS file
         */
        do_action("elementor/css-file/{$name}/parse", $this);

        return $this->stylesheet_obj->__toString();
    }

    /**
     * Add control style rules.
     *
     * Register new style rules for the control.
     *
     * @since 1.6.0
     *
     * @param array $control The control
     * @param array $values Values array
     * @param array $controls The controls stack
     * @param array $placeholders Placeholders
     * @param array $replacements Replacements
     */
    protected function addControlStyleRules(array $control, array $values, array $controls, array $placeholders, array $replacements)
    {
        $this->addControlRules(
            $control,
            $controls,
            function ($control) use ($values) {
                return $this->getStyleControlValue($control, $values);
            },
            $placeholders,
            $replacements
        );
    }

    /**
     * Get style control value.
     *
     * Retrieve the value of the style control for any give control and values.
     *
     * It will retrieve the control name and return the style value.
     *
     * @since 1.6.0
     *
     * @param array $control The control
     * @param array $values Values array
     *
     * @return mixed Style control value
     */
    private function getStyleControlValue(array $control, array $values)
    {
        $value = $values[$control['name']];

        // fix for background image
        if (!empty($value['url']) && (strrpos($control['name'], '_image') !== false || 'background_video_fallback' === $control['name'])) {
            $value['url'] = Helper::getMediaLink($value['url']);
        }

        if (isset($control['selectors_dictionary'][$value])) {
            $value = $control['selectors_dictionary'][$value];
        }

        if (!is_numeric($value) && !is_float($value) && empty($value)) {
            return null;
        }

        return $value;
    }

    /**
     * Init stylesheet.
     *
     * Initialize CSS file stylesheet by creating a new `Stylesheet` object and register new
     * breakpoints for the stylesheet.
     *
     * @since 1.2.0
     */
    private function initStylesheet()
    {
        $this->stylesheet_obj = new Stylesheet();

        $breakpoints = Responsive::getBreakpoints();

        $this->stylesheet_obj
            ->addDevice('mobile', 0)
            ->addDevice('tablet', $breakpoints['md'])
            ->addDevice('desktop', $breakpoints['lg']);
    }

    /**
     * Add repeater control style rules.
     *
     * Register new style rules for the repeater control.
     *
     * @since 2.0.0
     *
     * @param ControlsStack $controls_stack The control stack
     * @param array $repeater_control The repeater control
     * @param array $repeater_values Repeater values array
     * @param array $placeholders Placeholders
     * @param array $replacements Replacements
     */
    protected function addRepeaterControlStyleRules(ControlsStack $controls_stack, array $repeater_control, array $repeater_values, array $placeholders, array $replacements)
    {
        $placeholders = array_merge($placeholders, ['{{CURRENT_ITEM}}']);

        foreach ($repeater_control['style_fields'] as $index => $item) {
            $this->addControlsStackStyleRules(
                $controls_stack,
                $item,
                $repeater_values[$index],
                $placeholders,
                array_merge($replacements, ['.elementor-repeater-item-' . $repeater_values[$index]['_id']]),
                $repeater_control['fields']
            );
        }
    }

    /**
     * Add dynamic control style rules.
     *
     * Register new style rules for the dynamic control.
     *
     * @since 2.0.0
     *
     * @param array $control The control
     * @param string $value The value
     */
    protected function addDynamicControlStyleRules(array $control, $value)
    {
        Plugin::$instance->dynamic_tags->parseTagsText($value, $control, function ($id, $name, $settings) {
            $tag = Plugin::$instance->dynamic_tags->createTag($id, $name, $settings);

            if (!$tag instanceof Tag) {
                return;
            }

            $this->addControlsStackStyleRules($tag, $tag->getStyleControls(), $tag->getActiveSettings(), ['{{WRAPPER}}'], ['#elementor-tag-' . $id]);
        });
    }
}
