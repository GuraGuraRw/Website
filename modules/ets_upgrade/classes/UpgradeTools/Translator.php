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

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools;

use PHPUnit\Exception;

class Translator
{
    private $caller;

    public function __construct($caller)
    {
        $this->caller = $caller;
    }

    /**
     * Translate a string to the current language.
     *
     * This methods has the same signature as the 1.7 trans method, but only relies
     *  on the module translation files.
     *
     * @param string $id Original text
     * @param array $parameters Parameters to apply
     * @param string $domain Unused
     * @param string $locale Unused
     *
     * @return string Translated string with parameters applied
     */
    public function trans($id, array $parameters = array(), $domain = 'Modules.Etsupgrade.Admin', $locale = null)
    {
        // If PrestaShop core is not instancied properly, do not try to translate
        if (!method_exists('\Context', 'getContext') || null === \Context::getContext()->language) {
            return $this->applyParameters($id, $parameters);
        }

        if (method_exists('\Translate', 'getModuleTranslation')) {
            try {
                $translated = \Translate::getModuleTranslation('ets_upgrade', $id, $this->caller, null);
            } catch (\Exception $exception) {
                $translated = $id;
            }
            if (!count($parameters)) {
                return $translated;
            }
        } else {
            $translated = $id;
        }
        unset($domain, $locale);
        return $this->applyParameters($translated, $parameters);
    }

    /**
     * @param string $id
     * @param array $parameters
     *
     * @return string Translated string with parameters applied
     *
     * @internal Public for tests
     */
    public function applyParameters($id, array $parameters = array())
    {
        // Replace placeholders for non numeric keys
        foreach ($parameters as $placeholder => $value) {
            if (is_int($placeholder)) {
                continue;
            }
            $id = str_replace($placeholder, $value, $id);
            unset($parameters[$placeholder]);
        }

        return call_user_func_array('sprintf', array_merge(array($id), $parameters));
    }
}
