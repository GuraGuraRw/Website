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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader\CoreUpgrader16;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader\CoreUpgrader17;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader\CoreUpgrader80;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\SettingsFileWriter;

class UpgradeDb extends AbstractTask
{
    public function run()
    {
        try {

            // Do update database.
            $this->getCoreUpgrader()->doUpgrade();

            if ($this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_SQL_VERSIONS)) {
                $this->next = 'upgradeDb';
                return true;
            }

            if (@file_exists(UpgradeFileNames::FILES_SQL_VERSIONS))
                @unlink(UpgradeFileNames::FILES_SQL_VERSIONS);

        } catch (UpgradeException $e) {

            // Next step error.
            $this->next = 'error';
            $this->error = true;
            foreach ($e->getQuickInfos() as $log) {
                $this->logger->debug($log);
            }
            $this->logger->error($this->translator->trans('Error during database upgrade. You may need to restore your database.', array(), 'Modules.Etsupgrade.Admin'));
            $this->logger->error($e->getMessage());

            return false;
        }

        // Estimate time.
        $this->container->getState()->setStepDone('upgradeDb');
        if ($this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::MODULES_TO_UPGRADE_LIST) && !$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::MODULES_TO_UPGRADE_LIST)) {
            $this->container->getState()->setEstimateTime(array(
                'upgradeModules' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
            ));
        }
        // End estimate time.

        // Next step.
        $this->stepDone = true;
        $this->next = 'upgradeModules';
        $this->logger->info($this->translator->trans('Database upgraded. Now upgrading your Addons modules...', array(), 'Modules.Etsupgrade.Admin'));

        return true;
    }

    public function getCoreUpgrader()
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '<')) {
            return new CoreUpgrader16($this->container, $this->logger);
        }

        if (version_compare($this->container->getState()->getInstallVersion(), '8.0.0', '<')) {
            return new CoreUpgrader17($this->container, $this->logger);
        }

        return new CoreUpgrader80($this->container, $this->logger);
    }

    public function init()
    {
        // Clear cache folders.
        //Blowfish
        $old_files = [];
        if (version_compare($this->container->getState()->getOldVersion(), '1.7.0.0', '<') && file_exists(($filename = rtrim($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '/') . '/classes/Blowfish.php'))) {
            $old_files[] = $filename;
        }
        //Attribute
        if (version_compare($this->container->getState()->getInstallVersion(), '8.0.0', '>=') && file_exists(($filename = rtrim($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '/') . '/classes/Attribute.php'))) {
            $old_files[] = $filename;
        }
        if ($old_files) {
            foreach ($old_files as $filename)
                @rename($filename, $filename . '.bck');
        }

        // Autoload classes.
        $this->container->initPrestaShopAutoloader();

        if (!class_exists('\Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass') && file_exists(($filename = rtrim($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '/') . '/vendor/symfony/symfony/src/Symfony/Component/EventDispatcher/DependencyInjection/RegisterListenersPass.php')))
            require_once $filename;

        if (!class_exists('\Doctrine\Common\Collections\Expr\Comparison') && file_exists(($filename = rtrim($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '/') . '/vendor/doctrine/collections/lib/Doctrine/Common/Collections/Expr/Comparison.php')))
            require_once $filename;

        // Migrating settings file
        if (!$this->container->getState()->getInitialized()) {
            (new SettingsFileWriter($this->translator))->migrateSettingsFile($this->logger, version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '>='));

            if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '>=') && file_exists(($doctrine_file = rtrim($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '/') . '/app/config/doctrine.yml'))) {
                $doctrine = \Symfony\Component\Yaml\Yaml::parseFile($doctrine_file);
                if (isset($doctrine['doctrine']['dbal']['connections']['default'])) {
                    $doctrine['doctrine']['dbal']['connections']['default']['server_version'] = $this->container->getState()->getDatabaseServerVersion();
                    if (isset($doctrine['doctrine']['dbal']['connections']['default']['options']['1013'])) {
                        unset($doctrine['doctrine']['dbal']['connections']['default']['options']['1013']);
                    }
                    file_put_contents($doctrine_file, \Symfony\Component\Yaml\Yaml::dump($doctrine, 64, 2));
                }
            }
        }

        parent::init();
    }
}
