<?php

namespace Logeecom\Infrastructure\Logger\Interfaces;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Interface ShopLoggerAdapter.
 *
 * @package Logeecom\Infrastructure\Logger\Interfaces
 */
interface ShopLoggerAdapter extends LoggerAdapter
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;
}
