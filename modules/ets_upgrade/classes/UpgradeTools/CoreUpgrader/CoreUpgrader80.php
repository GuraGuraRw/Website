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

declare(strict_types=1);

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\CoreUpgrader;

use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;
use PrestaShop\PrestaShop\Adapter\Module\Repository\ModuleRepository;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Domain\MailTemplate\Command\GenerateThemeMailTemplatesCommand;
use PrestaShop\PrestaShop\Core\Exception\CoreException;

class CoreUpgrader80 extends CoreUpgrader
{
    protected function initConstants()
    {
        parent::initConstants();

        //Remove services:
        if (@file_exists(($filename = _PS_ROOT_DIR_ . '/src/PrestaShopBundle/Resources/config/services/adapter/news.yml')))
            @unlink($filename);
        // Container may be needed to run upgrade scripts
        $this->container->getSymfonyAdapter()->initAppKernel();
    }

    protected function upgradeDb($oldversion)
    {
        parent::upgradeDb($oldversion);

        $commandResult = $this->container->getSymfonyAdapter()->runSchemaUpgradeCommand();
        if (0 !== $commandResult['exitCode']) {
            throw (new UpgradeException($this->container->getTranslator()->trans('Error upgrading Doctrine schema', [], 'Modules.Etsupgrade.Admin')))->setQuickInfos(explode("\n", $commandResult['output']));
        }
    }

    protected function upgradeLanguage($lang)
    {
        $isoCode = $lang['iso_code'];

        if (!\Validate::isLangIsoCode($isoCode)) {
            return;
        }
        $errorsLanguage = [];

        if (!\Language::downloadLanguagePack($isoCode, _PS_VERSION_, $errorsLanguage)) {
            throw new UpgradeException($this->container->getTranslator()->trans('Download of the language pack %lang% failed. %details%', ['%lang%' => $isoCode, '%details%' => implode('; ', $errorsLanguage)], 'Modules.Etsupgrade.Admin'));
        }

        $lang_pack = \Language::getLangDetails($isoCode);
        \Language::installSfLanguagePack($lang_pack['locale'], $errorsLanguage);

        if (!$this->container->getUpgradeConfiguration()->shouldKeepMails()) {
            $mailTheme = \Configuration::get('PS_MAIL_THEME', null, null, null, 'modern');

            $frontTheme = _THEME_NAME_;
            $frontThemeMailsFolder = _PS_ALL_THEMES_DIR_ . $frontTheme . '/mails';
            $frontThemeModulesFolder = _PS_ALL_THEMES_DIR_ . $frontTheme . '/modules';

            $generateCommand = new GenerateThemeMailTemplatesCommand(
                $mailTheme,
                $lang_pack['locale'],
                true,
                is_dir($frontThemeMailsFolder) ? $frontThemeMailsFolder : '',
                is_dir($frontThemeModulesFolder) ? $frontThemeModulesFolder : ''
            );
            /** @var CommandBusInterface $commandBus */
            $commandBus = $this->container->getModuleAdapter()->getCommandBus();

            try {
                $commandBus->handle($generateCommand);
            } catch (CoreException $e) {
                throw new UpgradeException($this->container->getTranslator()->trans('Cannot generate email templates: %s.', [$e->getMessage()], 'Modules.Etsupgrade.Admin'));
            }
        }

        if (!empty($errorsLanguage)) {
            throw new UpgradeException($this->container->getTranslator()->trans('Error while updating translations for lang %lang%. %details%', ['%lang%' => $isoCode, '%details%' => implode('; ', $errorsLanguage)], 'Modules.Etsupgrade.Admin'));
        }
        \Language::loadLanguages();

        // TODO: Update AdminTranslationsController::addNewTabs to install tabs translated
    }

    protected function disableCustomModules80()
    {
        $moduleRepository = new ModuleRepository(_PS_ROOT_DIR_, _PS_MODULE_DIR_);
        $this->container->getModuleAdapter()->disableNonNativeModules80($this->pathToPhpUpgradeScripts, $moduleRepository);
    }
}
