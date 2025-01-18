<?php

namespace Packlink\BusinessLogic\Registration;

if (!defined('_PS_VERSION_')) {
    exit;
}

interface RegistrationInfoService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Returns registration data from the integration.
     *
     * @return RegistrationInfo
     */
    public function getRegistrationInfoData();
}
