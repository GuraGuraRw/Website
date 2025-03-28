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
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class WidgetTabs extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/86-widgets/general-widgets/310-tabs-widget';

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Tabs');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-tabs';
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
        return ['tabs', 'accordion', 'toggle'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_tabs',
            [
                'label' => __('Tabs'),
            ]
        );

        $repeater = new Repeater();

        $repeater->addControl(
            'tab_title',
            [
                'label' => __('Title & Description'),
                'type' => ControlsManager::TEXT,
                'default' => __('Tab Title'),
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
            ]
        );

        $repeater->addControl(
            'tab_content',
            [
                'label' => __('Content'),
                'default' => __('Tab Content'),
                'placeholder' => __('Tab Content'),
                'type' => ControlsManager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $this->addControl(
            'tabs',
            [
                'label' => __('Tabs Items'),
                'type' => ControlsManager::REPEATER,
                'fields' => $repeater->getControls(),
                'default' => [
                    [
                        'tab_title' => __('Tab #1'),
                        'tab_content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'),
                    ],
                    [
                        'tab_title' => __('Tab #2'),
                        'tab_content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
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

        $this->addControl(
            'type',
            [
                'label' => __('Type'),
                'type' => ControlsManager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal'),
                    'vertical' => __('Vertical'),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator' => 'before',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_tabs_style',
            [
                'label' => __('Tabs'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'navigation_width',
            [
                'label' => __('Navigation Width'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->addControl(
            'border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title, {{WRAPPER}} .elementor-tab-title:before, {{WRAPPER}} .elementor-tab-title:after, {{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-mobile-title, {{WRAPPER}} .elementor-tab-desktop-title.elementor-active, {{WRAPPER}} .elementor-tab-title:before, {{WRAPPER}} .elementor-tab-title:after, {{WRAPPER}} .elementor-tab-content, {{WRAPPER}} .elementor-tabs-content-wrapper' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-tabs-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'heading_title',
            [
                'label' => __('Title'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'tab_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title, {{WRAPPER}} .elementor-tab-title a' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ],
            ]
        );

        $this->addControl(
            'tab_active_color',
            [
                'label' => __('Active Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active a' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
            ]
        );

        $this->addGroupControl(
            GroupControlTextStroke::getType(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
            ]
        );

        $this->addControl(
            'heading_content',
            [
                'label' => __('Content'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'content_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $tabs = $this->getSettingsForDisplay('tabs');

        $id_int = substr($this->getIdInt(), 0, 3); ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
            <?php foreach ($tabs as $index => $item) {
                $tab_count = $index + 1;
                $tab_title_key = $this->getRepeaterSettingKey('tab_title', 'tabs', $index);

                $this->addRenderAttribute($tab_title_key, [
                    'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                    'class' => ['elementor-tab-title', 'elementor-tab-desktop-title'],
                    'data-tab' => $tab_count,
                    'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                ]); ?>
                <div <?php $this->printRenderAttributeString($tab_title_key); ?> role="tab">
                    <a href="javascript:;"><?php echo $item['tab_title']; ?></a>
                </div>
            <?php } ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
            <?php foreach ($tabs as $index => $item) {
                $tab_count = $index + 1;
                $tab_content_key = $this->getRepeaterSettingKey('tab_content', 'tabs', $index);
                $tab_title_mobile_key = $this->getRepeaterSettingKey('tab_title_mobile', 'tabs', $tab_count);

                $this->addRenderAttribute($tab_content_key, [
                    'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                    'class' => ['elementor-tab-content', 'elementor-clearfix'],
                    'data-tab' => $tab_count,
                    'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                ]);
                $this->addRenderAttribute($tab_title_mobile_key, [
                    'class' => ['elementor-tab-title', 'elementor-tab-mobile-title'],
                    'data-tab' => $tab_count,
                    'role' => 'tab',
                ]);
                $this->addInlineEditingAttributes($tab_content_key, 'advanced'); ?>
                <div <?php $this->printRenderAttributeString($tab_title_mobile_key); ?>><?php echo $item['tab_title']; ?></div>
                <div <?php $this->printRenderAttributeString($tab_content_key); ?> role="tabpanel">
                    <?php echo isset($item['__dynamic__']['tab_content']) ? $item['tab_content'] : $this->parseTextEditor($item['tab_content']); ?>
                </div>
            <?php } ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render tabs widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
        ?>
        <div class="elementor-tabs" role="tablist">
        <# if ( settings.tabs ) {
            var tabindex = view.getIDInt().toString().substr( 0, 3 );
            #>
            <div class="elementor-tabs-wrapper">
            <# _.each( settings.tabs, function( item, index ) {
                var tabCount = index + 1;
                #>
                <div id="elementor-tab-title-{{ tabindex + tabCount }}"
                    class="elementor-tab-title elementor-tab-desktop-title"
                    data-tab="{{ tabCount }}" role="tab"
                    aria-controls="elementor-tab-content-{{ tabindex + tabCount }}">
                    <a href="javascript:;">{{{ item.tab_title }}}</a>
                </div>
            <# } ); #>
            </div>
            <div class="elementor-tabs-content-wrapper">
            <# _.each( settings.tabs, function( item, index ) {
                var tabCount = index + 1,
                    tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'tabs',index );

                view.addRenderAttribute( tabContentKey, {
                    'id': 'elementor-tab-content-' + tabindex + tabCount,
                    'class': [ 'elementor-tab-content', 'elementor-clearfix', 'elementor-repeater-item-' + item._id ],
                    'data-tab': tabCount,
                    'role' : 'tabpanel',
                    'aria-labelledby' : 'elementor-tab-title-' + tabindex + tabCount
                } );

                view.addInlineEditingAttributes( tabContentKey, 'advanced' );
                #>
                <div class="elementor-tab-title elementor-tab-mobile-title" data-tab="{{ tabCount }}" role="tab">
                    {{{ item.tab_title }}}
                </div>
                <div {{{ view.getRenderAttributeString( tabContentKey ) }}}>{{{ item.tab_content }}}</div>
            <# } ); #>
            </div>
        <# } #>
        </div>
        <?php
    }
}
