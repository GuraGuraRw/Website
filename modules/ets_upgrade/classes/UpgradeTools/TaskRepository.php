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

use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

class TaskRepository
{
    public static function get($step, UpgradeContainer $container)
    {
        switch ($step) {
            // MISCELLANEOUS (upgrade configuration, checks etc.)
            case 'checkFilesVersion':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous\CheckFilesVersion($container);
            case 'compareReleases':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous\CompareReleases($container);
            case 'getChannelInfo':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous\GetChannelInfo($container);
            case 'updateConfig':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous\UpdateConfig($container);

            // ROLLBACK
            case 'noRollbackFound':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback\NoRollbackFound($container);
            case 'restoreDb':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback\RestoreDb($container);
            case 'restoreFiles':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback\RestoreFiles($container);
            case 'rollback':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback\Rollback($container);
            case 'rollbackComplete':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback\RollbackComplete($container);

            // UPGRADE
            case 'backupDb':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\BackupDb($container);
            case 'backupFiles':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\BackupFiles($container);
            case 'cleanDatabase':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\CleanDatabase($container);
            case 'download':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\Download($container);
            case 'removeSamples':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\RemoveSamples($container);
            case 'upgradeComplete':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\UpgradeComplete($container);
            case 'upgradeDb':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\UpgradeDb($container);
            case 'upgradeFiles':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\UpgradeFiles($container);
            case 'upgradeModules':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\UpgradeModules($container);
            case 'upgradeNow':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\UpgradeNow($container);
            case 'unzip':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\Unzip($container);
	        case 'enableModules':
		        return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\EnableModules($container);
	        case 'removeOverride':
		        return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\RemoveOverride($container);
	        case 'renameModules':
		        return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\RenameModules($container);
	        case 'installModules':
		        return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\InstallModules($container);
            case 'cleanCached':
                return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade\CleanCached($container);
        }
        error_log('Unknown step ' . $step);

        return new \PrestaShop\Module\EtsAutoUpgrade\TaskRunner\NullTask($container);
    }
}
