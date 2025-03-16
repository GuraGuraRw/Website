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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

/**
 * Clean the cached from unwanted entries.
 */
class CleanCached extends AbstractTask
{
    public function run()
    {
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::FILES_CACHE)) {
            return $this->warmUp();
        }
        $this->next = 'cleanCached';
        $dirsToClean = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_CACHE);
        if (!is_array($dirsToClean)) {
            $this->next = 'upgradeDb';
            $this->stepDone = true;
            $this->container->getState()->setStepDone('cleanCached');
            return true;
        }
        if (count($dirsToClean) > 0) {
            do {
                $dir = array_shift($dirsToClean);
                if (!is_dir($dir) ||
                    !is_writeable($dir) ||
                    $this->container->getState()->getTimeout()
                ) {
                    $this->logger->debug($this->translator->trans('Cannot remove %s.', array($dir), 'Modules.Etsupgrade.Admin'));
                    if (is_dir($dir)) {
                        $dir = rtrim($dir, '\\/');
                        if (rename($dir, $dir . '_removed')) {
                            $this->container->getState()->setTimeout(0);
                        }
                    } else
                        $this->container->getState()->setTimeout(0);
                } elseif ($this->container->getCacheCleaner()->cleanFolders($dir)) {
                    $this->logger->debug($this->translator->trans('Directory %s has been removed.', array($dir), 'Modules.Etsupgrade.Admin'));
                }
            } while (count($dirsToClean) > 0);

            $dirsToCleanLeft = count($dirsToClean);
            $this->container->getFileConfigurationStorage()->save($dirsToCleanLeft, UpgradeFileNames::FILES_CACHE);
            $this->next = 'cleanCached';
            if ($dirsToCleanLeft) {
                $this->logger->info($this->translator->trans('%s directories to clean left.', array($dirsToCleanLeft), 'Modules.Etsupgrade.Admin'));
            }
            $this->stepDone = false;
        } else {
            if (@file_exists(UpgradeFileNames::FILES_CACHE)) {
                unlink(UpgradeFileNames::FILES_CACHE);
            }
            $this->stepDone = true;
            $this->status = 'ok';
            $this->next = 'upgradeDb';
            $this->logger->info($this->translator->trans('Directory needs to clean has been removed.', array(), 'Modules.Etsupgrade.Admin'));
            $this->container->getState()->setStepDone('cleanCached');

            // Clean Files:
            if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '>=')) {
                $this->cleanFiles();
            }
            return true;
        }

        return true;
    }

    public function warmUp()
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '<') && @file_exists(($class_index = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/cache/class_index.php')))
            @unlink($class_index);
        $dirsToClean = array(
            $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/app/cache/',
            $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/cache/smarty/cache/',
            $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/cache/smarty/compile/',
            $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/var/cache/',
        );

        $defaultThemeNames = array(
            'default',
            'prestashop',
            'default-boostrap',
            'classic',
        );

        if (defined('_THEME_NAME_') && $this->container->getUpgradeConfiguration()->shouldUpdateDefaultTheme() && in_array(_THEME_NAME_, $defaultThemeNames)) {
            $dirsToClean[] = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/themes/' . _THEME_NAME_ . '/cache/';
        }

        $this->container->getFileConfigurationStorage()->save($dirsToClean, UpgradeFileNames::FILES_CACHE);

        $total_dir_to_clean = count($dirsToClean);
        if ($total_dir_to_clean) {
            $this->logger->info($this->translator->trans('%s directory will be cleaned.', array($total_dir_to_clean), 'Modules.Etsupgrade.Admin'));
        }

        $this->stepDone = false;
        $this->next = 'cleanCached';

        return true;
    }

    public function cleanFiles()
    {
        $filesToClean = array(
            $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/classes/db/MySQL.php',
        );
        foreach ($filesToClean as $file) {
            if (is_file($file)) {
                if (!unlink($file)) {
                    $this->logger->debug($this->container->getTranslator()->trans('[CLEANING CACHE] File %s is not removed', array($file), 'Modules.Etsupgrade.Admin'));
                    return false;
                }
            }
        }
        return true;
    }

    public function init()
    {

    }

}