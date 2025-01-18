<?php

namespace Logeecom\Infrastructure\Utility\Events;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class Event.
 *
 * @package Logeecom\Infrastructure\Utility\Events
 */
abstract class Event
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
}
