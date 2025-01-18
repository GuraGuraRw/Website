<?php

namespace Packlink\DemoUI\Controllers;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packlink\BusinessLogic\Controllers\SystemInfoController as CoreSystemInfoController;

/**
 * Class SystemInfoController
 */
class SystemInfoController extends BaseHttpController
{
    /**
     * @var CoreSystemInfoController
     */
    private $controller;

    /**
     * DebugController constructor.
     */
    public function __construct()
    {
        $this->controller = new CoreSystemInfoController();
    }

    public function get()
    {
        $this->outputDtoEntities($this->controller->get());
    }
}
