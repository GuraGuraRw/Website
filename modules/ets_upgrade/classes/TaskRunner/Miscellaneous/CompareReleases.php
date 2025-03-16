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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Miscellaneous;

use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;

/**
 * get the list of all modified and deleted files between current version
 * and target version (according to channel configuration).
*/
class CompareReleases extends AbstractTask
{
    public function run()
    {
        // do nothing after this request (see javascript function doAjaxRequest )
        $this->next = '';
        $channel = $this->container->getUpgradeConfiguration()->get('channel');
        $upgrader = $this->container->getUpgrader();
        switch ($channel) {
            case 'archive':
                $version = $this->container->getUpgradeConfiguration()->get('archive.version_num');
                break;
            case 'directory':
                $version = $this->container->getUpgradeConfiguration()->get('directory.version_num');
                break;
            default:
                preg_match('#([0-9]+\.[0-9]+)(?:\.[0-9]+){1,2}#', _PS_VERSION_, $matches);
                $upgrader->branch = $matches[1];
                $upgrader->channel = $channel;
                if ($this->container->getUpgradeConfiguration()->get('channel') == 'private' && !$this->container->getUpgradeConfiguration()->get('private_allow_major')) {
                    $upgrader->checkPSVersion(false, array('private', 'minor'));
                } else {
                    $upgrader->checkPSVersion(false, array('minor'));
                }
                $version = $upgrader->version_num;
        }

        $diffFileList = $upgrader->getDiffFilesList(_PS_VERSION_, $version);
        if (!is_array($diffFileList)) {
            $this->nextParams['status'] = 'error';
            $this->nextParams['msg'] = $this->translator->trans('Unable to generate diff file list between %oldversion% and %newversion%.', array('%oldversion%'=>_PS_VERSION_, '%newversion%'=>$version), 'Modules.Etsupgrade.Admin');
        } else {
            $this->container->getFileConfigurationStorage()->save($diffFileList, UpgradeFileNames::FILES_DIFF_LIST);
            if (count($diffFileList) > 0) {
                $this->nextParams['msg'] = $this->translator->trans('%modifiedfiles% files will be modified, %deletedfiles% files will be deleted (if they are found).', array('%modifiedfiles%' => count($diffFileList['modified']), '%deletedfiles%' => count($diffFileList['deleted'])), 'Modules.Etsupgrade.Admin');
            } else {
                $this->nextParams['msg'] = $this->translator->trans('No diff files found.', array(), 'Modules.Etsupgrade.Admin');
            }
            $this->nextParams['result'] = $diffFileList;
        }
    }
}
