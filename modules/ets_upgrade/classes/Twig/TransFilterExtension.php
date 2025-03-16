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

namespace PrestaShop\Module\EtsAutoUpgrade\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

class TransFilterExtension extends Twig_Extension
{
    const DOMAIN = 'Modules.Etsupgrade.Admin';

    private $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('trans', array($this, 'trans')),
        );
    }

    public function trans($string, $params = array())
    {
        return $this->translator->trans($string, $params, self::DOMAIN);
    }
}
