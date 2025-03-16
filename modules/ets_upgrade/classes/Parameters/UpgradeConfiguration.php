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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contains the module configuration (form params).
*/
class UpgradeConfiguration extends ArrayCollection
{
    /**
     * Performance settings, if your server has a low memory size, lower these values.
     *
     * @var array
    */
    protected $performanceValues = array(
        'loopFiles' => array(200, 400, 800), // files array(400, 800, 1600)
        'loopTime' => array(6, 12, 25), // seconds array(6, 12, 25)
        'maxBackupFileSize' => array(7864320, 15728640, 31457280), // bytes array(15728640, 31457280, 62914560)
        'maxWrittenAllowed' => array(2097152, 4194304, 8388608), // bytes array(4194304, 8388608, 16777216)
    );

    /**
     * Get the name of the new release archive.
     *
     * @return string
    */
    public function getArchiveFilename()
    {
        return $this->get('archive.filename');
    }

    /**
     * Get the version included in the new release.
     *
     * @return string
    */
    public function getArchiveVersion()
    {
        return $this->get('archive.version_num');
    }

    /**
     * Get channel selected on config panel (Minor, major ...).
     *
     * @return string
    */
    public function getChannel()
    {
        return $this->get('channel');
    }

    /**
     * Check channel selected is major.
     *
     * @return string
    */
    public function isMajorChannel()
    {
        return preg_match('#(major)([0-9]+\.[0-9]+)?#', $this->getChannel());
    }

    /**
     * @return int Number of files to handle in a single call to avoid timeouts
    */
    public function getNumberOfFilesPerCall()
    {
        return $this->performanceValues['loopFiles'][$this->getPerformanceLevel()];
    }

    /**
     * @return int Number of seconds allowed before having to make another request
    */
    public function getTimePerCall()
    {
        return $this->performanceValues['loopTime'][$this->getPerformanceLevel()];
    }

    /**
     * @return int Kind of reference for SQL file creation, giving a file size before another request is needed
    */
    public function getMaxSizeToWritePerCall()
    {
        return $this->performanceValues['maxWrittenAllowed'][$this->getPerformanceLevel()];
    }

    /**
     * @return int Max file size allowed in backup
    */
    public function getMaxFileToBackup()
    {
        return $this->performanceValues['maxBackupFileSize'][$this->getPerformanceLevel()];
    }

    /**
     * @return int level of performance selected (0 for low, 2 for high)
    */
    public function getPerformanceLevel()
    {
        return $this->get('PS_AUTOUP_PERFORMANCE') - 1;
    }

    /**
     * @return bool True if the ets_upgrade module should backup the images as well
    */
    public function shouldBackupImages()
    {
        return (bool)$this->get('PS_AUTOUP_KEEP_IMAGES');
    }

    /**
     * @return bool True if non-native modules must be disabled during upgrade
    */
    public function shouldDeactivateCustomModules()
    {
        return (bool)$this->get('PS_AUTOUP_CUSTOM_MOD_DESACT');
    }

    /**
     * @return bool true if we should keep the merchant emails untouched
    */
    public function shouldKeepMails()
    {
        return (bool)$this->get('PS_AUTOUP_KEEP_MAILS');
    }

    /**
     * @return bool True if we have to set the native theme by default
    */
    public function shouldSwitchToDefaultTheme()
    {
        return (bool)$this->get('PS_AUTOUP_CHANGE_DEFAULT_THEME');
    }

    /**
     * @return bool True if we are allowed to update th default theme files
    */
    public function shouldUpdateDefaultTheme()
    {
        return (bool)$this->get('PS_AUTOUP_UPDATE_DEFAULT_THEME');
    }

    public function merge(array $array = array())
    {
        foreach ($array as $key => $value) {
            $this->set($key, $value);
        }
    }
}
