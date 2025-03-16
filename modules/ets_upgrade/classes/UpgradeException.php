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

namespace PrestaShop\Module\EtsAutoUpgrade;

/**
 * Todo: Should we create a UpgradeWarning class instead of setting the severity here?
*/
class UpgradeException extends \Exception
{
    const SEVERITY_ERROR = 1;
    const SEVERITY_WARNING = 2;

    private $quickInfos = array();

    private $severity = self::SEVERITY_ERROR;

    public function getQuickInfos()
    {
        return $this->quickInfos;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function addQuickInfo($quickInfo)
    {
        $this->quickInfos[] = $quickInfo;

        return $this;
    }

    public function setQuickInfos(array $quickInfos)
    {
        $this->quickInfos = $quickInfos;

        return $this;
    }

    public function setSeverity($severity)
    {
        $this->severity = (int) $severity;

        return $this;
    }
}
