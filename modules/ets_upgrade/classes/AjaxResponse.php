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

use PrestaShop\Module\EtsAutoUpgrade\Log\Logger;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeConfiguration;

/**
 * Class creating the content to return at an ajax call.
 */
class AjaxResponse
{
    /**
     * Used during upgrade.
     *
     * @var bool Supposed to store a boolean in case of error
     */
    private $error = false;

    /**
     * Used during upgrade.
     *
     * @var bool Inform when the step is completed
     */
    private $stepDone = true;

    /**
     * Used during upgrade. "N/A" as value otherwise.
     *
     * @var string Next step to call (can be the same as the previous one)
     */
    private $next = 'N/A';

    /**
     * @var array Params to send (upgrade conf, details on the work to do ...)
     */
    private $nextParams = array();

    /**
     * Request format of the data to return.
     * Seems to be never modified. Converted as const.
     */
    const RESPONSE_FORMAT = 'json';

    /**
     * @var UpgradeConfiguration
     */
    private $upgradeConfiguration;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var State
     */
    private $state;

    /**
     * @var float
     */
    private $estimateTime;
    /**
     * @var int
     */
    private $unitTime;

    /**
     * @var int
     */
    private $current_part_step;
    /**
     * @var int
     */
    private $php_version_id;

    /**
     * @return mixed
     */
    public function getPhpVersionId()
    {
        if ($version = explode('.', phpversion()))
            $this->php_version_id = ((int)$version[0] * 10000 + (int)$version[1] * 100 + (int)$version[2]);
        return $this->php_version_id;
    }

    public function setPhpVersionId($php_version_id)
    {
        $this->php_version_id = $php_version_id;

        return $this;
    }

    public function __construct(State $state, Logger $logger)
    {
        $this->state = $state;
        $this->logger = $logger;
    }

    /**
     * @return array of data to ready to be returned to caller
     */
    public function getResponse()
    {
        $return = array(
            'error' => $this->error,
            'stepDone' => $this->stepDone,
            'next' => $this->next,
            'status' => $this->getStatus(),
            'next_desc' => $this->logger->getLastInfo(),
            'nextQuickInfo' => $this->logger->getInfos(),
            'nextErrors' => $this->logger->getErrors(),
            'nextParams' => array_merge(
                $this->nextParams,
                $this->state->export(),
                array(
                    'typeResult' => self::RESPONSE_FORMAT,
                    'config' => $this->upgradeConfiguration->toArray(),
                    'php_version_id' => $this->getPhpVersionId()
                )
            ),
            'estimateTime' => $this->estimateTime,
            'unitTime' => $this->unitTime,
            'current_part_step' => $this->getCurrentPartStep(),
        );

        return $return;
    }

    /**
     * @return string Json encoded response from $this->getResponse()
     */
    public function getJson()
    {
        return json_encode($this->getResponse());
    }

    // GETTERS

    public function getError()
    {
        return $this->error;
    }

    public function getStepDone()
    {
        return $this->stepDone;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function getStatus()
    {
        return $this->getNext() == 'error' ? 'error' : 'ok';
    }

    public function getNextParams()
    {
        return $this->nextParams;
    }

    public function getUpgradeConfiguration()
    {
        return $this->upgradeConfiguration;
    }

    // SETTERS

    public function setError($error)
    {
        $this->error = (bool)$error;

        return $this;
    }

    public function setStepDone($stepDone)
    {
        $this->stepDone = $stepDone;

        return $this;
    }

    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    public function setNextParams($nextParams)
    {
        $this->nextParams = $nextParams;

        return $this;
    }

    public function setUpgradeConfiguration(UpgradeConfiguration $upgradeConfiguration)
    {
        $this->upgradeConfiguration = $upgradeConfiguration;

        return $this;
    }

    /**
     * @param mixed $estimateTime
     * @return AjaxResponse
     */
    public function setEstimateTime($estimateTime)
    {
        $this->estimateTime = $estimateTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitTime()
    {
        return $this->unitTime;
    }

    /**
     * @param mixed $unitTime
     */
    public function setUnitTime($unitTime)
    {
        $this->unitTime = $unitTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentPartStep()
    {
        return $this->current_part_step;
    }

    /**
     * @param mixed $current_part_step
     */
    public function setCurrentPartStep($current_part_step)
    {
        $this->current_part_step = $current_part_step;

        return $this;
    }
}
