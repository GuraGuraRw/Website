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

/**
 * very first step of the upgrade process. The only thing done is the selection
 * of the next step.
 */
class UpgradeNow extends AbstractTask
{
    public function run()
    {
        $this->container->getState()->setStartTime(time());

        if (!$this->container->getUpgradeConfiguration()->isMajorChannel()) {

            $this->container->getState()->setEstimateTime(array(
                'enableModules' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
                'installModules' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
                'removeOverride' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
                'renameModules' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
            ));

        } else {

            $this->container->getState()->setEstimateTime(array(
                'upgradeDb' => array(
                    'part' => 15,
                    'stepDone' => 0,
                ),
                'upgradeModules' => array(
                    'part' => 40,
                    'stepDone' => 0,
                ),
            ));

        }
        //if not backup image
        if (!$this->container->getUpgradeConfiguration()->shouldBackupImages()) {

            $this->container->getState()->setEstimateTime(array(
                'backupFiles' => array(
                    'part' => 15,
                    'stepDone' => 0,
                ),
            ));

        }
        // if not backup database and files set estimate time.
        if (!$this->container->getUpgradeConfiguration()->get('PS_AUTOUP_BACKUP')) {

            $this->container->getState()->setEstimateTime(array(
                'backupDb' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
                'backupFiles' => array(
                    'part' => 0,
                    'stepDone' => 0,
                ),
            ));
        }
        $this->logger->info($this->translator->trans('Starting upgrade...', array(), 'Modules.Etsupgrade.Admin'));

        $this->container->getWorkspace()->createFolders();

        $channel = $this->container->getUpgradeConfiguration()->get('channel');//'directory';//
        $upgrader = $this->container->getUpgrader();
        $this->next = 'download';
        preg_match('#([0-9]+\.[0-9]+)(?:\.[0-9]+){1,2}#', _PS_VERSION_, $matches);
        $upgrader->branch = $matches[1];
        $upgrader->channel = $channel;
        if ($this->container->getUpgradeConfiguration()->get('channel') == 'private' && !$this->container->getUpgradeConfiguration()->get('private_allow_major')) {
            $upgrader->checkPSVersion(false, array('private', 'minor'));
        } else {
            $upgrader->checkPSVersion(false, array('minor'));
        }

        if ($upgrader->isLastVersion()) {
            $this->next = '';
            $this->logger->info($this->translator->trans('You already have the %s version.', array($upgrader->version_name), 'Modules.Etsupgrade.Admin'));

            return;
        }

        $this->moduleSkipped();

        if (version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
            $this->removeIndex(_PS_ROOT_DIR_ . '/src/');
        }
        switch ($channel) {
            case 'directory':
                // if channel directory is chosen, we assume it's "ready for use" (samples already removed for example)
                $this->next = 'removeSamples';
                $this->logger->debug($this->translator->trans('Downloading and unzipping steps have been skipped, upgrade process will now remove sample data.', array(), 'Modules.Etsupgrade.Admin'));
                $this->logger->info($this->translator->trans('Shop deactivated. Removing sample files...', array(), 'Modules.Etsupgrade.Admin'));
                break;
            case 'archive':
                $this->next = 'unzip';
                $this->logger->debug($this->translator->trans('Downloading step has been skipped, upgrade process will now unzip the local archive.', array(), 'Modules.Etsupgrade.Admin'));
                $this->logger->info($this->translator->trans('Shop deactivated. Extracting files...', array(), 'Modules.Etsupgrade.Admin'));
                break;
            default:
                $this->next = 'download';
                $this->logger->info($this->translator->trans('Shop deactivated. Now downloading... (this can take a while)', array(), 'Modules.Etsupgrade.Admin'));
                if ($upgrader->channel == 'private') {
                    $upgrader->link = $this->container->getUpgradeConfiguration()->get('private_release_link');
                    $upgrader->md5 = $this->container->getUpgradeConfiguration()->get('private_release_md5');
                }
                $this->logger->debug($this->translator->trans('Downloaded archive will come from %s', array($upgrader->link), 'Modules.Etsupgrade.Admin'));
                $this->logger->debug($this->translator->trans('MD5 hash will be checked against %s', array($upgrader->md5), 'Modules.Etsupgrade.Admin'));
        }
        $this->stepDone = true;
        $this->container->getState()->setDatabaseServerVersion($this->container->getDb()->getVersion());
        $this->container->getState()->setStepDone('upgradeNow');
    }

    public function moduleSkipped()
    {
        if ($this->container->getUpgradeConfiguration()->isMajorChannel() && !$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::LIST_MODULE_REFERENCE)) {

            $skipModules = array(
                'cheque',
                'bankwire',
                'cashondelivery',
            );
            $skipModules = array_map(function ($module) {
                return '"' . pSQL($module) . '"';
            }, $skipModules);

            $results = array('contactform');
            $listModules = $this->container->getDb()->executeS('SELECT `name` FROM `' . _DB_PREFIX_ . 'module` m 
				JOIN `' . _DB_PREFIX_ . 'module_shop` ms ON (m.id_module = ms.id_module) 
				WHERE `name` IN (' . implode(',', $skipModules) . ') GROUP BY `name`');

            foreach ($listModules as $module) {
                $results[] = $module['name'];
            }
            $this->container->getFileConfigurationStorage()->save($results, UpgradeFileNames::LIST_MODULE_REFERENCE);
        }
    }

    /**
     * Clear files index on dir /src/.
     * @param $dir
     * @return bool
     */
    public function removeIndex($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        if ($dirs = scandir($dir)) {
            foreach ($dirs as $file) {
                if ($file !== '.' && $file !== '..') {
                    $file = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($file)) {
                        $this->removeIndex($file);
                    } elseif (is_file($file) && basename($file) == 'index.php') {
                        unlink($file);
                    }
                }
            }
        }
    }
}
