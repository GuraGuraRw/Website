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
use PrestaShop\Module\EtsAutoUpgrade\Log\Logger;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;

abstract class AbstractTask
{
    /* usage :  key = the step you want to skip
     *               value = the next step you want instead
     *	example : public static $skipAction = array();
    */
    public static $skipAction = array();

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var \PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator
     */
    protected $translator;

    /**
     * @var UpgradeContainer
     */
    protected $container;

    // Task progress details
    protected $stepDone;
    protected $status;
    protected $error;
    protected $nextParams = array();
    protected $next;

    // Estimating time end process.
    protected $estimateTime = 0;
    protected $unitTime = 0;

    public function __construct(UpgradeContainer $container)
    {
        $this->container = $container;
        $this->logger = $this->container->getLogger();
        $this->translator = $this->container->getTranslator();
        $this->checkTaskMayRun();
    }

    /**
     * @return string base64 encoded data from AjaxResponse
     */
    public function getEncodedResponse()
    {
        return call_user_func('base64_encode', $this->getJsonResponse());
    }

    /**
     * @return string Json encoded data from AjaxResponse
     */
    public function getJsonResponse()
    {
        return $this->getResponse()->getJson();
    }

    /**
     * Get result of the task and data to send to the next request.
     *
     * @return AjaxResponse
     */
    public function getResponse()
    {
        $response = new AjaxResponse($this->container->getState(), $this->logger);

        return $response->setError($this->error)
            ->setStepDone($this->stepDone)
            ->setNext($this->next)
            ->setNextParams($this->nextParams)
            ->setEstimateTime($this->getEstimateTime())
            ->setUnitTime($this->getUnitTime())
            ->setCurrentPartStep($this->getCurrentPartStep())
            ->setUpgradeConfiguration($this->container->getUpgradeConfiguration());
    }

    public function getCurrentPartStep()
    {
        $et = $this->container->getState()->getEstimateTimeByStep($this->next);
        return isset($et['part']) ? (int)$et['part'] : 0;
    }

    public function getUnitTime()
    {
        if ($this->next == 'download') {
            $this->unitTime = $this->container->getState()->getInitTime();
        } elseif ($this->stepDone) {
            $timeStepDone = time() - $this->container->getState()->getStartTime();
            $partStepsDone = $this->container->getState()->getTotalTimePartDone();
            $this->unitTime = $partStepsDone ? ($timeStepDone / $partStepsDone) : 0;
        }

        return $this->unitTime;
    }

    /**
     * @return float|int
     */
    public function getEstimateTime()
    {
        $totalPart = $this->container->getState()->getTotalTimePart();

        if ($this->next == 'download') {
            $this->estimateTime = $this->container->getState()->getInitTime() * $totalPart;
        } elseif ($this->stepDone) {
            $totalPartStep = $this->container->getState()->getTotalTimePartDone();
            $overTime = time() - $this->container->getState()->getStartTime();
            $this->estimateTime = $totalPartStep ? ($overTime / $totalPartStep) * $totalPart : 0;
        }

        return $this->estimateTime;
    }

    private function checkTaskMayRun()
    {
        // PrestaShop demo mode
        if (defined('_PS_MODE_DEMO_') && _PS_MODE_DEMO_ == true) {
            return;
        }

        $currentAction = get_class($this);
        if (isset(self::$skipAction[$currentAction])) {
            $this->next = self::$skipAction[$currentAction];
            $this->logger->info($this->translator->trans('Action %s skipped', array($currentAction), 'Modules.Etsupgrade.Admin'));
        }
    }

    public function init()
    {
        $this->container->initPrestaShopCore();
    }

    abstract public function run();

    public function handleException(UpgradeException $e)
    {
        foreach ($e->getQuickInfos() as $log) {
            $this->logger->debug($log);
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_ERROR) {
            $this->next = 'error';
            $this->error = true;
            $this->logger->error($e->getMessage());
        }
        if ($e->getSeverity() === UpgradeException::SEVERITY_WARNING) {
            $this->logger->warning($e->getMessage());
        }
    }

    public function psShopEnable($enabled = 0)
    {
        // Disable all shops.
        foreach (\Shop::getCompleteListOfShopsID() as $id_shop) {
            \Configuration::updateValue('PS_SHOP_ENABLE', (int)$enabled, false, null, (int)$id_shop);
        }
        \Configuration::updateGlobalValue('PS_SHOP_ENABLE', (int)$enabled);
    }
}
