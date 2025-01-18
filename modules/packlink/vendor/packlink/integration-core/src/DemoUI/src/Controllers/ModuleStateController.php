<?php

namespace Packlink\DemoUI\Controllers;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class ModuleStateController.
 *
 * @package Packlink\DemoUI\Controllers
 */
class ModuleStateController extends BaseHttpController
{
    /**
     * @var bool
     */
    protected $requiresAuthentication = false;

    /**
     * Gets current app state.
     */
    public function getCurrentState()
    {
        $controller = new \Packlink\BusinessLogic\Controllers\ModuleStateController();

        $this->output($controller->getCurrentState()->toArray());
    }
}
