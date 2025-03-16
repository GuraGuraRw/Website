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

//use PrestaShopBundle\Install\Install;
use PrestaShop\PrestaShop\Adapter\Entity\Language;
use PrestaShopBundle\Install\LanguageList;
use PrestaShopBundle\Install\XmlLoader;

/**
 * Migrate BO tabs for 1.7 (new reorganization of BO)
 */
function migrate_tabs_17()
{
    include_once _PS_INSTALL_PATH_ . 'upgrade/php/add_new_tab.php';

    /* first make some room for new tabs */
    $moduleTabs = Db::getInstance()->executeS(
        'SELECT id_parent FROM `' . _DB_PREFIX_ . 'tab` WHERE `module` IS NOT NULL AND `module` != \'\' ORDER BY `id_tab` ASC'
    );

    $moduleParents = array();

    if ($moduleTabs) {
        foreach ($moduleTabs as $tab) {
            $idParent = $tab['id_parent'];
            $moduleParents[$idParent] = Db::getInstance()->getValue('SELECT `class_name` FROM `' . _DB_PREFIX_ . 'tab` WHERE id_tab=' . $idParent);
        }
    }

    /* delete the old structure */
    Db::getInstance()->execute(
        'DELETE t, tl FROM `' . _DB_PREFIX_ . 'tab` t JOIN `' . _DB_PREFIX_ . 'tab_lang` tl ON (t.id_tab=tl.id_tab) WHERE `module` IS NULL OR `module` = \'\''
    );

    /* Add new column enabled if not exits*/
    if (!Db::getInstance()->executeS('SHOW COLUMNS FROM `' . _DB_PREFIX_ . 'tab_lang` LIKE \'enabled\';')) {
        Db::getInstance()->execute('ALTER TABLE `' . _DB_PREFIX_ . 'tab_lang` ADD `enabled` TINYINT(1) NOT NULL DEFAULT \'0\';');
    }

    $defaultLanguage = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
    $languageList = LanguageList::getInstance();
    $isoList = $languageList->getIsoList();
    if (
        is_array($isoList)
        && count($isoList) > 0
        && !in_array($defaultLanguage->iso_code, $isoList)
    ) {
        if ($idLang = (int)Db::getInstance()->getValue('SELECT `id_lang` FROM `' . _DB_PREFIX_ . 'lang` WHERE `iso_code` !=\'' . pSQL($defaultLanguage->iso_code) . '\' AND `iso_code` IN (' . implode(',', array_map(function ($iso_code) {
                return '\'' . trim($iso_code) . '\'';
            }, $isoList)) . ')')
        ) {
            Configuration::updateValue('PS_LANG_DEFAULT', $idLang);
            $defaultLanguage = new Language($idLang);
        } elseif (
            ($languages = $languageList->getLanguages())
            && is_array($languages)
            && count($languages) > 0
        ) {
            if (
                isset($languages['en'])
                && $languages['en'] instanceof PrestaShopBundle\Install\Language
                && trim($languages['en']->iso_code) !== ''
            ) {
                $language = $languages['en'];
            } else {
                $language = current($languages);
            }
            if ($language) {
                $defaultLanguage->iso_code = $language->iso_code;
                $defaultLanguage->locale = $language->locale;
                $defaultLanguage->language_code = $language->language_code;
                $defaultLanguage->update();
            }
        }
    }
    $languageList->setLanguage($defaultLanguage->iso_code);

    /* insert the new structure */
    ProfileCore::resetCacheAccesses();
    LanguageCore::resetCache();
    if (!populateTab()) {
        return false;
    }
    /* update remaining idParent */
    if ($moduleParents) {
        foreach ($moduleParents as $idParent => $className) {
            if (!empty($className)) {
                $idTab = Db::getInstance()->getValue('SELECT id_tab FROM ' . _DB_PREFIX_ . 'tab WHERE class_name="' . pSQL($className) . '"');
                Db::getInstance()->execute('UPDATE ' . _DB_PREFIX_ . 'tab SET id_parent=' . (int) $idTab . ' WHERE id_parent=' . (int) $idParent);
            }
        }
    }
}

function populateTab()
{
    $languages = [];
    foreach (Language::getLanguages() as $lang) {
        $languages[$lang['id_lang']] = $lang['iso_code'];
    }

    // Because we use 1.7.7+ files but with a not-yet migrated Tab entity, we need to use
    // a custom XmlLoader to remove the `enabled` key before inserting to the DB
    $xml_loader = new \XmlLoader1700();
    $xml_loader->setTranslator(Context::getContext()->getTranslator());
    $xml_loader->setLanguages($languages);

    try {
        $xml_loader->populateEntity('tab');
    } catch (PrestashopInstallerException $e) {
        return false;
    }

    return true;
}

class XmlLoader1700 extends XmlLoader
{
    public function createEntityTab($identifier, array $data, array $data_lang)
    {
        if (isset($data['enabled'])) {
            unset($data['enabled']);
        }
        if (isset($data['wording'])) {
            unset($data['wording']);
        }
        if (isset($data['wording_domain'])) {
            unset($data['wording_domain']);
        }
        parent::createEntityTab($identifier, $data, $data_lang);
    }
}