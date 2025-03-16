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

use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

class RenameModules extends AbstractTask
{
	public function run()
	{
		$this->logger->debug($this->translator->trans('Modules renaming...', array(), 'Modules.Etsupgrade.Admin'));
		if ($this->warmUp()) {
			$this->logger->info($this->translator->trans('Modules have been renamed.', array(), 'Modules.Etsupgrade.Admin'));
		} else {
			$this->logger->info($this->translator->trans('No module has been renamed.', array(), 'Modules.Etsupgrade.Admin'));
		}
		$this->stepDone = true;
		$this->status = 'ok';
        $this->container->getState()->setStepDone('renameModules');
		$this->next = 'upgradeComplete';
		return true;
	}

	public function warmUp()
	{
		//native modules
		$nativeModules = $this->container->getModulesOnLatestDir();

		//module custom.
		$moduleDir = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
		$module_list_xml = $moduleDir . 'ets_upgrade' . DIRECTORY_SEPARATOR . 'modules_list.xml';

		//blacklist.
		if (@file_exists($module_list_xml) && ($modules_list = @simplexml_load_file($module_list_xml))) {
			foreach ($modules_list as $module) {
				$nativeModules[] = (string)$module['name'];
			}
		}

		//compare module list after copied last version.
		$modulesDirOnDisk = array();
		if (@is_dir($moduleDir) && ($modules = @scandir($moduleDir, SCANDIR_SORT_NONE))) {
			foreach ($modules as $name) {
				if (!in_array($name, array('.', '..', 'index.php', '.htaccess')) && preg_match('/^(?!backup_)[a-zA-Z0-9_-]+$/', $name) && !in_array($name, $nativeModules) && !preg_match('/^(ets|ybc|ph)_[a-zA-Z0-9_-]+$/', $name)) {
					$modulesDirOnDisk[] = $name;
				}
			}
		}

		//rename module old version.
		$count = 0;
		if ($modulesDirOnDisk) {
			$this->logger->info($this->translator->trans('%s modules will be renamed.', array(count($modulesDirOnDisk)), 'Modules.Etsupgrade.Admin'));
			foreach ($modulesDirOnDisk as $moduleName) {
				if ($moduleName != 'ets_upgrade' && @is_dir($moduleDir . $moduleName) && @rename($moduleDir . $moduleName, $moduleDir . 'backup_' . $moduleName)) {
					$count++;
					$this->logger->info($this->translator->trans('Module %s has been renamed to %s..', array($moduleName, 'backup_' . $moduleName), 'Modules.Etsupgrade.Admin'));
				}
			}
		}

		return $count;
	}
}