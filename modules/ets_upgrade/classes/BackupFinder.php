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

namespace PrestaShop\Module\EtsAutoUpgrade;

use PrestaShop\Module\EtsAutoUpgrade\Tools14;

class BackupFinder
{
    /**
     * @var string[]
    */
    private $availableBackups;

    /**
     * @var string
    */
    private $backupPath;

    /**
     * BackupFinder constructor.
     *
     * @param string $backupPath
    */
    public function __construct($backupPath)
    {
        $this->backupPath = $backupPath;
    }

    /**
     * @return array
    */
    public function getAvailableBackups()
    {
        if (null === $this->availableBackups) {
            $this->availableBackups = $this->buildBackupList();
        }

        return $this->availableBackups;
    }

    /**
     * @return array
    */
    private function buildBackupList()
    {
        return array_intersect(
            $this->getBackupDbAvailable($this->backupPath),
            $this->getBackupFilesAvailable($this->backupPath)
        );
    }

    /**
     * @param string $backupPath
     *
     * @return array
    */
    private function getBackupDbAvailable($backupPath)
    {
        $array = array();

        $files = scandir($backupPath);

        foreach ($files as $file) {
            if ($file[0] == 'V' && is_dir($backupPath . DIRECTORY_SEPARATOR . $file)) {
                $array[] = $file;
            }
        }

        return $array;
    }

    /**
     * @param string $backupPath
     *
     * @return array
    */
    private function getBackupFilesAvailable($backupPath)
    {
        $array = array();
        $files = scandir($backupPath);

        foreach ($files as $file) {
            if ($file[0] != '.' && Tools14::substr($file, 0, 16) == 'auto-backupfiles') {
                $array[] = preg_replace('#^auto-backupfiles_(.*-[0-9a-f]{1,8})\..*$#', '$1', $file);
            }
        }

        return $array;
    }
}
