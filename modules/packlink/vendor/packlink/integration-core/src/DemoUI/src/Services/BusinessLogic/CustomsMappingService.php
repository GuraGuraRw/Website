<?php

namespace Packlink\DemoUI\Services\BusinessLogic;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Packlink\BusinessLogic\Customs\CustomsMappingService as BaseCustomsService;

class CustomsMappingService extends BaseCustomsService
{

    /**
     * @inheritDoc
     */
    public function getReceiverTaxIdOptions()
    {
        return array(
            array(
                'value' => 'tax_id_1',
                'name' => 'Tax ID 1',
            ),
            array(
                'value' => 'tax_id_2',
                'name' => 'Tax ID 2',
            ),
            array(
                'value' => 'tax_id_3',
                'name' => 'Tax ID 3',
            )
        );
    }
}
