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

use PrestaShop\Module\EtsAutoUpgrade\AjaxResponse;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\ChainedTasks;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;

/**
 * Execute the whole upgrade process in a single request.
*/
class AllUpgradeTasks extends ChainedTasks
{
    const initialTask = 'upgradeNow';
    const TASKS_WITH_RESTART = ['upgradeFiles', 'upgradeDb'];

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
        if (!empty($options['action'])) {
            $this->step = $options['action'];
        }

        if (!empty($options['channel'])) {
            $this->container->getUpgradeConfiguration()->merge(array(
                'channel' => $options['channel'],
                // Switch on default theme if major upgrade (i.e: 1.6 -> 1.7)
                'PS_AUTOUP_CHANGE_DEFAULT_THEME' => in_array($options['channel'], array('major', 'major16')),//($options['channel'] === 'major'),
            ));
            $this->container->getUpgrader()->channel = $options['channel'];
            $this->container->getUpgrader()->checkPSVersion(true);
        }

        if (!empty($options['data'])) {
            $this->container->getState()->importFromEncodedData($options['data']);
        }
    }

    /**
     * For some steps, we may require a new request to be made.
     * For instance, in case of obsolete autoloader or loaded classes after a file copy.
    */
    protected function checkIfRestartRequested(AjaxResponse $response)
    {
        if (parent::checkIfRestartRequested($response)) {
            return true;
        }

        if (!$response->getStepDone()) {
            return false;
        }

        if (!in_array($this->step, self::TASKS_WITH_RESTART)) {
            return false;
        }

        $this->logger->info('Restart requested. Please run the following command to continue your upgrade:');
        $args = $_SERVER['argv'];
        foreach ($args as $key => $arg) {
            if (strpos($arg, '--data') === 0) {
                unset($args[$key]);
            }
        }
        $this->logger->info('$ ' . implode(' ', $args) . ' --action=' . $response->getNext() . ' --data=' . $this->getEncodedResponse());

        return true;
    }

    /**
     * Set default config on first run.
    */
    public function init()
    {
        if ($this->step === self::initialTask) {
            parent::init();
            $this->container->getState()->initDefault(
                $this->container->getUpgrader(),
                $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH),
                $this->container->getProperty(UpgradeContainer::PS_VERSION));
        }
    }
}
