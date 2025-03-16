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

namespace PrestaShop\Module\EtsAutoUpgrade\Twig\Block;

use PrestaShop\Module\EtsAutoUpgrade\BackupFinder;
use Twig_Environment;

class RollbackForm
{
    /**
     * @var Twig_Environment|\Twig\Environment
     */
    private $twig;

    /**
     * @var BackupFinder
    */
    private $backupFinder;

    public function __construct($twig, BackupFinder $backupFinder)//Twig_Environment
    {
        $this->twig = $twig;
        $this->backupFinder = $backupFinder;
    }

    public function render()
    {
        return $this->twig->render(
            '@ModuleAutoUpgrade/block/rollbackForm.twig',
            array(
                'availableBackups' => $this->backupFinder->getAvailableBackups(),
            )
        );
    }
}
