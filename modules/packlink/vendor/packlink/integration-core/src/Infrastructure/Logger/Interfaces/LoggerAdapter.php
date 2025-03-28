<?php

namespace Logeecom\Infrastructure\Logger\Interfaces;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Logger\LogData;

/**
 * Interface LoggerAdapter.
 *
 * @package Logeecom\Infrastructure\Logger\Interfaces
 */
interface LoggerAdapter
{
    /**
     * Log message in system
     *
     * @param LogData $data
     */
    public function logMessage(LogData $data);
}
