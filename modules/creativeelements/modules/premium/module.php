<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2024 WebshopWorks.com
 * @license   One domain support license
 */
namespace CE;

if (!defined('_PS_VERSION_')) {
    exit;
}

use CE\CoreXBaseXModule as BaseModule;

class ModulesXPremiumXModule extends BaseModule
{
    public function getName()
    {
        return 'premium';
    }

    public static function addCaptchaPromoControls(WidgetBase $widget)
    {
        _CE_ADMIN_ && !\Tools::file_exists_cache(_PS_MODULE_DIR_ . 'invrecaptcha/invrecaptcha.php') && $widget->addControl(
            'captcha',
            [
                'type' => ControlsManager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'raw' => '
                    <i class="eicon-close" style="position:absolute; top:8px; right:8px; cursor:pointer" onclick="$(`.elementor-control-show_captcha input`).prop(`checked`, false).change()"></i>
                    Protect your site against spam and abuse, while letting your real customers pass through with ease.
                    <a href="https://addons.prestashop.com/website-security-access/32222-spam-protection-invisible-recaptcha.html" target="_blank">
                        <i class="eicon-link"></i>Invisible reCAPTCHA
                    </a> does this all in the background without any user interaction.
                    <style>.elementor-control-captcha:not(.elementor-hidden-control) ~ .elementor-control-show_captcha { display: none }</style>
                ',
                'condition' => [
                    'show_captcha!' => '',
                ],
            ]
        ) && $widget->addControl(
            'show_captcha',
            [
                'label' => 'Spam Protection - Invisible reCaptcha',
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => __('Learn More'),
                        'icon' => 'eicon-info-circle',
                    ],
                ],
                'default' => 'yes',
                'render_type' => 'none',
            ]
        );
    }

    public function registerDocuments($documents)
    {
        $documents->registerDocumentType('content', 'CE\ModulesXPremiumXDocumentsXContent');
    }

    public function registerWidgets($widgets_manager)
    {
        foreach ([
            'AnimatedHeadline',
            'LayerSlider',
            'CallToAction',
            'FlipBox',
            'ImageHotspot',
            'ContactForm',
            'EmailSubscription',
            'Countdown',
            'TestimonialCarousel',
            'TrustedshopsReviews',
            'FacebookPage',
            'FacebookButton',
            'Template',
            'ImageSlider',
            'Module',
        ] as $class_suffix) {
            $widget_class = 'CE\ModulesXPremiumXWidgetsX' . $class_suffix;

            $widgets_manager->registerWidgetType(new $widget_class());
        }
    }

    public function __construct()
    {
        add_action('elementor/documents/register', [$this, 'registerDocuments']);
        add_action('elementor/widgets/widgets_registered', [$this, 'registerWidgets']);
    }
}
