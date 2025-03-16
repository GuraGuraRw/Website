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

namespace PrestaShop\Module\EtsAutoUpgrade\Log;

/**
 * This class retrieves all message to display during the upgrade / rollback tasks.
*/
abstract class Logger implements LoggerInterface
{
    const DEBUG = 1;
    const INFO = 2;
    const NOTICE = 3;
    const WARNING = 4;
    const ERROR = 5;
    const CRITICAL = 6;
    const ALERT = 7;
    const EMERGENCY = 8;

    protected static $levels = array(
        self::DEBUG => 'DEBUG',
        self::INFO => 'INFO',
        self::NOTICE => 'NOTICE',
        self::WARNING => 'WARNING',
        self::ERROR => 'ERROR',
        self::CRITICAL => 'CRITICAL',
        self::ALERT => 'ALERT',
        self::EMERGENCY => 'EMERGENCY',
    );

    public function alert($message, array $context = array())
    {
        $this->log(self::ALERT, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }

    public function emergency($message, array $context = array())
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log(self::ERROR, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->log(self::NOTICE, $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->log(self::WARNING, $message, $context);
    }

    /**
     * Equivalent of the old $nextErrors
     * Used during upgrade. Will be displayed in the top right panel (not visible at the beginning).
     *
     * @var array Details of error which occured during the request. Verbose levels: ERROR
    */
    public function getErrors()
    {
        return array();
    }

    /**
     * Equivalent of the old $nextQuickInfo
     * Used during upgrade. Will be displayed in the lower panel.
     *
     * @var array Details on what happened during the execution. Verbose levels: DEBUG / INFO / WARNING
    */
    public function getInfos()
    {
        return array();
    }

    /**
     * Return the last message stored with the INFO level.
     * Equivalent of the old $next_desc
     * Used during upgrade. Will be displayed on the top left panel.
     *
     * @var string Stores the main information about the current step
    */
    public function getLastInfo()
    {
        return '';
    }
}
