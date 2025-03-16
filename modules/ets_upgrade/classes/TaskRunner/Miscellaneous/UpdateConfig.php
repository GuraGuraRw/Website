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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfigurationStorage;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Upgrader;

/**
 * update configuration after validating the new values.
*/
class UpdateConfig extends AbstractTask
{
    public function run()
    {
        // nothing next
        $this->next = '';

        // Was coming from EtsAdminSelfUpgrade::currentParams before
        $request = $this->getRequestParams();
        $config = array();
        // update channel
        if (isset($request['channel'])) {
            $config['channel'] = $request['channel'];
            $config['archive.filename'] = Upgrader::DEFAULT_FILENAME;
            // Switch on default theme if major upgrade (i.e: 1.6 -> 1.7)
            $config['PS_AUTOUP_CHANGE_DEFAULT_THEME'] = preg_match('#(?:major)(?:[0-9]+\.[0-9]+)?#', $request['channel']);
        }
        if (isset($request['private_release_link'], $request['private_release_md5'])) {
            $config['channel'] = 'private';
            $config['private_release_link'] = $request['private_release_link'];
            $config['private_release_md5'] = $request['private_release_md5'];
            $config['private_allow_major'] = $request['private_allow_major'];
        }
        if (!empty($request['archive_prestashop'])) {
            $file = $request['archive_prestashop'];
            if (!file_exists($this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH) . DIRECTORY_SEPARATOR . $file)) {
                $this->error = true;
                $this->logger->info($this->translator->trans('File %s does not exist. Unable to select that channel.', array($file), 'Modules.Etsupgrade.Admin'));

                return false;
            }
            if (empty($request['archive_num'])) {
                $this->error = true;
                $this->logger->info($this->translator->trans('Version number is missing. Unable to select that channel.', array(), 'Modules.Etsupgrade.Admin'));

                return false;
            }
            $config['channel'] = 'archive';
            $config['archive.filename'] = $request['archive_prestashop'];
            $config['archive.version_num'] = $request['archive_num'];
            $this->logger->info($this->translator->trans('Upgrade process will use archive.', array(), 'Modules.Etsupgrade.Admin'));
        }
        if (isset($request['directory_num'])) {
            $config['channel'] = 'directory';
            if (empty($request['directory_num']) || strpos($request['directory_num'], '.') === false) {
                $this->error = true;
                $this->logger->info($this->translator->trans('Version number is missing. Unable to select that channel.', array(), 'Modules.Etsupgrade.Admin'));

                return false;
            }

            $config['directory.version_num'] = $request['directory_num'];
        }
        if (isset($request['skip_backup'])) {
            $config['skip_backup'] = $request['skip_backup'];
        }

        if (!$this->writeConfig($config)) {
            $this->error = true;
            $this->logger->info($this->translator->trans('Error on saving configuration', array(), 'Modules.Etsupgrade.Admin'));
        }
    }

    protected function getRequestParams()
    {
        return empty($_REQUEST['params']) ? array() : $_REQUEST['params'];
    }

    /**
     * update module configuration (saved in file UpgradeFiles::configFilename) with $new_config.
     *
     * @param array $config
     *
     * @return bool true if success
    */
    private function writeConfig($config)
    {
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::CONFIG_FILENAME) && !empty($config['channel'])) {
            $this->container->getUpgrader()->channel = $config['channel'];
            $this->container->getUpgrader()->checkPSVersion();

            $this->container->getState()->setInstallVersion($this->container->getUpgrader()->version_num);
            $this->container->getState()->setOldVersion(_PS_VERSION_);
        }

        $this->container->getUpgradeConfiguration()->merge($config);
        $this->logger->info($this->translator->trans('Successfully updated.', array(), 'Modules.Etsupgrade.Admin'));

        return (new UpgradeConfigurationStorage($this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR))->save($this->container->getUpgradeConfiguration(), UpgradeFileNames::CONFIG_FILENAME);
    }
}
