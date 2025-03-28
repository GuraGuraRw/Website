<?php

namespace Packlink\DemoUI\Services\Infrastructure;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Logger\Interfaces\ShopLoggerAdapter;
use Logeecom\Infrastructure\Logger\LogData;

/**
 * Class LoggerService
 *
 * @package Packlink\PacklinkPro\Services\Infrastructure
 */
class LoggerService implements ShopLoggerAdapter
{
    /**
     * Logs message in the system.
     *
     * @param LogData $data
     */
    public function logMessage(LogData $data)
    {

    }
}
