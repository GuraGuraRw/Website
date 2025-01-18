<?php

namespace Packlink\DemoUI\Controllers;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packlink\BusinessLogic\Controllers\AutoConfigurationController;

/**
 * Class AutoConfigureController.
 *
 * @package Packlink\DemoUI\Controllers
 */
class AutoConfigureController extends BaseHttpController
{
    /**
     * Starts the auto-configuration process.
     */
    public function start()
    {
        $controller = new AutoConfigurationController();

        $this->output(array('success' => $controller->start(true)));
    }
}
