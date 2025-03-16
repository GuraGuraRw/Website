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

class RemoveOverride extends AbstractTask
{
    public static $modulesOnListXml = array();

    public function run()
    {
        $begin_time = time();

        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_ON_OVERRIDE)) {
            return $this->warmUp();
        }
        if (!self::$modulesOnListXml) {
            self::$modulesOnListXml = array('ets_upgrade') + (array)$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_ON_LIST_XML);
        }
        $this->next = 'removeOverride';
        $listModules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_ON_OVERRIDE);

        if (!is_array($listModules)) {
            $this->container->getState()->setStepDone($this->next);
            $this->next = $this->container->getUpgradeConfiguration()->isMajorChannel()? 'renameModules' : 'upgradeComplete';
            $this->container->getState()->setWarningExists(true);
            $this->logger->error($this->translator->trans('No module has been removed override.', array(), 'Modules.Etsupgrade.Admin'));
            // Remove all override.
            $this->container->getModuleAdapter()->doRemoveAllOverride(self::$modulesOnListXml);

            return true;
        }
        $time_elapsed = time() - $begin_time;
        if (count($listModules) > 0) {
            do {
                $module_info = array_shift($listModules);
                try {
                    $this->container->getModuleAdapter()->doRemoveOverride($module_info);
                    $this->logger->debug($this->translator->trans('The module %s has been removed override', array($module_info), 'Modules.Etsupgrade.Admin'));
                } catch (UpgradeException $e) {
                    $this->handleException($e);

                    if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                        return false;
                    }
                }
                $time_elapsed = time() - $begin_time;
            } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($listModules) > 0);

            $modules_left = count($listModules);
            $this->container->getFileConfigurationStorage()->save($listModules, UpgradeFileNames::MODULES_ON_OVERRIDE);
            unset($listModules);

            $this->next = 'removeOverride';
            if ($modules_left) {
                $this->logger->info($this->translator->trans('%s modules left to remove override.', array($modules_left), 'Modules.Etsupgrade.Admin'));
            }
            $this->stepDone = false;
        } else {
            if (@file_exists(UpgradeFileNames::MODULES_ON_OVERRIDE)) {
                unlink(UpgradeFileNames::MODULES_ON_OVERRIDE);
            }
            $this->stepDone = true;
            $this->status = 'ok';
            $this->next = $this->container->getUpgradeConfiguration()->isMajorChannel()? 'renameModules' : 'upgradeComplete';
            $this->logger->info($this->translator->trans('Modules have been removed override.', array(), 'Modules.Etsupgrade.Admin'));
            $this->container->getState()->setStepDone('removeOverride');
            // Remove all override.
            $this->container->getModuleAdapter()->doRemoveAllOverride(self::$modulesOnListXml);

            return true;
        }

        return true;
    }

    public function warmUp()
    {
        try {
            $moduleOverrides = array();

            if (!self::$modulesOnListXml) {
                self::$modulesOnListXml = array('ets_upgrade') + (array)$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_ON_LIST_XML);
            }
            if ($modules = $this->container->getDb()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'module` WHERE active = \'0\'')) {
                foreach ($modules as $module) {
                    $moduleName = trim($module['name']);
                    if (!in_array($moduleName, self::$modulesOnListXml) && @is_dir($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/modules/' . $moduleName . '/override')) {
                        $moduleOverrides[] = $moduleName;
                    }
                }
            }
            $this->container->getFileConfigurationStorage()->save($moduleOverrides, UpgradeFileNames::MODULES_ON_OVERRIDE);
        } catch (UpgradeException $e) {
            $this->handleException($e);

            return false;
        }

        $total_modules_to_upgrade = count($moduleOverrides);
        if ($total_modules_to_upgrade) {
            $this->logger->info($this->translator->trans('%s modules will be remove override.', array($total_modules_to_upgrade), 'Modules.Etsupgrade.Admin'));
        }
        $this->stepDone = false;
        $this->next = 'removeOverride';

        return true;
    }
}