<?php

namespace Packlink\BusinessLogic\ShipmentDraft\Exceptions;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Exceptions\BaseException;

/**
 * Class DraftTaskMapAlreadyExists.
 *
 * @package Packlink\BusinessLogic\ShipmentDraft\Exceptions
 */
class DraftTaskMapExists extends BaseException
{
}
