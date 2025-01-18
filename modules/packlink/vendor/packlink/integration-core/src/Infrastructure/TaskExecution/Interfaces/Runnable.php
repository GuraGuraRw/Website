<?php

namespace Logeecom\Infrastructure\TaskExecution\Interfaces;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Serializer\Interfaces\Serializable;

/**
 * Interface Runnable.
 *
 * @package Logeecom\Infrastructure\TaskExecution\Interfaces
 */
interface Runnable extends Serializable
{
    /**
     * Starts runnable run logic
     */
    public function run();
}
