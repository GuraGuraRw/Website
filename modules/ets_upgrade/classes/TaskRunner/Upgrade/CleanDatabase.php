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

/**
 * Clean the database from unwanted entries.
*/
class CleanDatabase extends AbstractTask
{
    public function run()
    {
        // Clean tabs order
        foreach ($this->container->getDb()->ExecuteS('SELECT DISTINCT id_parent FROM ' . _DB_PREFIX_ . 'tab') as $parent) {
            $i = 1;
            foreach ($this->container->getDb()->ExecuteS('SELECT id_tab FROM `' . _DB_PREFIX_ . 'tab` WHERE id_parent = ' . (int)$parent['id_parent'] . ' ORDER BY IF(class_name IN ("AdminHome", "AdminDashboard"), 1, 2), position ASC') as $child) {
                $this->container->getDb()->Execute('UPDATE `' . _DB_PREFIX_ . 'tab` SET position = ' . (int)($i++) . ' WHERE id_tab = ' . (int)$child['id_tab'] . ' AND id_parent = ' . (int)$parent['id_parent']);
            }
        }
        $this->stepDone = true;
        $this->status = 'ok';
        if ($this->container->getUpgradeConfiguration()->isMajorChannel()) {
            $this->next = 'enableModules';
        } else {
            $this->next = 'upgradeComplete';
        }
        $this->logger->info($this->translator->trans('The database has been cleaned.', array(), 'Modules.Etsupgrade.Admin'));

        $this->container->getState()->setStepDone('cleanDatabase');
    }
}
