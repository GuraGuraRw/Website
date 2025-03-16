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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Rollback;

use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\ChainedTasks;

/**
 * Execute the whole upgrade process in a single request.
*/
class AllRollbackTasks extends ChainedTasks
{
    const initialTask = 'rollback';

    protected $step = self::initialTask;

    /**
     * Customize the execution context with several options
     * > action: Replace the initial step to run
     * > channel: Makes a specific upgrade (minor, major etc.)
     * > data: Loads an encoded array of data coming from another request.
     *
     * @param array $options
    */
    public function setOptions(array $options)
    {
        if (!empty($options['backup'])) {
            $this->container->getState()->setRestoreName($options['backup']);
        }
    }

    /**
     * Set default config on first run.
    */
    public function init()
    {
        // Do nothing
    }
}
