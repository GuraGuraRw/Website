<?php


namespace Packlink\BusinessLogic\Brand;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packlink\BusinessLogic\Brand\DTO\BrandConfiguration;

/**
 * Interface BrandConfigurationService
 *
 * @package Packlink\BusinessLogic\Brand
 */
interface BrandConfigurationService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Retrieves BrandConfiguration.
     *
     * @return BrandConfiguration
     */
    public function get();
}
