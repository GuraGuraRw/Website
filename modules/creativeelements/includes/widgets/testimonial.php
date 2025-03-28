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
 * Elementor testimonial widget.
 *
 * Elementor widget that displays customer testimonials that show social proof.
 *
 * @since 1.0.0
 */
class WidgetTestimonial extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/86-widgets/general-widgets/309-testimonial-widget';

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'testimonial';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Testimonial');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-testimonial';
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
        return ['testimonial', 'blockquote'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_testimonial',
            [
                'label' => __('Testimonial'),
            ]
        );

        $this->addControl(
            'testimonial_content',
            [
                'label' => __('Content'),
                'type' => ControlsManager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'rows' => '10',
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.'),
            ]
        );

        $this->addControl(
            'testimonial_image',
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
            'testimonial_name',
            [
                'label' => __('Name'),
                'type' => ControlsManager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => 'John Doe',
            ]
        );

        $this->addControl(
            'testimonial_job',
            [
                'label' => __('Title'),
                'type' => ControlsManager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => 'Designer',
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
            ]
        );

        $this->addControl(
            'testimonial_image_position',
            [
                'label' => __('Image Position'),
                'type' => ControlsManager::SELECT,
                'default' => 'aside',
                'options' => [
                    'aside' => __('Aside'),
                    'top' => __('Top'),
                ],
                'condition' => [
                    'testimonial_image[url]!' => '',
                ],
                'separator' => 'before',
                'style_transfer' => true,
            ]
        );

        $this->addControl(
            'testimonial_alignment',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'default' => 'center',
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
                ],
                'style_transfer' => true,
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

        // Content.
        $this->startControlsSection(
            'section_style_testimonial_content',
            [
                'label' => __('Content'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'content_content_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'content_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->addGroupControl(
            GroupControlTextStroke::getType(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->endControlsSection();

        // Image.
        $this->startControlsSection(
            'section_style_testimonial_image',
            [
                'label' => __('Image'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'testimonial_image[url]!' => '',
                ],
            ]
        );

        $this->addControl(
            'image_size',
            [
                'label' => __('Image Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'image_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->endControlsSection();

        // Name.
        $this->startControlsSection(
            'section_style_testimonial_name',
            [
                'label' => __('Name'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'name_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'name_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'name_shadow',
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->endControlsSection();

        // Job.
        $this->startControlsSection(
            'section_style_testimonial_job',
            [
                'label' => __('Title'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'job_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'job_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->addGroupControl(
            GroupControlTextShadow::getType(),
            [
                'name' => 'job_shadow',
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        $this->addRenderAttribute('wrapper', 'class', 'elementor-testimonial-wrapper');

        if ($settings['testimonial_alignment']) {
            $this->addRenderAttribute('wrapper', 'class', 'elementor-testimonial-text-align-' . $settings['testimonial_alignment']);
        }

        $this->addRenderAttribute('meta', 'class', 'elementor-testimonial-meta');

        if ($settings['testimonial_image']['url']) {
            $this->addRenderAttribute('meta', 'class', 'elementor-has-image');
        }

        if ($settings['testimonial_image_position']) {
            $this->addRenderAttribute('meta', 'class', 'elementor-testimonial-image-position-' . $settings['testimonial_image_position']);
        }

        $has_image = !empty($settings['testimonial_image']['url']);
        $has_name = '' !== $settings['testimonial_name'];
        $has_job = '' !== $settings['testimonial_job'];

        if (!$settings['testimonial_content'] && !$has_image && !$has_name && !$has_job) {
            return;
        }

        if (!empty($settings['link']['url'])) {
            $this->addLinkAttributes('link', $settings['link']);
        } ?>
        <div <?php $this->printRenderAttributeString('wrapper'); ?>>
        <?php if ($settings['testimonial_content']) {
            $this->addRenderAttribute('testimonial_content', 'class', 'elementor-testimonial-content');
            $this->addInlineEditingAttributes('testimonial_content'); ?>
            <div <?php $this->printRenderAttributeString('testimonial_content'); ?>>
                <?php echo $settings['testimonial_content']; ?>
            </div>
        <?php } ?>
        <?php if ($has_image || $has_name || $has_job) { ?>
            <div <?php $this->printRenderAttributeString('meta'); ?>>
                <div class="elementor-testimonial-meta-inner">
                <?php if ($has_image) { ?>
                    <div class="elementor-testimonial-image">
                    <?php
                    $image_html = GroupControlImageSize::getAttachmentImageHtml($settings, 'testimonial_image');

                    if (!empty($settings['link']['url'])) {
                        $image_html = '<a ' . $this->getRenderAttributeString('link') . '>' . $image_html . '</a>';
                    }
                    echo $image_html;
                    ?>
                    </div>
                <?php } ?>

                <?php if ($has_name || $has_job) { ?>
                    <div class="elementor-testimonial-details">
                    <?php if ($has_name) {
                        $this->addRenderAttribute('testimonial_name', 'class', 'elementor-testimonial-name');
                        $this->addInlineEditingAttributes('testimonial_name', 'none'); ?>
                        <?php if (!empty($settings['link']['url'])) { ?>
                            <a <?php echo "{$this->getRenderAttributeString('testimonial_name')} {$this->getRenderAttributeString('link')}"; ?>><?php echo $settings['testimonial_name']; ?></a>
                        <?php } else { ?>
                            <div <?php $this->printRenderAttributeString('testimonial_name'); ?>><?php echo $settings['testimonial_name']; ?></div>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($has_job) {
                        $this->addRenderAttribute('testimonial_job', 'class', 'elementor-testimonial-job');
                        $this->addInlineEditingAttributes('testimonial_job', 'none'); ?>
                        <?php if (!empty($settings['link']['url'])) { ?>
                            <a <?php echo "{$this->getRenderAttributeString('testimonial_job')} {$this->getRenderAttributeString('link')}"; ?>><?php echo $settings['testimonial_job']; ?></a>
                        <?php } else { ?>
                            <div <?php $this->printRenderAttributeString('testimonial_job'); ?>><?php echo $settings['testimonial_job']; ?></div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php
    }

    /**
     * Render testimonial widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
        ?>
        <#
        var imageUrl = false,
            hasImage = false;

        if ( '' !== settings.testimonial_image.url ) {
            imageUrl = elementor.helpers.getMediaLink( settings.testimonial_image.url );
            hasImage = ' elementor-has-image';

            var imageHtml = '<img src="' + imageUrl + '" alt="testimonial" />';
            if ( settings.link.url ) {
                imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
            }
        }

        var testimonial_alignment = settings.testimonial_alignment ? ' elementor-testimonial-text-align-' + settings.testimonial_alignment : '',
            testimonial_image_position = settings.testimonial_image_position ? ' elementor-testimonial-image-position-' + settings.testimonial_image_position : '';
        #>
        <div class="elementor-testimonial-wrapper{{ testimonial_alignment }}">
        <# if ( '' !== settings.testimonial_content ) {
            view.addRenderAttribute( 'testimonial_content', 'class', 'elementor-testimonial-content' );
            view.addInlineEditingAttributes( 'testimonial_content' );
            #>
            <div {{{ view.getRenderAttributeString( 'testimonial_content' ) }}}>
                {{{ settings.testimonial_content }}}
            </div>
        <# } #>
            <div class="elementor-testimonial-meta{{ hasImage }}{{ testimonial_image_position }}">
                <div class="elementor-testimonial-meta-inner">
                    <# if ( imageUrl ) { #>
                        <div class="elementor-testimonial-image">{{{ imageHtml }}}</div>
                    <# } #>
                    <div class="elementor-testimonial-details">
                        <?php $this->renderTestimonialDescription(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function renderTestimonialDescription()
    {
        ?>
        <#
        if ( '' !== settings.testimonial_name ) {
            view.addRenderAttribute( 'testimonial_name', 'class', 'elementor-testimonial-name' );
            view.addInlineEditingAttributes( 'testimonial_name', 'none' );

            if ( settings.link.url ) {
                #><a href="{{{ settings.link.url }}}" {{{ view.getRenderAttributeString( 'testimonial_name' ) }}}>{{{ settings.testimonial_name }}}</a><#
            } else {
                #><div {{{ view.getRenderAttributeString( 'testimonial_name' ) }}}>{{{ settings.testimonial_name }}}</div><#
            }
        }
        if ( '' !== settings.testimonial_job ) {
            view.addRenderAttribute( 'testimonial_job', 'class', 'elementor-testimonial-job' );
            view.addInlineEditingAttributes( 'testimonial_job', 'none' );

            if ( settings.link.url ) {
                #><a href="{{{ settings.link.url }}}" {{{ view.getRenderAttributeString( 'testimonial_job' ) }}}>{{{ settings.testimonial_job }}}</a><#
            } else {
                #><div {{{ view.getRenderAttributeString( 'testimonial_job' ) }}}>{{{ settings.testimonial_job }}}</div><#
            }
        }
        #>
        <?php
    }
}
