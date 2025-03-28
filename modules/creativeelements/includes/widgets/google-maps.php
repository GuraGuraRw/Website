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

/**
 * Elementor google maps widget.
 *
 * Elementor widget that displays an embedded google map.
 *
 * @since 1.0.0
 */
class WidgetGoogleMaps extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/85-widgets/basic-widgets/301-google-maps-widget';

    /**
     * Get widget name.
     *
     * Retrieve google maps widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'google_maps';
    }

    /**
     * Get widget title.
     *
     * Retrieve google maps widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Google Maps');
    }

    /**
     * Get widget icon.
     *
     * Retrieve google maps widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-google-maps';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the google maps widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     *
     * @return array Widget categories
     */
    public function getCategories()
    {
        return ['basic'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     *
     * @return array Widget keywords
     */
    public function getKeywords()
    {
        return ['google', 'map', 'embed', 'location'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register google maps widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_map',
            [
                'label' => __('Map'),
            ]
        );

        $default_address = __('London Eye, London, United Kingdom');
        $this->addControl(
            'address',
            [
                'label' => __('Location'),
                'type' => ControlsManager::TEXT,
                // 'dynamic' => [
                //     'active' => true,
                //     'categories' => [
                //         TagsModule::POST_META_CATEGORY,
                //     ],
                // ],
                'placeholder' => $default_address,
                'default' => $default_address,
                'label_block' => true,
            ]
        );

        $this->addControl(
            'zoom',
            [
                'label' => __('Zoom'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'separator' => 'before',
            ]
        );

        $this->addResponsiveControl(
            'height',
            [
                'label' => __('Height'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} \x69frame" => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'view',
            [
                'label' => __('View'),
                'type' => ControlsManager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_map_style',
            [
                'label' => __('Map'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->startControlsTabs('map_filter');

        $this->startControlsTab(
            'normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addGroupControl(
            GroupControlCssFilter::getType(),
            [
                'name' => 'css_filters',
                'selector' => "{{WRAPPER}} \x69frame",
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addGroupControl(
            GroupControlCssFilter::getType(),
            [
                'name' => 'css_filters_hover',
                'selector' => "{{WRAPPER}}:hover \x69frame",
            ]
        );

        $this->addControl(
            'hover_transition',
            [
                'label' => __('Transition Duration'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} \x69frame" => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();
    }

    /**
     * Render google maps widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        if (!$settings['address']) {
            return;
        }

        if (0 === (int) $settings['zoom']['size']) {
            $settings['zoom']['size'] = 10;
        }

        printf(
            '<div class="elementor-custom-embed">' .
            '<%s src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near"' .
            ' loading="lazy" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" aria-label="%s"></%1$s>' .
            '</div>',
            "\x69frame",
            rawurlencode($settings['address']),
            abs((int) $settings['zoom']['size']),
            esc_attr($settings['address'])
        );
    }
}
