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
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class WidgetImageBox extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/86-widgets/general-widgets/304-image-box-widget';

    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'image-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Image Box');
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-image-box';
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
        return ['image', 'photo', 'visual', 'box'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register image box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_image',
            [
                'label' => __('Image Box'),
            ]
        );

        $this->addControl(
            'image',
            [
                'label' => __('Choose Image'),
                'type' => ControlsManager::MEDIA,
                'seo' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::getPlaceholderImageSrc(),
                ],
            ]
        );

        $this->addControl(
            'title_text',
            [
                'label' => __('Title & Description'),
                'type' => ControlsManager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('This is the heading'),
                'placeholder' => __('Enter your title'),
                'label_block' => true,
            ]
        );

        $this->addControl(
            'description_text',
            [
                'show_label' => false,
                'type' => ControlsManager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'),
                'placeholder' => __('Enter your description'),
                'rows' => 10,
            ]
        );

        $this->addControl(
            'link',
            [
                'label' => __('Link'),
                'type' => ControlsManager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'position',
            [
                'label' => __('Image Position'),
                'type' => ControlsManager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'top' => [
                        'title' => __('Top'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
            ]
        );

        $this->addControl(
            'title_display',
            [
                'label' => __('Title Display'),
                'type' => ControlsManager::CHOOSE,
                'options' => WidgetHeading::getDisplaySizes(),
                'style_transfer' => true,
            ]
        );

        $this->addControl(
            'title_size',
            [
                'label' => __('Title HTML Tag'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
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
            'section_style_image',
            [
                'label' => __('Image'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'image_space',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .elementor-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addResponsiveControl(
            'image_size',
            [
                'label' => __('Width') . ' (%)',
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 30,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'hover_animation',
            [
                'label' => __('Hover Animation'),
                'type' => ControlsManager::HOVER_ANIMATION,
            ]
        );

        $this->startControlsTabs('image_effects');

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
                'selector' => '{{WRAPPER}} .elementor-image-box-img img',
            ]
        );

        $this->addControl(
            'image_opacity',
            [
                'label' => __('Opacity'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->addControl(
            'background_hover_transition',
            [
                'label' => __('Transition Duration'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img img' => 'transition-duration: {{SIZE}}s',
                ],
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
                'selector' => '{{WRAPPER}}:hover .elementor-image-box-img img',
            ]
        );

        $this->addControl(
            'image_opacity_hover',
            [
                'label' => __('Opacity'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_content',
            [
                'label' => __('Content'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'text_align',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'content_vertical_alignment',
            [
                'label' => __('Vertical Alignment'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'top' => __('Top'),
                    'middle' => __('Middle'),
                    'bottom' => __('Bottom'),
                ],
                'default' => 'top',
                'prefix_class' => 'elementor-vertical-align-',
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

        $this->addResponsiveControl(
            'title_bottom_space',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'title_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-title' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-title',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
            ]
        );

        $this->addGroupControl(
            GroupControlTextStroke::getType(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-image-box-title',
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'title_shadow',
                'selector' => '{{WRAPPER}} .elementor-image-box-title',
            ]
        );

        $this->addControl(
            'heading_description',
            [
                'label' => __('Description'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'description_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-description' => 'color: {{VALUE}};',
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
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-description',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'description_shadow',
                'selector' => '{{WRAPPER}} .elementor-image-box-description',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Render image box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        $has_content = '' !== $settings['title_text'] || '' !== $settings['description_text'];

        $html = '<div class="elementor-image-box-wrapper">';

        if (!empty($settings['link']['url'])) {
            $this->addLinkAttributes('link', $settings['link']);
        }

        if (!empty($settings['image']['url'])) {
            $image_html = GroupControlImageSize::getAttachmentImageHtml($settings);

            if (!empty($settings['link']['url'])) {
                $image_html = '<a ' . $this->getRenderAttributeString('link') . '>' . $image_html . '</a>';
            }

            $html .= '<figure class="elementor-image-box-img">' . $image_html . '</figure>';
        }

        if ($has_content) {
            $html .= '<div class="elementor-image-box-content">';

            if ('' !== $settings['title_text']) {
                $this->addRenderAttribute('title_text', 'class', 'elementor-image-box-title');

                $settings['title_display'] && $this->addRenderAttribute('title_text', 'class', 'ce-display-' . $settings['title_display']);

                $this->addInlineEditingAttributes('title_text', 'none');

                $title_html = $settings['title_text'];

                if (!empty($settings['link']['url'])) {
                    $title_html = '<a ' . $this->getRenderAttributeString('link') . '>' . $title_html . '</a>';
                }

                $html .= "<{$settings['title_size']} {$this->getRenderAttributeString('title_text')}>$title_html</{$settings['title_size']}>";
            }

            if ('' !== $settings['description_text']) {
                $this->addRenderAttribute('description_text', 'class', 'elementor-image-box-description');
                $this->addInlineEditingAttributes('description_text');

                $html .= "<p {$this->getRenderAttributeString('description_text')}>{$settings['description_text']}</p>";
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        echo $html;
    }

    /**
     * Render image box widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
        ?>
        <#
        var html = '<div class="elementor-image-box-wrapper">';

        if ( settings.image.url ) {
            var imageUrl = elementor.helpers.getMediaLink( settings.image.url ),
                imageHtml = '<img src="' + imageUrl + '" class="elementor-animation-' + settings.hover_animation + '">';

            if ( settings.link.url ) {
                imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
            }

            html += '<figure class="elementor-image-box-img">' + imageHtml + '</figure>';
        }

        if ( settings.title_text || settings.description_text ) {
            html += '<div class="elementor-image-box-content">';

            if ( settings.title_text ) {
                var title_html = settings.title_text;

                if ( settings.link.url ) {
                    title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
                }

                view.addRenderAttribute( 'title_text', 'class', [
                    'elementor-image-box-title',
                    'ce-display-' + settings.title_display
                ] );
                view.addInlineEditingAttributes( 'title_text', 'none' );

                html += '<' + settings.title_size  + ' ' + view.getRenderAttributeString( 'title_text' ) + '>' +
                            title_html +
                        '</' + settings.title_size  + '>';
            }

            if ( settings.description_text ) {
                view.addRenderAttribute( 'description_text', 'class', 'elementor-image-box-description' );

                view.addInlineEditingAttributes( 'description_text' );

                html += '<p ' + view.getRenderAttributeString( 'description_text' ) + '>' +
                            settings.description_text +
                        '</p>';
            }

            html += '</div>';
        }

        html += '</div>';

        print( html );
        #>
        <?php
    }
}
