<?php

namespace Logeecom\Infrastructure\TaskExecution\Interfaces;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Interface TaskRunnerWakeup.
 *
 * @package Logeecom\Infrastructure\TaskExecution\Interfaces
 */
interface TaskRunnerWakeup
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Wakes up TaskRunner instance asynchronously if active instance is not already running.
     */
    public function wakeup();
}
