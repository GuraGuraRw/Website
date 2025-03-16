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

namespace PrestaShop\Module\EtsAutoUpgrade\Parameters;

use PrestaShop\Module\EtsAutoUpgrade\Upgrader;

class UpgradeConfigurationStorage extends FileConfigurationStorage
{
    /**
     * UpgradeConfiguration loader.
     *
     * @param string $configFileName
     *
     * @return \PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration
    */
    public function load($configFileName = '')
    {
        $data = array_merge(
            $this->getDefaultData(),
            parent::load($configFileName)
        );

        return new UpgradeConfiguration($data);
    }

    /**
     * @param \PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration $config
     * @param string $configFileName Destination path of the config file
     *
     * @return bool
    */
    public function save($config, $configFileName)
    {
        if (!$config instanceof UpgradeConfiguration) {
            throw new \InvalidArgumentException('Config is not a instance of UpgradeConfiguration');
        }

        return parent::save($config->toArray(), $configFileName);
    }

    public function getDefaultData()
    {
        return array(
            'PS_AUTOUP_PERFORMANCE' => 2,
            'PS_AUTOUP_CUSTOM_MOD_DESACT' => 1,
            'PS_AUTOUP_UPDATE_DEFAULT_THEME' => 1,
            'PS_AUTOUP_CHANGE_DEFAULT_THEME' => 1,
            'PS_AUTOUP_KEEP_MAILS' => 0,
            'PS_AUTOUP_BACKUP' => 1,
            'PS_AUTOUP_KEEP_IMAGES' => 1,
            'channel' => Upgrader::DEFAULT_CHANNEL,
            'archive.filename' => Upgrader::DEFAULT_FILENAME,
        );
    }
}
