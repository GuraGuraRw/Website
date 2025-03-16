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

namespace PrestaShop\Module\EtsAutoUpgrade;

use PrestaShop\Module\EtsAutoUpgrade\Log\LoggerInterface;

class Workspace
{
    /**
     * @var LoggerInterface
    */
    private $logger;

    /**
     * @var UpgradeTools\Translator
    */
    private $translator;

    /**
     * @var array List of paths used by autoupgrade
    */
    private $paths;

    public function __construct(LoggerInterface $logger, $translator, array $paths)
    {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->paths = $paths;
    }

    public function createFolders()
    {
        foreach ($this->paths as $path) {
            if (!file_exists($path) && !mkdir($path)) {
                $this->logger->error($this->translator->trans('Unable to create directory %s', array($path), 'Modules.Etsupgrade.Admin'));
            }
            if (!is_writable($path)) {
                $this->logger->error($this->translator->trans('Unable to write in the directory "%s"', array($path), 'Modules.Etsupgrade.Admin'));
            }
        }
    }
}
