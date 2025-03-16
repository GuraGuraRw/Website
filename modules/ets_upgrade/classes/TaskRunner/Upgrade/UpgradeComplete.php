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

namespace PrestaShop\Module\EtsAutoUpgrade\TaskRunner\Upgrade;

use Configuration;
use Tools;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\TaskRunner\AbstractTask;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\FilesystemAdapter;
use PrestaShop\PrestaShop\Adapter\Entity\Db;

/**
 * Ends the upgrade process and displays the success message.
 */
class UpgradeComplete extends AbstractTask
{
    public function run()
    {
        $this->upgradeSQLVersion();

        if ($this->container->getUpgradeConfiguration()->shouldDeactivateCustomModules() && !$this->container->getUpgradeConfiguration()->isMajorChannel() && ($modules = $this->container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_ENABLED_MODULES))) {

            $return = $this->container->getDb()->execute('UPDATE `' . _DB_PREFIX_ . 'module` SET `active` = 1 WHERE `name` IN (' . implode(',', $modules) . ')');
            foreach ($modules as $id => $module) {
                // Retrieve all shops where the module is enabled
                if ($list = \Shop::getContextListShopID()) {
                    $sql = 'SELECT `id_shop` FROM `' . _DB_PREFIX_ . 'module_shop`
                    WHERE `id_module` = ' . (int)$id . ' AND `id_shop` IN(' . implode(', ', $list) . ')';

                    // Store the results in an array
                    $items = array();
                    if ($results = $this->container->getDb()->executeS($sql)) {
                        foreach ($results as $row) {
                            $items[] = $row['id_shop'];
                        }
                    }
                    // Enable module in the shop where it is not enabled yet
                    foreach ($list as $id_shop) {
                        if (!in_array($id_shop, $items)) {
                            $return &= $this->container->getDb()->insert('module_shop', array(
                                'id_module' => $id,
                                'id_shop' => $id_shop,
                            ));
                        }
                    }
                }
            }
            unset($module);
            if ($return) {
                $this->logger->debug($this->translator->trans('Keep module enabled', array(), 'Modules.Etsupgrade.Admin'));
            }
        }

        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.8.0', '>=')) {
            //DESCRIBE `users`
            $columns = $this->container->getDb()->executeS('DESCRIBE `' . _DB_PREFIX_ . 'shop`');
            if ($columns) {
                $column_is_not_exit = true;
                foreach ($columns as $column) {
                    if ($column_is_not_exit && isset($column['Field']) && trim($column['Field']) === 'color') {
                        $column_is_not_exit = false;
                        break;
                    }
                }
                if ($column_is_not_exit) {
                    $this->container->getDb()->execute('ALTER TABLE `' . _DB_PREFIX_ . 'shop` ADD `color` varchar(50) NOT NULL');
                }
            }
        }

        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '>=')) {
            $this->renameController();
            $id_currency_default = (int)$this->container->getDb()->getValue('SELECT `value` FROM `' . _DB_PREFIX_ . 'configuration` WHERE `name`=\'PS_CURRENCY_DEFAULT\'');
            if ($id_currency_default <= 0) {
                $id_currency_default = (int)$this->container->getDb()->getValue('SELECT id_currency FROM `' . _DB_PREFIX_ . 'currency` WHERE active=1');
            }
            $this->container->getDb()->execute('UPDATE `' . _DB_PREFIX_ . 'orders` SET id_currency=' . (int)$id_currency_default . ' WHERE id_currency<=0 OR id_currency is NULL');
        }

        if (version_compare($this->container->getState()->getInstallVersion(), '1.6.0.0', '>=')) {
            $exist = $this->container->getDb()->getValue('SELECT `id_configuration` FROM `' . _DB_PREFIX_ . 'configuration` WHERE `name` LIKE \'PS_DISABLE_OVERRIDES\'');
            if ($exist) {
                $this->container->getDb()->execute('UPDATE `' . _DB_PREFIX_ . 'configuration` SET value = 0 WHERE `name` LIKE \'PS_DISABLE_OVERRIDES\'');
            } else {
                $this->container->getDb()->execute('INSERT INTO `' . _DB_PREFIX_ . 'configuration` (`name`, `value`, date_add, date_upd) VALUES ("PS_DISABLE_OVERRIDES", 0, NOW(), NOW())');
            }

            // Prestashop > 1.6
            if (file_exists(_PS_ROOT_DIR_ . '/classes/PrestaShopAutoload.php') && !class_exists('PrestaShopAutoload')) {
                require_once _PS_ROOT_DIR_ . '/classes/PrestaShopAutoload.php';
            }
            if (class_exists('PrestaShopAutoload') && method_exists('PrestaShopAutoload', 'generateIndex')) {
                \PrestaShopAutoload::getInstance()->_include_override_path = true;
                \PrestaShopAutoload::getInstance()->generateIndex();
            }
        } else {
            // Prestashop 1.5
            if (file_exists(_PS_ROOT_DIR_ . '/classes/Autoload.php') && !class_exists('Autoload')) {
                require_once _PS_ROOT_DIR_ . '/classes/Autoload.php';
            }
            if (class_exists('Autoload') && method_exists('Autoload', 'generateIndex')) {
                \Autoload::getInstance()->_include_override_path = true;
                \Autoload::getInstance()->generateIndex();
            }
        }

        $this->logger->debug($this->translator->trans('Override enabled', array(), 'Modules.Etsupgrade.Admin'));

        $this->logger->info($this->container->getState()->getWarningExists() ?
            $this->translator->trans('Upgrade process done, but some warnings have been found.', array(), 'Modules.Etsupgrade.Admin') :
            $this->translator->trans('Upgrade process done. Congratulations! You can now reactivate your shop.', array(), 'Modules.Etsupgrade.Admin')
        );
        $this->next = '';

        if (@file_exists(($filePath = $this->container->getFilePath())) && $this->container->getUpgradeConfiguration()->get('channel') != 'archive' && unlink($filePath)) {
            $this->logger->debug($this->translator->trans('%s removed', array($filePath), 'Modules.Etsupgrade.Admin'));
        } elseif (is_file($filePath)) {
            $this->logger->debug('<strong>' . $this->translator->trans('Please remove %s by FTP', array($filePath), 'Modules.Etsupgrade.Admin') . '</strong>');
        }

        if (version_compare($this->container->getState()->getInstallVersion(), '8.0.0', '>=')) {
            $autoUpgradeFileZip = $this->container->getProperty(UpgradeContainer::DOWNLOAD_PATH) . DIRECTORY_SEPARATOR . 'autoupgrade.zip';
            if (@file_exists($autoUpgradeFileZip) && $this->container->getUpgradeConfiguration()->get('channel') != 'archive' && unlink($autoUpgradeFileZip)) {
                $this->logger->debug($this->translator->trans('%s removed', array($autoUpgradeFileZip), 'Modules.Etsupgrade.Admin'));
            } elseif (is_file($autoUpgradeFileZip)) {
                $this->logger->debug('<strong>' . $this->translator->trans('Please remove %s by FTP', array($autoUpgradeFileZip), 'Modules.Etsupgrade.Admin') . '</strong>');
            }
        }

        if (@file_exists(($latestPath = $this->container->getProperty(UpgradeContainer::LATEST_PATH))) && $this->container->getUpgradeConfiguration()->get('channel') != 'directory' && FilesystemAdapter::deleteDirectory($latestPath)) {
            $this->logger->debug($this->translator->trans('%s removed', array($latestPath), 'Modules.Etsupgrade.Admin'));
        } elseif (is_dir($latestPath)) {
            $this->logger->debug('<strong>' . $this->translator->trans('Please remove %s by FTP', array($latestPath), 'Modules.Etsupgrade.Admin') . '</strong>');
        }

        // Re-init config
        Configuration::deleteByName('PS_AUTOUP_IGNORE_REQS');

        //version 1.7.8.0
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.8.0', '>=')) {
            $shops = $this->container->getDb()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'shop`');
            if (count($shops) > 1) {
                foreach ($shops as $shop) {
                    Configuration::updateValue('PS_LOGS_EMAIL_RECEIVERS', Configuration::get('PS_SHOP_EMAIL', null, (int)$shop['id_shop_group'], (int)$shop['id_shop']), false, (int)$shop['id_shop_group'], (int)$shop['id_shop']);
                }
            } else
                Configuration::updateValue('PS_LOGS_EMAIL_RECEIVERS', Configuration::get('PS_SHOP_EMAIL'));
        }

        // Enable all shops.
        $this->psShopEnable(1);

        // Removing temporary files
        $this->container->getFileConfigurationStorage()->cleanAll();

        // Set default configs.
        $configs = $this->container->getUpgradeConfiguration();
        $configs->merge($this->container->getUpgradeConfigurationStorage()->getDefaultData());
        $this->container->getUpgradeConfigurationStorage()->save($configs, UpgradeFileNames::CONFIG_FILENAME);

        //Convert image 1.5 to 1.6, 1.7.
        $this->copyImg();

        $this->cleanFilesTranslation();

        $this->container->getState()->setStepDone('upgradeComplete');
    }

    public function copyImg()
    {
        if (version_compare($this->container->getState()->getOldVersion(), '1.6.0.0', '<') && $this->container->getUpgradeConfiguration()->isMajorChannel() && ($files = glob(_PS_IMG_DIR_ . 'p/*'))) {
            foreach ($files as $file) {
                if (preg_match('#^(\d+)\-((\d+)\.jpg)$#', basename($file), $matches)) {
                    $dest_dir = _PS_IMG_DIR_ . 'p/' . implode('/', str_split($matches[3])) . '/';
                    $dest_file = $dest_dir . $matches[2];
                    if (!@file_exists($dest_file)) {
                        if (!@is_dir($dest_file))
                            @mkdir($dest_dir, 0755, true);
                        if (@is_dir($dest_dir))
                            @copy($file, $dest_file);
                    }
                }
            }
        }
    }

    public function upgradeSQLVersion()
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.0.0', '>=')) {
            return $this->container->getDb()->execute('DELETE FROM `' . _DB_PREFIX_ . 'hook` WHERE `name`=\'actionProductListOverride\'');
        }
    }

    public function cleanFilesTranslation()
    {
        if (version_compare($this->container->getState()->getInstallVersion(), '1.7.7.0', '>=')) {
            if ($languages = $this->container->getDb()->executeS('SELECT l.*, ls.`id_shop` FROM `' . _DB_PREFIX_ . 'lang` l LEFT JOIN `' . _DB_PREFIX_ . 'lang_shop` ls ON (l.id_lang = ls.id_lang)')) {
                $dirsToClean = [];
                foreach ($languages as $l) {
                    $dirsToClean[] = $this->container->getProperty(UpgradeContainer::PS_ROOT_PATH) . '/translations/' . Tools::strtolower($l['iso_code']) . '/';
                }
                if (count($dirsToClean) > 0) {
                    foreach ($dirsToClean as $dir) {
                        if (!file_exists($dir)) {
                            $this->logger->debug($this->container->getTranslator()->trans('[SKIP] directory "%s" does not exist and cannot be emptied.', array(str_replace($this->container->getProperty(UpgradeContainer::PS_ROOT_PATH), '', $dir)), 'Modules.Etsupgrade.Admin'));
                            continue;
                        }
                        foreach (scandir($dir) as $file) {
                            if ($file[0] === '.' || $file === 'index.php') {
                                continue;
                            }
                            if (is_file($dir . $file)) {
                                if (unlink($dir . $file)) {
                                    $this->logger->debug($this->container->getTranslator()->trans('[CLEANING TRANSLATION FILES] File %s is removed', array($file), 'Modules.Etsupgrade.Admin'));
                                }
                            } elseif (is_dir($dir . $file . DIRECTORY_SEPARATOR)) {
                                FilesystemAdapter::deleteDirectory($dir . $file . DIRECTORY_SEPARATOR);
                            }
                        }
                        if (is_dir($dir))
                            rmdir($dir);
                    }
                }
            }
        }
    }

    public function renameController()
    {
        if ($controllers = glob(_PS_ROOT_DIR_ . '/controllers/front/listing/*.php')) {
            foreach ($controllers as $controller) {
                if (!@file_exists(($filename = _PS_ROOT_DIR_ . '/controllers/front/' . basename($controller))) && @is_writable($filename)) {
                    @rename($filename, $filename . '.bck');
                }
            }
        }
    }
}
