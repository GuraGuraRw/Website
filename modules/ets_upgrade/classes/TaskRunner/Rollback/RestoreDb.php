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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Database;

/**
 * Restores database from backup file.
*/
class RestoreDb extends AbstractTask
{
	public function run()
	{
		$databaseTools = new Database($this->container->getDb());
		$ignore_stats_table = array(
			_DB_PREFIX_ . 'connections',
			_DB_PREFIX_ . 'connections_page',
			_DB_PREFIX_ . 'connections_source',
			_DB_PREFIX_ . 'guest',
			_DB_PREFIX_ . 'statssearch',
			_DB_PREFIX_ . 'pagenotfound',
		);
		$startTime = time();
		$listQuery = array();

		// deal with running backup rest if exist
		if (file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST)) {
			$listQuery = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::QUERIES_TO_RESTORE_LIST);
		}

		// deal with the next files stored in restoreDbFilenames
		$restoreDbFilenames = $this->container->getState()->getRestoreDbFilenames();
		if (empty($listQuery) && count($restoreDbFilenames) > 0) {
			$currentDbFilename = array_shift($restoreDbFilenames);
			$this->container->getState()->setRestoreDbFilenames($restoreDbFilenames);
			if (!preg_match('#auto-backupdb_([0-9]{6})_#', $currentDbFilename, $match)) {
				$this->next = 'error';
				$this->error = true;
				$this->logger->error($this->translator->trans('%s: File format does not match.', array($currentDbFilename), 'Modules.Etsupgrade.Admin'));

				return false;
			}
			$this->container->getState()->setDbStep($match[1]);
			$backupdb_path = $this->container->getProperty(UpgradeContainer::BACKUP_PATH) . DIRECTORY_SEPARATOR . $this->container->getState()->getRestoreName();

			$dot_pos = strrpos($currentDbFilename, '.');
			$fileext = Tools14::substr($currentDbFilename, $dot_pos + 1);
			$content = '';

			$this->logger->debug($this->translator->trans(
				'Opening backup database file %filename% in %extension% mode',
				array(
					'%filename%' => $currentDbFilename,
					'%extension%' => $fileext,
				),
				'Modules.Etsupgrade.Admin'
			));

			switch ($fileext) {
				case 'bz':
				case 'bz2':
					$fp = call_user_func('bzopen', $backupdb_path . DIRECTORY_SEPARATOR . $currentDbFilename, 'r');
					if (is_resource($fp)) {
						while (!feof($fp)) {
							$content .= call_user_func('bzread', $fp, 4096);
						}
						call_user_func('bzclose', $fp);
					}
					break;
				case 'gz':
					$fp = gzopen($backupdb_path . DIRECTORY_SEPARATOR . $currentDbFilename, 'r');
					if (is_resource($fp)) {
						while (!feof($fp)) {
							$content .= gzread($fp, 4096);
						}
						gzclose($fp);
					}
					break;
				default:
					$fp = fopen($backupdb_path . DIRECTORY_SEPARATOR . $currentDbFilename, 'r');
					if (is_resource($fp)) {
						while (!feof($fp)) {
							$content .= fread($fp, 4096);
						}
						fclose($fp);
					}
			}
			$currentDbFilename = '';

			if (empty($content)) {
				$this->logger->error($this->translator->trans('Database backup is empty.', array(), 'Modules.Etsupgrade.Admin'));
				$this->next = 'rollback';

				return false;
			}

			// preg_match_all is better than preg_split (what is used in do Upgrade.php)
			// This way we avoid extra blank lines
			// option s (PCRE_DOTALL) added
			$listQuery = preg_split('/;[\n\r]+/Usm', $content);
			unset($content);

			// Get tables before backup
			if ($listQuery) {
				$tables_after_restore = array();
				foreach ($listQuery as $q) {
					if (preg_match('/`(?<table>' . _DB_PREFIX_ . '[a-zA-Z0-9_-]+)`/', $q, $matches)) {
						if (isset($matches['table'])) {
							$tables_after_restore[$matches['table']] = $matches['table'];
						}
					}
				}

				$tables_after_restore = array_unique($tables_after_restore);

				if ($this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST)) {
					$tables_after_restore = array_merge($tables_after_restore, $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST));
				}
				if (count($restoreDbFilenames) == 0) {
					$tables_before_restore = $databaseTools->getAllTables();
					$tablesToRemove = array_diff($tables_before_restore, $tables_after_restore, $ignore_stats_table);
					$this->container->getFileConfigurationStorage()->save($tablesToRemove, UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST);
				} else
					$this->container->getFileConfigurationStorage()->save($tables_after_restore, UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST);
			}
		}

		/** @todo : error if listQuery is not an array (that can happen if toRestoreQueryList is empty for example)*/
		$time_elapsed = time() - $startTime;
		if (is_array($listQuery) && count($listQuery) > 0) {
			$this->container->getDb()->execute('SET SESSION sql_mode = \'\'');
			$this->container->getDb()->execute('SET FOREIGN_KEY_CHECKS=0');

			do {
				if (count($listQuery) == 0) {
					if (file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST)) {
						unlink($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST);
					}

					$restoreDbFilenamesCount = count($this->container->getState()->getRestoreDbFilenames());
					if ($restoreDbFilenamesCount) {
						$this->logger->info($this->translator->trans(
							'Database restoration file %filename% done. %filescount% file(s) left...',
							array(
								'%filename%' => $this->container->getState()->getDbStep(),
								'%filescount%' => $restoreDbFilenamesCount,
							),
							'Modules.Etsupgrade.Admin'
						));
					} else {
						$this->logger->info($this->translator->trans('Database restoration file %1$s done.', array($this->container->getState()->getDbStep()), 'Modules.Etsupgrade.Admin'));
					}

					$this->stepDone = true;
					$this->status = 'ok';
					$this->next = 'restoreDb';

					if ($restoreDbFilenamesCount === 0) {
						$this->next = 'rollbackComplete';
						$this->logger->info($this->translator->trans('Database has been restored.', array(), 'Modules.Etsupgrade.Admin'));

						$databaseTools->cleanTablesAfterBackup($this->container->getFileConfigurationStorage()->load(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST));
						$this->container->getFileConfigurationStorage()->clean(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST);
					}

					return true;
				}

				// filesForBackup already contains all the correct files
				if (count($listQuery) == 0) {
					continue;
				}

				$query = trim(array_shift($listQuery));
				if (!empty($query)) {
					if (!$this->container->getDb()->execute($query, false)) {
						if (is_array($listQuery)) {
							$listQuery = array_unshift($listQuery, $query);
						}
						$this->logger->error($this->translator->trans('[SQL ERROR]', array(), 'Modules.Etsupgrade.Admin') . ' ' . $query . ' - ' . $this->container->getDb()->getMsgError());
						$this->logger->info($this->translator->trans('Error during database restoration', array(), 'Modules.Etsupgrade.Admin'));
						$this->next = 'error';
						$this->error = true;
						unlink($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST);

						return false;
					}
				}

				// note : theses queries can be too big and can cause issues for display

				$time_elapsed = time() - $startTime;
			} while ($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall());

			$queries_left = count($listQuery);

			if ($queries_left > 0) {
				$this->container->getFileConfigurationStorage()->save($listQuery, UpgradeFileNames::QUERIES_TO_RESTORE_LIST);
			} elseif (file_exists($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST)) {
				unlink($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::QUERIES_TO_RESTORE_LIST);
			}

			$this->stepDone = false;
			$this->next = 'restoreDb';
			$this->logger->info($this->translator->trans(
				'%numberqueries% queries left for file %filename%...',
				array(
					'%numberqueries%' => $queries_left,
					'%filename%' => $this->container->getState()->getDbStep(),
				),
				'Modules.Etsupgrade.Admin'
			));
			unset($query, $listQuery);
		} else {
			$this->stepDone = true;
			$this->status = 'ok';
			$this->next = 'rollbackComplete';
			$this->logger->info($this->translator->trans('Database restoration done.', array(), 'Modules.Etsupgrade.Admin'));

			$databaseTools->cleanTablesAfterBackup($this->container->getFileConfigurationStorage()->load(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST));
			$this->container->getFileConfigurationStorage()->clean(UpgradeFileNames::DB_TABLES_TO_CLEAN_LIST);
		}

		return true;
	}

	public function init()
	{
		// We don't need the whole core being instanciated, only the autoloader
		$this->container->initPrestaShopAutoloader();

		// Loads the parameters.php file on PrestaShop 1.7, needed for accessing the database
		if (file_exists($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/config/bootstrap.php')) {
			require_once $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/config/bootstrap.php';
		}

	}
}
