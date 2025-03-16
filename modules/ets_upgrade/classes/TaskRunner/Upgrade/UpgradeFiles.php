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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;
use PrestaShop\PrestaShop\Adapter\Entity\Language;

class UpgradeFiles extends AbstractTask
{
    private $destUpgradePath;

    public function run()
    {
        // The first call must init the list of files be upgraded
        if (!$this->container->getFileConfigurationStorage()->exists(UpgradeFileNames::FILES_TO_UPGRADE_LIST)) {
            return $this->warmUp();
        }

        // later we could choose between _PS_ROOT_DIR_ or _PS_TEST_DIR_
        $this->destUpgradePath = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH);

        $this->next = 'upgradeFiles';
        $filesToUpgrade = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_TO_UPGRADE_LIST);
        if (!is_array($filesToUpgrade)) {
            $this->next = 'error';
            $this->logger->error($this->translator->trans('filesToUpgrade is not an array', array(), 'Modules.Etsupgrade.Admin'));

            return false;
        }

        // @TODO : does not upgrade files in modules, translations if they have not a correct md5 (or crc32, or whatever) from previous version
        for ($i = 0; $i < $this->container->getUpgradeConfiguration()->getNumberOfFilesPerCall(); ++$i) {
            if (count($filesToUpgrade) <= 0) {
                $this->next = 'cleanCached';
                if (file_exists(UpgradeFileNames::FILES_TO_UPGRADE_LIST)) {
                    unlink(UpgradeFileNames::FILES_TO_UPGRADE_LIST);
                }
                $this->logger->info($this->translator->trans('All files upgraded. Now upgrading database...', array(), 'Modules.Etsupgrade.Admin'));
                $this->stepDone = true;
                $this->container->getState()->setStepDone('upgradeFiles');
                $this->_replaceFiles();
                $this->_legacyFiles();
                break;
            }

            $file = array_shift($filesToUpgrade);
            if (!$this->upgradeThisFile($file)) {
                // put the file back to the begin of the list
                $this->next = 'error';
                $this->logger->error($this->translator->trans('Error when trying to upgrade file %s.', array($file), 'Modules.Etsupgrade.Admin'));
                break;
            }
        }
        $this->container->getFileConfigurationStorage()->save($filesToUpgrade, UpgradeFileNames::FILES_TO_UPGRADE_LIST);
        if (count($filesToUpgrade) > 0) {
            $this->logger->info($this->translator->trans('%s files left to upgrade.', array(count($filesToUpgrade)), 'Modules.Etsupgrade.Admin'));
            $this->stepDone = false;
        }

        return true;
    }

    /**
     * list files to upgrade and return it as array
     * TODO: This method needs probably to be moved in FilesystemAdapter.
     *
     * @param string $dir
     *
     * @return array|false Number of files found, or false if param is not a folder
     */
    protected function listFilesToUpgrade($dir)
    {
        $list = array();
        if (!is_dir($dir)) {
            $this->logger->error($this->translator->trans('[ERROR] %s does not exist or is not a directory.', array($dir), 'Modules.Etsupgrade.Admin'));
            $this->logger->info($this->translator->trans('Nothing has been extracted. It seems the unzipping step has been skipped.', array(), 'Modules.Etsupgrade.Admin'));
            $this->next = 'error';

            return false;
        }

        $allFiles = scandir($dir);
        foreach ($allFiles as $file) {
            $fullPath = $dir . DIRECTORY_SEPARATOR . $file;

            if ($this->container->getFilesystemAdapter()->isFileSkipped(
                $file,
                $fullPath,
                'upgrade',
                $this->container->getProperty(UpgradeContainer::LATEST_PATH)
            )) {
                if (!in_array($file, array('.', '..'))) {
                    $this->logger->debug($this->translator->trans('File %s is preserved', array($file), 'Modules.Etsupgrade.Admin'));
                }
                continue;
            }
            $list[] = str_replace($this->container->getProperty(UpgradeContainer::LATEST_PATH), '', $fullPath);
            if (is_dir($fullPath) && strpos($dir . DIRECTORY_SEPARATOR . $file, 'install') === false) {
                $list = array_merge($list, $this->listFilesToUpgrade($fullPath));
            }
        }

        return $list;
    }

    /**
     * upgradeThisFile.
     *
     * @param mixed $file
     * @return bool
     */
    public function upgradeThisFile($file)
    {
        // translations_custom and mails_custom list are currently not used
        // later, we could handle customization with some kind of diff functions
        // for now, just copy $file in str_replace($this->latestRootDir,_PS_ROOT_DIR_)
        $orig = $this->container->getProperty(UpgradeContainer::LATEST_PATH) . $file;
        $dest = $this->destUpgradePath . $file;

        if (preg_match('/^\/?install\//', $file) || $this->container->getFilesystemAdapter()->isFileSkipped($file, $dest, 'upgrade')) {
            $this->logger->debug($this->translator->trans('%s ignored', array($file), 'Modules.Etsupgrade.Admin'));

            return true;
        }
        if (is_dir($orig)) {
            // if $dest is not a directory (that can happen), just remove that file
            if (!is_dir($dest) && file_exists($dest)) {
                unlink($dest);
                $this->logger->debug($this->translator->trans('[WARNING] File %1$s has been deleted.', array($file), 'Modules.Etsupgrade.Admin'));
            }
            if (!file_exists($dest)) {
                if (mkdir($dest)) {
                    $this->logger->debug($this->translator->trans('Directory %1$s created.', array($file), 'Modules.Etsupgrade.Admin'));

                    return true;
                } else {
                    $this->next = 'error';
                    $this->logger->error($this->translator->trans('Error while creating directory %s.', array($dest), 'Modules.Etsupgrade.Admin'));

                    return false;
                }
            } else { // directory already exists
                $this->logger->debug($this->translator->trans('Directory %s already exists.', array($file), 'Modules.Etsupgrade.Admin'));

                return true;
            }
        } elseif (is_file($orig)) {
            $translationAdapter = $this->container->getTranslationAdapter();
            if ($translationAdapter->isTranslationFile($file) && file_exists($dest)) {
                $type_trad = $translationAdapter->getTranslationFileType($file);
                if ($translationAdapter->mergeTranslationFile($orig, $dest, $type_trad)) {
                    $this->logger->info($this->translator->trans('[TRANSLATION] The translation files have been merged into file %s.', array($dest), 'Modules.Etsupgrade.Admin'));

                    return true;
                }
                $this->logger->warning($this->translator->trans(
                    '[TRANSLATION] The translation files have not been merged into file %filename%. Switch to copy %filename%.',
                    array('%filename%' => $dest),
                    'Modules.Etsupgrade.Admin'
                ));
            }
            if (!is_dir(dirname($dest))) {
                mkdir(dirname($dest), 0755, true);
            }
            // upgrade exception were above. This part now process all files that have to be upgraded (means to modify or to remove)
            // delete before updating (and this will also remove deprecated files)
            if (copy($orig, $dest)) {
                $this->logger->debug($this->translator->trans('Copied %1$s.', array($file), 'Modules.Etsupgrade.Admin'));

                return true;
            } elseif (is_dir(dirname($dest))) {
                $this->next = 'error';
                $this->logger->error($this->translator->trans('Error while copying file %s', array($file), 'Modules.Etsupgrade.Admin'));

                return false;
            }
        } elseif (is_file($dest)) {
            if (file_exists($dest)) {
                if (!unlink($dest)) {
                    rename($dest, $dest . '.bck');
                }
            }
            $this->logger->debug(sprintf('removed file %1$s.', $file));

            return true;
        } elseif (is_dir($dest)) {
            if (strpos($dest, DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR) === false) {
                FilesystemAdapter::deleteDirectory($dest, true);
            }
            $this->logger->debug(sprintf('removed dir %1$s.', $file));

            return true;
        } else {
            return true;
        }
    }

    /**
     * First call of this task needs a warmup, where we load the files list to be upgraded.
     *
     * @return bool
     */
    protected function warmUp()
    {
        $newReleasePath = $this->container->getProperty(UpgradeContainer::LATEST_PATH);
        if (!$this->container->getFilesystemAdapter()->isReleaseValid($newReleasePath)) {
            $this->logger->error($this->translator->trans('Could not assert the folder %s contains a valid PrestaShop release, exiting.', array($newReleasePath), 'Modules.Etsupgrade.Admin'));
            $this->logger->error($this->translator->trans('A file may be missing, or the release is stored in a subfolder by mistake.', array(), 'Modules.Etsupgrade.Admin'));
            $this->next = 'error';

            return false;
        }

        $admin_dir = str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . DIRECTORY_SEPARATOR, '', $this->container->getProperty(UpgradeContainer::PS_ADMIN_PATH));
        if (file_exists($newReleasePath . DIRECTORY_SEPARATOR . 'admin')) {
            rename($newReleasePath . DIRECTORY_SEPARATOR . 'admin', $newReleasePath . DIRECTORY_SEPARATOR . $admin_dir);
        } elseif (file_exists($newReleasePath . DIRECTORY_SEPARATOR . 'admin-dev')) {
            rename($newReleasePath . DIRECTORY_SEPARATOR . 'admin-dev', $newReleasePath . DIRECTORY_SEPARATOR . $admin_dir);
        }
        if (file_exists($newReleasePath . DIRECTORY_SEPARATOR . 'install-dev')) {
            rename($newReleasePath . DIRECTORY_SEPARATOR . 'install-dev', $newReleasePath . DIRECTORY_SEPARATOR . 'install');
        }

        // list saved in UpgradeFileNames::toUpgradeFileList
        // get files differences (previously generated)
        $admin_dir = trim(str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $this->container->getProperty(UpgradeContainer::PS_ADMIN_PATH)), DIRECTORY_SEPARATOR);
        $filepath_list_diff = $this->container->getProperty(UpgradeContainer::WORKSPACE_PATH) . DIRECTORY_SEPARATOR . UpgradeFileNames::FILES_DIFF_LIST;
        $list_files_diff = array();
        if (file_exists($filepath_list_diff)) {
            $list_files_diff = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_DIFF_LIST);
            // only keep list of files to delete. The modified files will be listed with _listFilesToUpgrade
            $list_files_diff = $list_files_diff['deleted'];
            foreach ($list_files_diff as $k => $path) {
                if (preg_match('#ets_upgrade#', $path)) {
                    unset($list_files_diff[$k]);
                } else {
                    $list_files_diff[$k] = str_replace('/' . 'admin', '/' . $admin_dir, $path);
                }
            } // do not replace by DIRECTORY_SEPARATOR
        }

        $list_files_to_upgrade = $this->listFilesToUpgrade($newReleasePath);
        if (false === $list_files_to_upgrade) {
            return false;
        }

        // also add files to remove
        $list_files_to_upgrade = array_merge($list_files_diff, $list_files_to_upgrade);

        $filesToMoveToTheBeginning = array(
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'ClassLoader.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_classmap.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_files.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_namespaces.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_psr4.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_real.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'autoload_static.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR . 'include_paths.php',
            DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'composer',
            DIRECTORY_SEPARATOR . 'vendor',
        );

        foreach ($filesToMoveToTheBeginning as $file) {
            if ($key = array_search($file, $list_files_to_upgrade)) {
                unset($list_files_to_upgrade[$key]);
                $list_files_to_upgrade = array_merge(array($file), $list_files_to_upgrade);
            }
        }

        // save in a serialized array in UpgradeFileNames::toUpgradeFileList
        $this->container->getFileConfigurationStorage()->save($list_files_to_upgrade, UpgradeFileNames::FILES_TO_UPGRADE_LIST);
        $total_files_to_upgrade = count($list_files_to_upgrade);

        if ($total_files_to_upgrade == 0) {
            $this->logger->error($this->translator->trans('[ERROR] Unable to find files to upgrade.', array(), 'Modules.Etsupgrade.Admin'));
            $this->next = 'error';

            return false;
        }
        //if total files upgrade is large then up part time.
        if ($partStep = $this->container->getState()->getEstimateTimeByStep('upgradeFiles')) {
            $unitPart = $this->container->getState()->getUnitPart();
            $changePart = (int)$partStep['part'] * (1 + (($total_files_to_upgrade - $unitPart) / $unitPart) * $this->container->getState()->getRatio());
            $this->container->getState()->setEstimateTime(array(
                'upgradeFiles' => array(
                    'part' => $changePart,
                    'stepDone' => 0,
                ),
            ));
        }

        $this->logger->info($this->translator->trans('%s files will be upgraded.', array($total_files_to_upgrade), 'Modules.Etsupgrade.Admin'));
        $this->next = 'upgradeFiles';
        $this->stepDone = false;

        return true;
    }

    public function init()
    {
        // Do nothing. Overrides parent init for avoiding core to be loaded here.
    }

    public function _replaceFiles()
    {
        // Change file SqlTranslationLoader.php;
        $destSqlTranslationLoaderPath = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/src/PrestaShopBundle/Translation/Loader/SqlTranslationLoader.php';
        if (PHP_VERSION_ID >= 70000 && @file_exists($destSqlTranslationLoaderPath) && @is_writeable($destSqlTranslationLoaderPath)) {

            $content = Tools14::file_get_contents($destSqlTranslationLoaderPath);

            if ($content && !preg_match('#\/\*module:ets_upgrade\*\/#', $content, $matches)) {
                $content = preg_replace(
                    '#\$this->addTranslationsToCatalogue\(\s*(\$(?:[^\,]+?))((?:\s*,\s*(?:[^\,]+?))+)?\)\s*;#',
                    '/*module:ets_upgrade*/
        if (is_array($1) && !empty($1)) {
            $this->addTranslationsToCatalogue($1$2);
        }',
                    $content
                );
                @file_put_contents($destSqlTranslationLoaderPath, $content);
            }
        }

        // Change file Hook.php;
        if ($this->container->getState()->getInstallVersion() !== '' && version_compare($this->container->getState()->getInstallVersion(), '1.7.7.0', '>=')) {
            $hookFile = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/classes/Hook.php';
            if (@file_exists($hookFile) && @is_writeable($hookFile)) {
                $hookContent = Tools14::file_get_contents($hookFile);
                if ($hookContent && preg_match('#throw new PrestaShopObjectNotFoundException\(\'The hook id \#\%s does not exist in database\', \$hook_id\);#', $hookContent, $matches)) {
                    $hookContent = str_replace(
                        'throw new PrestaShopObjectNotFoundException(\'The hook id #%s does not exist in database\', $hook_id);'
                        , '//throw new PrestaShopObjectNotFoundException(\'The hook id #%s does not exist in database\', $hook_id);'
                        , $hookContent
                    );
                    @file_put_contents($hookFile, $hookContent);
                }
            }
        }
    }

    public function _legacyFiles()
    {
        if (trim(($version_num = $this->container->getState()->getInstallVersion())) !== '' && version_compare($version_num, '1.7.0.0', '>=') && trim(($version_old_num = $this->container->getState()->getOldVersion())) !== '' && version_compare($version_old_num, '1.7.0.0', '<')) {
            $ps_root_path = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH);
            $dest = $ps_root_path . '/classes/db/MySQL.php';
            if (is_file($dest) && is_writeable($dest) && unlink($dest)) {
                copy($ps_root_path . '/modules/ets_upgrade/classes/TaskRunner/Legacy/MySQL', $dest);
            }
        }
    }
}
