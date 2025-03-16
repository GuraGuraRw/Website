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

use PrestaShop\Module\EtsAutoUpgrade\Log\Logger;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\PrestaShop\Core\Domain\Theme\Exception\FailedToEnableThemeModuleException;
use PrestaShopDatabaseException;

class ThemeAdapter
{
    /**
     * @var UpgradeContainer
     */
    private $container;
    private $upgradeVersion;

    /**
     * @var Logger
     */
    protected $logger;

    public function __construct($upgradeVersion, UpgradeContainer $container, Logger $logger)
    {
        $this->upgradeVersion = $upgradeVersion;
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * Enable the given theme on the shop.
     *
     * @param string $themeName
     *
     * @return mixed
     */
    public function enableTheme($themeName)
    {
        return version_compare($this->upgradeVersion, '1.7.0.0', '>=') ?
            $this->enableTheme17($themeName) :
            $this->enableTheme16($themeName);
    }

    /**
     * Get the default theme name provided with PrestaShop.
     *
     * @return string
     */
    public function getDefaultTheme()
    {
        return version_compare($this->upgradeVersion, '1.7.0.0', '>=') ?
            'classic' : // 1.7
            'default-bootstrap'; // 1.6
    }

    /**
     * Use 1.7 theme manager is order to enable the new theme.
     *
     * @param string $themeName
     *
     * @return bool|array
     */
    private function enableTheme17($themeName)
    {
        $themeManager = $this->getThemeManager();

        try {
            if ($this->uninstallModules()) {
                $isThemeEnabled = $themeManager->enable($themeName);
                if (!$isThemeEnabled) {
                    $errors = $themeManager->getErrors($themeName);

                    return $errors ? $errors : 'Unknown error';
                }
            }
        } catch (\PrestaShopException $prestaShopException) {
            $this->logger->warning($this->container->getTranslator()->trans('Error:') . ' ' . $prestaShopException->getMessage());
        } catch (PrestaShopDatabaseException $prestaShopDatabaseException) {
            $this->logger->warning($this->container->getTranslator()->trans('Error:') . ' ' . $prestaShopDatabaseException->getMessage());
        } catch (FailedToEnableThemeModuleException $failedToEnableThemeModuleException) {
            $this->logger->warning($this->container->getTranslator()->trans('Error:') . ' ' . $failedToEnableThemeModuleException->getMessage());
        } catch (\Exception $exception) {
            $this->logger->warning($this->container->getTranslator()->trans('Error:') . ' ' . $exception->getMessage());
        }

        return true;
    }

    public function uninstallModules()
    {
        if (version_compare($this->upgradeVersion, '1.7.0.0', '>=')) {
            $modules = [
                'blockbanner',
                'blocktopmenu',
            ];
            $res = true;
            foreach ($modules as $module) {
                if (trim($module) == 'blocktopmenu' && \Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'module` WHERE `name`=\'' . pSQL($module) . '\'')) {
                    \Cache::clean('Module::isInstalled' . $module);
                    \Cache::clean('Module::getModuleIdByName_' . pSQL($module));
                } else
                    $res &= $this->parentUninstallClosureModule($module);
            }
            return $res;
        }
        return true;
    }

    private function parentUninstallClosureModule($moduleName)
    {
        $this->logger->info($this->container->getTranslator()->trans('parentUninstallClosureModule %s', array($moduleName), 'Module.EtsUpgrade.Admin'));
        if (trim($moduleName) == '' || !\Validate::isModuleName($moduleName)) {
            return true;
        }
        if (!\Module::isInstalled($moduleName))
            return true;
        $this->logger->info($this->container->getTranslator()->trans('UninstallClosure %s start!', array($moduleName), 'Module.EtsUpgrade.Admin'));
        try {
            if (trim($moduleName) == 'blockbanner') {
                // Data migration
                \Configuration::updateValue('BANNER_IMG', \Configuration::getConfigInMultipleLangs('BLOCKBANNER_IMG'));
                \Configuration::updateValue('BANNER_LINK', \Configuration::getConfigInMultipleLangs('BLOCKBANNER_LINK'));
                \Configuration::updateValue('BANNER_DESC', \Configuration::getConfigInMultipleLangs('BLOCKBANNER_DESC'));
            }
            $oldModule = \Module::getInstanceByName($moduleName);
            if ($oldModule) {
                $this->logger->info($this->container->getTranslator()->trans('UninstallClosure %s is ready!', array($moduleName), 'Module.EtsUpgrade.Admin'));
                $parentUninstallClosure = function () {
                    return parent::uninstall();
                };
                $parentUninstallClosure = $parentUninstallClosure->bindTo($oldModule, get_class($oldModule));
                $parentUninstallClosure();
                $this->logger->info($this->container->getTranslator()->trans('parentUninstallClosure %s is successfully', array($moduleName), 'Module.EtsUpgrade.Admin'));
            } elseif (\Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'module` WHERE `name`=\'' . pSQL($moduleName) . '\'')) {
                \Cache::clean('Module::isInstalled' . $moduleName);
                \Cache::clean('Module::getModuleIdByName_' . pSQL($moduleName));
            }
        } catch (\Exception $exception) {
            if (\Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'module` WHERE `name`=\'' . pSQL($moduleName) . '\'')) {
                \Cache::clean('Module::isInstalled' . $moduleName);
                \Cache::clean('Module::getModuleIdByName_' . pSQL($moduleName));
            }
            $this->logger->warning($this->container->getTranslator()->trans('Error:') . ' ' . $exception->getMessage());

            return true;
        }

        return true;
    }

    private function getThemeManager()
    {
        return (new \PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder(\Context::getContext(), $this->container->getDb()))->build();
    }

    /**
     * Backward compatibility function for theme enabling.
     *
     * @param string $themeName
     * @return bool
     */
    private function enableTheme16($themeName)
    {
        $db = $this->container->getDb();
        if ($id_theme = (int)$db->getValue('SELECT id_theme FROM `' . _DB_PREFIX_ . 'theme` WHERE name LIKE \'' . $themeName . '\'')) {
            if ($this->container->getUpgradeConfiguration()->shouldSwitchToDefaultTheme()) {
                $this->doInstallTheme($id_theme);
            }
            $db->execute('UPDATE `' . _DB_PREFIX_ . 'shop` SET id_theme = ' . (int)$id_theme);
            $db->execute('DELETE FROM `' . _DB_PREFIX_ . 'theme` WHERE  name LIKE \'default\' OR name LIKE \'prestashop\'');
        }

        return true;
    }

    public function doInstallTheme($id_theme)
    {
        //defines
        $translator = $this->container->getTranslator();
        $shops_asso = \Shop::getShops();

        $this->logger->info($translator->trans('Theme installing...', array(), 'Module.EtsUpgrade.Admin'));

        $theme = new \Theme((int)$id_theme);

        if (count($shops_asso) == 1) {
            $shops = array();
            foreach ($shops_asso as $shop) {
                $shops[] = (int)$shop['id_shop'];
            }
        } else {
            $shops = array(\Configuration::get('PS_SHOP_DEFAULT'));
        }

        $xml = false;
        if (file_exists(_PS_ROOT_DIR_ . '/config/xml/themes/' . $theme->directory . '.xml')) {
            $xml = @simplexml_load_file(_PS_ROOT_DIR_ . '/config/xml/themes/' . $theme->directory . '.xml');
        } elseif (file_exists(_PS_ROOT_DIR_ . '/config/xml/themes/default.xml')) {
            $xml = @simplexml_load_file(_PS_ROOT_DIR_ . '/config/xml/themes/default.xml');
        }

        if ($xml) {
            $module_hook = array();
            foreach ($xml->modules->hooks->hook as $row) {
                $name = (string)$row['module'];
                $module_hook[$name]['hook'][] = array(
                    'hook' => (string)$row['hook'],
                    'position' => (string)$row['position'],
                );
            }

            $modules = array();
            foreach ($xml->modules->module as $element) {
                $name = (string)$element['name'];
                $modules[(string)$element['action'] . $name] = $name;
            }

            $this->updateImages($xml);

            foreach ($shops as $id_shop) {
                foreach ($modules as $key => $value) {
                    if (strpos($key, 'enable') == 0) {
                        $module = \Module::getInstanceByName($value);
                        if ($module) {
                            $module->ps_versions_compliancy = array('min' => _PS_VERSION_, 'max' => '1.6.99.99');
                            $is_installed_success = true;
                            if (!\Module::isInstalled($module->name)) {
                                try {
                                    $is_installed_success = $module->install();
                                } catch (PrestaShopDatabaseException $prestaShopDatabaseException) {
                                    $this->logger->warning($translator->trans('Error:') . ' ' . $prestaShopDatabaseException->getMessage());
                                }
                            }

                            if ($is_installed_success) {
                                if (!\Module::isEnabled($module->name)) {
                                    $module->enable();
                                }

                                if ((int)$module->id > 0 && isset($module_hook[$module->name])) {
                                    $this->hookModule($module->id, $module_hook[$module->name], $id_shop);
                                }
                            } else {
                                $this->logger->warning($translator->trans('Enable module %s error: ', array($module->name), 'Module.EtsUpgrade.Admin') . implode(';', $module->getErrors()));
                            }

                            unset($module_hook[$module->name]);
                        }
                    } elseif (strpos($key, 'disable') == 0) {
                        $module_obj = \Module::getInstanceByName($value);
                        if (\Validate::isLoadedObject($module_obj)) {
                            if (\Module::isEnabled($module_obj->name)) {
                                $module_obj->disable();
                            }

                            unset($module_hook[$module_obj->name]);
                        }
                    }
                }
                if (\Shop::isFeatureActive()) {
                    \Configuration::updateValue('PS_PRODUCTS_PER_PAGE', (int)$theme->product_per_page, false, null, (int)$id_shop);
                } else {
                    \Configuration::updateValue('PS_PRODUCTS_PER_PAGE', (int)$theme->product_per_page);
                }
            }

            $this->updateMetas($xml, $theme);
        }
    }

    private function hookModule($id_module, $module_hooks, $shop)
    {
        $db = $this->container->getDb();
        $db->execute('INSERT IGNORE INTO `' . _DB_PREFIX_ . 'module_shop` (id_module, id_shop) VALUES(' . (int)$id_module . ', ' . (int)$shop . ')');
        $db->execute('DELETE FROM `' . _DB_PREFIX_ . 'hook_module` WHERE `id_module` = ' . (int)$id_module . ' AND id_shop = ' . (int)$shop);

        foreach ($module_hooks as $hooks) {
            foreach ($hooks as $hook) {
                $id_hook = (int)\Hook::getIdByName($hook['hook']);
                // If hook does not exist, we create it
                if (!$id_hook) {
                    $new_hook = new \Hook();
                    $new_hook->name = pSQL($hook['hook']);
                    $new_hook->title = pSQL($hook['hook']);
                    $new_hook->live_edit = (bool)preg_match('/^display/i', $new_hook->name);
                    $new_hook->position = (bool)$new_hook->live_edit;
                    $new_hook->add();
                    $id_hook = (int)$new_hook->id;
                }
                $sql_hook_module = 'INSERT INTO `' . _DB_PREFIX_ . 'hook_module` (`id_module`, `id_shop`, `id_hook`, `position`)
									VALUES (' . (int)$id_module . ', ' . (int)$shop . ', ' . (int)$id_hook . ', ' . (int)$hook['position'] . ')';
                $db->execute($sql_hook_module);
            }
        }
    }

    private function updateImages($xml)
    {
        if (isset($xml->images->image)) {

            $db = $this->container->getDb();
            $translate = $this->container->getTranslator();

            foreach ($xml->images->image as $row) {
                $db->delete('image_type', '`name` = \'' . pSQL($row['name']) . '\'');
                if ($db->execute('
					INSERT INTO `' . _DB_PREFIX_ . 'image_type` (`name`, `width`, `height`, `products`, `categories`, `manufacturers`, `suppliers`, `scenes`)
					VALUES (\'' . pSQL($row['name']) . '\',
						' . (int)$row['width'] . ',
						' . (int)$row['height'] . ',
						' . ($row['products'] == 'true' ? 1 : 0) . ',
						' . ($row['categories'] == 'true' ? 1 : 0) . ',
						' . ($row['manufacturers'] == 'true' ? 1 : 0) . ',
						' . ($row['suppliers'] == 'true' ? 1 : 0) . ',
						' . ($row['scenes'] == 'true' ? 1 : 0) . ')
				')) {
                    $this->logger->info($translate->trans('ImageType %s width %dpx height %dpx has been added.', array((string)$row['name'], (int)$row['width'], (int)$row['height']), 'Module.EtsUpgrade.Admin'));
                }
            }
        }
    }

    private function updateMetas($xml, $theme)
    {
        if (isset($xml->metas->meta) && $xml->metas->meta) {

            $db = $this->container->getDb();
            $metas_xml = array();

            foreach ($xml->metas->meta as $meta) {
                $meta_id = $db->getValue('SELECT id_meta FROM `' . _DB_PREFIX_ . 'meta` WHERE page=\'' . pSQL($meta['meta_page']) . '\'');
                if ((int)$meta_id > 0) {
                    $tmp_meta = array();
                    $tmp_meta['id_meta'] = (int)$meta_id;
                    $tmp_meta['left'] = (string)$meta['left'];
                    $tmp_meta['right'] = (string)$meta['right'];
                    $metas_xml[(int)$meta_id] = $tmp_meta;
                }
            }
            $fill_default_meta = false;
            if (count($xml->metas->meta) < (int)$db->getValue('SELECT count(*) FROM ' . _DB_PREFIX_ . 'meta')) {
                $fill_default_meta = true;
            }

            if ($fill_default_meta == true) {
                $metas = $db->executeS('SELECT id_meta FROM ' . _DB_PREFIX_ . 'meta');
                foreach ($metas as $meta) {
                    if (!isset($metas_xml[(int)$meta['id_meta']])) {
                        $tmp_meta['id_meta'] = (int)$meta['id_meta'];
                        $tmp_meta['left'] = $theme->default_left_column;
                        $tmp_meta['right'] = $theme->default_right_column;
                        $metas_xml[(int)$meta['id_meta']] = $tmp_meta;
                    }
                }
            }

            $theme->updateMetas($metas_xml);
        }
    }
}
