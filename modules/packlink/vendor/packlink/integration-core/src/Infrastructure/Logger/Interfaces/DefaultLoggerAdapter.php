<?php

namespace Logeecom\Infrastructure\Logger\Interfaces;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Interface DefaultLoggerAdapter.
 *
 * @package Logeecom\Infrastructure\Logger\Interfaces
 */
interface DefaultLoggerAdapter extends LoggerAdapter
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;
}
