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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner;

use PrestaShop\Module\EtsAutoUpgrade\AjaxResponse;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\TaskRepository;

/**
 * Execute the whole process in a single request, useful in CLI.
*/
abstract class ChainedTasks extends AbstractTask
{
    protected $step;

    /**
     * Execute all the tasks from a specific initial step, until the end (complete or error).
     *
     * @return int Return code (0 for success, any value otherwise)
    */
    public function run()
    {
        $requireRestart = false;
        while ($this->canContinue() && !$requireRestart) {
            $this->logger->info('=== Step ' . $this->step);
            $controller = TaskRepository::get($this->step, $this->container);
            $controller->init();
            $controller->run();

            $result = $controller->getResponse();
            $requireRestart = $this->checkIfRestartRequested($result);
            $this->error = $result->getError();
            $this->stepDone = $result->getStepDone();
            $this->step = $result->getNext();
        }

        return (int) ($this->error || $this->step === 'error');
    }

    /**
     * Customize the execution context with several options.
     *
     * @param array $options
    */
    abstract public function setOptions(array $options);

    /**
     * Tell the while loop if it can continue.
     *
     * @return bool
    */
    protected function canContinue()
    {
        if (empty($this->step)) {
            return false;
        }

        if ($this->error) {
            return false;
        }

        return $this->step !== 'error';
    }

    /**
     * For some steps, we may require a new request to be made.
     * Return true for stopping the process.
    */
    protected function checkIfRestartRequested(AjaxResponse $response)
    {
    	unset($response);
        return false;
    }
}
