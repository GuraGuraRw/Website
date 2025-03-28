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

use CE\CoreXSettingsXManager as SettingsManager;

/**
 * Elementor typography control.
 *
 * A base control for creating typography control. Displays input fields to define
 * the content typography including font size, font family, font weight, text
 * transform, font style, line height and letter spacing.
 *
 * @since 1.0.0
 */
class GroupControlTypography extends GroupControlBase
{
    /**
     * Fields.
     *
     * Holds all the typography control fields.
     *
     * @since 1.0.0
     * @static
     *
     * @var array Typography control fields
     */
    protected static $fields;

    /**
     * Scheme fields keys.
     *
     * Holds all the typography control scheme fields keys.
     * Default is an array containing `font_family` and `font_weight`.
     *
     * @since 1.0.0
     * @static
     *
     * @var array Typography control scheme fields keys
     */
    private static $_scheme_fields_keys = ['font_family', 'font_weight'];

    /**
     * Get scheme fields keys.
     *
     * Retrieve all the available typography control scheme fields keys.
     *
     * @since 1.0.0
     * @static
     *
     * @return array Scheme fields keys
     */
    public static function getSchemeFieldsKeys()
    {
        return self::$_scheme_fields_keys;
    }

    /**
     * Get typography control type.
     *
     * Retrieve the control type, in this case `typography`.
     *
     * @since 1.0.0
     * @static
     *
     * @return string Control type
     */
    public static function getType()
    {
        return 'typography';
    }

    /**
     * Init fields.
     *
     * Initialize typography control fields.
     *
     * @since 1.2.2
     *
     * @return array Control fields
     */
    protected function initFields()
    {
        $fields = [];

        $default_fonts = SettingsManager::getSettingsManagers('general')->getModel()->getSettings('elementor_default_generic_fonts');

        if ($default_fonts) {
            $default_fonts = ', ' . $default_fonts;
        }

        $fields['font_family'] = [
            'label' => _x('Family', 'Typography Control'),
            'type' => ControlsManager::FONT,
            'selector_value' => 'font-family: "{{VALUE}}"' . $default_fonts . ';',
        ];

        $fields['font_size'] = [
            'label' => _x('Size', 'Typography Control'),
            'type' => ControlsManager::SLIDER,
            'size_units' => ['px', 'em', 'rem', 'vw'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 200,
                ],
                'vw' => [
                    'min' => 0.1,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'responsive' => true,
            'selector_value' => 'font-size: {{SIZE}}{{UNIT}}',
        ];

        $typo_weight_options = [
            '' => __('Default'),
        ];

        foreach (array_merge(['normal', 'bold'], range(100, 900, 100)) as $weight) {
            $typo_weight_options[$weight] = ucfirst($weight);
        }

        $fields['font_weight'] = [
            'label' => _x('Weight', 'Typography Control'),
            'type' => ControlsManager::SELECT,
            'options' => &$typo_weight_options,
        ];

        $fields['text_transform'] = [
            'label' => _x('Transform', 'Typography Control'),
            'type' => ControlsManager::SELECT,
            'options' => [
                '' => __('Default'),
                'uppercase' => _x('Uppercase', 'Typography Control'),
                'lowercase' => _x('Lowercase', 'Typography Control'),
                'capitalize' => _x('Capitalize', 'Typography Control'),
                'none' => _x('Normal', 'Typography Control'),
            ],
        ];

        $fields['font_style'] = [
            'label' => _x('Style', 'Typography Control'),
            'type' => ControlsManager::SELECT,
            'options' => [
                '' => __('Default'),
                'normal' => _x('Normal', 'Typography Control'),
                'italic' => _x('Italic', 'Typography Control'),
                'oblique' => _x('Oblique', 'Typography Control'),
            ],
        ];

        $fields['text_decoration'] = [
            'label' => _x('Decoration', 'Typography Control'),
            'type' => ControlsManager::SELECT,
            'options' => [
                '' => __('Default'),
                'underline' => _x('Underline', 'Typography Control'),
                'overline' => _x('Overline', 'Typography Control'),
                'line-through' => _x('Line Through', 'Typography Control'),
                'none' => _x('None', 'Typography Control'),
            ],
        ];

        $fields['line_height'] = [
            'label' => _x('Line-Height', 'Typography Control'),
            'type' => ControlsManager::SLIDER,
            'desktop_default' => [
                'unit' => 'em',
            ],
            'tablet_default' => [
                'unit' => 'em',
            ],
            'mobile_default' => [
                'unit' => 'em',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                ],
            ],
            'responsive' => true,
            'size_units' => ['px', 'em'],
            'selector_value' => 'line-height: {{SIZE}}{{UNIT}}',
        ];

        $fields['letter_spacing'] = [
            'label' => _x('Letter Spacing', 'Typography Control'),
            'type' => ControlsManager::SLIDER,
            'range' => [
                'px' => [
                    'min' => -5,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'responsive' => true,
            'selector_value' => 'letter-spacing: {{SIZE}}{{UNIT}}',
        ];

        return $fields;
    }

    /**
     * Prepare fields.
     *
     * Process typography control fields before adding them to `add_control()`.
     *
     * @since 1.2.3
     *
     * @param array $fields Typography control fields
     *
     * @return array Processed fields
     */
    protected function prepareFields($fields)
    {
        array_walk(
            $fields,
            function (&$field, $field_name) {
                if (in_array($field_name, ['typography', 'popover_toggle'])) {
                    return;
                }

                $selector_value = !empty($field['selector_value']) ? $field['selector_value'] : str_replace('_', '-', $field_name) . ': {{VALUE}};';

                $field['selectors'] = [
                    '{{SELECTOR}}' => $selector_value,
                ];
            }
        );

        return parent::prepareFields($fields);
    }

    /**
     * Add group arguments to field.
     *
     * Register field arguments to typography control.
     *
     * @since 1.2.2
     *
     * @param string $control_id Typography control id
     * @param array $field_args Typography control field arguments
     *
     * @return array Field arguments
     */
    protected function addGroupArgsToField($control_id, $field_args)
    {
        $field_args = parent::addGroupArgsToField($control_id, $field_args);

        $args = $this->getArgs();

        if (in_array($control_id, self::getSchemeFieldsKeys()) && !empty($args['scheme'])) {
            $field_args['scheme'] = [
                'type' => self::getType(),
                'value' => $args['scheme'],
                'key' => $control_id,
            ];
        }

        return $field_args;
    }

    /**
     * Get default options.
     *
     * Retrieve the default options of the typography control. Used to return the
     * default options while initializing the typography control.
     *
     * @since 1.9.0
     *
     * @return array Default typography control options
     */
    protected function getDefaultOptions()
    {
        return [
            'popover' => [
                'starter_name' => 'typography',
                'starter_title' => __('Typography'),
                'settings' => [
                    'render_type' => 'ui',
                ],
            ],
        ];
    }
}
