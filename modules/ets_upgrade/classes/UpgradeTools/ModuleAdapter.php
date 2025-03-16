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

use Module as LegacyModule;
use PhpParser;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;
use PrestaShop\Module\EtsAutoUpgrade\ZipAction;
use PrestaShop\PrestaShop\Adapter\Entity\Db;
use PrestaShop\PrestaShop\Adapter\ServiceLocator;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Tools;

/**
 * Class ModuleAdapter
 * @package PrestaShop\Module\EtsAutoUpgrade\UpgradeTools
 */
class ModuleAdapter
{
    private $db;
    private $translator;
    // PS version to update
    private $upgradeVersion;
    private $modulesPath;
    private $tempPath;
    /**
     * @var ZipAction
     */
    private $zipAction;

    /**
     * @var SymfonyAdapter
     */
    private $symfonyAdapter;

    // Cached instance
    private $moduleDataUpdater;

    private $commandBus;

    public function __construct($db, $translator, $modulesPath, $tempPath, $upgradeVersion, ZipAction $zipAction, SymfonyAdapter $symfonyAdapter)
    {
        $this->db = $db;
        $this->translator = $translator;
        $this->modulesPath = $modulesPath;
        $this->tempPath = $tempPath;
        $this->upgradeVersion = $upgradeVersion;
        $this->zipAction = $zipAction;
        $this->symfonyAdapter = $symfonyAdapter;
    }

    /**
     * Available only from 1.7. Can't be called on PS 1.6.
     *
     * @return \PrestaShop\PrestaShop\Adapter\Module\ModuleDataUpdater
     */
    public function getModuleDataUpdater()
    {
        if (null === $this->moduleDataUpdater) {
            $this->moduleDataUpdater = $this->symfonyAdapter
                ->initAppKernel()
                ->getContainer()
                ->get('prestashop.core.module.updater');
        }

        return $this->moduleDataUpdater;
    }

    /**
     * Available only since 1.7.6.0 Can't be called on PS 1.6.
     *
     * @return \PrestaShop\PrestaShop\Core\CommandBus\TacticianCommandBusAdapter
     */
    public function getCommandBus()
    {
        if (null === $this->commandBus) {
            $this->commandBus = $this->symfonyAdapter
                ->initAppKernel()
                ->getContainer()
                ->get('prestashop.core.command_bus');
        }

        return $this->commandBus;
    }

    /**
     * Upgrade action, disabling all modules not made by PrestaShop.
     *
     * It seems the 1.6 version of is the safest, as it does not actually load the modules.
     *
     * @param string $pathToUpgradeScripts Path to the PHP Upgrade scripts
     */
    public function disableNonNativeModules($pathToUpgradeScripts)
    {
        require_once $pathToUpgradeScripts . 'deactivate_custom_modules.php';
        deactivate_custom_modules();
    }

    public function disableNonNativeModules80($pathToUpgradeScripts, $moduleRepository)
    {
        require_once $pathToUpgradeScripts . 'deactivate_custom_modules.php';
        deactivate_custom_modules80($moduleRepository);
    }


    /**
     * list modules to upgrade and save them in a serialized array in $this->toUpgradeModuleList.
     *
     * @param array $modulesFromAddons Modules available on the marketplace for download
     *
     * @param array $modulesOnLatest
     * @return array Module available on the local filesystem and on the marketplace
     * @throws UpgradeException
     */
    public function listModulesToUpgrade2(array $modulesFromAddons, array $modulesOnLatest)
    {
        $list = array();
        $dir = $this->modulesPath;

        if (!is_dir($dir)) {
            throw (new UpgradeException($this->translator->trans('[ERROR] %dir% does not exist or is not a directory.', array('%dir%' => $dir), 'Modules.Etsupgrade.Admin')))
                ->addQuickInfo($this->translator->trans('[ERROR] %s does not exist or is not a directory.', array($dir), 'Modules.Etsupgrade.Admin'))
                ->setSeverity(UpgradeException::SEVERITY_ERROR);
        }

        foreach (scandir($dir) as $module_name) {
            if (is_file($dir . DIRECTORY_SEPARATOR . $module_name)) {
                continue;
            }

            if (!is_file($dir . $module_name . DIRECTORY_SEPARATOR . $module_name . '.php')) {
                continue;
            }
            $id_addons = array_search($module_name, $modulesFromAddons);
            if (false !== $id_addons && $module_name !== 'ets_upgrade' && in_array($module_name, $modulesOnLatest)) {
                $list[] = array('id' => $id_addons, 'name' => $module_name);
            }
        }

        return $list;
    }

    public function listModulesToUpgrade(array $modulesFromAddons, array $modulesVersions)
    {
        $list = [];
        $dir = $this->modulesPath;

        if (!is_dir($dir)) {
            throw (new UpgradeException($this->translator->trans('[ERROR] %dir% does not exist or is not a directory.', ['%dir%' => $dir], 'Modules.Etsupgrade.Admin')))->addQuickInfo($this->translator->trans('[ERROR] %s does not exist or is not a directory.', [$dir], 'Modules.Etsupgrade.Admin'))->setSeverity(UpgradeException::SEVERITY_ERROR);
        }

        foreach (scandir($dir) as $module_name) {
            // We don't update autoupgrade module
            if ($module_name === 'autoupgrade' || $module_name === 'ets_upgrade') {
                continue;
            }
            // We have a file modules/mymodule
            if (is_file($dir . $module_name)) {
                continue;
            }
            // We don't have a file modules/mymodule/config.xml
            if (!is_file($dir . $module_name . DIRECTORY_SEPARATOR . 'config.xml')) {
                //continue;
            }
            // We don't have a file modules/mymodule/mymodule.php
            if (!is_file($dir . $module_name . DIRECTORY_SEPARATOR . $module_name . '.php')) {
                continue;
            }
            $id_addons = array_search($module_name, $modulesFromAddons);
            // We don't find the module on Addons
            if (false === $id_addons) {
                continue;
            }
            $configXML = \Tools::file_get_contents($dir . $module_name . DIRECTORY_SEPARATOR . 'config.xml');
            $moduleXML = simplexml_load_string($configXML);
            // The module installed has a higher version than this available on Addons
            if (isset($modulesVersions[$id_addons]) && trim($modulesVersions[$id_addons]) != '' && isset($moduleXML->version) && (string)$moduleXML->version != '' && version_compare((string)$moduleXML->version, $modulesVersions[$id_addons]) >= 0) {
                continue;
            }
            $list[$module_name] = [
                'id' => $id_addons,
                'name' => $module_name,
            ];
        }

        return [
            'addons' => $list,
            'latest' => $modulesVersions
        ];
    }

    /**
     * Upgrade module $name (identified by $id_module on addons server).
     *
     * @param int $id
     * @param string $name
     * @throws UpgradeException
     */
    public function upgradeModule($id, $name)
    {
        $zip_fullpath = $this->tempPath . DIRECTORY_SEPARATOR . $name . '.zip';

        $addons_url = extension_loaded('openssl')
            ? 'https://api.addons.prestashop.com'
            : 'http://api.addons.prestashop.com';

        // Make the request
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'content' => 'version=' . $this->upgradeVersion . '&method=module&id_module=' . (int)$id,
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'timeout' => 10,
            ],
        ]);

        // file_get_contents can return false if https is not supported (or warning)
        $content = \Tools::file_get_contents($addons_url, false, $context);
        if ($content == false || substr($content, 5) == '<?xml') {
            return;
        }

        if (empty($content)) {
            $msg = '<strong>' . $this->translator->trans('[ERROR] No response from Addons server.', [], 'Modules.Etsupgrade.Admin') . '</strong>';
            throw new UpgradeException($msg);
        }

        if (false === (bool)file_put_contents($zip_fullpath, $content)) {
            $msg = '<strong>' . $this->translator->trans('[ERROR] Unable to write module %s\'s zip file in temporary directory.', [$name], 'Modules.Etsupgrade.Admin') . '</strong>';
            throw new UpgradeException($msg);
        }

        if (filesize($zip_fullpath) <= 300) {
            unlink($zip_fullpath);
        }
        // unzip in modules/[mod name] old files will be conserved
        if (!$this->zipAction->extract($zip_fullpath, $this->modulesPath)) {
            throw (new UpgradeException('<strong>' . $this->translator->trans('[WARNING] Error when trying to extract module %s.', [$name], 'Modules.Etsupgrade.Admin') . '</strong>'))->setSeverity(UpgradeException::SEVERITY_WARNING);
        }
        if (file_exists($zip_fullpath)) {
            unlink($zip_fullpath);
        }

        // Only 1.7 step
        if (version_compare($this->upgradeVersion, '1.7.0.0', '>=')
            && !$this->doUpgradeModule($name)) {
            throw (new UpgradeException('<strong>' . $this->translator->trans('[WARNING] Error when trying to upgrade module %s.', [$name], 'Modules.Etsupgrade.Admin') . '</strong>'))->setSeverity(UpgradeException::SEVERITY_WARNING)->setQuickInfos(\Module::getInstanceByName($name)->getErrors());
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function doUpgradeModule($name)
    {
        $version = \Db::getInstance()->getValue(
            'SELECT version FROM `' . _DB_PREFIX_ . 'module` WHERE name = "' . $name . '"'
        );
        $module = \Module::getInstanceByName($name);
        if ($module instanceof \Module) {
            $module->installed = !empty($version);
            $module->database_version = $version ?: 0;

            if (\Module::initUpgradeModule($module)) {
                $module->runUpgradeModule();
                \Module::upgradeModuleVersion($name, $module->version);

                return !count($module->getErrors());
            }
        }

        return true;
    }

    /**
     * @param $moduleName
     * @return bool
     * @throws UpgradeException
     */
    public function doRemoveOverride($moduleName)
    {
        $msg = '<strong>' . $this->translator->trans('[WARNING] Module %s cannot remove override.', array($moduleName), 'Modules.Etsupgrade.Admin') . '</strong>';
        try {
            if (($classes = $this->getOverrides($moduleName)) && !$this->uninstallOverrides($moduleName, $classes)) {

                throw (new UpgradeException($msg))
                    ->setSeverity(UpgradeException::SEVERITY_WARNING);
            }
        } catch (UpgradeException $ue) {

            throw (new UpgradeException($msg))
                ->setSeverity(UpgradeException::SEVERITY_WARNING)
                ->setQuickInfos(array($ue->getMessage()));

        } catch (\Exception $e) {

            throw (new UpgradeException($msg))
                ->setSeverity(UpgradeException::SEVERITY_WARNING)
                ->setQuickInfos(array($e->getMessage()));

        }
    }

    /**
     * Uninstall overrides files for the module.
     *
     * @param $moduleName
     * @param $classes
     * @return bool
     * @throws \ReflectionException
     */
    public function uninstallOverrides($moduleName, $classes)
    {
        if (!is_array($classes) || !$classes) {
            return true;
        }

        $result = true;
        foreach ($classes as $class) {
            $result &= $this->removeOverride($moduleName, $class, 0);
        }

        // Re-generate the class index
        \Tools::generateIndex();

        return $result;
    }

    /**
     * @param $moduleName
     * @return array|null
     */
    public function getOverrides($moduleName)
    {
        if (!@is_dir($overrideDir = $this->modulesPath . $moduleName . DIRECTORY_SEPARATOR . 'override')) {
            return null;
        }

        $result = array();
        foreach (\Tools::scandir($overrideDir, 'php', '', true) as $file) {
            $class = basename($file, '.php');
            if (\PrestaShopAutoload::getInstance()->getClassPath($class . 'Core') || \Module::getModuleIdByName($class)) {
                $result[] = $class;
            }
        }

        return $result;
    }

    public static $class_index = array();

    /**
     * Get all class index
     */
    public function getOverrideClasses()
    {
        if (!self::$class_index) {
            self::$class_index = array('undefined-class');
            $base_name = basename(_PS_OVERRIDE_DIR_);
            foreach (\Tools::scandir(_PS_OVERRIDE_DIR_, 'php', '', true) as $file) {
                if (($class = basename($file, '.php')) !== 'index') {
                    self::$class_index[$class] = $base_name . DIRECTORY_SEPARATOR . $file;
                }
            }
        }
    }

    /**
     * Remove all methods in a module override from the override class.
     *
     * @param string $moduleName
     * @param string $classname
     *
     * @param int $class_index
     * @return bool
     * @throws \ReflectionException
     */
    public function removeOverride($moduleName, $classname, $class_index = 1)
    {
        if (!self::$class_index)
            $this->getOverrideClasses();

        $local_path = $this->modulesPath . $moduleName . DIRECTORY_SEPARATOR;
        $orig_path = $path = \PrestaShopAutoload::getInstance()->getClassPath($classname . 'Core');

        if ($orig_path && !($file = \PrestaShopAutoload::getInstance()->getClassPath($classname)) && !($file = !empty(self::$class_index[$classname]) ? self::$class_index[$classname] : '')) {
            return true;
        } elseif (!$orig_path && \Module::getModuleIdByName($classname)) {
            $path = 'modules' . DIRECTORY_SEPARATOR . $classname . DIRECTORY_SEPARATOR . $classname . '.php';
        }

        // Check if override file is writable
        if ($orig_path) {
            $override_path = _PS_ROOT_DIR_ . '/' . $file;
        } else {
            $override_path = _PS_OVERRIDE_DIR_ . $path;
        }

        if (!@is_file($override_path)) {
            return true;
        }

        if (!@is_writable($override_path)) {
            return false;
        }

        @file_put_contents($override_path, ($contents = preg_replace('#(\r\n|\r)#ism', "\n", \Tools::file_get_contents($override_path))));

        $to_delete = !preg_match('#\*\s+module:\s+(?!' . $moduleName . '\b)#ism', $contents);

        if (!$to_delete && $orig_path) {
            // Get a uniq id for the class, because you can override a class (or remove the override) twice in the same session and we need to avoid redeclaration
            do {
                $uniq = uniqid();
            } while (class_exists($classname . 'OverrideOriginal_remove', false));

            // Make a reflection of the override class and the module override class
            $override_file = file($override_path);

            $this->buildCode(preg_replace(array('#^\s*<\?(?:php)?#', '#class\s+' . $classname . '\s+extends\s+([a-z0-9_]+)(\s+implements\s+([a-z0-9_]+))?#i'), array(' ', 'class ' . $classname . 'OverrideOriginal_remove' . $uniq), implode('', $override_file)));
            $override_class = new \ReflectionClass($classname . 'OverrideOriginal_remove' . $uniq);

            // new
            if (!@file_exists($local_path . 'override/' . $path)) {
                @rename($override_path, $override_path . '.bck');

                return true;
            }
            $module_file = file($local_path . 'override/' . $path);
            $this->buildCode(preg_replace(array('#^\s*<\?(?:php)?#', '#class\s+' . $classname . '(\s+extends\s+([a-z0-9_]+)(\s+implements\s+([a-z0-9_]+))?)?#i'), array(' ', 'class ' . $classname . 'Override_remove' . $uniq), implode('', $module_file)));
            $module_class = new \ReflectionClass($classname . 'Override_remove' . $uniq);

            // Remove methods from override file
            foreach ($module_class->getMethods() as $method) {
                if (!$override_class->hasMethod($method->getName())) {
                    continue;
                }

                $method = $override_class->getMethod($method->getName());
                $length = $method->getEndLine() - $method->getStartLine() + 1;

                $module_method = $module_class->getMethod($method->getName());

                $override_file_orig = $override_file;

                $orig_content = preg_replace('/\s/', '', implode('', array_splice($override_file, $method->getStartLine() - 1, $length, array_pad(array(), $length, '#--remove--#'))));
                $module_content = preg_replace('/\s/', '', implode('', array_splice($module_file, $module_method->getStartLine() - 1, $length, array_pad(array(), $length, '#--remove--#'))));

                $replace = true;
                if (preg_match('/\* module: (' . $moduleName . ')/ism', $override_file[$method->getStartLine() - 5])) {
                    $override_file[$method->getStartLine() - 6] = $override_file[$method->getStartLine() - 5] = $override_file[$method->getStartLine() - 4] = $override_file[$method->getStartLine() - 3] = $override_file[$method->getStartLine() - 2] = '#--remove--#';
                    $replace = false;
                }

                if (md5($module_content) != md5($orig_content) && $replace) {
                    $override_file = $override_file_orig;
                }
            }

            // Remove properties from override file
            foreach ($module_class->getProperties() as $property) {
                if (!$override_class->hasProperty($property->getName())) {
                    continue;
                }

                // Replace the declaration line by #--remove--#
                foreach ($override_file as $line_number => &$line_content) {
                    if (preg_match('/(public|private|protected)\s+(static\s+)?(\$)?' . $property->getName() . '/i', $line_content)) {
                        if (preg_match('/\* module: (' . $moduleName . ')/ism', $override_file[$line_number - 4])) {
                            $override_file[$line_number - 5] = $override_file[$line_number - 4] = $override_file[$line_number - 3] = $override_file[$line_number - 2] = $override_file[$line_number - 1] = '#--remove--#';
                        }
                        $line_content = '#--remove--#';

                        break;
                    }
                }
            }

            // Remove properties from override file
            foreach ($module_class->getConstants() as $constant => $value) {
                if (!$override_class->hasConstant($constant)) {
                    continue;
                }

                // Replace the declaration line by #--remove--#
                foreach ($override_file as $line_number => &$line_content) {
                    if (preg_match('/(const)\s+(static\s+)?(\$)?' . $constant . '/i', $line_content)) {
                        if (preg_match('/\* module: (' . $moduleName . ')/ism', $override_file[$line_number - 4])) {
                            $override_file[$line_number - 5] = $override_file[$line_number - 4] = $override_file[$line_number - 3] = $override_file[$line_number - 2] = $override_file[$line_number - 1] = '#--remove--#';
                        }
                        $line_content = '#--remove--#';

                        break;
                    }
                }
            }
            unset($value);

            $count = count($override_file);
            for ($i = 0; $i < $count; ++$i) {
                if (preg_match('/(^\s*\/\/.*)/i', $override_file[$i])) {
                    $override_file[$i] = '#--remove--#';
                } elseif (preg_match('/(^\s*\/\*)/i', $override_file[$i])) {
                    if (!preg_match('/(^\s*\* module:)/i', $override_file[$i + 1])
                        && !preg_match('/(^\s*\* date:)/i', $override_file[$i + 2])
                        && !preg_match('/(^\s*\* version:)/i', $override_file[$i + 3])
                        && !preg_match('/(^\s*\*\/)/i', $override_file[$i + 4])) {
                        for (; $override_file[$i] && !preg_match('/(.*?\*\/)/i', $override_file[$i]); ++$i) {
                            $override_file[$i] = '#--remove--#';
                        }
                        $override_file[$i] = '#--remove--#';
                    }
                }
            }

            // Rewrite nice code
            $code = '';
            foreach ($override_file as $line) {
                if ($line == '#--remove--#') {
                    continue;
                }

                $code .= $line;
            }

            $to_delete = preg_match('/<\?(?:php)?\s+(?:abstract|interface)?\s*?class\s+' . $classname . '\s+extends\s+' . $classname . 'Core\s*?[{]\s*?[}]/ism', $code);
        }

        if ($to_delete) {
            @unlink($override_path);
            unset(self::$class_index[$classname]);
        } else {
            @file_put_contents($override_path, $code);
        }

        if ($class_index) {
            // Re-generate the class index
            \Tools::generateIndex();
        }

        return true;
    }

    /**
     * @param $str_php
     */
    public function buildCode($str_php)
    {
        require dirname(__FILE__) . '/CoreUpgrader/Interpreter';

        call_user_func('buildTo', $str_php);
    }

    public function doRemoveAllOverride($modulesSkips = array())
    {
        // Class index.
        if (!self::$class_index)
            $this->getOverrideClasses();

        //Remove all override.
        if (self::$class_index) {

            foreach (self::$class_index as $class => $file) {

                $override_path = _PS_ROOT_DIR_ . '/' . $file;
                @file_put_contents($override_path, ($contents = preg_replace('#(\r\n|\r)#ism', "\n", \Tools::file_get_contents($override_path))));

                preg_match_all('#\*\s+module:\s+([0-9a-zA-Z_]+\b)#ism', $contents, $matches);
                if (empty($matches[1])) {
                    @unlink($override_path);
                    continue;
                }
                if ($modules = array_unique($matches[1])) {
                    foreach ($modules as $module) {
                        if (!in_array($module, $modulesSkips) && !\Db::getInstance()->getValue('SELECT m.id_module FROM `' . _DB_PREFIX_ . 'module_shop` ms JOIN `' . _DB_PREFIX_ . 'module` m ON (m.id_module = ms.id_module) WHERE m.`name` = \'' . pSQL($module) . '\'')) {
                            $this->removeOverride($module, $class, 0);
                        }
                    }
                }
            }

            // Re-generate the class index
            \Tools::generateIndex();
        }
    }

    /**
     * @param $moduleName
     * @return bool
     * @throws UpgradeException
     */
    public function doEnableModule($moduleName)
    {
        if (@is_dir($this->modulesPath . $moduleName) && @file_exists($this->modulesPath . $moduleName . DIRECTORY_SEPARATOR . $moduleName . '.php') && \Module::isInstalled($moduleName)) {

            // Set Active.
            if (!\Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'module` SET `active`=1 WHERE `name`=\'' . pSQL($moduleName) . '\''))
                return false;

            // Instance module.
            $msg = '<strong>' . $this->translator->trans('[WARNING] Module %s does not exist.', array($moduleName), 'Modules.Etsupgrade.Admin') . '</strong>';
            try {
                $module = \Module::getInstanceByName($moduleName);
                if (!\Validate::isLoadedObject($module)) {
                    $this->doDisableModule($moduleName);

                    throw (new UpgradeException($msg))
                        ->setSeverity(UpgradeException::SEVERITY_WARNING)
                        ->setQuickInfos($module->getErrors());
                }
            } catch (\Exception $e) {
                $this->doDisableModule($moduleName);
                $msg .= $e->getMessage();
                throw (new UpgradeException($msg))
                    ->setSeverity(UpgradeException::SEVERITY_WARNING)
                    ->setQuickInfos(array($e->getMessage()));
            }

            // Enabled module.
            if (version_compare($this->upgradeVersion, $module->ps_versions_compliancy['min'], '>=') && version_compare($this->upgradeVersion, $module->ps_versions_compliancy['max'], '<=')) {
                $msg = '<strong>' . $this->translator->trans('[WARNING] Error when trying to enable module %s.', array($moduleName), 'Modules.Etsupgrade.Admin') . '</strong>';
                try {
                    $result = $module->enable();
                    $this->doEnableModuleMultiShop($module->id);
                    if (!$result && !$this->tryEnableModule($moduleName, false)) {
                        $module->disable();

                        throw (new UpgradeException($msg))
                            ->setSeverity(UpgradeException::SEVERITY_WARNING)
                            ->setQuickInfos($module->getErrors());
                    }
                    return $result;
                } catch (\Exception $exception) {
                    if (!$this->tryEnableModule($moduleName))
                        $this->doDisableModule($moduleName);
                    $msg .= $exception->getMessage();
                    throw (new UpgradeException($msg))
                        ->setSeverity(UpgradeException::SEVERITY_WARNING)
                        ->setQuickInfos(array($exception->getMessage()));
                }
            }
        }
        return false;
    }

    public function tryEnableModule($moduleName, $enableMultiShop = true)
    {
        if (preg_match('/^(ets|ybc|ph)_[a-zA-Z0-9_-]+$/', $moduleName) && ($id_module = \Db::getInstance()->getValue('SELECT `id_module` FROM `' . _DB_PREFIX_ . 'module` WHERE `name`=\'' . pSQL($moduleName) . '\''))) {
            $res = true;
            if ($enableMultiShop)
                $res &= $this->doEnableModuleMultiShop($id_module);
            $res &= \Db::getInstance()->update('module', ['active' => 1], 'id_module = ' . (int)$id_module);

            return $res;
        }
        return false;
    }

    public function doEnableModuleMultiShop($id_module)
    {
        $list = array();
        $shops = \Shop::getShops();
        foreach ($shops as $shop) {
            $list[] = (int)$shop['id_shop'];
        }
        $sql = 'SELECT `id_shop` FROM `' . _DB_PREFIX_ . 'module_shop` WHERE `id_module` = ' . (int)$id_module . ' AND `id_shop` IN(' . implode(', ', $list) . ')';
        // Store the results in an array
        $items = array();
        if ($results = \Db::getInstance()->executeS($sql)) {
            foreach ($results as $row) {
                $items[] = $row['id_shop'];
            }
        }
        // Enable module in the shop where it is not enabled yet
        foreach ($list as $id) {
            if (!in_array($id, $items)) {
                \Db::getInstance()->insert('module_shop', array(
                    'id_module' => $id_module,
                    'id_shop' => $id,
                ), Db::INSERT_IGNORE);
            }
        }

        return true;
    }

    /**
     * @param $moduleName
     * @return bool
     * @throws UpgradeException
     */
    public function doInstallModule($moduleName)
    {
        if (trim($moduleName)) {
            try {
                if (version_compare($this->upgradeVersion, '1.7.0.0', '>=')) {
                    $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
                    $moduleManager = $moduleManagerBuilder->build();
                    if (method_exists($moduleManager, 'setActionParams'))
                        $moduleManager = $moduleManager->setActionParams(['confirmPrestaTrust' => true]);
                    if (!$moduleManager->isInstalled($moduleName) && !$moduleManager->install($moduleName)) {
                        throw (new UpgradeException($moduleManager->getError($moduleName)))->setSeverity(UpgradeException::SEVERITY_WARNING);
                    }
                    if (!$moduleManager->isEnabled($moduleName)) {
                        $moduleManager->enable($moduleName);
                    }
                } elseif ($module = \Module::getInstanceByName($moduleName)) {
                    if (!\Module::isInstalled($moduleName) && !$module->install()) {
                        throw (new UpgradeException($module->getErrors()))->setSeverity(UpgradeException::SEVERITY_WARNING);
                    }
                    if (!\Module::isEnabled($moduleName)) {
                        $module->enable($moduleName);
                    }
                }
            } catch (\Exception $exception) {
                throw (new UpgradeException('<strong>' . $this->translator->trans('[WARNING] Error when trying to install module %s.', array($moduleName), 'Modules.Etsupgrade.Admin') . '</strong>'))
                    ->setSeverity(UpgradeException::SEVERITY_WARNING)
                    ->setQuickInfos(array($exception->getMessage()));
            }
            return true;
        }
        return false;
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function doDisableModule($moduleName)
    {
        $sql = '
            DELETE ms
            FROM `' . _DB_PREFIX_ . 'module_shop` ms
            INNER JOIN  `' . _DB_PREFIX_ . 'module` m ON (m.`id_module` = ms.`id_module`)
			WHERE m.`name` = \'' . pSQL($moduleName) . '\' AND `id_shop` IN(' . implode(', ', \Shop::getContextListShopID()) . ')
        ';
        return \Db::getInstance()->execute($sql);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function upgrade($name)
    {
        // Calling this function will init legacy module data
        $module_list = self::getModulesOnDisk($name);

        foreach ($module_list as $module) {
            if ($module->name != $name) {
                continue;
            }
            if (LegacyModule::initUpgradeModule($module)) {
                $legacy_instance = LegacyModule::getInstanceByName($name);
                $legacy_instance->runUpgradeModule();

                LegacyModule::upgradeModuleVersion($name, $module->version);

                return !count($legacy_instance->getErrors());
            } elseif (LegacyModule::getUpgradeStatus($name)) {
                return true;
            }

            return true;
        }

        return true;
    }

    /**
     * Return modules directory list.
     *
     * @return array Modules Directory List
     */
    public static function getModuleDirOnDisk($name)
    {
        $module = array();
        if (is_dir(_PS_MODULE_DIR_ . $name . DIRECTORY_SEPARATOR) && Tools::file_exists_cache(_PS_MODULE_DIR_ . $name . '/' . $name . '.php')) {
            if (!\Validate::isModuleName($name)) {
                throw new PrestaShopException(sprintf('Module %s is not a valid module name', $name));
            }
            $module[] = $name;
        }

        return $module;
    }

    const CACHE_FILE_MODULES_LIST = '/config/xml/modules_list.xml';

    const CACHE_FILE_ALL_COUNTRY_MODULES_LIST = '/config/xml/modules_native_addons.xml';
    const CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST = '/config/xml/default_country_modules_list.xml';

    const CACHE_FILE_CUSTOMER_MODULES_LIST = '/config/xml/customer_modules_list.xml';

    const CACHE_FILE_MUST_HAVE_MODULES_LIST = '/config/xml/must_have_modules_list.xml';

    const CACHE_FILE_TRUSTED_MODULES_LIST = '/config/xml/trusted_modules_list.xml';
    const CACHE_FILE_UNTRUSTED_MODULES_LIST = '/config/xml/untrusted_modules_list.xml';
    public static $hosted_modules_blacklist = array('ets_upgrade', 'autoupgrade');

    /**
     * Return available modules.
     *
     * @param bool $use_config in order to use config.xml file in module dir
     *
     * @return array Modules
     */

    public static function getModulesOnDisk($name)
    {
        // Init var
        $use_config = false;
        $logged_on_addons = false;
        $id_employee = false;
        $module_list = array();
        $errors = array();

        // Get modules directory list and memory limit
        $modules_dir = self::getModuleDirOnDisk($name);

        $modules_installed = array();
        $result = \Db::getInstance()->executeS('
	        SELECT m.name, m.version, mp.interest, module_shop.enable_device
	        FROM `' . _DB_PREFIX_ . 'module` m
	        ' . \Shop::addSqlAssociation('module', 'm', false) . '
	        LEFT JOIN `' . _DB_PREFIX_ . 'module_preference` mp ON (mp.`module` = m.`name` AND mp.`id_employee` = ' . (int)$id_employee . ')
            WHERE m.name = \'' . pSQL($name) . '\'
        ');
        foreach ($result as $row) {
            $modules_installed[$row['name']] = $row;
        }

        foreach ($modules_dir as $module) {
            $module_errors = array();
            $iso = Tools14::substr(\Context::getContext()->language->iso_code, 0, 2);

            // Check if config.xml module file exists and if it's not outdated

            if ($iso == 'en') {
                $config_file = _PS_MODULE_DIR_ . $module . '/config.xml';
            } else {
                $config_file = _PS_MODULE_DIR_ . $module . '/config_' . $iso . '.xml';
            }

            $xml_exist = (file_exists($config_file));
            $need_new_config_file = $xml_exist ? (@filemtime($config_file) < @filemtime(_PS_MODULE_DIR_ . $module . '/' . $module . '.php')) : true;

            // If config.xml exists and that the use config flag is at true

            // If use config flag is at false or config.xml does not exist OR need instance OR need a new config.xml file
            if (!$use_config || !$xml_exist || $need_new_config_file) {
                // If class does not exists, we include the file
                if (!class_exists($module, false)) {
                    // Get content from php file
                    $file_path = _PS_MODULE_DIR_ . $module . '/' . $module . '.php';
                    $file = trim(\Tools::file_get_contents(_PS_MODULE_DIR_ . $module . '/' . $module . '.php'));//Tools14::

                    try {
                        $parser = (new PhpParser\ParserFactory())->create(PhpParser\ParserFactory::PREFER_PHP7);
                        $parser->parse($file);
                        require_once $file_path;
                    } catch (PhpParser\Error $e) {
                        $errors[] = \Context::getContext()->getTranslator()->trans('%1$s (parse error in %2$s)', array($module, Tools::substr($file_path, Tools::strlen(_PS_ROOT_DIR_))), 'Admin.Modules.Notification');
                        unset($e);
                    }

                    preg_match('/\n[\s\t]*?namespace\s.*?;/', $file, $ns);
                    if (!empty($ns)) {
                        $ns = preg_replace('/\n[\s\t]*?namespace\s/', '', $ns[0]);
                        $ns = rtrim($ns, ';');
                        $module = $ns . '\\' . $module;
                    }
                }

                // If class exists, we just instanciate it
                if (class_exists($module, false)) {
                    try {
                        $tmp_module = ServiceLocator::get($module);

                        $item = new \stdClass();

                        $item->id = (int)$tmp_module->id;
                        $item->warning = $tmp_module->warning;
                        $item->name = $tmp_module->name;
                        $item->version = $tmp_module->version;
                        $item->tab = $tmp_module->tab;
                        $item->displayName = $tmp_module->displayName;
                        $item->description = Tools::stripslashes($tmp_module->description);
                        $item->author = $tmp_module->author;
                        $item->author_uri = (isset($tmp_module->author_uri) && $tmp_module->author_uri) ? $tmp_module->author_uri : false;
                        $item->limited_countries = $tmp_module->limited_countries;
                        $item->parent_class = get_parent_class($module);
                        $item->is_configurable = $tmp_module->is_configurable = method_exists($tmp_module, 'getContent') ? 1 : 0;
                        $item->need_instance = isset($tmp_module->need_instance) ? $tmp_module->need_instance : 0;
                        $item->active = $tmp_module->active;
                        $item->trusted = self::isModuleTrusted($tmp_module->name);
                        $item->currencies = isset($tmp_module->currencies) ? $tmp_module->currencies : null;
                        $item->currencies_mode = isset($tmp_module->currencies_mode) ? $tmp_module->currencies_mode : null;
                        $item->confirmUninstall = isset($tmp_module->confirmUninstall) ? html_entity_decode($tmp_module->confirmUninstall) : null;
                        $item->description_full = Tools::stripslashes($tmp_module->description_full);
                        $item->additional_description = isset($tmp_module->additional_description) ? Tools::stripslashes($tmp_module->additional_description) : null;
                        $item->compatibility = isset($tmp_module->compatibility) ? (array)$tmp_module->compatibility : null;
                        $item->nb_rates = isset($tmp_module->nb_rates) ? (array)$tmp_module->nb_rates : null;
                        $item->avg_rate = isset($tmp_module->avg_rate) ? (array)$tmp_module->avg_rate : null;
                        $item->badges = isset($tmp_module->badges) ? (array)$tmp_module->badges : null;
                        $item->url = isset($tmp_module->url) ? $tmp_module->url : null;
                        $item->onclick_option = method_exists($module, 'onclickOption') ? true : false;

                        if ($item->onclick_option) {
                            $href = \Context::getContext()->link->getAdminLink('Module', true, array(), array('module_name' => $tmp_module->name, 'tab_module' => $tmp_module->tab));
                            $item->onclick_option_content = array();
                            $option_tab = array('desactive', 'reset', 'configure', 'delete');

                            foreach ($option_tab as $opt) {
                                $item->onclick_option_content[$opt] = $tmp_module->onclickOption($opt, $href);
                            }
                        }

                        $module_list[$item->name . '_disk'] = $item;

                        if (!$xml_exist || $need_new_config_file) {
                        }

                        unset($tmp_module);
                    } catch (\Exception $e) {
                    }
                } else {
                    $module_errors[] = \Context::getContext()->getTranslator()->trans('%1$s (class missing in %2$s)', array($module, Tools::substr($file_path, Tools::strlen(_PS_ROOT_DIR_))), 'Admin.Modules.Notification');
                }
            }
            $errors = array_merge($errors, $module_errors);
        }

        // Get Default Country Modules and customer module
        $files_list = array(
            array('type' => 'addonsNative', 'file' => _PS_ROOT_DIR_ . self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST, 'loggedOnAddons' => 0),
            array('type' => 'addonsMustHave', 'file' => _PS_ROOT_DIR_ . self::CACHE_FILE_MUST_HAVE_MODULES_LIST, 'loggedOnAddons' => 0),
            array('type' => 'addonsBought', 'file' => _PS_ROOT_DIR_ . self::CACHE_FILE_CUSTOMER_MODULES_LIST, 'loggedOnAddons' => 1),
        );
        foreach ($files_list as $f) {
            if (file_exists($f['file']) && ($f['loggedOnAddons'] == 0 || $logged_on_addons)) {
                $file = $f['file'];
                $content = \Tools::file_get_contents($file);//Tools14
                $xml = @simplexml_load_string($content, null, LIBXML_NOCDATA);

                if ($xml && isset($xml->module)) {
                    foreach ($xml->module as $modaddons) {
                        $flag_found = 0;

                        foreach ($module_list as $k => &$m) {
                            if (Tools::strtolower($m->name) == Tools14::strtolower($modaddons->name) && !isset($m->available_on_addons)) {
                                $flag_found = 1;
                                if ($m->version != $modaddons->version && version_compare($m->version, $modaddons->version) === -1) {
                                    $module_list[$k]->version_addons = $modaddons->version;
                                }
                            }
                        }
                        if ($flag_found == 1) {
                            if (isset($module_list[$modaddons->name . '_disk'])) {
                                $module_list[$modaddons->name . '_disk']->description_full = Tools::stripslashes(strip_tags((string)$modaddons->description_full));
                                $module_list[$modaddons->name . '_disk']->additional_description = Tools::stripslashes(strip_tags((string)$modaddons->additional_description));
                                $module_list[$modaddons->name . '_disk']->image = \Module::copyModAddonsImg($modaddons);
                                $module_list[$modaddons->name . '_disk']->show_quick_view = true;
                            }
                            break;
                        }
                    }
                }
            }
        }

        foreach ($module_list as $key => &$module) {
            if (!isset($module->tab)) {
                $module->tab = 'others';
            }
            if (defined('_PS_HOST_MODE_') && in_array($module->name, self::$hosted_modules_blacklist)) {
                unset($module_list[$key]);
            } elseif (isset($modules_installed[$module->name])) {
                $module->installed = true;
                $module->database_version = $modules_installed[$module->name]['version'];
                $module->interest = $modules_installed[$module->name]['interest'];
                $module->enable_device = $modules_installed[$module->name]['enable_device'];
            } else {
                $module->installed = false;
                $module->database_version = 0;
                $module->interest = 0;
            }
        }

        usort($module_list, function ($a, $b) {
            return strnatcasecmp($a->displayName, $b->displayName);
        });
        if ($errors) {
            if (!isset(\Context::getContext()->controller) && !\Context::getContext()->controller->controller_name) {
                echo '<div class="alert error"><h3>' . \Context::getContext()->getTranslator()->trans('The following module(s) could not be loaded', array(), 'Admin.Modules.Notification') . ':</h3><ol>';
                foreach ($errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
                echo '</ol></div>';
            } else {
                foreach ($errors as $error) {
                    \Context::getContext()->controller->errors[] = $error;
                }
            }
        }

        return $module_list;
    }


    /**
     * Return if the module is provided by addons.prestashop.com or not.
     *
     * @param string $name The module name (the folder name)
     * @param string $key The key provided by addons
     *
     * @return int
     */
    final public static function isModuleTrusted($module_name)
    {
        static $trusted_modules_list_content = null;
        static $modules_list_content = null;
        static $default_country_modules_list_content = null;
        static $untrusted_modules_list_content = null;

        $context = \Context::getContext();

        // If the xml file exist, isn't empty, isn't too old
        // and if the theme hadn't change
        // we use the file, otherwise we regenerate it
        if (!(
            file_exists(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST)
            && filesize(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST) > 0
            && ((time() - filemtime(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST)) < 86400)
        )) {
            self::generateTrustedXml($module_name);
        }

        if ($trusted_modules_list_content === null) {
            $trusted_modules_list_content = \Tools::file_get_contents(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST);
            if (strpos($trusted_modules_list_content, $context->shop->theme->getName()) === false) {
                self::generateTrustedXml($module_name);
            }
        }

        $modulesListCacheFilepath = _PS_ROOT_DIR_ . self::CACHE_FILE_MODULES_LIST;
        if ($modules_list_content === null && is_readable($modulesListCacheFilepath)) {
            $modules_list_content = \Tools::file_get_contents($modulesListCacheFilepath);
        }

        if ($default_country_modules_list_content === null) {
            $default_country_modules_list_content = \Tools::file_get_contents(_PS_ROOT_DIR_ . self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST);
        }

        if ($untrusted_modules_list_content === null) {
            $untrusted_modules_list_content = \Tools::file_get_contents(_PS_ROOT_DIR_ . self::CACHE_FILE_UNTRUSTED_MODULES_LIST);
        }

        // If the module is trusted, which includes both partner modules and modules bought on Addons

        if (stripos($trusted_modules_list_content, $module_name) !== false) {
            // If the module is not a partner, then return 1 (which means the module is "trusted")
            if (stripos($modules_list_content, '<module name="' . $module_name . '"/>') == false) {
                return 1;
            } elseif (stripos($default_country_modules_list_content, '<name><![CDATA[' . $module_name . ']]></name>') !== false) {
                // The module is a parter. If the module is in the file that contains module for this country then return 1 (which means the module is "trusted")
                return 1;
            }
            // The module seems to be trusted, but it does not seem to be dedicated to this country
            return 2;
        } elseif (stripos($untrusted_modules_list_content, $module_name) !== false) {
            // If the module is already in the untrusted list, then return 0 (untrusted)
            return 0;
        } else {
            // If the module isn't in one of the xml files
            // It might have been uploaded recenlty so we check
            // Addons API and clear XML files to be regenerated next time
            self::deleteTrustedXmlCache();

            return (int)\Module::checkModuleFromAddonsApi($module_name);
        }
    }

    /**
     * Delete the trusted / untrusted XML files, generated by generateTrustedXml().
     */
    final public static function deleteTrustedXmlCache()
    {
        \Tools::deleteFile(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST);
        \Tools::deleteFile(_PS_ROOT_DIR_ . self::CACHE_FILE_UNTRUSTED_MODULES_LIST);
    }

    /**
     * Generate XML files for trusted and untrusted modules.
     */
    final public static function generateTrustedXml($module_name)
    {
        $modules_on_disk = self::getModuleDirOnDisk($module_name);
        $trusted = array();
        $untrusted = array();

        $trusted_modules_xml = array(
            _PS_ROOT_DIR_ . self::CACHE_FILE_ALL_COUNTRY_MODULES_LIST,
            _PS_ROOT_DIR_ . self::CACHE_FILE_MUST_HAVE_MODULES_LIST,
            _PS_ROOT_DIR_ . self::CACHE_FILE_DEFAULT_COUNTRY_MODULES_LIST,
        );

        if (file_exists(_PS_ROOT_DIR_ . self::CACHE_FILE_CUSTOMER_MODULES_LIST)) {
            $trusted_modules_xml[] = _PS_ROOT_DIR_ . self::CACHE_FILE_CUSTOMER_MODULES_LIST;
        }

        // Create 2 arrays with trusted and untrusted modules
        foreach ($trusted_modules_xml as $file) {
            $content = \Tools::file_get_contents($file);
            $xml = @simplexml_load_string($content, null, LIBXML_NOCDATA);

            if ($xml && isset($xml->module)) {
                foreach ($xml->module as $modaddons) {
                    $trusted[] = \Tools::strtolower((string)$modaddons->name);
                }
            }
        }

        foreach (glob(_PS_ROOT_DIR_ . '/config/xml/themes/*.xml') as $theme_xml) {
            if (file_exists($theme_xml)) {
                $content = \Tools::file_get_contents($theme_xml);
                $xml = @simplexml_load_string($content, null, LIBXML_NOCDATA);

                if ($xml) {
                    foreach ($xml->modules->module as $modaddons) {
                        if ((string)$modaddons['action'] == 'install') {
                            $trusted[] = \Tools::strtolower((string)$modaddons['name']);
                        }
                    }
                }
            }
        }

        foreach ($modules_on_disk as $name) {
            if (!in_array($name, $trusted)) {
                if (\Module::checkModuleFromAddonsApi($name)) {
                    $trusted[] = \Tools::strtolower($name);
                } else {
                    $untrusted[] = \Tools::strtolower($name);
                }
            }
        }

        $context = \Context::getContext();

        // Save the 2 arrays into XML files
        $trusted_xml = new \SimpleXMLElement('<modules_list/>');
        $trusted_xml->addAttribute('theme', $context->shop->theme->getName());
        $modules = $trusted_xml->addChild('modules');
        $modules->addAttribute('type', 'trusted');
        foreach ($trusted as $key => $name) {
            $module = $modules->addChild('module');
            $module->addAttribute('name', $name);
        }
        unset($key);
        $success = @file_put_contents(_PS_ROOT_DIR_ . self::CACHE_FILE_TRUSTED_MODULES_LIST, $trusted_xml->asXML());

        $untrusted_xml = new \SimpleXMLElement('<modules_list/>');
        $modules = $untrusted_xml->addChild('modules');
        $modules->addAttribute('type', 'untrusted');
        foreach ($untrusted as $key => $name) {
            $module = $modules->addChild('module');
            $module->addAttribute('name', $name);
        }
        $success &= @file_put_contents(_PS_ROOT_DIR_ . self::CACHE_FILE_UNTRUSTED_MODULES_LIST, $untrusted_xml->asXML());

        if ($success) {
            return true;
        } else {
            \Context::getContext()->getTranslator()->trans('Trusted and Untrusted XML have not been generated properly', array(), 'Admin.Modules.Notification');
        }
    }
}
