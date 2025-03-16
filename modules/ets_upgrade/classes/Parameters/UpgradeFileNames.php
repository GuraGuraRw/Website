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

/**
 * File names where upgrade temporary content is stored.
 */
class UpgradeFileNames
{
    /**
     * configFilename contains all configuration specific to the ets_upgrade module.
     *
     * @var string
     */
    const CONFIG_FILENAME = 'config.var';

    /**
     * during upgradeFiles process,
     * this files contains the list of queries left to upgrade in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const QUERIES_TO_UPGRADE_LIST = 'queriesToUpgrade.list';

    /**
     * during upgradeFiles process,
     * this files contains the list of files left to upgrade in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const FILES_TO_UPGRADE_LIST = 'filesToUpgrade.list';

    /**
     * during upgradeModules process,
     * this files contains the list of modules left to upgrade in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const MODULES_TO_UPGRADE_LIST = 'modulesToUpgrade.list';

    /**
     * during upgradeFiles process,
     * this files contains the list of files left to upgrade in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const FILES_DIFF_LIST = 'filesDiff.list';

    /**
     * during backupFiles process,
     * this files contains the list of files left to save in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const FILES_TO_BACKUP_LIST = 'filesToBackup.list';

    /**
     * during backupDb process,
     * this files contains the list of tables left to save in a serialized array.
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const DB_TABLES_TO_BACKUP_LIST = 'tablesToBackup.list';

    /**
     * during restoreDb process,
     * this file contains a serialized array of queries which left to execute for restoring database
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const QUERIES_TO_RESTORE_LIST = 'queryToRestore.list';
    const DB_TABLES_TO_CLEAN_LIST = 'tableToClean.list';

    /**
     * during restoreFiles process,
     * this file contains difference between queryToRestore and queries present in a backupFiles archive
     * (this file is deleted in init() method if you reload the page).
     *
     * @var string
     */
    const FILES_TO_REMOVE_LIST = 'filesToRemove.list';

    /**
     * during restoreFiles process,
     * contains list of files present in backupFiles archive.
     *
     * @var string
     */
    const FILES_FROM_ARCHIVE_LIST = 'filesFromArchive.list';

    /**
     * mailCustomList contains list of mails files which are customized,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const MAILS_CUSTOM_LIST = 'mails-custom.list';

    /**
     * tradCustomList contains list of translation files which are customized,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const TRANSLATION_FILES_CUSTOM_LIST = 'translations-custom.list';

    /**
     * filesInitJsParams contains list of init info,
     *
     * @var string
     */
    const FILES_INIT_JS_PARAMS = 'filesInitJsParams.list';

    /**
     * modulesOnLatest contains list of modules last version Prestashop,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const MODULES_ON_LATEST = 'modulesOnLatest.list';

    /**
     * filesSqlVersions contains list of files SQL need upgrade,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const QUERIES_RUN_VERSIONS = 'queriesRunVersions.list';

    /**
     * filesSqlVersions contains list of files SQL need upgrade,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const FILES_SQL_VERSIONS = 'filesSqlVersions.list';

    /**
     * filesEnableModules contains list of module need enable,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const FILES_ENABLED_MODULES = 'filesEnableModules.list';

    /**
     * modulesOnOverride contains list of module override need remove override,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const MODULES_ON_OVERRIDE = 'modulesOnOverride.list';

    /**
     * listModuleOnLatest contains list of module of current version install,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const LIST_MODULE_ON_LATEST = 'listModuleOnLatest.list';

    /**
     * listModuleReference contains list of module convert upgrade version,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const LIST_MODULE_REFERENCE = 'listModuleReference.list';

    /**
     * modulesOnListXml contains list of module fetch for file modules_list.xml,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const MODULES_ON_LIST_XML = 'modulesOnListXml.list';

    /**
     * modulesOnListXml contains list of module fetch for file modules_list.xml,
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const NEXT_PARAMS_RESUME = 'nextParamsResume.list';


    /**
     * relative to original files for the current PrestaShop version.
     *
     * @var string
     */
    const FILES_CACHE = 'filesCache.list';

    /**
     * tmp_files contains an array of filename which will be removed
     * at the beginning of the upgrade process.
     *
     * @var array
     */
    public static $tmp_files = array(
        'QUERIES_TO_UPGRADE_LIST', // used ?
        'FILES_TO_UPGRADE_LIST',
        'FILES_DIFF_LIST',
        'FILES_TO_BACKUP_LIST',
        'DB_TABLES_TO_BACKUP_LIST',
        'QUERIES_TO_RESTORE_LIST',
        'DB_TABLES_TO_CLEAN_LIST',
        'FILES_TO_REMOVE_LIST',
        'FILES_FROM_ARCHIVE_LIST',
        'MAILS_CUSTOM_LIST',
        'TRANSLATION_FILES_CUSTOM_LIST',
        'FILES_SQL_VERSIONS',
        'QUERIES_RUN_VERSIONS',
        'FILES_ENABLED_MODULES',
        'MODULES_ON_OVERRIDE',
        'LIST_MODULE_ON_LATEST',
        'LIST_MODULE_REFERENCE',
        'MODULES_ON_LIST_XML',
        'NEXT_PARAMS_RESUME',
        'FILES_CACHE',
    );
}
