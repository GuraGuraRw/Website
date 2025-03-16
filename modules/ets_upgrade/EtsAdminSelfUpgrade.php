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

use PrestaShop\Module\EtsAutoUpgrade\AjaxResponse;
use PrestaShop\Module\EtsAutoUpgrade\BackupFinder;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradePage;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeSelfCheck;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;

require_once _PS_ROOT_DIR_ . '/modules/ets_upgrade/vendor/autoload.php';

class EtsAdminSelfUpgrade extends AdminController
{
    public $multishop_context;
    public $multishop_context_group = false;
    public $_html = '';
    // used for translations
    public static $l_cache;
    // retrocompatibility
    public $noTabLink = array();
    public $id = -1;

    public $ajax = false;

    public $standalone = true;

    /**
     * Initialized in initPath().
     */
    public $autoupgradePath;
    public $downloadPath;
    public $backupPath;
    public $latestPath;
    public $tmpPath;

    /**
     * autoupgradeDir.
     *
     * @var string directory relative to admin dir
     */
    public $autoupgradeDir = 'ets_upgrade';
    public $latestRootDir = '';
    public $prodRootDir = '';
    public $adminDir = '';

    public $keepImages;
    public $updateDefaultTheme;
    public $changeToDefaultTheme;
    public $keepMails;
    public $manualMode;
    public $deactivateCustomModule;

    public static $classes14 = array('Cache', 'CacheFS', 'CarrierModule', 'Db', 'FrontController', 'Helper', 'ImportModule',
        'MCached', 'Module', 'ModuleGraph', 'ModuleGraphEngine', 'ModuleGrid', 'ModuleGridEngine',
        'MySQL', 'Order', 'OrderDetail', 'OrderDiscount', 'OrderHistory', 'OrderMessage', 'OrderReturn',
        'OrderReturnState', 'OrderSlip', 'OrderState', 'PDF', 'RangePrice', 'RangeWeight', 'StockMvt',
        'StockMvtReason', 'SubDomain', 'Shop', 'Tax', 'TaxRule', 'TaxRulesGroup', 'WebserviceKey', 'WebserviceRequest', '',);

    public static $maxBackupFileSize = 15728640; // 15 Mo

    public $_fieldsUpgradeOptions = array();
    public $_fieldsBackupOptions = array();

    public static $channels = array();

    /**
     * @var UpgradeContainer
     */
    private $upgradeContainer;

    public function viewAccess($disable = false)
    {
        if ($this->ajax) {
            return true;
        } else {
            // simple access : we'll allow only 46admin
            if ($this->context->cookie->profile == _PS_ADMIN_PROFILE_) {
                return true;
            }
        }
        unset($disable);
        return false;
    }

    public function __construct()
    {
        parent::__construct();
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');
        @ini_set('magic_quotes_runtime', '0');
        @ini_set('magic_quotes_sybase', '0');

        $this->init();

        $this->db = Db::getInstance();
        $this->bootstrap = true;

        self::$currentIndex = $_SERVER['SCRIPT_NAME'] . (($controller = Tools14::getValue('controller')) ? '?controller=' . $controller : '');

        if (defined('_PS_ADMIN_DIR_')) {
            $file_tab = @filemtime($this->autoupgradePath . DIRECTORY_SEPARATOR . 'upgradetab.php');
            $file = @filemtime(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->autoupgradeDir . DIRECTORY_SEPARATOR . 'classes/Ext/upgradetab.php');

            if ($file_tab < $file) {
                @copy(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->autoupgradeDir . DIRECTORY_SEPARATOR . 'classes/Ext/upgradetab.php',
                    $this->autoupgradePath . DIRECTORY_SEPARATOR . 'upgradetab.php');
            }
        }

        if (!$this->ajax) {
            Context::getContext()->smarty->assign('display_header_javascript', true);
        }
    }

    /**
     * function to set configuration fields display.
     */
    private function _setFields()
    {
        if (!self::$channels) {
            $choices = array();
            if ($channels = $this->upgradeContainer->getUpgrader()->getChannels()) {
                foreach ($channels as $key => $channel) {
                    $choices[$key] = $this->trans('PrestaShop %s latest version - %s', array_values($channel), 'Modules.Etsupgrade.Admin');
                }
            }
            self::$channels = $choices;
        }

        $this->_fieldsBackupOptions = array(
            'PS_AUTOUP_BACKUP' => array(
                'title' => $this->trans('Back up my files and database', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool', 'defaultValue' => '1',
                'type' => 'bool', 'desc' => $this->trans('Automatically back up your database and files in order to restore your shop if needed. This is experimental: you should still perform your own manual backup for safety.', array(), 'Modules.Etsupgrade.Admin'),
            ),
            'PS_AUTOUP_KEEP_IMAGES' => array(
                'title' => $this->trans('Back up my images', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool', 'defaultValue' => '1',
                'type' => 'bool', 'desc' => $this->trans('To save time, you can decide not to back your images up. In any case, always make sure you did back them up manually.', array(), 'Modules.Etsupgrade.Admin'),
            ),
        );

        $this->_fieldsUpgradeOptions = array(
            'channel' => array(
                'title' => $this->trans('Select PrestaShop version to upgrade', array(), 'Modules.Etsupgrade.Admin'),
                'type' => 'radio',
                'validation' => 'isString',
                'defaultValue' => count($choices) > 1 ? 'major' : 'minor',
                'choices' => self::$channels,
            ),
            'PS_AUTOUP_PERFORMANCE' => array(
                'title' => $this->trans('Server performance', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isInt', 'defaultValue' => '1',
                'type' => 'select', 'desc' => $this->trans('Unless you are using a dedicated server, select "Medium" or "Low".', array(), 'Modules.Etsupgrade.Admin') . '<br />' .
                    $this->trans('A high value can cause the upgrade to fail if your server is not powerful enough to process the upgrade tasks in a short amount of time.', array(), 'Modules.Etsupgrade.Admin'),
                'choices' => array(1 => $this->trans('Low (recommended)', array(), 'Modules.Etsupgrade.Admin'), 2 => $this->trans('Medium', array(), 'Modules.Etsupgrade.Admin'), 3 => $this->trans('High', array(), 'Modules.Etsupgrade.Admin')),
            ),
            'PS_AUTOUP_CUSTOM_MOD_DESACT' => array(
                'title' => $this->trans('Disable non-native modules', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool',
                'type' => 'bool', 'desc' => $this->trans('As non-native modules can experience some compatibility issues, we recommend to disable them by default.', array(), 'Modules.Etsupgrade.Admin') . '<br />' .
                    $this->trans('Keeping them enabled might prevent you from loading the "Modules" page properly after the upgrade.', array(), 'Modules.Etsupgrade.Admin'),
            ),
            'PS_AUTOUP_UPDATE_DEFAULT_THEME' => array(
                'title' => $this->trans('Upgrade the default theme', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool', 'defaultValue' => '1',
                'type' => 'bool', 'desc' => $this->trans('If you customized the default PrestaShop theme in its folder (folder name "classic" in 1.7), enabling this option will lose your modifications.', array(), 'Modules.Etsupgrade.Admin') . '<br />'
                    . $this->trans('If you are using your own theme, enabling this option will simply update the default theme files, and your own theme will be safe.', array(), 'Modules.Etsupgrade.Admin'),
            ),
            'PS_AUTOUP_CHANGE_DEFAULT_THEME' => array(
                'title' => $this->trans('Switch to the default theme', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool', 'defaultValue' => '0',
                'type' => 'bool', 'desc' => $this->trans('This will change your theme: your shop will then use the default theme of the version of PrestaShop you are upgrading to.', array(), 'Modules.Etsupgrade.Admin'),
            ),
            'PS_AUTOUP_KEEP_MAILS' => array(
                'title' => $this->trans('Keep the customized email templates', array(), 'Modules.Etsupgrade.Admin'), 'cast' => 'intval', 'validation' => 'isBool',
                'type' => 'bool', 'desc' => $this->trans('This will not upgrade the default PrestaShop e-mails.', array(), 'Modules.Etsupgrade.Admin') . '<br />'
                    . $this->trans('If you customized the default PrestaShop e-mail templates, enabling this option will keep your modifications.', array(), 'Modules.Etsupgrade.Admin'),
            ),
        );
    }

    /**
     * init to build informations we need.
     */
    public function init()
    {
        parent::init();

        // For later use, let's set up prodRootDir and adminDir
        // This way it will be easier to upgrade a different path if needed
        $this->prodRootDir = _PS_ROOT_DIR_;
        $this->adminDir = realpath(_PS_ADMIN_DIR_);
        $this->upgradeContainer = new UpgradeContainer($this->prodRootDir, $this->adminDir);
        if (!defined('__PS_BASE_URI__')) {
            // _PS_DIRECTORY_ replaces __PS_BASE_URI__ in 1.5
            if (defined('_PS_DIRECTORY_')) {
                define('__PS_BASE_URI__', _PS_DIRECTORY_);
            } else {
                define('__PS_BASE_URI__', realpath(dirname($_SERVER['SCRIPT_NAME'])) . '/../../');
            }
        }
        // from $_POST or $_GET
        $this->action = empty($_REQUEST['action']) ? null : $_REQUEST['action'];
        $this->initPath();
        $this->upgradeContainer->getState()->importFromArray(
            empty($_REQUEST['params']) ? array() : $_REQUEST['params']
        );
        // If you have defined this somewhere, you know what you do
        // load options from configuration if we're not in ajax mode
        $upgrader = $this->upgradeContainer->getUpgrader();
        $this->upgradeContainer->getCookie()->create(
            $this->context->employee->id,
            $this->context->language->iso_code
        );

        $this->upgradeContainer->getState()->initDefault(
            $upgrader,
            $this->upgradeContainer->getProperty(UpgradeContainer::PS_ROOT_PATH),
            $this->upgradeContainer->getProperty(UpgradeContainer::PS_VERSION));

        if (Tools14::getIsset('refreshCurrentVersion')) {
            $upgradeConfiguration = $this->upgradeContainer->getUpgradeConfiguration();
            // delete the potential xml files we saved in config/xml (from last release and from current)
            $upgrader->clearXmlMd5File($this->upgradeContainer->getProperty(UpgradeContainer::PS_VERSION));
            $upgrader->clearXmlMd5File($upgrader->version_num);
            if ($upgradeConfiguration->get('channel') == 'private' && !$upgradeConfiguration->get('private_allow_major')) {
                $upgrader->checkPSVersion(true, array('private', 'minor'));
            } else {
                $upgrader->checkPSVersion(true, array('minor'));
            }
            $response = new AjaxResponse($this->upgradeContainer->getState(), $this->upgradeContainer->getLogger());
            die(
            $response
                ->setUpgradeConfiguration($this->upgradeContainer->getUpgradeConfiguration())
                ->getJson()
            );
        }
        // removing temporary files
        $this->upgradeContainer->getFileConfigurationStorage()->cleanAll();

        $this->keepImages = $this->upgradeContainer->getUpgradeConfiguration()->shouldBackupImages();
        $this->updateDefaultTheme = $this->upgradeContainer->getUpgradeConfiguration()->get('PS_AUTOUP_UPDATE_DEFAULT_THEME');
        $this->changeToDefaultTheme = $this->upgradeContainer->getUpgradeConfiguration()->get('PS_AUTOUP_CHANGE_DEFAULT_THEME');
        $this->keepMails = $this->upgradeContainer->getUpgradeConfiguration()->get('PS_AUTOUP_KEEP_MAILS');
        $this->deactivateCustomModule = $this->upgradeContainer->getUpgradeConfiguration()->get('PS_AUTOUP_CUSTOM_MOD_DESACT');

        if ($this->ajax && Tools14::isSubmit('uploadFileZip')) {
            $this->uploadFileZip();
        }
        if ($this->ajax && Tools14::isSubmit('testFileZip')) {
            $archive_filepath = $this->upgradeContainer->getProperty(UpgradeContainer::ARCHIVE_FILEPATH);
            $download_path = $this->upgradeContainer->getProperty(UpgradeContainer::DOWNLOAD_PATH);

            if (!@file_exists($archive_filepath) && !($archive_files = @glob($download_path . DIRECTORY_SEPARATOR . '*.zip'))) {
                $this->errors[] = $this->trans('The uploaded file is not PrestaShop zip file, please upload the correct file', array(), 'Modules.Etsupgrade.Admin');
            } elseif (isset($archive_files) && $archive_files) {
                foreach ($archive_files as $archive_file) {
                    if (@filesize($archive_file) > 0 && @rename($archive_file, $archive_filepath) && $this->zipTest($archive_filepath)) {
                        $this->errors = array();
                        break;
                    }
                }
            }
            die(Tools14::jsonEncode(array(
                'errors' => count($this->errors) ? $this->errors : false,
            )));
        }
    }

    const DEFAULT_MAX_SIZE = 104857600;

    public function uploadFileZip()
    {
        //Upload file
        $upload_err_ok = 0;
        $key = 'upload_file_zip';
        $archive_filepath = $this->upgradeContainer->getProperty(UpgradeContainer::ARCHIVE_FILEPATH);
        $download_path = $this->upgradeContainer->getProperty(UpgradeContainer::DOWNLOAD_PATH);

        if (@is_dir($download_path))
            mkdir($download_path, 0755, true);
        elseif (@file_exists($archive_filepath))
            @unlink($archive_filepath);

        // Check file.
        if (!@is_writable($download_path)) {
            $this->errors[] = $this->trans('The directory "%s" is not writable.', array(), 'Modules.Etsupgrade.Admin');
        } elseif ($uploadError = $this->checkUploadError($_FILES[$key]['error'])) {
            $this->errors[] = $uploadError;
        } elseif (isset($_FILES[$key]['name']) && preg_match('/\%00/', $_FILES[$key]['name'])) {
            $this->errors[] = $this->trans('Invalid file name', array(), 'Modules.Etsupgrade.Admin');
        } elseif (($postMaxSize = $this->getPostMaxSizeBytes()) && ($this->getServerVars('CONTENT_LENGTH') > $postMaxSize)) {
            $this->errors[] = $this->trans('The uploaded file exceeds the post_max_size directive in php.ini', array(), 'Modules.Etsupgrade.Admin');
        } elseif ($_FILES[$key]['size'] > self::DEFAULT_MAX_SIZE) {
            $this->errors[] = $this->trans('File is too big. Current size is %1s, maximum size is %2s.', array($_FILES[$key]['size'], self::DEFAULT_MAX_SIZE), 'Modules.Etsupgrade.Admin');
        }
        if (count($this->errors))
            $upload_err_ok = 1;
        // Upload file.
        if (!$upload_err_ok && isset($_FILES[$key]) && isset($_FILES[$key]['tmp_name']) && isset($_FILES[$key]['name']) && $_FILES[$key]['name']) {
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));

            if (!in_array($type, array('zip'))) {
                $this->errors[] = $this->trans('File type not allowed', array(), 'Modules.Etsupgrade.Admin');
            } elseif (@is_uploaded_file($_FILES[$key]['tmp_name']) && !@move_uploaded_file($_FILES[$key]['tmp_name'], $archive_filepath)) {
                $this->errors[] = $this->trans('Cannot upload file', array(), 'Modules.Etsupgrade.Admin');
                $upload_err_ok = 1;
            }
        }
        if (!count($this->errors))
            $this->zipTest($archive_filepath);

        die(Tools14::jsonEncode(array(
            'errors' => count($this->errors) ? $this->errors : false,
            'upload_err_ok' => $upload_err_ok
        )));
    }

    public function zipTest($archive_filepath)
    {
        if (!count($this->errors) && !Tools::ZipTest($archive_filepath))
            $this->errors[] = $this->trans('Zip file seems to be broken', array(), 'Modules.Etsupgrade.Admin');
        else {
            $zip = new ZipArchive();
            if ($zip->open($archive_filepath) === true) {

                $newVersion = $this->upgradeContainer->getState()->getInstallVersion();
                $is17 = version_compare($newVersion, '1.7.0.0', '>=') ? 1 : 0;
                $upload_err_ok = 0;

                if ($zip->locateName('Install_PrestaShop.html') === false || ($is17 && $zip->locateName('index.php') === false)) {
                    $upload_err_ok = 1;
                } elseif ($is17 && ($fromString = $zip->getFromName('index.php'))) {
                    preg_match('/define\(\s*\'_PS_VERSION_\'\s*,\s*\'([1-9]\.[0-9]\.[0-9]{1,2}\.[0-9]{1,2})\'\s*\)\s*\;/ms', $fromString, $matches);
                    if (empty($matches[1]) || !version_compare($matches[1], $newVersion, '='))
                        $upload_err_ok = 1;
                }
                if ($upload_err_ok) {
                    $this->errors[] = $this->trans('The uploaded file is not PrestaShop zip file, please upload the correct file', array(), 'Modules.Etsupgrade.Admin');
                    if ($archive_filepath && $zip->close())
                        @unlink($archive_filepath);
                }
            } else
                $this->errors[] = $this->trans('Cannot open zip file. It might be broken or damaged', array(), 'Modules.Etsupgrade.Admin');
        }
    }

    protected function getServerVars($var)
    {
        return isset($_SERVER[$var]) ? $_SERVER[$var] : '';
    }

    public function getPostMaxSizeBytes()
    {
        $postMaxSize = @ini_get('post_max_size');
        $bytes = (int)trim($postMaxSize);
        $last = Tools::strtolower($postMaxSize[Tools::strlen($postMaxSize) - 1]);

        switch ($last) {
            case 'g':
                $bytes *= 1024;
            // no break
            case 'm':
                $bytes *= 1024;
            // no break
            case 'k':
                $bytes *= 1024;
        }

        if ($bytes == '') {
            $bytes = null;
        }

        return $bytes;
    }

    protected function checkUploadError($error_code)
    {
        $error = 0;
        switch ($error_code) {
            case 1:
                $error = $this->trans('The uploaded file exceeds %s', array(ini_get('upload_max_filesize')), 'Modules.Etsupgrade.Admin');
                break;
            case 2:
                $error = $this->trans('The uploaded file exceeds %s', array(ini_get('post_max_size')), 'Modules.Etsupgrade.Admin');
                break;
            case 3:
                $error = $this->trans('The uploaded file was only partially uploaded', array(), 'Modules.Etsupgrade.Admin');
                break;
            case 4:
                $error = $this->trans('No file was uploaded', array(), 'Modules.Etsupgrade.Admin');
                break;
            case 6:
                $error = $this->trans('Missing temporary folder', array(), 'Modules.Etsupgrade.Admin');
                break;
            case 7:
                $error = $this->trans('Failed to write file to disk', array(), 'Modules.Etsupgrade.Admin');
                break;
            case 8:
                $error = $this->trans('A PHP extension stopped the file upload', array(), 'Modules.Etsupgrade.Admin');
                break;
            default:
                break;
        }
        return $error;
    }

    /**
     * create some required directories if they does not exists.
     */
    public function initPath()
    {
        $this->upgradeContainer->getWorkspace()->createFolders();

        // set autoupgradePath, to be used in backupFiles and backupDb config values
        $this->autoupgradePath = $this->adminDir . DIRECTORY_SEPARATOR . $this->autoupgradeDir;
        $this->backupPath = $this->autoupgradePath . DIRECTORY_SEPARATOR . 'backup';
        $this->downloadPath = $this->autoupgradePath . DIRECTORY_SEPARATOR . 'download';
        $this->latestPath = $this->autoupgradePath . DIRECTORY_SEPARATOR . 'latest';
        $this->tmpPath = $this->autoupgradePath . DIRECTORY_SEPARATOR . 'tmp';
        $this->latestRootDir = $this->latestPath . DIRECTORY_SEPARATOR;

        if (!file_exists($this->backupPath . DIRECTORY_SEPARATOR . 'index.php')) {
            if (!copy(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'index.php', $this->backupPath . DIRECTORY_SEPARATOR . 'index.php')) {
                $this->errors[] = $this->trans('Unable to create file %s', array($this->backupPath . DIRECTORY_SEPARATOR . 'index.php'), 'Modules.Etsupgrade.Admin');
            }
        }

        $tmp = "order deny,allow\ndeny from all";
        if (!file_exists($this->backupPath . DIRECTORY_SEPARATOR . '.htaccess')) {
            if (!file_put_contents($this->backupPath . DIRECTORY_SEPARATOR . '.htaccess', $tmp)) {
                $this->errors[] = $this->trans('Unable to create file %s', array($this->backupPath . DIRECTORY_SEPARATOR . '.htaccess'), 'Modules.Etsupgrade.Admin');
            }
        }
    }

    public function postProcess()
    {
        $this->_setFields();

        /*---Configs Environment---*/
        if (Tools14::isSubmit('putUnderMaintenance')) {
            foreach (Shop::getCompleteListOfShopsID() as $id_shop) {
                Configuration::updateValue('PS_SHOP_ENABLE', 0, false, null, (int)$id_shop);
            }
            Configuration::updateGlobalValue('PS_SHOP_ENABLE', 0);
        }

        if (Tools14::isSubmit('ignorePsRequirements')) {
            Configuration::updateValue('PS_AUTOUP_IGNORE_REQS', 1);
            die(Tools14::jsonEncode(array(
                'msg' => $this->trans('Saved', array(), 'Modules.Etsupgrade.Admin'),
            )));
        }

        if (Tools14::isSubmit('ignorePhpOutdated')) {
            Configuration::updateValue('PS_AUTOUP_IGNORE_PHP_UPGRADE', 1);
            die(Tools14::jsonEncode(array(
                'msg' => $this->trans('Saved', array(), 'Modules.Etsupgrade.Admin'),
            )));
        }
        /*---End Configs Environment---*/

        /*---Save Configs---*/
        if (Tools14::isSubmit('customSubmitAutoUpgrade')) {
            $config_keys = array_keys(array_merge($this->_fieldsUpgradeOptions, $this->_fieldsBackupOptions));
            $config = array();
            foreach ($config_keys as $key) {
                if (Tools14::getIsset($key)) {
                    $config[$key] = Tools14::getValue($key);
                }
            }
            $UpConfig = $this->upgradeContainer->getUpgradeConfiguration();
            $UpConfig->merge($config);

            if (!$this->upgradeContainer->getUpgradeConfigurationStorage()->save($UpConfig, UpgradeFileNames::CONFIG_FILENAME)) {
                $this->errors[] = $this->trans('Failed to save configuration!', array(), 'Modules.Etsupgrade.Admin');
            }
            $channels = $this->upgradeContainer->getUpgrader()->getChannels();
            die(Tools14::jsonEncode(array(
                'errors' => ($hasError = count($this->errors) > 0) ? Tools::nl2br(implode(PHP_EOL, $this->errors)) : false,
                'msg' => $hasError ? $this->trans('Configuration successfully.', array(), 'Modules.Etsupgrade.Admin') : '',
                'displayWarning' => PHP_VERSION_ID < 70103 && isset($config['channel']) && isset($channels[$config['channel']]) && isset($channels[$config['channel']]['branch_num']) && version_compare($channels[$config['channel']]['branch_num'], '1.7.7.0', '>=') ? 1 : 0,
            )));
        }
        /*---End Save Configs*/

        /*---Delete Backup---*/
        if (Tools14::isSubmit('deletebackup')) {
            $res = false;
            $name = Tools14::getValue('name');
            $filelist = scandir($this->backupPath);
            foreach ($filelist as $filename) {
                // the following will match file or dir related to the selected backup
                if (!empty($filename) && $filename[0] != '.' && $filename != 'index.php' && $filename != '.htaccess'
                    && preg_match('#^(auto-backupfiles_|)' . preg_quote($name) . '(\.zip|)$#', $filename, $matches)) {
                    if (is_file($this->backupPath . DIRECTORY_SEPARATOR . $filename)) {
                        $res &= unlink($this->backupPath . DIRECTORY_SEPARATOR . $filename);
                    } elseif (!empty($name) && is_dir($this->backupPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR)) {
                        $res = FilesystemAdapter::deleteDirectory($this->backupPath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR);
                    }
                }
            }
            if ($res) {
                Tools14::redirectAdmin(self::$currentIndex . '&conf=1&token=' . Tools14::getValue('token'));
            } else {
                $this->errors[] = $this->trans('Error when trying to delete backups %s', array($name), 'Modules.Etsupgrade.Admin');
            }
        }
        /*---End Delete Backup*/

        parent::postProcess();
    }

    public function display()
    {
        // Make sure the user has configured the upgrade options, or set default values
        $configuration_keys = array(
            'PS_AUTOUP_UPDATE_DEFAULT_THEME' => 1,
            'PS_AUTOUP_CHANGE_DEFAULT_THEME' => 0,
            'PS_AUTOUP_KEEP_MAILS' => 0,
            'PS_AUTOUP_CUSTOM_MOD_DESACT' => 1,
            'PS_AUTOUP_PERFORMANCE' => 2,
        );

        foreach ($configuration_keys as $k => $default_value) {
            if (Configuration::get($k) == '') {
                Configuration::updateValue($k, $default_value);
            }
        }

        // update backup name
        $backupFinder = new BackupFinder($this->backupPath);
        $availableBackups = $backupFinder->getAvailableBackups();
        if (!$this->upgradeContainer->getUpgradeConfiguration()->get('PS_AUTOUP_BACKUP')
            && !empty($availableBackups)
            && !in_array($this->upgradeContainer->getState()->getBackupName(), $availableBackups)
        ) {
            $this->upgradeContainer->getState()->setBackupName(end($availableBackups));
        }

        $upgrader = $this->upgradeContainer->getUpgrader();
        $upgradeSelfCheck = new UpgradeSelfCheck(
            $upgrader,
            $this->prodRootDir,
            $this->adminDir,
            $this->autoupgradePath
        );
        if (Tools14::getValue('refreshChecklist')) {
            $isOkForUpgrade = $upgradeSelfCheck->isOkForUpgrade() && $upgradeSelfCheck->isIgnoreUpgrade();
            die(Tools14::jsonEncode(array(
                'isOkForUpgrade' => $isOkForUpgrade,
                'msg' => !$isOkForUpgrade ? $this->trans('Please make sure this checklist is all green', array(), 'Modules.Etsupgrade.Admin') : '',
            )));
        }
        $response = new AjaxResponse($this->upgradeContainer->getState(), $this->upgradeContainer->getLogger());
        $this->_html = (new UpgradePage(
            $this->upgradeContainer->getUpgradeConfiguration(),
            $this->upgradeContainer->getTwig(),
            $this->upgradeContainer->getTranslator(),
            $upgradeSelfCheck,
            $upgrader,
            $backupFinder,
            $this->autoupgradePath,
            $this->prodRootDir,
            $this->adminDir,
            self::$currentIndex,
            $this->token,
            $this->upgradeContainer->getState()->getInstallVersion(),
            $this->manualMode,
            $this->upgradeContainer->getState()->getBackupName(),
            $this->downloadPath,
            $this->upgradeContainer
        ))->display(
            $response
                ->setUpgradeConfiguration($this->upgradeContainer->getUpgradeConfiguration())
                ->getJson()
        );

        $this->ajax = true;
        $this->content = $this->_html;

        return parent::display();
    }

    /**
     * @deprecated
     * Method allowing errors on very old tabs to be displayed.
     * On the next major of this module, use an admin controller and get rid of this.
     *
     * This method is called by functions.php available in the admin root folder.
     */
    public function displayErrors()
    {
        if (empty($this->errors)) {
            return;
        }
        echo implode(' - ', $this->errors);
    }

    /**
     * Adapter for trans calls, existing only on PS 1.7.
     * Making them available for PS 1.6 as well.
     *
     * @param string $id
     * @param array $parameters
     * @param string $domain
     * @param string $locale
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return (new \PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator(__CLASS__))->trans($id, $parameters, $domain, $locale);
    }
}
