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

use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator;

class BackupOptionsForm
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

    public function __construct(Translator $translator, FormRenderer $formRenderer)
    {
        $this->translator = $translator;
        $this->formRenderer = $formRenderer;

        $translationDomain = 'Modules.Etsupgrade.Admin';

        $this->fields = array(
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
                'backupOptions',
                $this->fields,
                $this->translator->trans(
                    'Backup Options',
                    array(),
                    'Modules.Etsupgrade.Admin'
                ),
                '',
                'database_gear'
            );
    }
}
