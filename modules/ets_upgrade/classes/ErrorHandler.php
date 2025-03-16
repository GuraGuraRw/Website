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

use PrestaShop\Module\EtsAutoUpgrade\Log\LegacyLogger;
use PrestaShop\Module\EtsAutoUpgrade\Log\Logger;

/**
 * In order to improve the debug of the module in case of case, we need to display the missed errors
 * directly on the user interface. This will allow a merchant to know what happened, without having to open
 * his PHP logs.
*/
class ErrorHandler
{
    /**
     * @var Logger
    */
    private $logger;

    /**
     * @param Logger $logger
    */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Enable error handlers for critical steps.
     * Display hidden errors by PHP config to improve debug process.
    */
    public function enable()
    {
        error_reporting(E_ALL);
        set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array($this, 'exceptionHandler'));
        register_shutdown_function(array($this, 'fatalHandler'));
    }

    /**
     * Function retrieving uncaught exceptions.
     *
     * @param \Throwable $e
    */
    public function exceptionHandler($e)
    {
        $message = get_class($e) . ': ' . $e->getMessage();
        $this->report($e->getFile(), $e->getLine(), Logger::CRITICAL, $message, $e->getTraceAsString(), true);
    }

    /**
     * Function called by PHP errors, forwarding content to the ajax response.
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     *
     * @return bool
    */
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        switch ($errno) {
            case E_USER_ERROR:
                return false; // Will be taken by fatalHandler
            case E_USER_WARNING:
            case E_WARNING:
                $type = Logger::WARNING;
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $type = Logger::NOTICE;
                break;
            default:
                $type = Logger::DEBUG;
                break;
        }

        $this->report($errfile, $errline, $type, $errstr);

        return true;
    }

    /**
     * Fatal error from PHP are not taken by the error_handler. We must check if an error occured
     * during the script shutdown.
    */
    public function fatalHandler()
    {
        $lastError = error_get_last();
        $trace = isset($lastError['backtrace']) ? var_export($lastError['backtrace'], true) : null;
        if ($lastError && in_array($lastError['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR), true)) {
            $this->report($lastError['file'], $lastError['line'], Logger::CRITICAL, $lastError['message'], $trace, true);
        }
    }

    /**
     * Create a json encoded.
     *
     * @param string $log
     *
     * @return string
    */
    public function generateJsonLog($log)
    {
        return json_encode(array(
            'nextQuickInfo' => $this->logger->getInfos(),
            'nextErrors' => array_merge($this->logger->getErrors(), array($log)),
            'error' => true,
            'next' => 'error',
        ));
    }

    /**
     * Forwards message to the main class of the upgrade.
     *
     * @param string $file
     * @param int $line
     * @param int $type Level of criticity
     * @param string $message
     * @param bool $display
    */
    protected function report($file, $line, $type, $message, $trace = null, $display = false)
    {
        if ($type >= Logger::CRITICAL) {
            http_response_code(500);
        }
        $log = "[INTERNAL] $file line $line - $message";
        if (!empty($trace)) {
            $log .= PHP_EOL . $trace;
        }
        $jsonResponse = $this->generateJsonLog($log);

        try {
            $this->logger->log($type, $log);
            if ($display && $this->logger instanceof LegacyLogger) {
                echo $jsonResponse;
            }
        } catch (\Exception $e) {
            echo $jsonResponse;

            $fd = fopen('php://stderr', 'w');
            fwrite($fd, $log);
            fclose($fd);
        }
    }
}
