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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;

class InstallModules extends AbstractTask
{
    public function run()
    {
        $begin_time = time();
        $this->next = 'installModules';
        $listModules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::LIST_MODULE_REFERENCE);
        if (!is_array($listModules)) {
            $this->container->getState()->setStepDone('installModules');
            $this->next = 'removeOverride';
            $this->container->getState()->setWarningExists(true);
            $this->logger->error($this->translator->trans('No module has been installed.', array(), 'Modules.Etsupgrade.Admin'));
            return true;
        }
        $time_elapsed = time() - $begin_time;
        if (count($listModules) > 0) {
            do {
                $moduleName = array_shift($listModules);
                switch ($moduleName) {
                    case 'cheque':
                        $moduleName = 'ps_checkpayment';
                        break;
                    case 'bankwire':
                        $moduleName = 'ps_wirepayment';
                        break;
                    case 'cashondelivery':
                        $moduleName = 'ps_cashondelivery';
                        break;
                }
                try {
                    if ($this->container->getModuleAdapter()->doInstallModule($moduleName)) {
                        $this->logger->info($this->translator->trans('The module %s has been installed.', array($moduleName), 'Modules.Etsupgrade.Admin'));
                    }
                } catch (UpgradeException $e) {
                    $this->handleException($e);
                    if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
                        return false;
                    }
                }
                $time_elapsed = time() - $begin_time;
            } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($listModules) > 0);

            $nb_modules = count($listModules);
            $this->container->getFileConfigurationStorage()->save($listModules, UpgradeFileNames::LIST_MODULE_REFERENCE);
            unset($listModules);

            $this->next = 'installModules';
            if ($nb_modules > 0) {
                $this->logger->info($this->translator->trans('%s modules left to installed.', array($nb_modules), 'Modules.Etsupgrade.Admin'));
            }
            $this->stepDone = false;
        } else {
            if (@file_exists(UpgradeFileNames::LIST_MODULE_REFERENCE)) {
                unlink(UpgradeFileNames::LIST_MODULE_REFERENCE);
            }
            $this->stepDone = true;
            $this->status = 'ok';
            $this->container->getState()->setStepDone('installModules');
            $this->next = 'removeOverride';
            $this->logger->info($this->translator->trans('Modules have been installed.', array(), 'Modules.Etsupgrade.Admin'));

            return true;
        }
        return true;
    }
}