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
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

/**
 * ajaxProcessRestoreFiles restore the previously saved files,
 * and delete files that weren't archived.
 */
class RestoreFiles extends AbstractTask
{
    public function run()
    {
        // loop
        $this->stepDone = false;
        $this->next = 'restoreFiles';
        if (!$this->container->getState()->getForceStep() &&
            (!file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_FROM_ARCHIVE_LIST) || !file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_TO_REMOVE_LIST))
        ) {
            // cleanup current PS tree
            $fromArchive = $this->container->getZipAction()->listContent($this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $this->container->getState()->getRestoreFilesFilename());
            foreach ($fromArchive as $k => $v) {
                $fromArchive[DIRECTORY_SEPARATOR . $v] = DIRECTORY_SEPARATOR . $v;
            }
            unset($k);
            $this->container->getFileConfigurationStorage()->save($fromArchive, UpgradeFileNames::FILES_FROM_ARCHIVE_LIST);
            // get list of files to remove
            $toRemove = $this->container->getFilesystemAdapter()->listFilesToRemove();
            $toRemoveOnly = array();

            // let's reverse the array in order to make possible to rmdir
            // remove fullpath. This will be added later in the loop.
            // we do that for avoiding fullpath to be revealed in a text file
            foreach ($toRemove as $k => $v) {
                $vfile = str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $v);
                $toRemove[] = str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $vfile);

                if (!isset($fromArchive[$vfile]) && is_file($v)) {
                    $toRemoveOnly[$vfile] = str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $vfile);
                }
            }

            $this->logger->debug($this->translator->trans('%s file(s) will be removed before restoring the backup files.', array(count($toRemoveOnly)), 'Modules.Etsupgrade.Admin'));
            $this->container->getFileConfigurationStorage()->save($toRemoveOnly, UpgradeFileNames::FILES_TO_REMOVE_LIST);

            if (empty($fromArchive) || empty($toRemove)) {
                if (empty($fromArchive)) {
                    $this->logger->error($this->translator->trans('[ERROR] Backup file %s does not exist.', array(UpgradeFileNames::FILES_FROM_ARCHIVE_LIST), 'Modules.Etsupgrade.Admin'));
                }
                if (empty($toRemove)) {
                    $this->logger->error($this->translator->trans('[ERROR] File "%s" does not exist.', array(UpgradeFileNames::FILES_TO_REMOVE_LIST), 'Modules.Etsupgrade.Admin'));
                }
                $this->logger->info($this->translator->trans('Unable to remove upgraded files.', array(), 'Modules.Etsupgrade.Admin'));
                $this->next = 'error';

                return false;
            }
        }

        if ($this->container->getState()->getForceStep()) {
            $fromArchive = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_FROM_ARCHIVE_LIST);
            $toRemoveOnly = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_TO_REMOVE_LIST);
        }

        $destExtract = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH);
        if (!empty($fromArchive)) {
            $filepath = $this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $this->container->getState()->getRestoreFilesFilename();

            $res = $this->container->getZipAction()->extract($filepath, $destExtract, 1);
            if (!$res) {
                $this->next = 'error';
                $this->logger->error($this->translator->trans(
                    'Unable to extract file %filename% into directory %directoryname%.',
                    array(
                        '%filename%' => $filepath,
                        '%directoryname%' => $destExtract,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            }

            if (!empty($toRemoveOnly)) {
                foreach ($toRemoveOnly as $fileToRemove) {
                    @unlink($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . $fileToRemove);
                }
            }

        }
        if ($this->container->getZipAction()->extractZipCompleted($destExtract)) {
            $this->container->getState()->setForceStep(0);
            $this->stepDone = true;
            $this->next = 'restoreDb';
            $this->logger->debug($this->translator->trans('Files restored.', array(), 'Modules.Etsupgrade.Admin'));
            $this->logger->info($this->translator->trans('Files restored. Now restoring database...', array(), 'Modules.Etsupgrade.Admin'));
            if (PHP_VERSION_ID >= 80000) {
                $defines = preg_replace('/\s*get_magic_quotes_gpc\(\)\s*/', ' false', Tools14::file_get_contents($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/config/defines.inc.php'));
                file_put_contents($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/config/defines.inc.php', $defines);
            }
        } else {
            $this->container->getState()->setForceStep(1);
            $this->stepDone = false;
            $this->next = 'restoreFiles';
            $this->logger->info($this->translator->trans('Files restore continue.', array(), 'Modules.Etsupgrade.Admin'));
        }

        return true;
    }

    public function init()
    {
        // Do nothing
    }
}
