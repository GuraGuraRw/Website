<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/

namespace PrestaShop\Module\EtsAutoUpgrade\Log;

/**
 * Logger to use when the messages can be seen as soon as they are created.
 * For instance, in a CLI context.
*/
class StreamedLogger extends Logger
{
    /**
     * @var int Minimum criticity of level to display
    */
    protected $filter = self::INFO;

    /**
     * @var resource File handler of standard output
    */
    protected $out;

    /**
     * @var resource File handler of standard error
    */
    protected $err;

    public function __construct()
    {
        $this->out = fopen('php://stdout', 'w');
        $this->err = fopen('php://stderr', 'w');
    }

    public function __destruct()
    {
        fclose($this->out);
        fclose($this->err);
    }

    /**
     * Check the verbosity allows the message to be displayed.
     *
     * @param int $level
     *
     * @return bool
    */
    public function isFiltered($level)
    {
        return $level < $this->filter;
    }

    /**
     * {@inherit}.
    */
    public function log($level, $message, array $context = array())
    {
        if (empty($message)) {
            return;
        }

        $log = self::$levels[$level] . ' - ' . $message . PHP_EOL;

        if ($level > self::ERROR) {
            fwrite($this->err, $log);
        }

        if (!$this->isFiltered($level)) {
            fwrite($this->out, $log);
        }
    }

    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the verbosity of the logger.
     *
     * @param int $filter
     *
     * @return $this
    */
    public function setFilter($filter)
    {
        if (!array_key_exists($filter, self::$levels)) {
            throw new \Exception('Unknown level ' . $filter);
        }
        $this->filter = $filter;

        return $this;
    }
}
