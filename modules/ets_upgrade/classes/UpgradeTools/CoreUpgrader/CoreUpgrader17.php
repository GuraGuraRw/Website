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

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader;

use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;
use PrestaShop\Module\EtsAutoUpgrade\XmlUtils;
use PrestaShop\PrestaShop\Adapter\Tools;

/**
 * Class used to modify the core of PrestaShop, on the files are copied on the filesystem.
 * It will run subtasks such as database upgrade, language upgrade etc.
 */
class CoreUpgrader17 extends CoreUpgrader
{
    const SF_LANGUAGE_PACK_URL = 'http://i18n.prestashop.com/translations/%version%/%locale%/%locale%.zip';
    const EMAILS_LANGUAGE_PACK_URL = 'http://i18n.prestashop.com/mails/%version%/%locale%/%locale%.zip';

    protected function initConstants()
    {
        parent::initConstants();

        // Container may be needed to run upgrade scripts
        $this->container->getSymfonyAdapter()->initAppKernel();
    }

    protected function upgradeDb($oldversion)
    {
        parent::upgradeDb($oldversion);

        if (!$this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_SQL_VERSIONS) && version_compare($this->container->getState()->getOldVersion(), '1.7.1.1', '<')) {
            //convert data before convert type column.
            $commandResult = $this->container->getSymfonyAdapter()->runSchemaUpgradeCommand();
            if (0 !== $commandResult['exitCode']) {
                throw (new UpgradeException($this->container->getTranslator()->trans('Error upgrading Doctrine schema', array(), 'Modules.Etsupgrade.Admin')))
                    ->setQuickInfos(explode("\n", $commandResult['output']));
            }
        }
    }

    public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 600)
    {
        if ($stream_context == null && preg_match('/^https?:\/\//', $url)) {
            $stream_context = stream_context_create(array(
                "http" => array(
                    "timeout" => $curl_timeout,
                    "max_redirects" => 101,
                    "header" => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36'
                ),
                "ssl" => array(
                    "allow_self_signed" => true,
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            ));
        }
        if (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => html_entity_decode($url),
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => $curl_timeout,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_FOLLOWLOCATION => true,
            ));
            $content = curl_exec($curl);
            curl_close($curl);
            return $content;
        } elseif (in_array(ini_get('allow_url_fopen'), array('On', 'on', '1')) || !preg_match('/^https?:\/\//', $url)) {
            return Tools14::file_get_contents($url, $use_include_path, $stream_context);
        } else {
            return false;
        }
    }

    public function downloadLanguagePack($iso, $version, &$errors = array())
    {
        $iso = (string)$iso; // $iso often comes from xml and is a SimpleXMLElement

        try {
            $lang_pack = \Language::getLangDetails($iso);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }
        if (!$errors && empty($lang_pack)) {
            $errors[] = $this->container->getTranslator()->trans('Sorry this language is not available', array(), 'Modules.Etsupgrade.Admin');
        } else {
            $this->downloadXLFLanguagePack($lang_pack['locale'], $errors, 'sf');
        }
        unset($version);

        return !count($errors);
    }

    public function downloadXLFLanguagePack($locale, &$errors = array(), $type = 'sf')
    {
        $file = _PS_TRANSLATIONS_DIR_ . $type . '-' . $locale . '.zip';
        $url = ('emails' === $type) ? self::EMAILS_LANGUAGE_PACK_URL : self::SF_LANGUAGE_PACK_URL;
        $url = str_replace(
            array(
                '%version%',
                '%locale%',
            ),
            array(
                _PS_VERSION_,
                $locale,
            ),
            $url
        );

        if (!is_writable(dirname($file))) {
            // @todo Throw exception
            $errors[] = $this->container->getTranslator()->trans('Server does not have permissions for writing.', array(), 'Modules.Etsupgrade.Admin') . ' (' . $file . ')';
        } elseif ($content = self::file_get_contents($url)) {
            @file_put_contents($file, $content);
        } else {
            $errors[] = $this->container->getTranslator()->trans('Language pack unavailable.', array(), 'Modules.Etsupgrade.Admin') . ' ' . $url;
        }
    }

    protected function upgradeLanguage($lang)
    {
        $isoCode = $lang['iso_code'];

        if (!\Validate::isLangIsoCode($isoCode)) {
            return;
        }
        $errorsLanguage = array();

        if (!$this->downloadLanguagePack($isoCode, _PS_VERSION_, $errorsLanguage)) {

            throw (new UpgradeException(
                $this->container->getTranslator()->trans(
                    'Download of the language pack %lang% failed. %details%',
                    [
                        '%lang%' => $isoCode,
                        '%details%' => implode('; ', $errorsLanguage),
                    ],
                    'Modules.Etsupgrade.Admin'
                )
            ))->setSeverity(UpgradeException::SEVERITY_WARNING);
        }

        try {
            $lang_pack = \Language::getLangDetails($isoCode);
        } catch (\Exception $e) {
            throw (new UpgradeException($this->container->getTranslator()->trans('Language pack unavailable.', array(), 'Modules.Etsupgrade.Admin')))
                ->setQuickInfos($e->getMessage())
                ->setSeverity(UpgradeException::SEVERITY_WARNING);
        }

        \Language::installSfLanguagePack($lang_pack['locale'], $errorsLanguage);
        $this->updateTabMultilangTable($lang_pack['locale']);

        if (!$this->container->getUpgradeConfiguration()->shouldKeepMails()) {
            \Language::installEmailsLanguagePack($lang_pack, $errorsLanguage);
        }

        if (!empty($errorsLanguage)) {
            throw (new UpgradeException(
                $this->container->getTranslator()->trans(
                    'Error while updating translations for lang %lang%. %details%',
                    [
                        '%lang%' => $isoCode,
                        '%details%' => implode('; ', $errorsLanguage),
                    ],
                    'Modules.Etsupgrade.Admin'
                )
            ))->setSeverity(UpgradeException::SEVERITY_WARNING);
        }
        \Language::loadLanguages();

        // TODO: Update AdminTranslationsController::addNewTabs to install tabs translated

        // CLDR has been updated on PS 1.7.6.0. From this version, updates are not needed anymore.
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.6.0', '<')) {
            $cldrUpdate = new \PrestaShop\PrestaShop\Core\Cldr\Update(_PS_TRANSLATIONS_DIR_);
            $cldrUpdate->fetchLocale(\Language::getLocaleByIso($isoCode));
        }
    }

    public function updateTabMultilangTable($locale, $domain = 'Admin.Navigation.Menu')
    {
        if (!$locale)
            return;
        $domain = str_replace('.', '', $domain);
        $resource = _PS_ROOT_DIR_ . '/app/Resources/translations/' . $locale . '/' . $domain . '.' . $locale . '.xlf';
        $dom = XmlUtils::loadFile($resource);

        if ($trans = $this->extractXliff1($dom)) {
            $id_lang = (int)\Db::getInstance()->getValue('SELECT `id_lang` FROM `' . _DB_PREFIX_ . 'lang` WHERE `locale` = \'' . pSQL(\Tools::strtolower($locale)) . '\'');//\Language::getIdByLocale($locale) ;
            $query = '';
            foreach ($trans as $source => $target) {
                $query .= 'UPDATE `' . _DB_PREFIX_ . 'tab_lang` SET `name`=\'' . pSQL($target) . '\' WHERE MD5(TRIM(name))=\'' . pSQL(trim(md5($source))) . '\' AND id_lang=' . (int)$id_lang . ';';
            }
            if ($query)
                \Db::getInstance()->execute($query);
        }

        return true;
    }

    private function extractXliff1(\DOMDocument $dom)
    {
        $xml = simplexml_import_dom($dom);
        $encoding = \Tools::strtoupper($dom->encoding);

        $xml->registerXPathNamespace('xliff', 'urn:oasis:names:tc:xliff:document:1.2');
        $trans = [];
        foreach ($xml->xpath('//xliff:trans-unit') as $translation) {
            if (!isset($translation->source)) {
                continue;
            }
            $source = (string)$translation->source;
            // If the xlf file has another encoding specified, try to convert it because
            // simple_xml will always return utf-8 encoded values
            $target = $this->utf8ToCharset((string)(isset($translation->target) ? $translation->target : $translation->source), $encoding);
            $trans[$source] = $target;
        }
        return $trans;
    }

    private function utf8ToCharset($content, $encoding = null)
    {
        if ('UTF-8' !== $encoding && !empty($encoding)) {
            return mb_convert_encoding($content, $encoding, 'UTF-8');
        }

        return $content;
    }
}
