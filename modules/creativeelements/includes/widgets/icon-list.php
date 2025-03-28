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
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class WidgetIconList extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/86-widgets/general-widgets/305-icon-list-widget';

    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'icon-list';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Icon List');
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-bullet-list';
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
        return ['icon list', 'icon', 'list'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_icon',
            [
                'label' => __('Icon List'),
            ]
        );

        $this->addControl(
            'view',
            [
                'label' => __('Layout'),
                'type' => ControlsManager::CHOOSE,
                'default' => 'traditional',
                'options' => [
                    'traditional' => [
                        'title' => __('Default'),
                        'icon' => 'eicon-editor-list-ul',
                    ],
                    'inline' => [
                        'title' => __('Inline'),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                ],
                'render_type' => 'template',
                'classes' => 'elementor-control-start-end',
                'style_transfer' => true,
                'prefix_class' => 'elementor-icon-list--layout-',
            ]
        );

        $repeater = new Repeater();

        $repeater->addControl(
            'text',
            [
                'label' => __('Text'),
                'type' => ControlsManager::TEXT,
                'label_block' => true,
                'placeholder' => __('List Item'),
                'default' => __('List Item'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->addControl(
            'selected_icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

        $repeater->addControl(
            'link',
            [
                'label' => __('Link'),
                'type' => ControlsManager::URL,
                'dynamic' => [
                    'active' => true,
                    'property' => 'url', // Tmp fix for contentTemplate
                ],
                'placeholder' => __('https://your-link.com'),
            ]
        );

        $this->addControl(
            'icon_list',
            [
                'type' => ControlsManager::REPEATER,
                'fields' => $repeater->getControls(),
                'default' => [
                    [
                        'text' => __('List Item #1'),
                        'selected_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'text' => __('List Item #2'),
                        'selected_icon' => [
                            'value' => 'fas fa-xmark',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'text' => __('List Item #3'),
                        'selected_icon' => [
                            'value' => 'far fa-circle-dot',
                            'library' => 'fa-regular',
                        ],
                    ],
                ],
                'title_field' => '{{{
                    elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\'
                }}} {{{ text }}}',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_icon_list',
            [
                'label' => __('List'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'space_between',
            [
                'label' => __('Space Between'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin: 0 calc(-{{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin: 0 calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'inset-inline-end: calc(-{{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->addResponsiveControl(
            'icon_align',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $columns = range(1, 10);
        $columns = array_combine($columns, $columns);
        $columns[''] = __('Default');

        $this->addResponsiveControl(
            'columns',
            [
                'label' => __('Columns'),
                'type' => ControlsManager::SELECT,
                'separator' => 'before',
                'options' => &$columns,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items' => 'columns: {{VALUE}};',
                ],
                'condition' => [
                    'view!' => 'inline',
                ],
            ]
        );

        $this->addResponsiveControl(
            'column_gap',
            [
                'label' => __('Columns Gap'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    '%' => [
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'inline',
                ],
            ]
        );

        $this->addControl(
            'divider',
            [
                'label' => __('Divider'),
                'type' => ControlsManager::POPOVER_TOGGLE,
                'label_off' => __('Off'),
                'label_on' => __('On'),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
                ],
                'separator' => 'before',
            ]
        );

        $this->startPopover();

        $this->addControl(
            'divider_style',
            [
                'label' => __('Style'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'solid' => __('Solid'),
                    'double' => __('Double'),
                    'dotted' => __('Dotted'),
                    'dashed' => __('Dashed'),
                ],
                'default' => 'solid',
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'divider_weight',
            [
                'label' => __('Weight'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'divider_width',
            [
                'label' => __('Width'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'condition' => [
                    'divider' => 'yes',
                    'view!' => 'inline',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'divider_height',
            [
                'label' => __('Height'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                    ],
                ],
                'condition' => [
                    'divider' => 'yes',
                    'view' => 'inline',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'divider_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'default' => '#ddd',
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ],
                'condition' => [
                    'divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endPopover();

        $this->endControlsSection();

        $this->startControlsSection(
            'section_icon_style',
            [
                'label' => __('Icon'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'icon_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon *' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ],
            ]
        );

        $this->addControl(
            'icon_color_hover',
            [
                'label' => __('Hover'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addResponsiveControl(
            'icon_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 14,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addResponsiveControl(
            'icon_self_align',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'view' => 'traditional',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_text_style',
            [
                'label' => __('Text'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ],
            ]
        );

        $this->addControl(
            'text_color_hover',
            [
                'label' => __('Hover'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'text_indent',
            [
                'label' => __('Text Indent'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'padding-inline-start: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item > *',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-icon-list-text',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Render icon list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        $this->addRenderAttribute('icon_list', 'class', 'elementor-icon-list-items');
        $this->addRenderAttribute('list_item', 'class', 'elementor-icon-list-item');

        if ('inline' === $settings['view']) {
            $this->addRenderAttribute('icon_list', 'class', 'elementor-inline-items');
            $this->addRenderAttribute('list_item', 'class', 'elementor-inline-item');
        } ?>
        <ul <?php $this->printRenderAttributeString('icon_list'); ?>>
        <?php foreach ($settings['icon_list'] as $index => $item) {
            $repeater_setting_key = $this->getRepeaterSettingKey('text', 'icon_list', $index);

            $this->addRenderAttribute($repeater_setting_key, 'class', 'elementor-icon-list-text');
            $this->addInlineEditingAttributes($repeater_setting_key); ?>
            <li class="elementor-icon-list-item">
            <?php empty($item['link']['url']) || print '<a ' . $this->addLinkAttributes("link_$index", $item['link'])->getRenderAttributeString("link_$index") . '>'; ?>
            <?php if ($icon = IconsManager::getBcIcon($item, 'icon', ['aria-hidden' => 'true'])) { ?>
                <span class="elementor-icon-list-icon"><?php echo $icon; ?></span>
            <?php } ?>
                <span <?php $this->printRenderAttributeString($repeater_setting_key); ?>><?php echo $item['text']; ?></span>
            <?php empty($item['link']['url']) || print '</a>'; ?>
            </li>
        <?php } ?>
        </ul>
        <?php
    }

    /**
     * Render icon list widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
        ?>
        <#
        var icon;

        view.addRenderAttribute( 'icon_list', 'class', 'elementor-icon-list-items' );
        view.addRenderAttribute( 'list_item', 'class', 'elementor-icon-list-item' );

        if ( 'inline' === settings.view ) {
            view.addRenderAttribute( 'icon_list', 'class', 'elementor-inline-items' );
            view.addRenderAttribute( 'list_item', 'class', 'elementor-inline-item' );
        }
        if ( settings.icon_list ) { #>
            <ul {{{ view.getRenderAttributeString( 'icon_list' ) }}}>
            <# _.each( settings.icon_list, function( item, index ) {
                var iconTextKey = view.getRepeaterSettingKey( 'text', 'icon_list', index );

                view.addRenderAttribute( iconTextKey, 'class', 'elementor-icon-list-text' );
                view.addInlineEditingAttributes( iconTextKey ); #>

                <li {{{ view.getRenderAttributeString( 'list_item' ) }}}>
                <# if ( item.link && item.link.url ) { #>
                    <a href="{{ item.link.url }}">
                <# } #>
                <# if ( icon = elementor.helpers.getBcIcon( view, item, 'icon' ) ) { #>
                    <span class="elementor-icon-list-icon">{{{ icon }}}</span>
                <# } #>
                    <span {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.text }}}</span>
                <# if ( item.link && item.link.url ) { #>
                    </a>
                <# } #>
                </li>
            <# } ); #>
            </ul><#
        } #>
        <?php
    }
}
