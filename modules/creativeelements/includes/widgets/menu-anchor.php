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
 * Elementor menu anchor widget.
 *
 * Elementor widget that allows to link and menu to a specific position on the
 * page.
 *
 * @since 1.0.0
 */
class WidgetMenuAnchor extends WidgetBase
{
    const HELP_URL = 'http://docs.webshopworks.com/creative-elements/86-widgets/general-widgets/330-menu-anchor-widget';

    /**
     * Get widget name.
     *
     * Retrieve menu anchor widget name.
     *
     * @since 1.0.0
     *
     * @return string Widget name
     */
    public function getName()
    {
        return 'menu-anchor';
    }

    /**
     * Get widget title.
     *
     * Retrieve menu anchor widget title.
     *
     * @since 1.0.0
     *
     * @return string Widget title
     */
    public function getTitle()
    {
        return __('Menu Anchor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve menu anchor widget icon.
     *
     * @since 1.0.0
     *
     * @return string Widget icon
     */
    public function getIcon()
    {
        return 'eicon-anchor';
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
        return ['menu', 'anchor', 'link'];
    }

    protected function isDynamicContent()
    {
        return false;
    }

    /**
     * Register menu anchor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_anchor',
            [
                'label' => __('Anchor'),
            ]
        );

        $this->addControl(
            'anchor',
            [
                'label' => __('The ID of Menu Anchor.'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('For Example: About'),
                'description' => __('This ID will be the CSS ID you will have to use in your own page, Without #.'),
                'label_block' => true,
            ]
        );

        $this->addControl(
            'anchor_note',
            [
                'type' => ControlsManager::RAW_HTML,
                'raw' => sprintf(__('Note: The ID link ONLY accepts these chars: %s'), '`A-Z, a-z, 0-9, _ , -`'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ]
        );

        $this->endControlsSection();
    }

    /**
     * Render menu anchor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        $anchor = $this->getSettingsForDisplay('anchor');

        if (!empty($anchor)) {
            $this->addRenderAttribute('inner', 'id', sanitize_html_class($anchor));
        }

        $this->addRenderAttribute('inner', 'class', 'elementor-menu-anchor'); ?>
        <div <?php $this->printRenderAttributeString('inner'); ?>></div>
        <?php
    }

    /**
     * Render menu anchor widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     */
    protected function contentTemplate()
    {
        ?>
        <div class="elementor-menu-anchor"{{{ settings.anchor ? ' id="' + settings.anchor + '"' : '' }}}></div>
        <?php
    }
}
