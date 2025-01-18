<?php

namespace Packlink\BusinessLogic\Registration\Exceptions;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Exceptions\BaseException;

/**
 * Class UnableToRegisterAccountException
 *
 * @package Packlink\BusinessLogic\Registration\Exceptions
 */
class UnableToRegisterAccountException extends BaseException
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
}
