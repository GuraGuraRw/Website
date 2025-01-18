<?php

namespace Logeecom\Infrastructure\Http\Exceptions;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Logeecom\Infrastructure\Exceptions\BaseException;

/**
 * Class HttpBaseException. All Http exceptions should inherit from this class.
 *
 * @package Logeecom\Infrastructure\Utility\Exceptions
 */
class HttpBaseException extends BaseException
{
}
