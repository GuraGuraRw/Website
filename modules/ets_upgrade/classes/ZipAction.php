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

use PrestaShop\Module\EtsAutoUpgrade\Log\LoggerInterface;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;
use Symfony\Component\Filesystem\Filesystem;

class ZipAction
{
    /**
     * @var int Number of files added in a zip per request
     */
    private $configMaxNbFilesCompressedInARow;
    /**
     * @var int Max file size allowed in a zip file
     */
    private $configMaxFileSizeAllowed;

    private $logger;
    private $translator;

    /**
     * @var string Path to the shop, in order to remove it from the archived file paths
     */
    private $prodRootDir;

    public function __construct($translator, LoggerInterface $logger, UpgradeConfiguration $configuration, $prodRootDir)
    {
        $this->translator = $translator;
        $this->logger = $logger;
        $this->prodRootDir = $prodRootDir;

        $this->configMaxNbFilesCompressedInARow = $configuration->getNumberOfFilesPerCall();
        $this->configMaxFileSizeAllowed = $configuration->getMaxFileToBackup();
    }

    /**
     * Add files to an archive.
     * Note the number of files added can be limited.
     *
     * @var array List of files to add
     * @var string $toFile
     */
    public function compress(&$filesList, $toFile)
    {
        $zip = $this->open($toFile, \ZipArchive::CREATE);
        if ($zip === false) {
            return false;
        }

        for ($i = 0; $i < $this->configMaxNbFilesCompressedInARow && count($filesList); ++$i) {
            $file = array_shift($filesList);

            $archiveFilename = $this->getFilepathInArchive($file);
            if (!$this->isFileWithinFileSizeLimit($file)) {
                continue;
            }

            if (!$zip->addFile($file, $archiveFilename)) {
                // if an error occur, it's more safe to delete the corrupted backup
                $zip->close();
                (new Filesystem())->remove($toFile);
                $this->logger->error($this->translator->trans(
                    'Error when trying to add %filename% to archive %archive%.',
                    array(
                        '%filename%' => $file,
                        '%archive%' => $archiveFilename,
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            }

            $this->logger->debug($this->translator->trans(
                '%filename% added to archive. %filescount% files left.',
                array(
                    '%filename%' => $archiveFilename,
                    '%filescount%' => count($filesList),
                ),
                'Modules.Etsupgrade.Admin'
            ));
        }

        if (!$zip->close()) {
            $this->logger->error($this->translator->trans(
                'Could not close the Zip file properly. Check you are allowed to write on the disk and there is available space on it.',
                array(),
                'Modules.Etsupgrade.Admin'
            ));

            return false;
        }

        return true;
    }

    /**
     * Extract an archive to the given directory
     *
     * @param $from_file
     * @param $to_dir
     * @param int $keepIndex
     * @return bool success
     *              we need a copy of it to be able to restore without keeping Tools and Autoload stuff
     */
    public function extract($from_file, $to_dir, $keepIndex = 0)
    {
        if (!is_file($from_file)) {
            $this->logger->error($this->translator->trans('%s is not a file', array($from_file), 'Modules.Etsupgrade.Admin'));

            return false;
        }

        if (!file_exists($to_dir)) {
            // ToDo: Use Filesystem from Symfony
            if (!mkdir($to_dir)) {
                $this->logger->error($this->translator->trans('Unable to create directory %s.', array($to_dir), 'Modules.Etsupgrade.Admin'));

                return false;
            }
            chmod($to_dir, 0775);
        }

        $zip = $this->open($from_file);
        if ($zip === false) {
            return false;
        }
        if ($keepIndex) {
            $index1 = $this->getZipIndex($to_dir, 1);
            $index2 = $this->getZipIndex($to_dir, 2);
            $zip_index = $index1 ?: $index2;
        } else
            $zip_index = 0;
        for ($i = $zip_index; $i < $zip->numFiles; ++$i) {

            if ($keepIndex)
                $this->writeZipIndex($to_dir, $i);

            if (!$zip->extractTo($to_dir, array($zip->getNameIndex($i)))) {
                $this->logger->error(
                    $this->translator->trans(
                        'Could not extract %file% from backup, the destination might not be writable.',
                        ['%file%' => $zip->statIndex($i)['name']],
                        'Modules.Etsupgrade.Admin'
                    )
                );
                $zip->close();
                return false;
            }
            if ($i > $zip_index && $i % 5000 === 0) {
                $zip->close();
                return true;
            }
        }

        $zip->close();
        $this->logger->debug($this->translator->trans('Content of archive %zip% is extracted', ['%zip%' => $from_file], 'Modules.Etsupgrade.Admin'));
        if ($keepIndex && $i >= ((int)$zip->numFiles - 1)) {
            @unlink($to_dir . '/zip_index1.log');
            @unlink($to_dir . '/zip_index2.log');
        }
        return true;
    }

    public function extractZipCompleted($to_dir)
    {
        return !(file_exists($to_dir . '/zip_index1.log') || file_exists($to_dir . '/zip_index1.log'));
    }

    public function writeZipIndex($to_dir, $i)
    {
        $i1 = $this->getZipIndex($to_dir, 1);
        $i2 = $this->getZipIndex($to_dir, 2);
        if (!$i2) {
            @file_put_contents($to_dir . '/zip_index2.log', $i1, LOCK_EX);
            @file_put_contents($to_dir . '/zip_index1.log', $i, LOCK_EX);
        } elseif (!$i1) {
            @file_put_contents($to_dir . '/zip_index1.log', $i2, LOCK_EX);
            @file_put_contents($to_dir . '/zip_index2.log', $i, LOCK_EX);
        } else {
            @file_put_contents($to_dir . '/zip_index1.log', $i, LOCK_EX);
            @file_put_contents($to_dir . '/zip_index2.log', $i, LOCK_EX);
        }
    }

    public function getZipIndex($to_dir, $i)
    {
        return (int)Tools14::file_get_contents($to_dir . '/zip_index' . (int)$i . '.log');
    }

    /**
     * Lists the files present in the given archive
     *
     * @return array
     * @var string Path to the file
     *
     */
    public function listContent($zipfile)
    {
        if (!file_exists($zipfile)) {
            return [];
        }

        $zip = $this->open($zipfile);
        if ($zip === false) {
            $this->logger->error($this->translator->trans('[ERROR] Unable to list archived files', array(), 'Modules.Etsupgrade.Admin'));

            return [];
        }

        $files = [];
        for ($i = 0; $i < $zip->numFiles; ++$i) {
            $files[] = $zip->getNameIndex($i);
        }

        return $files;
    }

    /**
     * Get the path of a file from the archive root
     *
     * @return string Path of the file in the backup archive
     * @var string Path of the file on the filesystem
     *
     */
    private function getFilepathInArchive($filepath)
    {
        return ltrim(str_replace($this->prodRootDir, '', $filepath), DIRECTORY_SEPARATOR);
    }

    /**
     * Checks a file size matches the given limits
     *
     * @return bool Size is inside the maximum limit
     * @var string Path to a file
     *
     */
    private function isFileWithinFileSizeLimit($filepath)
    {
        $size = filesize($filepath);
        $pass = ($size < $this->configMaxFileSizeAllowed);
        if (!$pass) {
            $this->logger->debug($this->translator->trans(
                'File %filename% (size: %filesize%) has been skipped during backup.',
                array(
                    '%filename%' => $this->getFilepathInArchive($filepath),
                    '%filesize%' => $size,
                ),
                'Modules.Etsupgrade.Admin'
            ));
        }

        return $pass;
    }

    /**
     * Open an archive
     *
     * @return false|\ZipArchive
     * @var int ZipArchive flags
     *
     * @var string Path to the archive
     */
    private function open($zipFile, $flags = 0)
    {
        $zip = new \ZipArchive();
        if ($zip->open($zipFile, $flags) !== true || empty($zip->filename)) {
            $this->logger->error($this->translator->trans('Unable to open zipFile %s', array($zipFile), 'Modules.Etsupgrade.Admin'));

            return false;
        }

        return $zip;
    }
}
