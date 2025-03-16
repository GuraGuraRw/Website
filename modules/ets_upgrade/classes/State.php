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

/**
 * Class storing the temporary data to keep between 2 ajax requests.
 */
class State
{
    /**
     * @var string
     */
    private $database_server_version;
    /**
     * @var string Destination version of PrestaShop
     */
    private $install_version;
    /**
     * @var string Old version of PrestaShop
     */
    private $old_version;

    private $forceFromFile;
    private $forceStep;

    private $backupName;
    private $backupFilesFilename;
    private $backupDbFilename;

    private $restoreName;
    private $restoreFilesFilename;
    private $restoreDbFilenames = array();

    // STEP BackupDb
    private $backup_lines;
    private $backup_loop_limit;
    private $backup_table;

    /**
     * Int during BackupDb, allowing the script to increent the number of different file names
     * String during step RestoreDb, which contains the file to process (Data coming from toRestoreQueryList).
     *
     * @var string|int Contains the SQL progress
     */
    private $dbStep = 0;
    /**
     * Data filled in upgrade warmup, to avoid risky tasks during the process.
     *
     * @var array|null File containing sample files to be deleted
     */
    private $removeList;
    /**
     * @var string|null File containing files to be upgraded
     */
    private $fileToUpgrade;
    /**
     * @var string|null File containing modules to be upgraded
     */
    private $modulesToUpgrade;
    /**
     * installedLanguagesIso is an array of iso_code of each installed languages.
     *
     * @var array
     */
    private $installedLanguagesIso = array();
    /**
     * modules_addons is an array of array(id_addons => name_module).
     *
     * @var array
     */
    private $modules_addons = array();

    /**
     * @var bool Determining if all steps went totally successfully
     */
    private $warning_exists = false;

    /**
     * @var int Estimate time.
     */
    private $totalTimePart = 100;
    /**
     * @var int.
     */
    private $totalTimePartDone = 0;
    /**
     * @var array container all state each step
     */
    private $estimateTime = array(
        'upgradeNow' => array(
            'part' => 1,
            'stepDone' => 0,
        ),
        'download' => array(
            'part' => 15,
            'stepDone' => 0,
        ),
        'unzip' => array(
            'part' => 15,
            'stepDone' => 0,
        ),
        'removeSamples' => array(
            'part' => 0,
            'stepDone' => 0,
        ),
        'backupFiles' => array(
            'part' => 35,
            'stepDone' => 0,
        ),
        'backupDb' => array(
            'part' => 35,
            'stepDone' => 0,
        ),
        'upgradeFiles' => array(
            'part' => 30,
            'stepDone' => 0,
        ),
        'cleanCached' => array(
            'part' => 5,
            'stepDone' => 0,
        ),
        'upgradeDb' => array(
            'part' => 24,
            'stepDone' => 0,
        ),
        'upgradeModules' => array(
            'part' => 30,
            'stepDone' => 0,
        ),
        'cleanDatabase' => array(
            'part' => 0,
            'stepDone' => 0,
        ),
        'enableModules' => array(
            'part' => 12,
            'stepDone' => 0,
        ),
        'installModules' => array(
            'part' => 9,
            'stepDone' => 0,
        ),
        'removeOverride' => array(
            'part' => 5,
            'stepDone' => 0,
        ),
        'renameModules' => array(
            'part' => 0,
            'stepDone' => 0,
        ),
        'upgradeComplete' => array(
            'part' => 1,
            'stepDone' => 0,
        ),
    );
    /**
     * @var int.
     */
    private $initTime = 10;
    /**
     * @var int.
     */
    private $startTime = 0;
    /**
     * @var int
     */
    private $unitPart = 1000;
    /**
     * @var float speed.
     */
    private $ratio = 0.05;
    /**
     * @var int version php
     */
    private $unitTime;

    /**
     * @var bool if prestashop version >= 1.7
     */
    private $prestashop17;

    /**
     * @var bool if true system re-download file prestashop.zip
     */
    private $isReDownloadFileZip = 0;
    /**
     * @var int version php
     */
    private $php_version_id;
    /**
     * @var int request timeout
     */
    private $timeout = 0;

    public function __construct()
    {
        if ($version = explode('.', phpversion())) {
            $this->php_version_id = ((int)$version[0] * 10000 + (int)$version[1] * 100 + (int)$version[2]);
        }
    }

    /**
     * @return mixed
     */
    public function getDatabaseServerVersion()
    {
        return $this->database_server_version;
    }

    /**
     * @param string $database_server_version
     */
    public function setDatabaseServerVersion($database_server_version)
    {
        $this->database_server_version = $database_server_version;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return State
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhpVersionId()
    {
        if (!$this->php_version_id) {
            if ($version = explode('.', phpversion())) {
                $this->php_version_id = ((int)$version[0] * 10000 + (int)$version[1] * 100 + (int)$version[2]);
            }
        }

        return $this->php_version_id;
    }

    /**
     * @param array $savedState from another request
     * @return State
     */
    public function importFromArray(array $savedState)
    {
        foreach ($savedState as $name => $value) {
            if (!empty($value) && property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }

        return $this;
    }

    /**
     * @param string $encodedData
     * @return State
     */
    public function importFromEncodedData($encodedData)
    {
        $decodedData = json_decode(call_user_func('base64_decode', $encodedData), true);
        if (empty($decodedData['nextParams'])) {
            return $this;
        }

        return $this->importFromArray($decodedData['nextParams']);
    }

    /**
     * @return array of class properties for export
     */
    public function export()
    {
        return get_object_vars($this);
    }

    /**
     * @param Upgrader $upgrader
     * @param $prodRootDir
     * @param $version
     */
    public function initDefault(Upgrader $upgrader, $prodRootDir, $version)
    {
        $postData = http_build_query(array(
            'action' => 'native',
            'iso_code' => 'all',
            'method' => 'listing',
            'version' => $this->getInstallVersion(),
        ));
        $xml_local = $prodRootDir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'modules_native_addons.xml';
        $xml = $upgrader->getApiAddons($xml_local, $postData, true);

        $modules_addons = array();
        if (is_object($xml)) {
            foreach ($xml as $mod) {
                $modules_addons[(string)$mod->id] = (string)$mod->name;
            }
        }
        $this->setModulesAddons($modules_addons);

        // installedLanguagesIso is used to merge translations files
        $installedLanguagesIso = array_map(
            function ($v) {
                return $v['iso_code'];
            },
            \Language::getIsoIds(false)
        );
        $this->setInstalledLanguagesIso($installedLanguagesIso);

        $rand = dechex(mt_rand(0, min(0xffffffff, mt_getrandmax())));
        $date = date('Ymd-His');
        $backupName = 'V' . $version . '_' . $date . '-' . $rand;
        // Todo: To be moved in state class? We could only require the backup name here
        // I.e = $this->upgradeContainer->getState()->setBackupName($backupName);, which triggers 2 other setters internally
        $this->setBackupName($backupName);
    }

    public function getIsReDownloadFileZip()
    {
        return (int)$this->isReDownloadFileZip;
    }

    public function setIsReDownloadFileZip($isReDownloadFileZip)
    {
        $this->isReDownloadFileZip = (int)$isReDownloadFileZip;
    }

    private $isReDownloadAutoUpgrade = 0;

    public function isReDownloadAutoUpgrade()
    {
        return (int)$this->isReDownloadAutoUpgrade;
    }

    public function setIsReDownloadAutoUpgrade($isReDownloadAutoUpgrade)
    {
        $this->isReDownloadAutoUpgrade = (int)$isReDownloadAutoUpgrade;
    }

    private $isUnzipAutoUpgrade = 0;

    /**
     * @return bool
     */
    public function isUnzipAutoUpgrade()
    {
        return (int)$this->isUnzipAutoUpgrade;
    }

    /**
     * @param bool $isUnzipAutoUpgrade
     */
    public function setIsUnzipAutoUpgrade($isUnzipAutoUpgrade)
    {
        $this->isUnzipAutoUpgrade = (int)$isUnzipAutoUpgrade;
    }

    private $initialized = 0;

    /**
     * @return int
     */
    public function getInitialized()
    {
        return (int)$this->initialized;
    }

    /**
     * @param int $initialized
     */
    public function setInitialized($initialized)
    {
        $this->initialized = (int)$initialized;
    }

    public function getForceStep()
    {
        return (int)$this->forceStep;
    }

    public function setForceStep($forceStep)
    {
        $this->forceStep = (int)$forceStep;
    }

    public function getInstallVersion()
    {
        return $this->install_version;
    }

    public function getOldVersion()
    {
        return $this->old_version;
    }

    public function getForceFromFile()
    {
        return $this->forceFromFile;
    }

    public function setForceFromFile($forceFromFile)
    {
        $this->forceFromFile = $forceFromFile;
    }

    public function getBackupName()
    {
        return $this->backupName;
    }

    public function getBackupFilesFilename()
    {
        return $this->backupFilesFilename;
    }

    public function getBackupDbFilename()
    {
        return $this->backupDbFilename;
    }

    public function getBackupLines()
    {
        return $this->backup_lines;
    }

    public function getBackupLoopLimit()
    {
        return $this->backup_loop_limit;
    }

    public function getBackupTable()
    {
        return $this->backup_table;
    }

    public function getDbStep()
    {
        return $this->dbStep;
    }

    public function getRemoveList()
    {
        return $this->removeList;
    }

    public function getRestoreName()
    {
        return $this->restoreName;
    }

    public function getRestoreFilesFilename()
    {
        return $this->restoreFilesFilename;
    }

    public function getRestoreDbFilenames()
    {
        return $this->restoreDbFilenames;
    }

    public function getInstalledLanguagesIso()
    {
        return $this->installedLanguagesIso;
    }

    public function getModules_addons()
    {
        return $this->modules_addons;
    }

    public function getWarningExists()
    {
        return $this->warning_exists;
    }

    public function setInstallVersion($install_version)
    {
        $this->install_version = $install_version;

        return $this;
    }

    public function setOldVersion($old_version)
    {
        $this->old_version = $old_version;

        return $this;
    }

    public function setBackupName($backupName)
    {
        $this->backupName = $backupName;
        $this->setBackupFilesFilename('auto-backupfiles_' . $backupName . '.zip')
            ->setBackupDbFilename('auto-backupdb_XXXXXX_' . $backupName . '.sql');

        return $this;
    }

    public function setBackupFilesFilename($backupFilesFilename)
    {
        $this->backupFilesFilename = $backupFilesFilename;

        return $this;
    }

    public function setBackupDbFilename($backupDbFilename)
    {
        $this->backupDbFilename = $backupDbFilename;

        return $this;
    }

    public function setBackupLines($backup_lines)
    {
        $this->backup_lines = $backup_lines;

        return $this;
    }

    public function setBackupLoopLimit($backup_loop_limit)
    {
        $this->backup_loop_limit = $backup_loop_limit;

        return $this;
    }

    public function setBackupTable($backup_table)
    {
        $this->backup_table = $backup_table;

        return $this;
    }

    public function setDbStep($dbStep)
    {
        $this->dbStep = $dbStep;

        return $this;
    }

    public function setRemoveList($removeList)
    {
        $this->removeList = $removeList;

        return $this;
    }

    public function setRestoreName($restoreName)
    {
        $this->restoreName = $restoreName;

        return $this;
    }

    public function setRestoreFilesFilename($restoreFilesFilename)
    {
        $this->restoreFilesFilename = $restoreFilesFilename;

        return $this;
    }

    public function setRestoreDbFilenames($restoreDbFilenames)
    {
        $this->restoreDbFilenames = $restoreDbFilenames;

        return $this;
    }

    public function setInstalledLanguagesIso($installedLanguagesIso)
    {
        $this->installedLanguagesIso = $installedLanguagesIso;

        return $this;
    }

    public function setModulesAddons($modules_addons)
    {
        $this->modules_addons = $modules_addons;

        return $this;
    }

    public function setWarningExists($warning_exists)
    {
        $this->warning_exists = $warning_exists;

        return $this;
    }

    public function getTotalTimePart()
    {
        if (is_array($this->estimateTime)) {
            $this->totalTimePart = 0;
            foreach ($this->estimateTime as $step => $value) {
                if (!(int)$value['stepDone'])
                    $this->totalTimePart += (int)$value['part'];
            }
            unset($step);
        }

        return $this->totalTimePart;
    }

    public function getTotalTimePartDone()
    {
        if (is_array($this->estimateTime)) {
            $this->totalTimePartDone = 0;
            foreach ($this->estimateTime as $step => $value) {
                if ((int)$value['stepDone'])
                    $this->totalTimePartDone += (int)$value['part'];
            }
            unset($step);
        }

        return $this->totalTimePartDone;
    }

    public function getEstimateTime()
    {
        return $this->estimateTime;
    }

    public function getEstimateTimeByStep($step)
    {
        return isset($this->estimateTime[$step]) ? $this->estimateTime[$step] : false;
    }

    public function isStepDone($step)
    {
        return isset($this->estimateTime[$step]) && (int)$this->estimateTime[$step]['stepDone'] > 0;
    }

    public function setEstimateTime(array $estimateTime)
    {
        if ($estimateTime) {
            foreach ($estimateTime as $step => $part) {
                $this->estimateTime[$step] = $part;
            }
        }
    }

    public function setStepDone($next)
    {
        if ($next) {
            $this->estimateTime[$next]['stepDone'] = 1;
        }
    }

    public function getInitTime()
    {
        return $this->initTime;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function isPrestashop17()//ver17()
    {
        $this->prestashop17 = version_compare($this->install_version, '1.7.0.0', '>=');

        return $this->prestashop17;
    }

    public function getUnitPart()
    {
        return $this->unitPart;
    }

    public function setUnitPart($unitPart)
    {
        $this->unitPart = $unitPart;
    }

    public function getRatio()
    {
        return $this->ratio;
    }

    public function setRatio($ratio)
    {
        $this->ratio = $ratio;
    }

    public function getUnitTime()
    {
        return $this->unitTime;
    }

    public function setUnitTime($unitTime)
    {
        $this->unitTime = $unitTime;
    }
}
