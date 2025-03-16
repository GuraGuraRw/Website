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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;

/**
 * Upgrade all partners modules according to the installed prestashop version.
 */
class UpgradeModules extends AbstractTask
{
    public function run()
    {
        $start_time = time();
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_TO_UPGRADE_LIST)) {
            return $this->warmUp();
        }

        $this->next = 'upgradeModules';
        $modules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
        $listModules = !empty($modules['latest']) ? $modules['latest'] : [];
        $listModulesAddon = !empty($modules['addons']) ? $modules['addons'] : [];
        if (!is_array($listModules)) {
            $this->next = 'upgradeComplete';
            $this->container->getState()->setWarningExists(true);
            $this->logger->error($this->translator->trans('listModules is not an array. No module has been updated.', array(), 'Modules.Etsupgrade.Admin'));
            if (file_exists(UpgradeFileNames::MODULES_TO_UPGRADE_LIST)) {
                unlink(UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
            }
            return true;
        }
        $time_elapsed = time() - $start_time;
        // module list
        if (count($listModules) > 0) {
            do {
                $moduleName = array_shift($listModules);
                try {
                    $this->logger->info($this->translator->trans('Upgrading module %module%...', ['%module%' => $moduleName], 'Modules.Etsupgrade.Admin'));
                    if (is_array($listModulesAddon) && $listModulesAddon && !empty($listModulesAddon[$moduleName])) {
                        $moduleAddon = $listModulesAddon[$moduleName];
                        $this->container->getModuleAdapter()->upgradeModule($moduleAddon['id'], $moduleAddon['name']);
                        $this->logger->info($this->translator->trans('The files of module %s have been upgraded.', array($moduleName), 'Modules.Etsupgrade.Admin'));
                        unset($listModulesAddon[$moduleName]);
                    } else {
                        if (!$this->container->getModuleAdapter()->doUpgradeModule($moduleName)) {
                            $this->logger->info($this->translator->trans('Upgrade module %module% fail.', ['%module%' => $moduleName], 'Modules.Etsupgrade.Admin'));
                        } else {
                            $this->logger->info($this->translator->trans('Module %module% upgraded!', ['%module%' => $moduleName], 'Modules.Etsupgrade.Admin'));
                        }
                    }
                } catch (UpgradeException $e) {
                    $this->handleException($e);
                    if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                        $this->logger->error($this->translator->trans('Upgrade module %module% error!', ['%module%' => $moduleName], 'Modules.Etsupgrade.Admin'));
                        return false;
                    }
                    $this->logger->info($e->getMessage());
                }
                $time_elapsed = time() - $start_time;
            } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($listModules) > 0);

            $modules_left = count($listModules);
            $this->container->getFileConfigurationStorage()->save(['addons' => $listModulesAddon, 'latest' => $listModules], UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
            unset($listModules);

            $this->next = 'upgradeModules';
            if ($modules_left) {
                $this->logger->info($this->translator->trans('%s modules left to upgrade.', array($modules_left), 'Modules.Etsupgrade.Admin'));
            }
            $this->stepDone = false;
        } else {
            $modules_to_delete = array(
                'backwardcompatibility' => 'Backward Compatibility',
                'dibs' => 'Dibs',
                'cloudcache' => 'Cloudcache',
                'mobile_theme' => 'The 1.4 mobile_theme',
                'trustedshops' => 'Trustedshops',
                'dejala' => 'Dejala',
                'stripejs' => 'Stripejs',
                'blockvariouslinks' => 'Block Various Links',
            );

            foreach ($modules_to_delete as $key => $module) {
                $this->container->getDb()->execute('
                    DELETE ms.*, hm.*
                    FROM `' . _DB_PREFIX_ . 'module_shop` ms
                    INNER JOIN `' . _DB_PREFIX_ . 'hook_module` hm USING (`id_module`)
                    INNER JOIN `' . _DB_PREFIX_ . 'module` m USING (`id_module`)
                    WHERE m.`name` LIKE \'' . pSQL($key) . '\'
                ');
                $this->container->getDb()->execute('UPDATE `' . _DB_PREFIX_ . 'module` SET `active` = 0 WHERE `name` LIKE \'' . pSQL($key) . '\'');

                $path = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $key . DIRECTORY_SEPARATOR;
                if (file_exists($path . $key . '.php')) {
                    if (FilesystemAdapter::deleteDirectory($path)) {
                        $this->logger->warning($this->translator->trans(
                            'The %modulename% module is not compatible with version %version%, it will be removed from your FTP.',
                            array(
                                '%modulename%' => $module,
                                '%version%' => $this->container->getState()->getInstallVersion(),
                            ),
                            'Modules.Etsupgrade.Admin'
                        ));
                    } else {
                        $this->logger->error($this->translator->trans(
                            'The %modulename% module is not compatible with version %version%, please remove it from your FTP.',
                            array(
                                '%modulename%' => $module,
                                '%version%' => $this->container->getState()->getInstallVersion(),
                            ),
                            'Modules.Etsupgrade.Admin'
                        ));
                    }
                }
            }

            $this->stepDone = true;
            $this->status = 'ok';
            $this->next = 'cleanDatabase';
            $this->logger->info($this->translator->trans('Addons modules files have been upgraded.', array(), 'Modules.Etsupgrade.Admin'));
            if (file_exists(UpgradeFileNames::MODULES_TO_UPGRADE_LIST)) {
                unlink(UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
            }
            $this->container->getState()->setStepDone('upgradeModules');

            return true;
        }

        return true;
    }

    public function warmUp()
    {
        try {
            $modulesToUpgrade = $this->container->getModuleAdapter()->listModulesToUpgrade($this->container->getState()->getModules_addons(), $this->container->getModulesOnLatestDir());
            $this->container->getFileConfigurationStorage()->save($modulesToUpgrade, UpgradeFileNames::MODULES_TO_UPGRADE_LIST);
        } catch (UpgradeException $e) {
            $this->handleException($e);

            return false;
        }

        $total_modules_to_upgrade = count($modulesToUpgrade);
        if ($total_modules_to_upgrade) {
            $this->logger->info($this->translator->trans('%s modules will be upgraded.', array($total_modules_to_upgrade), 'Modules.Etsupgrade.Admin'));
        }

        // WamUp core side
        if (method_exists('\Module', 'getModulesOnDisk')) {
            //\Module::getModulesOnDisk();
        }

        $this->stepDone = false;
        $this->next = 'upgradeModules';

        return true;
    }

}
