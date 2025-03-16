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

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;

class FileFilter
{
    /**
     * @var UpgradeConfiguration
    */
    protected $configuration;

    /**
     * @var string Autoupgrade sub directory*
    */
    protected $autoupgradeDir;

    public function __construct(UpgradeConfiguration $configuration, $autoupgradeDir = 'ets_upgrade')
    {
        $this->configuration = $configuration;
        $this->autoupgradeDir = $autoupgradeDir;
    }

    /**
     * EtsAdminSelfUpgrade::backupIgnoreAbsoluteFiles.
     *
     * @return array
    */
    public function getFilesToIgnoreOnBackup()
    {
        // during backup, do not save
        $backupIgnoreAbsoluteFiles = array(
            '/app/cache',
            '/cache/smarty/compile',
            '/cache/smarty/cache',
            '/cache/tcpdf',
            '/cache/cachefs',
            '/var/cache',

            // do not care about the two autoupgrade dir we use;
            '/modules/ets_upgrade',
            '/admin/ets_upgrade',
        );

        if (!$this->configuration->shouldBackupImages()) {
            $backupIgnoreAbsoluteFiles[] = '/img';
        } else {
            $backupIgnoreAbsoluteFiles[] = '/img/tmp';
        }

        return $backupIgnoreAbsoluteFiles;
    }

    /**
     * EtsAdminSelfUpgrade::restoreIgnoreAbsoluteFiles.
     *
     * @return array
    */
    public function getFilesToIgnoreOnRestore()
    {
        $restoreIgnoreAbsoluteFiles = array(
            '/app/config/parameters.php',
            '/app/config/parameters.yml',
            '/modules/ets_upgrade',
            '/admin/ets_upgrade',
            '.',
            '..',
        );

        if (!$this->configuration->shouldBackupImages()) {
            $restoreIgnoreAbsoluteFiles[] = '/img';
        } else {
            $restoreIgnoreAbsoluteFiles[] = '/img/tmp';
        }

        return $restoreIgnoreAbsoluteFiles;
    }

    /**
     * EtsAdminSelfUpgrade::excludeAbsoluteFilesFromUpgrade.
     *
     * @return array
    */
    public function getFilesToIgnoreOnUpgrade()
    {
        // do not copy install, neither app/config/parameters.php in case it would be present
        $excludeAbsoluteFilesFromUpgrade = array(
            '/app/config/parameters.php',
            '/app/config/parameters.yml',
            '/install',
            '/install-dev',
	        '/classes/Autoload.php',
        );

        // this will exclude ets_upgrade dir from admin, and ets_upgrade from modules
        // If set to false, we need to preserve the default themes
        if (!$this->configuration->shouldUpdateDefaultTheme()) {
            $excludeAbsoluteFilesFromUpgrade[] = '/themes/classic';
            $excludeAbsoluteFilesFromUpgrade[] = '/themes/default-bootstrap';
        }

        return $excludeAbsoluteFilesFromUpgrade;
    }

    /**
     * EtsAdminSelfUpgrade::backupIgnoreFiles
     * EtsAdminSelfUpgrade::excludeFilesFromUpgrade
     * EtsAdminSelfUpgrade::restoreIgnoreFiles.
     *
     * These files are checked in every subfolder of the directory tree and can match
     * several time, while the others are only matching a file from the project root.
     *
     * @return array
    */
    public function getExcludeFiles()
    {
        return array(
            '.',
            '..',
            '.svn',
            '.git',
            $this->autoupgradeDir,
        );
    }
}
