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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;

class EnableModules extends AbstractTask
{
    public function run()
    {
        $begin_time = time();
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_ON_LATEST)) {
            return $this->warmUp();
        }
        $this->next = 'enableModules';
        $listModules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_ON_LATEST);
        if (!is_array($listModules)) {
            $this->container->getState()->setWarningExists(true);
            $this->logger->error($this->translator->trans('No module has been enabled.', array(), 'Modules.Etsupgrade.Admin'));
            $this->completedTask();

            return true;
        }
        $time_elapsed = time() - $begin_time;
        if (count($listModules) > 0) {
            do {
                $module_info = array_shift($listModules);
                try {
                    if ($this->container->getModuleAdapter()->doEnableModule($module_info)) {
                        $this->logger->debug($this->translator->trans('The module %s has been enabled.', array($module_info), 'Modules.Etsupgrade.Admin'));
                    }
                } catch (UpgradeException $e) {
                    $this->handleException($e);

                    if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                        return false;
                    }
                }
                $time_elapsed = time() - $begin_time;
            } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($listModules) > 0);

            $modules_left = count($listModules);
            $this->container->getFileConfigurationStorage()->save($listModules, UpgradeFileNames::MODULES_ON_LATEST);
            unset($listModules);

            $this->next = 'enableModules';
            if ($modules_left > 0) {
                $this->logger->info($this->translator->trans('%s modules left to enabled.', array($modules_left), 'Modules.Etsupgrade.Admin'));
                $this->stepDone = false;
            } else {
                $this->completedTask();
            }
        } else {

            $this->completedTask();
            return true;
        }

        return true;
    }

    private function completedTask()
    {
        $this->stepDone = true;
        $this->status = 'ok';
        $this->next = $this->container->getUpgradeConfiguration()->isMajorChannel() ? 'installModules' : 'removeOverride';
        $this->logger->info($this->translator->trans('Modules have been enabled.', array(), 'Modules.Etsupgrade.Admin'));
        $this->container->getState()->setStepDone('enableModules');
        if (@file_exists(UpgradeFileNames::MODULES_ON_LATEST)) {
            unlink(UpgradeFileNames::MODULES_ON_LATEST);
        }
    }

    public function warmUp()
    {
        try {
            $modulesOnListXml = array();
            $modulesOnLatest = $this->container->getModulesOnLatestDir();

            $modulesDisabled = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_ENABLED_MODULES);
            $modulesDisabled = is_array($modulesDisabled) ? array_values($modulesDisabled) : array();

            $moduleDir = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
            if (@is_dir($moduleDir) && ($modules = @scandir($moduleDir, SCANDIR_SORT_NONE))) {
                foreach ($modules as $name) {
                    if (preg_match('/^(ets|ybc|ph)_[a-zA-Z0-9_-]+$/', $name)) {
                        $modulesOnLatest[] = $name;
                        $modulesOnListXml[] = $name;
                    }
                }
            }
            if (@file_exists(($module_list_xml = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'ets_upgrade' . DIRECTORY_SEPARATOR . 'modules_list.xml')) && ($modules = @simplexml_load_file($module_list_xml))) {
                foreach ($modules as $module) {
                    $module_name = trim((string)$module['name']);
                    if (!in_array($module_name, $modulesOnListXml)) {
                        $modulesOnListXml[] = $module_name;
                    }
                    if (in_array('"' . $module_name . '"', $modulesDisabled) && !in_array($module_name, $modulesOnLatest)) {
                        $modulesOnLatest[] = $module_name;
                    }
                }
                $this->container->getFileConfigurationStorage()->save($modulesOnListXml, UpgradeFileNames::MODULES_ON_LIST_XML);
            }

            $this->container->getFileConfigurationStorage()->save($modulesOnLatest, UpgradeFileNames::MODULES_ON_LATEST);

        } catch (UpgradeException $e) {
            $this->handleException($e);

            return false;
        }

        $total_modules_to_upgrade = count($modulesOnLatest);
        if ($total_modules_to_upgrade) {
            $this->logger->info($this->translator->trans('%s modules will be enabled.', array($total_modules_to_upgrade), 'Modules.Etsupgrade.Admin'));
        }
        $this->stepDone = false;
        $this->next = 'enableModules';

        return true;
    }
}