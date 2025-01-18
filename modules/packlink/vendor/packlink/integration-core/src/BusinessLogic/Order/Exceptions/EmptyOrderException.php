<?php

namespace Packlink\BusinessLogic\Order\Exceptions;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Exceptions\BaseException;

/**
 * Class EmptyOrderException
 *
 * @package Packlink\BusinessLogic\Order\Exceptions
 */
class EmptyOrderException extends BaseException
{
}
