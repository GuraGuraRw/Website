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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Remove all sample files from release archive.
*/
class RemoveSamples extends AbstractTask
{
    public function run()
    {
        $this->stepDone = false;
        $this->next = 'removeSamples';

        $removeList = $this->container->getState()->getRemoveList();
        $latestPath = $this->container->getProperty(UpgradeContainer::LATEST_PATH);
        // remove all sample pics in img subdir
        // This part runs at the first call of this step
        if (null === $removeList) {
            if (!$this->container->getFilesystemAdapter()->isReleaseValid($latestPath)) {
                $this->logger->error($this->translator->trans('Could not assert the folder %s contains a valid PrestaShop release, exiting.', array($latestPath), 'Modules.Etsupgrade.Admin'));
                $this->logger->error($this->translator->trans('A file may be missing, or the release is stored in a subfolder by mistake.', array(), 'Modules.Etsupgrade.Admin'));
                $this->next = 'error';

                return;
            }

            $removeList = $this->container->getFilesystemAdapter()->listSampleFilesFromArray(array(
                array('path' => $latestPath . '/img/c', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/cms', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/l', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/m', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/os', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/p', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/s', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/scenes', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/st', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img/su', 'filter' => '.jpg'),
                array('path' => $latestPath . '/img', 'filter' => '404.gif'),
                array('path' => $latestPath . '/img', 'filter' => 'favicon.ico'),
                array('path' => $latestPath . '/img', 'filter' => 'logo.jpg'),
                array('path' => $latestPath . '/img', 'filter' => 'logo_stores.gif'),
                array('path' => $latestPath . '/modules/editorial', 'filter' => 'homepage_logo.jpg'),
                // remove all override present in the archive
                array('path' => $latestPath . '/override', 'filter' => '.php'),
            ));

            $this->container->getState()->setRemoveList($removeList);

            if (count($removeList)) {
                $this->logger->debug(
                    $this->translator->trans('Starting to remove %s sample files',
                        array(count($removeList)), 'Modules.Etsupgrade.Admin'));
            }
        }

        $filesystem = new Filesystem();
        for ($i = 0; $i < $this->container->getUpgradeConfiguration()->getNumberOfFilesPerCall() && is_array($removeList) && 0 < count($removeList); ++$i) {
            $file = array_shift($removeList);
            try {
                $filesystem->remove($file);
            } catch (\Exception $e) {
                $this->next = 'error';
                $this->logger->error($this->translator->trans(
                    'Error while removing item %itemname%, %itemscount% items left.',
                    array(
                        '%itemname%' => $file,
                        '%itemscount%' => count($removeList),
                    ),
                    'Modules.Etsupgrade.Admin'
                ));

                return false;
            }

            if (count($removeList)) {
                $this->logger->debug($this->translator->trans(
                    '%itemname% item removed. %itemscount% items left.',
                    array(
                        '%itemname%' => $file,
                        '%itemscount%' => count($removeList),
                    ),
                    'Modules.Etsupgrade.Admin'
                ));
            }
        }
        $this->container->getState()->setRemoveList($removeList);

        if (0 >= count($removeList) || !is_array($removeList)) {
            $this->stepDone = true;
            $this->next = 'backupFiles';
            $this->logger->info(
                $this->translator->trans(
                    'All sample files removed. Now backing up files.',
                    array(),
                    'Modules.Etsupgrade.Admin'
            ));

            if ($this->container->getUpgradeConfiguration()->get('skip_backup')) {
                $this->next = 'upgradeFiles';
                $this->logger->info(
                    $this->translator->trans(
                        'All sample files removed. Backup process skipped. Now upgrading files.',
                        array(),
                        'Modules.Etsupgrade.Admin'
                ));
                $this->psShopEnable();
            }

            $this->container->getState()->setStepDone('removeSamples');
        }

        return true;
    }
}
