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

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;

/**
 * List the files modified in the current installation regards to the original version.
 */
class CheckFilesVersion extends AbstractTask
{
    public function run()
    {
        // do nothing after this request (see javascript function doAjaxRequest )
        $this->next = '';
        $upgrader = $this->container->getUpgrader();
        $changedFileList = $upgrader->getChangedFilesList();

        if ($changedFileList === false) {
            $this->nextParams['status'] = 'error';
            $this->nextParams['msg'] = $this->translator->trans('Unable to check files for the installed version of PrestaShop.', array(), 'Modules.Etsupgrade.Admin');

            return;
        }
        $modifications_count = 0;
        foreach (array('core', 'translation', 'mail') as $type) {
            if (!isset($changedFileList[$type])) {
                $changedFileList[$type] = array();
            } else
                $modifications_count += count($changedFileList[$type]);
        }

        if ($upgrader->isAuthenticPrestashopVersion() === true) {
            $this->nextParams['status'] = 'ok';
            $this->nextParams['msg'] = $this->translator->trans('Core files are ok', array(), 'Modules.Etsupgrade.Admin');
        } else {
            $this->nextParams['status'] = 'warn';
            $this->nextParams['msg'] = $this->translator->trans('%modificationscount% file modifications have been detected, including %coremodifications% from core and native modules:', array('%modificationscount%' => $modifications_count, '%coremodifications%' => count($changedFileList['core']),), 'Modules.Etsupgrade.Admin');
        }
        $this->nextParams['result'] = $changedFileList;

        $this->container->getFileConfigurationStorage()->save($changedFileList['translation'], UpgradeFileNames::TRANSLATION_FILES_CUSTOM_LIST);
        $this->container->getFileConfigurationStorage()->save($changedFileList['mail'], UpgradeFileNames::MAILS_CUSTOM_LIST);
    }
}
