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

class BackupFiles extends AbstractTask
{
	public function run()
	{
		if (!$this->container->getUpgradeConfiguration()->get('PS_AUTOUP_BACKUP')) {
			$this->stepDone = true;
			$this->next = 'backupDb';
			$this->logger->info('File backup skipped.');
            $this->container->getState()->setStepDone('backupFiles');

			return true;
		}

		$this->stepDone = false;
		$backupFilesFilename = $this->container->getState()->getBackupFilesFilename();
		if (empty($backupFilesFilename)) {
			$this->next = 'error';
			$this->error = true;
			$this->logger->info($this->translator->trans('Error during backup files', array(), 'Modules.Etsupgrade.Admin'));
			$this->logger->error($this->translator->trans('[ERROR] backup files filename has not been set', array(), 'Modules.Etsupgrade.Admin'));

			return false;
		}

		if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::FILES_TO_BACKUP_LIST)) {
			/** @todo : only add files and dir listed in "originalPrestashopVersion" list*/
			$filesToBackup = $this->container->getFilesystemAdapter()->listFilesInDir($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), 'backup', false);
			$this->container->getFileConfigurationStorage()->save($filesToBackup, UpgradeFileNames::FILES_TO_BACKUP_LIST);

			if ($countFiles = count($filesToBackup)) {
				$this->logger->debug($this->translator->trans('%s Files to backup.', array($countFiles), 'Modules.Etsupgrade.Admin'));

				//if total files backup is large then up part time.
                if ($partStep = $this->container->getState()->getEstimateTimeByStep('backupFiles')) {
                    $unitPart = $this->container->getState()->getUnitPart();
                    $changePart = (int)$partStep['part'] * (1 + (($countFiles - $unitPart)/$unitPart) * $this->container->getState()->getRatio());
                    $this->container->getState()->setEstimateTime(array(
                        'backupFiles' => array(
                            'part' => $changePart,
                            'stepDone' => 0,
                        ),
                    ));
                }
			}

			// delete old backup, create new
			if (!empty($backupFilesFilename) && file_exists($this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $backupFilesFilename)) {
				unlink($this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $backupFilesFilename);
			}

			$this->logger->debug($this->translator->trans('Backup files initialized in %s', array($backupFilesFilename), 'Modules.Etsupgrade.Admin'));
		}
		$filesToBackup = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_TO_BACKUP_LIST);

		$this->next = 'backupFiles';
		if (is_array($filesToBackup) && count($filesToBackup)) {
			$this->logger->info($this->translator->trans('Backup files in progress. %d files left', array(count($filesToBackup)), 'Modules.Etsupgrade.Admin'));

			$this->stepDone = false;
			$res = $this->container->getZipAction()->compress($filesToBackup, $this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $backupFilesFilename);
			if (!$res) {
				$this->next = 'error';
				$this->logger->info($this->translator->trans('Unable to open archive', array(), 'Modules.Etsupgrade.Admin'));

				return false;
			}
			$this->container->getFileConfigurationStorage()->save($filesToBackup, UpgradeFileNames::FILES_TO_BACKUP_LIST);
		}

		if (count($filesToBackup) <= 0) {
			$this->stepDone = true;
			$this->status = 'ok';
			$this->next = 'backupDb';
			$this->logger->debug($this->translator->trans('All files have been added to archive.', array(), 'Modules.Etsupgrade.Admin'));
			$this->logger->info($this->translator->trans('All files saved. Now backing up database', array(), 'Modules.Etsupgrade.Admin'));
            $this->container->getState()->setStepDone('backupFiles');
		}
	}
}
