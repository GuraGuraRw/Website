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

use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;
use Symfony\Component\Filesystem\Filesystem;

/**
 * extract chosen version into $this->upgradeClass->latestPath directory.
 */
class Unzip extends AbstractTask
{
    public function run()
    {
        $filepath = $this->container->getFilePath();
        $destExtract = $this->container->getProperty(UpgradeContainer::LATEST_PATH);

        if ($this->container->getState()->isUnzipAutoUpgrade()) {
            $this->unzipAutoUpgrade($destExtract);
            if ($this->next === 'error' || $this->container->getState()->isUnzipAutoUpgrade())
                return false;
            $this->setUnzipCompleted($destExtract . DIRECTORY_SEPARATOR . 'prestashop.zip');
        }
        $repeatTask = $this->container->getState()->getForceStep();

        if (@version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '<') || !@file_exists($destExtract . DIRECTORY_SEPARATOR . 'prestashop.zip')) {
            if (file_exists($destExtract) && !$repeatTask) {
                FilesystemAdapter::deleteDirectory($destExtract, false);
                $this->logger->debug($this->translator->trans('"/latest" directory has been emptied', array(), 'Modules.Etsupgrade.Admin'));
            }
            $relative_extract_path = str_replace(_PS_ROOT_DIR_, '', $destExtract);
            $report = '';
            if (!\ConfigurationTest::test_dir($relative_extract_path, false, $report)) {
                $this->logger->error($this->translator->trans('Extraction directory %s is not writable.', array($destExtract), 'Modules.Etsupgrade.Admin'));
                $this->next = 'error';
                $this->error = true;

                return false;
            }

            $res = $this->container->getZipAction()->extract($filepath, $destExtract, 1);

            if (!$res) {
                $this->next = 'error';
                $this->error = true;
                $this->logger->info($this->translator->trans(
                    'Unable to extract %filepath% file into %destination% folder...',
                    array(
                        '%filepath%' => $filepath,
                        '%destination%' => $destExtract,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            } elseif (@file_exists($destExtract . '/zip_index1.log') || @file_exists($destExtract . '/zip_index2.log')) {
                $this->logger->info($this->translator->trans('Continue to extract zip file...', array(), 'Modules.Etsupgrade.Admin'));
                $this->container->getState()->setForceStep(1);
                $this->stepDone = false;
                $this->next = 'unzip';
                return true;
            }
        }

        // From PrestaShop 1.7, we zip all the files in another package
        // which must be unzipped too
        $prestashop_core_zip = $destExtract . DIRECTORY_SEPARATOR . 'prestashop.zip';
        if (file_exists($prestashop_core_zip)) {
            if (!$repeatTask) {
                @unlink($destExtract . DIRECTORY_SEPARATOR . '/index.php');
                @unlink($destExtract . DIRECTORY_SEPARATOR . '/Install_PrestaShop.html');
            }
            $res = $this->container->getZipAction()->extract($prestashop_core_zip, $destExtract, 1);
            if (!$res) {
                $this->next = 'error';
                $this->logger->info($this->translator->trans(
                    'Unable to extract %filepath% file into %destination% folder...',
                    array(
                        '%filepath%' => $filepath,
                        '%destination%' => $destExtract,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            } elseif (@file_exists($destExtract . '/zip_index1.log') || @file_exists($destExtract . '/zip_index2.log')) {
                $this->logger->info($this->translator->trans('Continue to extract zip file...', array(), 'Modules.Etsupgrade.Admin'));
                $this->container->getState()->setForceStep(1);
                $this->stepDone = false;
                $this->next = 'unzip';
                return true;
            }
        } else {
            $filesystem = new Filesystem();
            $zipSubfolder = $destExtract . '/prestashop/';
            if (!is_dir($zipSubfolder)) {
                $this->next = 'error';
                $this->logger->error($this->translator->trans('No prestashop/ folder found in the ZIP file. Aborting.', array(), 'Modules.Etsupgrade.Admin'));

                return false;
            }
            // /!\ On PS 1.6, files are unzipped in a subfolder PrestaShop
            foreach (scandir($zipSubfolder) as $file) {
                if ($file[0] === '.') {
                    continue;
                }
                $filesystem->rename($zipSubfolder . $file, $destExtract . '/' . $file);
            }
        }

        // Unsetting to force listing
        $this->unzipAutoUpgrade($destExtract);
        if ($this->next === 'error' || $this->container->getState()->isUnzipAutoUpgrade())
            return false;

        $this->setUnzipCompleted($prestashop_core_zip);
        return true;
    }

    public function setUnzipCompleted($prestashop_core_zip)
    {
        $this->stepDone = true;
        $this->container->getState()->setRemoveList(null);
        $this->next = 'removeSamples';
        $this->logger->info($this->translator->trans('File extraction complete. Removing sample files...', array(), 'Modules.Etsupgrade.Admin'));

        @unlink($prestashop_core_zip);
        $this->container->getState()->setForceStep(0);
        $this->container->getState()->setStepDone('unzip');
    }

    public function unzipAutoUpgrade($destExtract)
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '8.0.0', '>=') && @file_exists(($autoupgrade_zip = $this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH) . DIRECTORY_SEPARATOR . 'autoupgrade.zip')) && is_dir($destExtract . DIRECTORY_SEPARATOR . 'install')) {
            if (file_exists(($extract_path = $destExtract . DIRECTORY_SEPARATOR . 'modules') . DIRECTORY_SEPARATOR . 'autoupgrade') && !$this->container->getState()->isUnzipAutoUpgrade()) {
                FilesystemAdapter::deleteDirectory($extract_path . DIRECTORY_SEPARATOR . 'autoupgrade', false);
                $this->logger->debug($this->translator->trans('"/latest/modules/autoupgrade" directory has been emptied', array(), 'Modules.Etsupgrade.Admin'));
            }
            $res = $this->container->getZipAction()->extract($autoupgrade_zip, $extract_path, 1);
            if (!$res) {
                $this->next = 'error';
                $this->logger->info($this->translator->trans(
                    'Unable to extract %filepath% file into %destination% folder...',
                    array(
                        '%filepath%' => $autoupgrade_zip,
                        '%destination%' => $destExtract,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            } elseif (@file_exists($extract_path . '/zip_index1.log') || @file_exists($extract_path . '/zip_index2.log')) {
                $this->logger->info($this->translator->trans('Continue to extract autoupgrade.zip file...', array(), 'Modules.Etsupgrade.Admin'));
                $this->container->getState()->setIsUnzipAutoUpgrade(1);
                $this->stepDone = false;
                $this->next = 'unzip';
                return true;
            }
            if (is_dir(($upgrade_folder = $extract_path . DIRECTORY_SEPARATOR . 'autoupgrade' . DIRECTORY_SEPARATOR . 'upgrade'))) {
                Tools14::recurseCopy($upgrade_folder, $destExtract . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . 'upgrade');
                $this->logger->info($this->translator->trans(
                    'Copied folder %filepath% into %destination% folder.',
                    array(
                        '%filepath%' => $upgrade_folder,
                        '%destination%' => $destExtract . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . 'upgrade',
                    ),
                    'Modules.Etsupgrade.Admin'
                ));
                $this->container->getState()->setIsUnzipAutoUpgrade(0);
            }
        }
    }
}
