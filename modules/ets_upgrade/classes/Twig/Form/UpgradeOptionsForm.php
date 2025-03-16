<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/

namespace PrestaShop\Module\EtsAutoUpgrade\Twig\Form;

use PrestaShop\Module\EtsAutoUpgrade\Upgrader;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator;

class UpgradeOptionsForm
{
    /**
     * @var array
    */
    private $fields;

    /**
     * @var Translator
    */
    private $translator;

    /**
     * @var FormRenderer
    */
    private $formRenderer;

    /**
     * @var Upgrader
    */
    private $upgrader;

    public function __construct(
        Translator $translator,
        FormRenderer $formRenderer,
        Upgrader $upgrader
    )
    {
        $this->upgrader = $upgrader;
        $this->translator = $translator;
        $this->formRenderer = $formRenderer;

        // TODO: Class const
        $translationDomain = 'Modules.Etsupgrade.Admin';
        $choices = array();
        if ($channels = $this->upgrader->getChannels()) {
            $ik = 0;
            foreach ($channels as $key => $channel) {
                $choices[$key] = $translator->trans('Prestashop %s latest version - %s', array_values($channel), $translationDomain) . (!$ik ? ' ' . $translator->trans('(Recommended)', array(), $translationDomain) : '') . (!empty($channel['changelog']) ? ' <a href="' . $channel['changelog'] . '" target="_blank">' . $translator->trans('Change log', array(), $translationDomain) . '</a>' : '');
                if (!$ik)  $ik++;
            }
        }

        $this->fields = array(
            'channel' => array(
                'title' => $translator->trans(
                    'Select Prestashop version to upgrade',
                    array(),
                    $translationDomain
                ),
                'validation' => 'isString',
                'defaultValue' => count($choices) > 1 ? 'major' : 'minor',
                'type' => 'radio',
                'choices' => $choices,
            ),
            'PS_AUTOUP_PERFORMANCE' => array(
                'title' => $translator->trans(
                    'Server performance',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isInt',
                'defaultValue' => '2',
                'type' => 'range',
                'desc' => $translator->trans(
                        'Unless you are using a dedicated server, select "Medium" or "Low".',
                        array(),
                        $translationDomain
                    ) . '<br />' .
                    $translator->trans(
                        'A high value can cause the upgrade to fail if your server is not powerful enough to process the upgrade tasks in a short amount of time.',
                        array(),
                        $translationDomain
                    ),
                'min' => 1,
                'step' => 1,
                'max' => 3,
                'col' => 9,
                'labels' => array(
                    1 => $translator->trans('Low', array(), $translationDomain),
                    2 => $translator->trans('Medium (recommended)', array(), $translationDomain),
                    3 => $translator->trans('High', array(), $translationDomain),
                ),
            ),
            'PS_AUTOUP_CUSTOM_MOD_DESACT' => array(
                'title' => $translator->trans(
                    'Disable non-native modules',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'type' => 'bool',
                'desc' => $translator->trans(
                        'As non-native modules can experience some compatibility issues, we recommend to disable them by default.',
                        array(),
                        $translationDomain
                    ) . '<br />' .
                    $translator->trans(
                        'Keeping them enabled might prevent you from loading the "Modules" page properly after the upgrade.',
                        array(),
                        $translationDomain
                    ),
            ),
            'PS_AUTOUP_UPDATE_DEFAULT_THEME' => array(
                'title' => $translator->trans(
                    'Upgrade the default theme',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'defaultValue' => '1',
                'type' => 'bool',
                'desc' => $translator->trans(
                        'If you customized the default PrestaShop theme in its folder (folder name "classic" in 1.7), enabling this option will lose your modifications.',
                        array(),
                        $translationDomain
                    ) . '<br />'
                    . $translator->trans(
                        'If you are using your own theme, enabling this option will simply update the default theme files, and your own theme will be safe.',
                        array(),
                        $translationDomain
                    ). '<br />'. $translator->trans(
                        '"Upgrade the default theme" is required if you upgrade Prestashop: 1.5->1.6, 1.5->1.7 or 1.6->1.7',
                        array(),
                        $translationDomain
                    ),

            ),
            'PS_AUTOUP_CHANGE_DEFAULT_THEME' => array(
                'title' => $translator->trans(
                    'Switch to the default theme',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'defaultValue' => '0',
                'type' => 'bool',
                'desc' => $translator->trans(
                    'This will change your theme: your shop will then use the default theme of the version of PrestaShop you are upgrading to.',
                    array(),
                    $translationDomain
                ). '<br />'. $translator->trans(
                        '"Switch to the default theme" is required if you upgrade Prestashop: 1.5->1.6, 1.5->1.7 or 1.6->1.7',
                        array(),
                        $translationDomain
                    ),
            ),
            'PS_AUTOUP_KEEP_MAILS' => array(
                'title' => $translator->trans(
                    'Keep the customized email templates',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'type' => 'bool',
                'desc' => $translator->trans(
                        'This will not upgrade the default PrestaShop e-mails.',
                        array(),
                        $translationDomain
                    ) . '<br />'
                    . $translator->trans(
                        'If you customized the default PrestaShop e-mail templates, enabling this option will keep your modifications.',
                        array(),
                        $translationDomain
                    ),
            ),
            'PS_AUTOUP_BACKUP' => array(
                'title' => $this->translator->trans(
                    'Back up my files and database',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'defaultValue' => '1',
                'type' => 'bool',
                'desc' => $this->translator->trans(
                    'Automatically back up your database and files in order to restore your shop if needed. This is experimental: you should still perform your own manual backup for safety.',
                    array(),
                    $translationDomain
                ),
            ),
            'PS_AUTOUP_KEEP_IMAGES' => array(
                'title' => $this->translator->trans(
                    'Back up my images',
                    array(),
                    $translationDomain
                ),
                'cast' => 'intval',
                'validation' => 'isBool',
                'defaultValue' => '1',
                'type' => 'bool',
                'desc' => $this->translator->trans(
                    'To save time, you can decide not to back your images up. In any case, always make sure you did back them up manually.',
                    array(),
                    $translationDomain
                ),
            ),
        );
    }

    public function render()
    {
        return $this->formRenderer->render(
            'upgradeOptions',
            $this->fields,
            $this->translator->trans(
                'Upgrade Options',
                array(),
                'Modules.Etsupgrade.Admin'
            ),
            '',
            'prefs'
        );
    }
}
