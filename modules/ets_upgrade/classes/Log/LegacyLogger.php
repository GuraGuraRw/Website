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
 * This class reimplement the old properties of the class EtsAdminSelfUpgrade,
 * where all the mesages were stored.
*/
class LegacyLogger extends Logger
{
    protected $normalMessages = array();
    protected $severeMessages = array();
    protected $lastInfo = '';

    /**
     * @var resource|false|null File descriptor of the log file
    */
    protected $fd;

    public function __construct($fileName = null)
    {
        if (null !== $fileName) {
            $this->fd = fopen($fileName, 'a');
        }
    }

    public function __destruct()
    {
        if (is_resource($this->fd)) {
            fclose($this->fd);
        }
    }

    /**
     * {@inheritdoc}
    */
    public function getErrors()
    {
        return $this->severeMessages;
    }

    /**
     * {@inheritdoc}
    */
    public function getInfos()
    {
        return $this->normalMessages;
    }

    /**
     * {@inheritdoc}
    */
    public function getLastInfo()
    {
        return $this->lastInfo;
    }

    /**
     * {@inheritdoc}
    */
    public function log($level, $message, array $context = array())
    {
        if (empty($message)) {
            return;
        }

        if (is_resource($this->fd)) {
            fwrite($this->fd, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL);
        }

        // Specific case for INFO
        if ($level === self::INFO) {
            // If last info is already defined, move it to the messages list
            if (!empty($this->lastInfo)) {
                $this->normalMessages[] = $this->lastInfo;
            }
            $this->lastInfo = $message;

            return;
        }

        if ($level < self::ERROR) {
            $this->normalMessages[] = $message;
        } else {
            $this->severeMessages[] = $message;
        }
    }
}
