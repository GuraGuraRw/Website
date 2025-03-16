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

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools;

use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\Log\LoggerInterface;

class CacheCleaner
{
    /**
     * @var UpgradeContainer
     */
    private $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(UpgradeContainer $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * @param $dirsToClean
     */
    public function cleanFolders($dirsToClean)
    {
        if (!$dirsToClean ||
            !is_array($dirsToClean) && !is_dir($dirsToClean)
        ) {
            return true;
        }
        if (!is_array($dirsToClean)) {
            $dirsToClean = array($dirsToClean);
        }
        foreach ($dirsToClean as $dir) {
            if (!file_exists($dir)) {
                $this->logger->debug($this->container->getTranslator()->trans('[SKIP] directory "%s" does not exist and cannot be emptied.', array(str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $dir)), 'Modules.Etsupgrade.Admin'));
                continue;
            }
            foreach (scandir($dir) as $file) {
                if ($file[0] === '.' || $file === 'index.php') {
                    continue;
                }
                // ToDo: Use Filesystem instead ?
                if (is_file($dir . $file)) {
                    if (!unlink($dir . $file)) {
                        $this->logger->debug($this->container->getTranslator()->trans('[CLEANING CACHE] File %s is not removed', array($file), 'Modules.Etsupgrade.Admin'));

                        return false;
                    }
                } elseif (is_dir($dir . $file . DIRECTORY_SEPARATOR)) {
                    if (!FilesystemAdapter::deleteDirectory($dir . $file . DIRECTORY_SEPARATOR)) {
                        $this->logger->debug($this->container->getTranslator()->trans('[CLEANING CACHE] Directory %s is not removed', array($file), 'Modules.Etsupgrade.Admin'));

                        return false;
                    }
                }
                $this->logger->debug($this->container->getTranslator()->trans('[CLEANING CACHE] File %s is removed', array($file), 'Modules.Etsupgrade.Admin'));
            }
        }

        return true;
    }
}
