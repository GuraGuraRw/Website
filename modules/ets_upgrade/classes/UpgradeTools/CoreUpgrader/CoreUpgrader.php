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

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader;

use PrestaShop\Module\EtsAutoUpgrade\Log\LoggerInterface;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\ThemeAdapter;

/**
 * Class used to modify the core of PrestaShop, on the files are copied on the filesystem.
 * It will run subtasks such as database upgrade, language upgrade etc.
 */
abstract class CoreUpgrader
{
    /**
     * @var UpgradeContainer
     */
    protected $container;

    /**
     * @var \Db
     */
    protected $db;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Version PrestaShop is upgraded to.
     *
     * @var string
     */
    protected $destinationUpgradeVersion;

    /**
     * Path to the temporary install folder, where upgrade files can be found
     *
     * @var string
     */
    protected $pathToInstallFolder;

    /**
     * Path to the folder containing PHP upgrade files
     *
     * @var string
     */
    protected $pathToPhpUpgradeScripts;


    /**
     * Path to the folder containing module ets_upgrade.
     *
     * @var string
     */
    protected $pathToInstallUpgradeFolder;

    public function __construct(UpgradeContainer $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    public function doUpgrade()
    {
        $this->initConstants();

        $oldversion = $this->getPreUpgradeVersion();

        if (!$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_SQL_VERSIONS)) {
            $this->checkVersionIsNewer($oldversion);
        }

        //check DB access
        error_reporting(E_ALL);
        $resultDB = \Db::checkConnection(_DB_SERVER_, _DB_USER_, _DB_PASSWD_, _DB_NAME_);
        if ($resultDB !== 0)
            throw new UpgradeException($this->container->getTranslator()->trans('Invalid database configuration', array(), 'Modules.Etsupgrade.Admin'));

        if (!$this->container->getState()->getInitialized()) {
            $this->logger->info($this->container->getTranslator()->trans('Initialization', array(), 'Modules.Etsupgrade.Admin'));
            // Disabled module custom anh override custom.
            if ($this->container->getUpgradeConfiguration()->isMajorChannel() || $this->container->getUpgradeConfiguration()->shouldDeactivateCustomModules()) {
                $this->logger->info($this->container->getTranslator()->trans('Disabling module and override...', array(), 'Modules.Etsupgrade.Admin'));
                $this->disableCustomModules();
                $this->disableOverrides(false);

                $this->logger->info($this->container->getTranslator()->trans('Disabled override OK', array(), 'Modules.Etsupgrade.Admin'));
            }

            // Convert type bit to tinyint before upgrade schema.
            $this->convertBitToTinyInt();
            $this->container->getState()->setInitialized(true);
        }

        $this->upgradeDb($oldversion);

        if (!$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_SQL_VERSIONS)) {
            // At this point, database upgrade is over.
            // Now we need to add all previous missing settings items, and reset cache and compile directories
            $this->upgradeDbComplete();
            $this->writeNewSettings();
            $this->runRecurrentQueries();
            $this->logger->debug($this->container->getTranslator()->trans('Database upgrade OK', array(), 'Modules.Etsupgrade.Admin')); // no error!

            $this->upgradeLanguages();
            $this->generateHtaccess();
            $this->cleanXmlFiles();
            $this->cleanFiles();

            if ($this->container->getUpgradeConfiguration()->isMajorChannel() || $this->container->getUpgradeConfiguration()->shouldDeactivateCustomModules()) {
                $this->disableOverrides();

                $this->logger->debug($this->container->getTranslator()->trans('Disabled override OK', array(), 'Modules.Etsupgrade.Admin'));
            }

            $this->updateTheme();

            $this->runCoreCacheClean();

            if ($this->container->getState()->getWarningExists()) {
                $this->logger->warning($this->container->getTranslator()->trans('Warning detected during upgrade.', array(), 'Modules.Etsupgrade.Admin'));
            } else {
                $this->logger->info($this->container->getTranslator()->trans('Database upgrade completed', array(), 'Modules.Etsupgrade.Admin'));
            }
        }
    }

    protected function deleteIdHookIsZero()
    {
        return \Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'hook_module` WHERE `id_hook`=0');
    }

    protected function convertBitToTinyInt()
    {
        $queryString = \Db::getInstance()->getValue("
            SELECT GROUP_CONCAT(DISTINCT CONCAT('ALTER TABLE `', TABLE_NAME, '` MODIFY COLUMN `', COLUMN_NAME, '` TINYINT(1) UNSIGNED ', IF(IS_NULLABLE = 'NO', 'NOT', ''), ' NULL') SEPARATOR ';') `queryString`
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '" . _DB_NAME_ . "' AND DATA_TYPE = 'BIT'
        ");
        if ($queryString)
            \Db::getInstance()->execute($queryString);
    }

    protected function upgradeDbComplete()
    {
        if ($this->container->getUpgradeConfiguration()->isMajorChannel()) {

            $id_profile = _PS_ADMIN_PROFILE_ ?: (int)\Db::getInstance()->getValue('SELECT id_profile FROM `' . _DB_PREFIX_ . 'profile` ORDER BY id_profile ASC');

            $sql = '
				INSERT INTO `' . _DB_PREFIX_ . 'access` (`id_profile`, `id_authorization_role`)
				SELECT ' . (int)$id_profile . ' `id_profile`, ar.id_authorization_role 
				FROM `' . _DB_PREFIX_ . 'authorization_role` ar
				LEFT JOIN `' . _DB_PREFIX_ . 'access` a ON (ar.id_authorization_role = a.id_authorization_role AND a.id_profile = ' . (int)$id_profile . ')
				WHERE a.id_authorization_role is NULL
				ORDER BY ar.id_authorization_role ASC;
			';

            return \Db::getInstance()->execute($sql);
        }
    }

    protected function initConstants()
    {
        // Initialize
        // setting the memory limit to 128M only if current is lower
        $memory_limit = ini_get('memory_limit');
        if ((Tools14::substr($memory_limit, -1) != 'G')
            && ((Tools14::substr($memory_limit, -1) == 'M' && Tools14::substr($memory_limit, 0, -1) < 512)
                || is_numeric($memory_limit) && ((int)$memory_limit < 131072))
        ) {
            @ini_set('memory_limit', '2048M');
        }

        // Redefine REQUEST_URI if empty (on some webservers...)
        if (!isset($_SERVER['REQUEST_URI']) || empty($_SERVER['REQUEST_URI'])) {
            if (!isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['SCRIPT_FILENAME'])) {
                $_SERVER['SCRIPT_NAME'] = $_SERVER['SCRIPT_FILENAME'];
            }
            if (isset($_SERVER['SCRIPT_NAME'])) {
                if (basename($_SERVER['SCRIPT_NAME']) == 'index.php' && empty($_SERVER['QUERY_STRING'])) {
                    $_SERVER['REQUEST_URI'] = dirname($_SERVER['SCRIPT_NAME']) . '/';
                } else {
                    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
                    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
                        $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
                    }
                }
            }
        }
        $_SERVER['REQUEST_URI'] = str_replace('//', '/', $_SERVER['REQUEST_URI']);

        $this->destinationUpgradeVersion = $this->container->getState()->getInstallVersion();
        $this->pathToInstallFolder = realpath($this->container->getProperty(UpgradeContainer::LATEST_PATH) . DIRECTORY_SEPARATOR . 'install');
        $this->pathToInstallUpgradeFolder = realpath($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/modules/ets_upgrade/install/upgrade/');
        // Kept for backward compatbility (unknown consequences on old versions of PrestaShop)
        define('INSTALL_VERSION', $this->destinationUpgradeVersion);
        // 1.4
        define('INSTALL_PATH', $this->pathToInstallFolder);
        // 1.5 ...
        if (!defined('_PS_CORE_DIR_')) {
            define('_PS_CORE_DIR_', _PS_ROOT_DIR_);
        }

        define('PS_INSTALLATION_IN_PROGRESS', true);
        define('SETTINGS_FILE_PHP', $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/app/config/parameters.php');
        define('SETTINGS_FILE_YML', $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/app/config/parameters.yml');
        define('DEFINES_FILE', $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/config/defines.inc.php');
        define('INSTALLER__PS_BASE_URI', Tools14::substr($_SERVER['REQUEST_URI'], 0, -1 * (Tools14::strlen($_SERVER['REQUEST_URI']) - strrpos($_SERVER['REQUEST_URI'], '/')) - Tools14::strlen(Tools14::substr(dirname($_SERVER['REQUEST_URI']), strrpos(dirname($_SERVER['REQUEST_URI']), '/') + 1))));

        define('_PS_INSTALL_PATH_', $this->pathToInstallFolder . '/');
        define('_PS_INSTALL_DATA_PATH_', _PS_INSTALL_PATH_ . 'data/');
        define('_PS_INSTALL_CONTROLLERS_PATH_', _PS_INSTALL_PATH_ . 'controllers/');
        define('_PS_INSTALL_MODELS_PATH_', _PS_INSTALL_PATH_ . 'models/');
        define('_PS_INSTALL_LANGS_PATH_', _PS_INSTALL_PATH_ . 'langs/');
        define('_PS_INSTALL_FIXTURES_PATH_', _PS_INSTALL_PATH_ . 'fixtures/');

        if (function_exists('date_default_timezone_set')) {
            date_default_timezone_set('Europe/Paris');
        }

        // if _PS_ROOT_DIR_ is defined, use it instead of "guessing" the module dir.
        if (defined('_PS_ROOT_DIR_') && !defined('_PS_MODULE_DIR_')) {
            define('_PS_MODULE_DIR_', _PS_ROOT_DIR_ . '/modules/');
        } elseif (!defined('_PS_MODULE_DIR_')) {
            define('_PS_MODULE_DIR_', $this->pathToInstallFolder . '/../modules/');
        }

        $upgrade_dir_php = 'upgrade/php';
        if (!file_exists($this->pathToInstallFolder . DIRECTORY_SEPARATOR . $upgrade_dir_php)) {
            $upgrade_dir_php = 'php';
            if (!file_exists($this->pathToInstallFolder . DIRECTORY_SEPARATOR . $upgrade_dir_php)) {
                throw new UpgradeException($this->container->getTranslator()->trans('/install/upgrade/php directory is missing in archive or directory', array(), 'Modules.Etsupgrade.Admin'));
            }
        }
        $this->pathToPhpUpgradeScripts = $this->pathToInstallFolder . DIRECTORY_SEPARATOR . $upgrade_dir_php . DIRECTORY_SEPARATOR;
        define('_PS_INSTALLER_PHP_UPGRADE_DIR_', $this->pathToPhpUpgradeScripts);

        if (!defined('__PS_BASE_URI__')) {
            define('__PS_BASE_URI__', realpath(dirname($_SERVER['SCRIPT_NAME'])) . '/../../');
        }

        if (!defined('_THEMES_DIR_')) {
            define('_THEMES_DIR_', __PS_BASE_URI__ . 'themes/');
        }

        if (file_exists($this->pathToInstallFolder . DIRECTORY_SEPARATOR . 'autoload.php')) {
            require_once $this->pathToInstallFolder . DIRECTORY_SEPARATOR . 'autoload.php';
        }
        $this->db = \Db::getInstance();
    }

    protected function getPreUpgradeVersion()
    {
        return $this->normalizeVersion($this->container->getState()->getOldVersion() ?: \Configuration::get('PS_VERSION_DB'));
    }

    /**
     * Add missing levels in version.
     * Example: 1.7 will become 1.7.0.0.
     *
     * @param string $version
     *
     * @return string
     *
     * @internal public for tests
     */
    public function normalizeVersion($version)
    {
        $arrayVersion = explode('.', $version);
        if (count($arrayVersion) < 4) {
            $arrayVersion = array_pad($arrayVersion, 4, '0');
        }

        return implode('.', $arrayVersion);
    }

    protected function checkVersionIsNewer($oldVersion)
    {
        if (strpos($this->destinationUpgradeVersion, '.') === false) {
            throw new UpgradeException($this->container->getTranslator()->trans('%s is not a valid version number.', array($this->destinationUpgradeVersion), 'Modules.Etsupgrade.Admin'));
        }

        $versionCompare = version_compare($this->destinationUpgradeVersion, $oldVersion);

        if ($versionCompare === -1) {
            throw new UpgradeException(
                $this->container->getTranslator()->trans('[ERROR] Version to install is too old.', array(), 'Modules.Etsupgrade.Admin')
                . ' ' .
                $this->container->getTranslator()->trans(
                    'Current version: %oldversion%. Version to install: %newversion%.',
                    array(
                        '%oldversion%' => $oldVersion,
                        '%newversion%' => $this->destinationUpgradeVersion,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));
        } elseif ($versionCompare === 0) {
            throw new UpgradeException($this->container->getTranslator()->trans('You already have the %s version.', array($this->destinationUpgradeVersion), 'Modules.Etsupgrade.Admin'));
        }
    }

    /**
     * Ask the core to disable the modules not coming from PrestaShop.
     */
    protected function disableCustomModules()
    {
        $this->disableNonNativeModules();
    }

    protected function disableNonNativeModules()
    {
        $db = \Db::getInstance();
        $arrNativeModules = array();

        if ($this->container->getUpgradeConfiguration()->isMajorChannel()) {

            $arrNativeModules = $this->container->getModulesOnLatestDir();
            $arrNativeModules = array_map(function ($nativeModule) {
                return '"' . pSQL($nativeModule) . '"';
            }, $arrNativeModules);

        } elseif ($this->container->getUpgradeConfiguration()->shouldDeactivateCustomModules()) {

            $modulesDirOnDisk = array();
            $modules = scandir(_PS_MODULE_DIR_, SCANDIR_SORT_NONE);
            foreach ($modules as $name) {
                if (!in_array($name, array('.', '..', 'index.php', '.htaccess')) && @is_dir(_PS_MODULE_DIR_ . $name . DIRECTORY_SEPARATOR) && @file_exists(_PS_MODULE_DIR_ . $name . DIRECTORY_SEPARATOR . $name . '.php')) {
                    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $name)) {
                        $this->logger->debug($this->container->getTranslator()->trans('Module name %s is invalid.', array($name), 'Modules.Etsupgrade.Admin'));
                    }
                    $modulesDirOnDisk[] = '"' . pSQL($name) . '"';
                }
            }

            $module_list_xml = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'modules_list.xml';

            if (!file_exists($module_list_xml)) {
                $module_list_xml = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'modules_list.xml';
                if (!file_exists($module_list_xml)) {
                    $this->logger->info($this->container->getTranslator()->trans('File modules_list.xml is not found.', array(), 'Modules.Etsupgrade.Admin'));
                    return false;
                }
            }

            $nativeModules = @simplexml_load_file($module_list_xml);

            if ($nativeModules) {
                foreach ($nativeModules as $nativeModulesType) {
                    if (in_array($nativeModulesType['type'], array('native', 'partner'))) {
                        foreach ($nativeModulesType->module as $module) {
                            $arrNativeModules[] = '"' . pSQL(trim((string)$module['name'])) . '"';
                        }
                    }
                }
            }
        }

        // Common.

        $arrNonNative = array();
        if ($arrNativeModules) {
            $arrNonNative = $db->executeS('
	            SELECT *
	            FROM `' . _DB_PREFIX_ . 'module` m
	            RIGHT JOIN `' . _DB_PREFIX_ . 'module_shop` ms ON (ms.id_module = m.id_module)
	            WHERE m.id_module is NOT NULL AND m.`active` = 1 AND m.`name`!=\'ets_upgrade\' AND m.`name` NOT IN (' . implode(',', $arrNativeModules) . ')
    		');
        }

        if (!$arrNonNative) {
            $this->logger->info($this->container->getTranslator()->trans('Non native module not found', array(), 'Modules.Etsupgrade.Admin'));
            return false;
        }

        $uninstallMe = array("undefined-modules");
        if (is_array($arrNonNative)) {
            foreach ($arrNonNative as $aModule) {
                if (empty($uninstallMe[(int)$aModule['id_module']])) {
                    $uninstallMe[(int)$aModule['id_module']] = trim($aModule['name']);
                }
            }
        }

        if (!is_array($uninstallMe)) {
            $uninstallMe = array($uninstallMe);
        }

        foreach ($uninstallMe as $k => $v) {
            $uninstallMe[$k] = '"' . pSQL($v) . '"';
        }

        $this->container->getFileConfigurationStorage()->save($uninstallMe, UpgradeFileNames::FILES_ENABLED_MODULES);

        $return = $db->execute('UPDATE `' . _DB_PREFIX_ . 'module` SET `active`=0 WHERE `name` IN (' . implode(',', array_values($uninstallMe)) . ')');

        if (count($db->executeS('SHOW TABLES LIKE \'' . _DB_PREFIX_ . 'module_shop\'')) > 0) {
            foreach ($uninstallMe as $k => $uninstall) {
                $return &= $db->execute('DELETE FROM `' . _DB_PREFIX_ . 'module_shop` WHERE `id_module` = ' . (int)$k);
            }
            unset($uninstall);
        }

        if ($return) {
            $this->logger->info($this->container->getTranslator()->trans('All non native modules are disabled', array(), 'Modules.Etsupgrade.Admin'));
        }

        return $return;
    }

    protected function upgradeDb($oldversion)
    {
        $start_time = time();
        $upgrade_dir_sql = $this->pathToInstallFolder . '/upgrade/sql';

        // To build list files.
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::FILES_SQL_VERSIONS)) {
            return $this->warmUp($upgrade_dir_sql, $oldversion);
        }

        $upgradeSqlFiles = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_SQL_VERSIONS);

        // Check list.
        if (!is_array($upgradeSqlFiles) || !count($upgradeSqlFiles)) {
            $this->container->getState()->setWarningExists(true);
            $this->logger->info($this->container->getTranslator()->trans('Files sql is empty. No sql file has been upgrade.', array(), 'Modules.Etsupgrade.Admin'));

            return true;
        }
        $queriesRunVersions = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::QUERIES_RUN_VERSIONS);
        // Do run query.
        $time_elapsed = time() - $start_time;
        do {
            $upgradeSqlFile = array();
            foreach ($upgradeSqlFiles as $version => $sqlFile) {
                if (isset($queriesRunVersions['ver']) && $queriesRunVersions['ver'] !== '' && version_compare($queriesRunVersions['ver'], $version, '>')) {
                    unset($upgradeSqlFiles[$version]);
                    continue;
                }
                $upgradeSqlFile[$version] = $sqlFile;
                break;
            }
            $sqlContentVersion = $this->applySqlParams($upgradeSqlFile);
            foreach ($sqlContentVersion as $upgrade_file => $sqlContent) {
                $nextQueryIk = isset($queriesRunVersions['index']) && $queriesRunVersions['index'] && isset($queriesRunVersions['index'][$upgrade_file]) && $queriesRunVersions['index'][$upgrade_file] ? (int)$queriesRunVersions['index'][$upgrade_file] : -1;
                $ik = 0;
                foreach ($sqlContent as $query) {
                    if ($ik > $nextQueryIk) {
                        //die(dump($ik, $nextQueryIk, $queriesRunVersions, $sqlContent));
                        $this->runQuery($upgrade_file, $query);
                        $queriesRunVersions['ver'] = $upgrade_file;
                        $queriesRunVersions['index'][$upgrade_file] = $ik;
                        $this->container->getFileConfigurationStorage()->save($queriesRunVersions, UpgradeFileNames::QUERIES_RUN_VERSIONS);
                    }
                    $ik++;
                }
            }
            if (!empty($version)) {
                unset($upgradeSqlFiles[$version]);
            }

            $time_elapsed = time() - $start_time;

        } while (($time_elapsed < $this->container->getUpgradeConfiguration()->getTimePerCall()) && count($upgradeSqlFiles) > 0);

        // To rebuild list files.
        $sql_files_left = count($upgradeSqlFiles);
        $this->container->getFileConfigurationStorage()->save($upgradeSqlFiles, UpgradeFileNames::FILES_SQL_VERSIONS);
        unset($upgradeSqlFiles);

        if ($sql_files_left) {
            $this->logger->info($this->container->getTranslator()->trans('%s sql files left to upgrade.', array($sql_files_left), 'Modules.Etsupgrade.Admin'));
        }

        return $sql_files_left > 0 ? true : false;
    }

    protected function warmUp($upgrade_dir_sql, $oldversion)
    {
        try {
            $upgradeSqlFiles = $this->getUpgradeSqlFilesListToApply($upgrade_dir_sql, $oldversion);
            $this->container->getFileConfigurationStorage()->save($upgradeSqlFiles, UpgradeFileNames::FILES_SQL_VERSIONS);
        } catch (UpgradeException $e) {
            $this->handleException($e);

            return false;
        }

        $total_sql_to_upgrade = count($upgradeSqlFiles);
        if ($total_sql_to_upgrade) {
            $this->logger->info($this->container->getTranslator()->trans('%s sql files will be upgraded.', array($total_sql_to_upgrade), 'Modules.Etsupgrade.Admin'));
        }
        return true;
    }

    protected function handleException(UpgradeException $e)
    {
        foreach ($e->getQuickInfos() as $log) {
            $this->logger->debug($log);
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
            $this->next = 'error';
            $this->error = true;
            $this->logger->error($e->getMessage());
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_WARNING) {
            $this->logger->warning($e->getMessage());
        }
    }

    protected function getUpgradeSqlFilesListToApply($upgrade_dir_sql, $oldversion)
    {
        if (!file_exists($upgrade_dir_sql)) {
            throw (new UpgradeException($this->container->getTranslator()->trans('Unable to find upgrade directory in the installation path.', array(), 'Modules.Etsupgrade.Admin')))
                ->setSeverity(UpgradeException::SEVERITY_WARNING);
        }

        $upgradeFiles = $neededUpgradeFiles = array();
        if ($handle = opendir($upgrade_dir_sql)) {
            while (false !== ($file = readdir($handle))) {
                if ($file[0] === '.') {
                    continue;
                }
                if (!is_readable($upgrade_dir_sql . DIRECTORY_SEPARATOR . $file)) {
                    throw (new UpgradeException($this->container->getTranslator()->trans('Error while loading SQL upgrade file "%s".', array($file), 'Modules.Etsupgrade.Admin')))
                        ->setSeverity(UpgradeException::SEVERITY_WARNING);
                }
                $upgradeFiles[] = str_replace('.sql', '', $file);
            }
            closedir($handle);
        }
        if (empty($upgradeFiles)) {
            throw (new UpgradeException($this->container->getTranslator()->trans('Cannot find the SQL upgrade files. Please check that the %s folder is not empty.', array($upgrade_dir_sql), 'Modules.Etsupgrade.Admin')))
                ->setSeverity(UpgradeException::SEVERITY_WARNING);
        }
        natcasesort($upgradeFiles);

        foreach ($upgradeFiles as $version) {
            if (version_compare($version, $oldversion) === 1 && version_compare($this->destinationUpgradeVersion, $version) !== -1) {


                $neededUpgradeFiles[$version] = @file_exists(($sqlFile = $this->pathToInstallUpgradeFolder . '/sql/' . $version . '.sql')) && (version_compare($version, '1.7.7.0') !== 0 || version_compare($oldversion, '1.7.0.0', '<') && version_compare($this->destinationUpgradeVersion, '1.7.7.0', '>=')) ? $sqlFile : $upgrade_dir_sql . DIRECTORY_SEPARATOR . $version . '.sql';

            }
        }

        return $neededUpgradeFiles;
    }

    /**
     * Replace some placeholders in the SQL upgrade files (prefix, engine...).
     *
     * @param array $sqlFiles
     *
     * @return array of SQL requests per version
     */
    protected function applySqlParams(array $sqlFiles)
    {
        $search = array('PREFIX_', 'ENGINE_TYPE', 'DB_NAME');
        $replace = array(_DB_PREFIX_, (defined('_MYSQL_ENGINE_') ? _MYSQL_ENGINE_ : 'MyISAM'), _DB_NAME_);

        $sqlRequests = array();

        foreach ($sqlFiles as $version => $file) {
            $sqlContent = Tools14::file_get_contents($file) . "\n";
            $sqlContent = str_replace($search, $replace, $sqlContent);
            $sqlContent = preg_split("/;\s*[\r\n]+/", $sqlContent);
            $sqlRequests[$version] = $sqlContent;
        }

        return $sqlRequests;
    }

    /**
     * ToDo, check to move this in a database class.
     *
     * @param string $upgrade_file File in which the request is stored (for logs)
     * @param string $query
     */
    protected function runQuery($upgrade_file, $query)
    {
        $query = trim($query);
        if (empty($query)) {
            return;
        }
        // If php code have to be executed
        if (strpos($query, '/* PHP:') !== false) {
            $this->runPhpQuery($upgrade_file, $query);
        } else
            $this->runSqlQuery($upgrade_file, $query);
    }

    protected function runPhpQuery($upgrade_file, $query)
    {
        // Parsing php code
        if (preg_match('#\/\*\s*PHP:((?:[0-9a-zA-Z_]+)\s*\((?:[^\(\);]*?)\))\s*;\s*\*\/#', $query, $matches) && !empty($matches[1])) {
            $phpString = $matches[1];
        } else {
            $pos = strpos($query, '/* PHP:') + Tools14::strlen('/* PHP:');
            $phpString = Tools14::substr($query, $pos, Tools14::strlen($query) - $pos - Tools14::strlen('*/;'));
        }

        $php = explode('::', $phpString);

        preg_match('/\((.*)\)/', $phpString, $pattern);
        $paramsString = trim($pattern[0], '()');

        preg_match_all('/([^,]+),? ?/', $paramsString, $parameters);
        $parameters = (isset($parameters[1]) && is_array($parameters[1])) ? $parameters[1] : array();

        foreach ($parameters as &$parameter) {
            $parameter = str_replace('\'', '', $parameter);
        }

        // reset phpRes to a null value
        $phpRes = null;
        // Call a simple function
        if (strpos($phpString, '::') === false) {
            $func_name = str_replace($pattern[0], '', $php[0]);

            if (@file_exists(($file = $this->pathToInstallUpgradeFolder . '/php/' . Tools14::strtolower($func_name) . '.php'))) {
                require_once $file;
                $phpRes = call_user_func_array($func_name, $parameters);
            } elseif (@file_exists(($file = $this->pathToPhpUpgradeScripts . Tools14::strtolower($func_name) . '.php'))) {
                require_once $file;
                $phpRes = call_user_func_array($func_name, $parameters);
            } else {
                $this->logger->error('[ERROR] ' . $upgrade_file . ' PHP - missing file ' . $query);
                $this->container->getState()->setWarningExists(true);

                return;
            }

        } // Or an object method
        else {
            $func_name = array($php[0], str_replace($pattern[0], '', $php[1]));
            $this->logger->error('[ERROR] ' . $upgrade_file . ' PHP - Object Method call is forbidden (' . $php[0] . '::' . str_replace($pattern[0], '', $php[1]) . ')');
            $this->container->getState()->setWarningExists(true);

            return;
        }

        if (isset($phpRes) && (is_array($phpRes) && !empty($phpRes['error'])) || $phpRes === false) {
            $this->logger->error('
                [ERROR] PHP ' . $upgrade_file . ' ' . $query . "\n" . '
                ' . (empty($phpRes['error']) ? '' : $phpRes['error'] . "\n") . '
                ' . (empty($phpRes['msg']) ? '' : ' - ' . $phpRes['msg'] . "\n"));
            $this->container->getState()->setWarningExists(true);
        } else {
            $this->logger->debug('<div class="upgradeDbOk">[OK] PHP ' . $upgrade_file . ' : ' . $query . '</div>');
        }
    }

    protected function runSqlQuery($upgrade_file, $query)
    {
        if (strstr($query, 'CREATE TABLE') !== false) {
            $pattern = '/CREATE TABLE.*[`]*' . _DB_PREFIX_ . '([^`\s]*)[`]*\s\(/';
            preg_match($pattern, $query, $matches);
            if (!empty($matches[1])) {
                $drop = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . $matches[1] . '`;';
                if ($this->db->execute($drop, false)) {
                    $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[DROP] SQL %s table has been dropped.', array('`' . _DB_PREFIX_ . $matches[1] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');
                }
            }
        }
        if (strstr($query, 'ALTER TABLE') !== false) {
            $pattern = '/ALTER TABLE.*[`]*' . _DB_PREFIX_ . '([^`\s]*)[`]*\s+ADD\s(UNIQUE\s)?(INDEX|KEY)\s+[`]*([^`\s]*)[`]*/';
            $res = preg_match($pattern, $query, $matches);
            if (!empty($matches[1]) && !empty($matches[3])) {
                $unique = !empty($matches[2]) ? 0 : 1;
                $uniqueIndexExist = 'SELECT COUNT(*) as `IndexExists` FROM INFORMATION_SCHEMA.STATISTICS WHERE table_schema = \'' . _DB_NAME_ . '\' AND table_name = \'' . _DB_PREFIX_ . $matches[1] . '\' AND index_name = \'' . $matches[3] . '\' AND non_unique = ' . (int)$unique . ';';
                if ($this->db->executeS($uniqueIndexExist)) {
                    $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[UNIQUE INDEX EXIST] SQL %s unique index exist in table %s.', array('`' . $matches[3] . '`', '`' . _DB_PREFIX_ . $matches[1] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');

                    return true;
                }
            }
            if (!$res) {
                $pattern = '/ALTER TABLE.*[`]*' . _DB_PREFIX_ . '([^`\s]*)[`]*\s+ADD\s+(?:COLUMN\s+)?[`]*([^`\s]*)[`]*/';
                preg_match($pattern, $query, $matches);
                if (!empty($matches[1]) && !empty($matches[2])) {
                    $columnExist = 'SHOW COLUMNS FROM `' . _DB_PREFIX_ . $matches[1] . '` LIKE \'' . $matches[2] . '\';';
                    if ($this->db->executeS($columnExist)) {
                        $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[EXIST] SQL %s column exist in table %s.', array('`' . $matches[2] . '`', '`' . _DB_PREFIX_ . $matches[1] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');

                        return true;
                    }
                }
            }
            $pattern = '/ALTER TABLE.*[`]*' . _DB_PREFIX_ . '(?<tbl>[^`\s]*)[`]*\s+DROP\s+(?:(?<idx>INDEX|KEY)\s+[`]*(?<name>[^`\s]*)[`]*|(?<pri>PRIMARY\s+KEY))/';
            $res2 = preg_match($pattern, $query, $matches);
            if (!empty($matches['tbl'])) {
                if (!empty($matches['idx']) && !empty($matches['name'])) {
                    $indexNotExist = 'SHOW INDEX FROM `' . _DB_PREFIX_ . $matches['tbl'] . '` WHERE `Key_name`=\'' . $matches['name'] . '\';';
                    if (!$this->db->executeS($indexNotExist)) {
                        $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[INDEX NOT EXIST] SQL INDEX|KEY %s not exist in table %s.', array('`' . $matches['name'] . '`', '`' . _DB_PREFIX_ . $matches['tbl'] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');

                        return true;
                    }
                } elseif ($matches['pri']) {
                    $priNotExist = 'SHOW INDEX FROM `' . _DB_PREFIX_ . $matches['tbl'] . '` WHERE `Key_name`=\'PRIMARY\';';
                    if (!$this->db->executeS($priNotExist)) {
                        $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[PRIMARY NOT EXIST] SQL PRIMARY KEY not exist in table %s.', array('`' . _DB_PREFIX_ . $matches['tbl'] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');

                        return true;
                    }
                }
            }
            if (!$res2) {
                $pattern = '/ALTER TABLE.*[`]*' . _DB_PREFIX_ . '(?<tbl>[^`\s]*)[`]*\s+DROP(?:\s+COLUMN)?\s+[`]*(?<name>[^`\s]*)[`]*/';
                preg_match($pattern, $query, $matches);
                if (!empty($matches['tbl']) && !empty($matches['name'])) {
                    $columnNotExist = 'SHOW COLUMNS FROM `' . _DB_PREFIX_ . $matches['tbl'] . '` LIKE \'' . $matches['name'] . '\';';
                    if (!$this->db->executeS($columnNotExist)) {
                        $this->logger->debug('<div class="upgradeDbOk">' . $this->container->getTranslator()->trans('[NOT EXIST] SQL %s column not exist in table %s.', array('`' . $matches['name'] . '`', '`' . _DB_PREFIX_ . $matches['tbl'] . '`'), 'Modules.Etsupgrade.Admin') . '</div>');

                        return true;
                    }
                }
            }
        }

        if (strstr($query, 'INSERT INTO') !== false) {
            $query = preg_replace('/(INSERT)(\s+INTO)/', '$1 IGNORE$2', $query);
        } elseif (strstr($query, 'UPDATE') !== false && strstr($query, 'UPDATE IGNORE') === false) {
            $query = preg_replace('/(UPDATE\s+)/', '$1 IGNORE ', $query);
        }
        if ($this->db->execute($query, false)) {
            $this->logger->debug('<div class="upgradeDbOk">[OK] SQL ' . $upgrade_file . ' ' . $query . '</div>');

            return true;
        }

        $error = $this->db->getMsgError();
        $error_number = $this->db->getNumberError();
        $this->logger->warning('
            <div class="upgradeDbError">
            [WARNING] SQL ' . $upgrade_file . '
            ' . $error_number . ' in ' . $query . ': ' . $error . '</div>');

        $duplicates = array('1050', '1054', '1060', '1061', '1062', '1091');
        if (!in_array($error_number, $duplicates)) {
            $this->logger->error('SQL ' . $upgrade_file . ' ' . $error_number . ' in ' . $query . ': ' . $error);
            $this->container->getState()->setWarningExists(true);
        }
    }

    public function writeNewSettings()
    {
        // Do nothing
    }

    protected function runRecurrentQueries()
    {
        $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET `name` = \'PS_LEGACY_IMAGES\' WHERE name LIKE \'0\' AND `value` = 1');
        $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET `value` = 0 WHERE `name` LIKE \'PS_LEGACY_IMAGES\'');
        if ($this->db->getValue('SELECT COUNT(id_product_download) FROM `' . _DB_PREFIX_ . 'product_download` WHERE `active` = 1') > 0) {
            $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET `value` = 1 WHERE `name` LIKE \'PS_VIRTUAL_PROD_FEATURE_ACTIVE\'');
        }

        // Exported from the end of doUpgrade()
        $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value="0" WHERE name = "PS_HIDE_OPTIMIZATION_TIS"', false);
        $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value="1" WHERE name = "PS_NEED_REBUILD_INDEX"', false);
        $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value="' . pSQL($this->destinationUpgradeVersion) . '" WHERE name = "PS_VERSION_DB"', false);

        // Disable geolocation when upgrade 1.6 to 1.7.
        if ($this->container->getUpgradeConfiguration()->isMajorChannel()) {
            $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value="0" WHERE name="PS_GEOLOCATION_ENABLED"', false);
        }
    }

    protected function upgradeLanguages()
    {
        if (!defined('_PS_TOOL_DIR_')) {
            define('_PS_TOOL_DIR_', _PS_ROOT_DIR_ . '/tools/');
        }
        if (!defined('_PS_TRANSLATIONS_DIR_')) {
            define('_PS_TRANSLATIONS_DIR_', _PS_ROOT_DIR_ . '/translations/');
        }
        if (!defined('_PS_MODULES_DIR_')) {
            define('_PS_MODULES_DIR_', _PS_ROOT_DIR_ . '/modules/');
        }
        if (!defined('_PS_MAILS_DIR_')) {
            define('_PS_MAILS_DIR_', _PS_ROOT_DIR_ . '/mails/');
        }

        $langs = $this->db->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'lang` WHERE `active` = 1');

        if (!is_array($langs)) {
            return;
        }
        foreach ($langs as $lang) {
            try {
                $this->upgradeLanguage($lang);

            } catch (UpgradeException $e) {

                $this->handleException($e);
            }
        }
    }

    abstract protected function upgradeLanguage($lang);

    protected function generateHtaccess()
    {
        require dirname(__FILE__) . '/Interpreter';

        $this->loadEntityInterface();

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Tools.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Tools.php';
        }

        if (!class_exists('ToolsCore') || !method_exists('ToolsCore', 'generateHtaccess')) {
            return;
        }
        $url_rewrite = (bool)$this->db->getvalue('SELECT `value` FROM `' . _DB_PREFIX_ . 'configuration` WHERE name=\'PS_REWRITING_SETTINGS\'');

        if (!defined('_MEDIA_SERVER_1_')) {
            define('_MEDIA_SERVER_1_', '');
        }

        if (!defined('_PS_USE_SQL_SLAVE_')) {
            define('_PS_USE_SQL_SLAVE_', false);
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/ObjectModel.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/ObjectModel.php';
        }
        if (!class_exists('ObjectModel', false) && class_exists('ObjectModelCore')) {
            call_user_func('buildTo', 'abstract class ObjectModel extends ObjectModelCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Configuration.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Configuration.php';
        }
        if (!class_exists('Configuration', false) && class_exists('ConfigurationCore')) {
            call_user_func('buildTo', 'class Configuration extends ConfigurationCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/cache/Cache.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/cache/Cache.php';
        }
        if (!class_exists('Cache', false) && class_exists('CacheCore')) {
            call_user_func('buildTo', 'abstract class Cache extends CacheCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/PrestaShopCollection.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/PrestaShopCollection.php';
        }
        if (!class_exists('PrestaShopCollection', false) && class_exists('PrestaShopCollectionCore')) {
            call_user_func('buildTo', 'class PrestaShopCollection extends PrestaShopCollectionCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/shop/ShopUrl.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/shop/ShopUrl.php';
        }
        if (!class_exists('ShopUrl', false) && class_exists('ShopUrlCore')) {
            call_user_func('buildTo', 'class ShopUrl extends ShopUrlCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/shop/Shop.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/shop/Shop.php';
        }
        if (!class_exists('Shop', false) && class_exists('ShopCore')) {
            call_user_func('buildTo', 'class Shop extends ShopCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Translate.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Translate.php';
        }
        if (!class_exists('Translate', false) && class_exists('TranslateCore')) {
            call_user_func('buildTo', 'class Translate extends TranslateCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/module/Module.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/module/Module.php';
        }
        if (!class_exists('Module', false) && class_exists('ModuleCore')) {
            call_user_func('buildTo', 'class Module extends ModuleCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Validate.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Validate.php';
        }
        if (!class_exists('Validate', false) && class_exists('ValidateCore')) {
            call_user_func('buildTo', 'class Validate extends ValidateCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Language.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Language.php';
        }
        if (!class_exists('Language', false) && class_exists('LanguageCore')) {
            call_user_func('buildTo', 'class Language extends LanguageCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Tab.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Tab.php';
        }
        if (!class_exists('Tab', false) && class_exists('TabCore')) {
            call_user_func('buildTo', 'class Tab extends TabCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Dispatcher.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Dispatcher.php';
        }
        if (!class_exists('Dispatcher', false) && class_exists('DispatcherCore')) {
            call_user_func('buildTo', 'class Dispatcher extends DispatcherCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Hook.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Hook.php';
        }
        if (!class_exists('Hook', false) && class_exists('HookCore')) {
            call_user_func('buildTo', 'class Hook extends HookCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Context.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Context.php';
        }
        if (!class_exists('Context', false) && class_exists('ContextCore')) {
            call_user_func('buildTo', 'class Context extends ContextCore{}');
        }

        if (file_exists(_PS_ROOT_DIR_ . '/classes/Group.php')) {
            require_once _PS_ROOT_DIR_ . '/classes/Group.php';
        }
        if (!class_exists('Group', false) && class_exists('GroupCore')) {
            call_user_func('buildTo', 'class Group extends GroupCore{}');
        }

        \ToolsCore::generateHtaccess(null, $url_rewrite);
    }

    protected function loadEntityInterface()
    {
        if (@file_exists(_PS_ROOT_DIR_ . '/src/Core/Foundation/Database/EntityInterface.php')) {
            require_once _PS_ROOT_DIR_ . '/src/Core/Foundation/Database/EntityInterface.php';
        }
    }

    protected function cleanFiles()
    {
        $files = array();
        if (version_compare($this->destinationUpgradeVersion, '8.0.0', '>=')) {
            $files = array(
                _PS_ROOT_DIR_ . '/classes/Attribute.php',
            );
        }
        if ($files) {
            foreach ($files as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }

    protected function cleanXmlFiles()
    {
        $files = array(
            _PS_ROOT_DIR_ . '/app/cache/dev/class_index.php',
            _PS_ROOT_DIR_ . '/app/cache/prod/class_index.php',
            _PS_ROOT_DIR_ . '/cache/class_index.php',
            _PS_ROOT_DIR_ . '/config/xml/blog-fr.xml',
            _PS_ROOT_DIR_ . '/config/xml/default_country_modules_list.xml',
            _PS_ROOT_DIR_ . '/config/xml/modules_list.xml',
            _PS_ROOT_DIR_ . '/config/xml/modules_native_addons.xml',
            _PS_ROOT_DIR_ . '/config/xml/must_have_modules_list.xml',
            _PS_ROOT_DIR_ . '/config/xml/tab_modules_list.xml',
            _PS_ROOT_DIR_ . '/config/xml/trusted_modules_list.xml',
            _PS_ROOT_DIR_ . '/config/xml/untrusted_modules_list.xml',
            _PS_ROOT_DIR_ . '/var/cache/dev/class_index.php',
            _PS_ROOT_DIR_ . '/var/cache/prod/class_index.php',
        );
        if (version_compare($this->destinationUpgradeVersion, '1.6.0.0', '>=')) {
            $files[] = $this->container->getProperty(UpgradeContainer::PS_ADMIN_PATH) . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'header.tpl';
        }
        foreach ($files as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    protected function disableOverrides($generate_index = true)
    {
        $exist = $this->db->getValue('SELECT `id_configuration` FROM `' . _DB_PREFIX_ . 'configuration` WHERE `name` LIKE \'PS_DISABLE_OVERRIDES\'');
        if ($exist) {
            $this->db->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value = 1 WHERE `name` LIKE \'PS_DISABLE_OVERRIDES\'');
        } else {
            $this->db->execute('INSERT INTO `' . _DB_PREFIX_ . 'configuration` (name, value, date_add, date_upd) VALUES ("PS_DISABLE_OVERRIDES", 1, NOW(), NOW())');
        }

        if ($generate_index) {
            if (file_exists(_PS_ROOT_DIR_ . '/classes/PrestaShopAutoload.php')) {
                require_once _PS_ROOT_DIR_ . '/classes/PrestaShopAutoload.php';
            }

            if (class_exists('PrestaShopAutoload') && method_exists('PrestaShopAutoload', 'generateIndex')) {
                \PrestaShopAutoload::getInstance()->_include_override_path = false;
                \PrestaShopAutoload::getInstance()->generateIndex();
            }
        }
    }

    protected function updateTheme()
    {
        // The merchant can ask for keeping its current theme.
        if ($this->container->getUpgradeConfiguration()->shouldSwitchToDefaultTheme() || $this->container->getUpgradeConfiguration()->isMajorChannel()) {
            if ($this->deleteIdHookIsZero())
                $this->logger->info($this->container->getTranslator()->trans('Cleaned id_hook=0 in table hook_module.', array(), 'Modules.Etsupgrade.Admin'));
            $this->logger->info($this->container->getTranslator()->trans('Switching to default theme.', array(), 'Modules.Etsupgrade.Admin'));
            $themeAdapter = new ThemeAdapter($this->destinationUpgradeVersion, $this->container, $this->logger);

            $themeErrors = $themeAdapter->enableTheme(
                $themeAdapter->getDefaultTheme()
            );

            if ($themeErrors !== true) {
                throw new UpgradeException($themeErrors);
            }

            $this->logger->info($this->container->getTranslator()->trans('Theme upgrade ok.', array(), 'Modules.Etsupgrade.Admin'));
        }
    }

    protected function runCoreCacheClean()
    {
        \Tools::clearCache();
    }
}