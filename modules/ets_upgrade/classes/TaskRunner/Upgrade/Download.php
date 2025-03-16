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
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;

/**
 * Download PrestaShop archive according to the chosen channel.
 */
class Download extends AbstractTask
{
    public function run()
    {
        if (!\ConfigurationTest::test_fopen() && !extension_loaded('curl')) {
            $this->logger->error($this->translator->trans('You need allow_url_fopen or cURL enabled for automatic download to work. You can also manually upload it in filepath %s.', array($this->container->getFilePath()), 'Modules.Etsupgrade.Admin'));
            $this->next = 'error';

            return;
        }

        $upgrader = $this->container->getUpgrader();
        // regex optimization
        preg_match('#([0-9]+\.[0-9]+)(?:\.[0-9]+){1,2}#', _PS_VERSION_, $matches);
        $upgrader->channel = $this->container->getUpgradeConfiguration()->get('channel');
        $upgrader->branch = $matches[1];
        if ($this->container->getUpgradeConfiguration()->get('channel') == 'private' && !$this->container->getUpgradeConfiguration()->get('private_allow_major')) {
            $upgrader->checkPSVersion(false, array('private', 'minor'));
        } else {
            $upgrader->checkPSVersion(false, array('minor'));
        }

        if ($upgrader->channel == 'private') {
            $upgrader->link = $this->container->getUpgradeConfiguration()->get('private_release_link');
            $upgrader->md5 = $this->container->getUpgradeConfiguration()->get('private_release_md5');
        }
        $download_path = $this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH) . DIRECTORY_SEPARATOR . 'prestashop.zip';
        if (!$this->container->getState()->getIsReDownloadFileZip()) {
            $this->logger->debug($this->translator->trans('Downloading from %s', array($upgrader->link), 'Modules.Etsupgrade.Admin'));
            $this->logger->debug($this->translator->trans('File will be saved in %s', array($this->container->getFilePath()), 'Modules.Etsupgrade.Admin'));
            FilesystemAdapter::deleteDirectory($this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH), false);
            $this->logger->debug($this->translator->trans('Download directory has been emptied', array(), 'Modules.Etsupgrade.Admin'));
        } elseif (@file_exists($download_path) && (int)filesize($download_path) > 0) {
            if ($this->container->getState()->isReDownloadAutoUpgrade())
                $this->downloadAutoUpgrade($upgrader);
            if ($this->next === 'error' || $this->container->getState()->isReDownloadAutoUpgrade())
                return;
            $this->setDownloadZipComplete();
            return;
        } elseif ($filesZip = glob($this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH) . DIRECTORY_SEPARATOR . '*.zip')) {
            foreach ($filesZip as $fileZip) {
                if (@filesize($fileZip) > 0 && @rename($fileZip, $download_path)) {
                    $this->logger->info($this->translator->trans('File uploaded. Now extracting...', array(), 'Modules.Etsupgrade.Admin'));
                    $this->stepDone = true;
                    $this->container->getState()->setStepDone('download');
                    $this->next = 'unzip';

                    return;
                }
            }
            $this->next = 'error';
        } else
            $this->next = 'error';
        if (trim($this->next) == 'error') {
            $this->logger->error($this->translator->trans('The uploaded file is not PrestaShop zip file, please upload the correct file', array(), 'Modules.Etsupgrade.Admin'));

            return;
        }
        $logger_errors = array();
        $report = '';
        $relative_download_path = str_replace(_PS_ROOT_DIR_, '', $this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH));
        if (\ConfigurationTest::test_dir($relative_download_path, false, $report)) {
            $res = $upgrader->downloadLast($this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH), $this->container->getProperty(UpgradeContainer::ARCHIVE_FILENAME));
            if ($res) {
                if (!@filesize($this->container->getProperty(UpgradeContainer::ARCHIVE_FILEPATH))) {
                    $logger_errors[] = $this->translator->trans('The downloaded file is blank.', array(), 'Modules.Etsupgrade.Admin');
                    $this->next = 'error';

                    // Remove file blank.
                    @unlink($this->container->getProperty(UpgradeContainer::ARCHIVE_FILEPATH));
                } else {
                    $md5file = md5_file(realpath($this->container->getProperty(UpgradeContainer::ARCHIVE_FILEPATH)));
                    if ($md5file == $upgrader->md5) {
                        $this->downloadAutoUpgrade($upgrader);
                        if ($this->next === 'error' || $this->container->getState()->isReDownloadAutoUpgrade())
                            return;
                        $this->setDownloadZipComplete();
                    } else {
                        $logger_errors[] = $this->translator->trans('Download complete but MD5 sum does not match (%s).', array($md5file), 'Modules.Etsupgrade.Admin');
                        $this->logger->info($this->translator->trans('Download complete but MD5 sum does not match (%s). Operation aborted.', array($md5file), 'Modules.Etsupgrade.Admin'));
                        $this->next = 'error';
                    }
                }
            } else {
                if ($upgrader->channel == 'private') {
                    $logger_errors[] = $this->translator->trans('Error during download. The private key may be incorrect.', array(), 'Modules.Etsupgrade.Admin');
                } else {
                    $logger_errors[] = $this->translator->trans('Error during download', array(), 'Modules.Etsupgrade.Admin');
                }
                $this->next = 'error';
            }
        } else {
            $logger_errors[] = $this->translator->trans('Download directory %s is not writable.', array($this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH)), 'Modules.Etsupgrade.Admin');
            $this->next = 'error';
        }
        if (!$this->container->getState()->getIsReDownloadFileZip() && $this->next === 'error') {
            $this->next = 'download';
            $this->stepDone = false;
            $this->container->getState()->setIsReDownloadFileZip(true);

            return;
        } elseif (count($logger_errors) > 0) {
            foreach ($logger_errors as $logger_error) {
                $this->logger->error($logger_error);
            }

            return;
        }
    }

    public function setDownloadZipComplete()
    {
        $this->stepDone = true;
        $this->container->getState()->setStepDone('download');
        $this->next = 'unzip';
        $this->logger->debug($this->translator->trans('Download complete.', array(), 'Modules.Etsupgrade.Admin'));
        $this->logger->info($this->translator->trans('Download complete. Now extracting...', array(), 'Modules.Etsupgrade.Admin'));
    }

    public function downloadAutoUpgrade($upgrader = null)
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '8.0.0', '>=') && !file_exists(($filename = $this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH)) . DIRECTORY_SEPARATOR . 'autoupgrade.zip')) {
            if ($upgrader == null)
                $upgrader = $this->container->getUpgrader();
            $full_report = null;
            $relative_download_path = str_replace(_PS_ROOT_DIR_, '', $filename);
            if (\ConfigurationTest::test_dir($relative_download_path, false, $full_report)) {
                $res = $upgrader->downloadAutoUpgradeLast($filename);
                if ($res) {
                    if (!@filesize(($archive_filename = $filename . DIRECTORY_SEPARATOR . 'autoupgrade.zip'))) {
                        $this->logger->info($this->translator->trans('The downloaded file autoupgrade.zip is blank.', array(), 'Modules.Etsupgrade.Admin'));
                        $this->next = 'error';
                        @unlink($archive_filename);
                    } else {
                        $md5file = md5_file(realpath($archive_filename));
                        if ($md5file == $upgrader->autoupgrade_md5) {
                            $this->logger->debug($this->translator->trans('Download autoupgrade complete.', array(), 'Modules.Etsupgrade.Admin'));
                            $this->container->getState()->setIsReDownloadAutoUpgrade(0);
                            return true;
                        } else {
                            $this->logger->info($this->translator->trans('Download autoupgrade complete but MD5 sum does not match (%s). Operation aborted.', array($md5file), 'Modules.Etsupgrade.Admin'));
                            $this->next = 'error';
                        }
                    }
                } else {
                    $this->next = 'error';
                    $this->logger->info($this->translator->trans('Error during download autoupgrade', array(), 'Modules.Etsupgrade.Admin'));
                }
                if ($this->next === 'error') {
                    $this->container->getState()->setIsReDownloadAutoUpgrade(1);
                }
            } else {
                if ($full_report !== null)
                    $this->logger->info($full_report);
                $this->next = 'error';
            }
        }
    }
}
