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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

/**
 * First step executed during a rollback.
 */
class Rollback extends AbstractTask
{
    public function run()
    {
        $this->container->getState()->setStartTime(time());
        // 1st, need to analyse what was wrong.
        $restoreName = $this->container->getState()->getRestoreName();
        $this->container->getState()->setRestoreFilesFilename($restoreName);
        $restoreDbFilenames = $this->container->getState()->getRestoreDbFilenames();

        if (empty($restoreName)) {
            $this->next = 'noRollbackFound';

            return;
        }

        if (preg_match('#^V(1\.[0-9]\.[0-9]+(?:\.[0-9]+))#', $restoreName, $version) && isset($version[1]) && trim($version[1]) !== '')
            $this->container->getState()->setOldVersion($version[1]);

        $files = scandir($this->container->getProperty(UpgradeContainer::BACKUP_PATH));
        // find backup filenames, and be sure they exists
        foreach ($files as $file) {
            if (preg_match('#' . preg_quote('auto-backupfiles_' . $restoreName) . '#', $file)) {
                $this->container->getState()->setRestoreFilesFilename($file);
                break;
            }
        }
        if (!is_file($this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $this->container->getState()->getRestoreFilesFilename())) {
            $this->next = 'error';
            $this->logger->error($this->translator->trans('[ERROR] File %s is missing: unable to restore files. Operation aborted.', array($this->container->getState()->getRestoreFilesFilename()), 'Modules.Etsupgrade.Admin'));

            return false;
        }
        $files = scandir($this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $restoreName);
        foreach ($files as $file) {
            if (preg_match('#auto-backupdb_[0-9]{6}_' . preg_quote($restoreName) . '#', $file)) {
                $restoreDbFilenames[] = $file;
            }
        }

        // order files is important !
        sort($restoreDbFilenames);
        $this->container->getState()->setRestoreDbFilenames($restoreDbFilenames);
        if (count($restoreDbFilenames) == 0) {
            $this->next = 'error';
            $this->logger->error($this->translator->trans('[ERROR] No backup database files found: it would be impossible to restore the database. Operation aborted.', array(), 'Modules.Etsupgrade.Admin'));

            return false;
        }
        $this->modulesRestore();
        $this->next = 'restoreFiles';
        $this->logger->info($this->translator->trans('Restoring files ...', array(), 'Modules.Etsupgrade.Admin'));
        // remove tmp files related to restoreFiles
        if (file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_FROM_ARCHIVE_LIST)) {
            unlink($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_FROM_ARCHIVE_LIST);
        }
        if (file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_TO_REMOVE_LIST)) {
            unlink($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_TO_REMOVE_LIST);
        }
    }

    public function init()
    {
        // Do nothing
    }

    public function modulesRestore()
    {
        $modulePath = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;

        if ($modules = @glob($modulePath . 'backup_*', GLOB_ONLYDIR)) {

            $this->logger->debug($this->translator->trans('%s modules will restore', array(count($modules)), 'Modules.Etsupgrade.Admin'));

            $modulePathPattern = str_replace(DIRECTORY_SEPARATOR, '\\' . DIRECTORY_SEPARATOR, $modulePath);
            foreach ($modules as $module) {
                $restoreName = preg_replace('/^' . $modulePathPattern . 'backup_/', '', $module);
                if (@rename($module, $modulePath . $restoreName)) {
                    $this->logger->info($this->translator->trans('Module %s restored', array($restoreName), 'Modules.Etsupgrade.Admin'));
                }
            }

        }
    }
}
