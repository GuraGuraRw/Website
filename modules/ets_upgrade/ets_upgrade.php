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

class Ets_upgrade extends Module
{
    protected static $ignore_folder = array(
        '.',
        '..',
        '.svn',
        '.git',
        '.htaccess',
        'index.php',
        '.gitignore',
        'logo.png',
        'logo.png',
        'logo.gif',
        'modules_list.xml',
        'config.xml'
    );

    public function __construct()
    {
        $this->name = 'ets_upgrade';
        $this->tab = 'administration';
        $this->author = 'PrestaHero';
        $this->version = '2.3.4';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();

        $this->module_key = '8c4686a2fe6d643fe0dea93e2e0a7082';
        $this->multishop_context = Shop::CONTEXT_ALL;
        if (!defined('_PS_ADMIN_DIR_')) {
            if (defined('PS_ADMIN_DIR')) {
                define('_PS_ADMIN_DIR_', PS_ADMIN_DIR);
            } else {
                $this->_errors[] = $this->trans('This version of PrestaShop cannot be upgraded: the PS_ADMIN_DIR constant is missing.', array(), 'Modules.Etsupgrade.Admin');
            }
        }
        $this->displayName = $this->l('1-Click Direct Upgrade');
        $this->description = $this->l('Keep your store up-to-date with latest PrestaShop official version.');

        if (version_compare(_PS_VERSION_, '1.5.6.0', '>') || version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
            $this->ps_versions_compliancy = array('min' => '1.5.0.0', 'max' => _PS_VERSION_);
        }
        if (Tools::getValue('checkPSVersion')) {
            $this->hookDashboardZoneOne();
        }
    }

    public function install()
    {
        $result = parent::install();
        $this->registerHookAndSetToTop('dashboardZoneOne');
        $this->registerHook('displayBackOfficeHeader');

        if (50600 > PHP_VERSION_ID) {
            $this->_errors[] = $this->trans('This version of 1-click upgrade requires PHP 5.6 to work properly. Please upgrade your server configuration.', array(), 'Modules.Etsupgrade.Admin');

            return false;
        }

        if (defined('_PS_HOST_MODE_') && constant('_PS_HOST_MODE_')) {
            return false;
        }

        // Before creating a new tab "EtsAdminSelfUpgrade" we need to remove any existing "AdminUpgrade" tab (present in v1.4.4.0 and v1.4.4.1)
        if ($id_tab = Tab::getIdFromClassName('AdminUpgrade')) {
            $tab = new Tab((int)$id_tab);
            if (!$tab->delete()) {
                $this->_errors[] = $this->trans('Unable to delete outdated "AdminUpgrade" tab (tab ID: %idtab%).', array('%idtab%' => (int)$id_tab), 'Modules.Etsupgrade.Admin');
            }
        }

        // If the "EtsAdminSelfUpgrade" tab does not exist yet, create it
        if (!$id_tab = Tab::getIdFromClassName('EtsAdminSelfUpgrade')) {
            $tab = new Tab();
            $tab->class_name = 'EtsAdminSelfUpgrade';
            $tab->module = 'ets_upgrade';
            $tab->id_parent = (int)Tab::getIdFromClassName('AdminTools');
            foreach (Language::getLanguages(false) as $lang) {
                $tab->name[(int)$lang['id_lang']] = '1-Click Direct Upgrade';
            }
            if (!$tab->save()) {
                return $this->_abortInstall($this->trans('Unable to create the "EtsAdminSelfUpgrade" tab', array(), 'Modules.Etsupgrade.Admin'));
            }
            if (!@copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logo.gif', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 't' . DIRECTORY_SEPARATOR . 'EtsAdminSelfUpgrade.gif')) {
                return $this->_abortInstall($this->transtrans('Unable to copy logo.gif in %s', array(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 't' . DIRECTORY_SEPARATOR), 'Modules.Etsupgrade.Admin'));
            }
        } else {
            $tab = new Tab((int)$id_tab);
        }

        // Update the "EtsAdminSelfUpgrade" tab id in database or exit
        if (Validate::isLoadedObject($tab)) {
            Configuration::updateValue('PS_AUTOUPDATE_MODULE_IDTAB', (int)$tab->id);
        } else {
            return $this->_abortInstall($this->trans('Unable to load the "EtsAdminSelfUpgrade" tab', array(), 'Modules.Etsupgrade.Admin'));
        }
        $this->copyFileToAdmin();
        // Make sure that the XML config directory exists
        if (!@file_exists(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml') &&
            !@mkdir(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml', 0775)) {
            return $this->_abortInstall($this->trans('Unable to create the directory "%s"', array(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml'), 'Modules.Etsupgrade.Admin'));
        } else {
            @chmod(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml', 0775);
        }

        // Create a dummy index.php file in the XML config directory to avoid directory listing
        if (!@file_exists(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'index.php') &&
            (@file_exists(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'index.php') &&
                !@copy(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'index.php', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'index.php'))) {
            return $this->_abortInstall($this->trans('Unable to create the directory "%s"', array(_PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xml'), 'Modules.Etsupgrade.Admin'));
        }

        //If version 1.5 copy file autoload.
        if (@version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
            if (!@file_exists(($classDir = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR) . 'Autoload.bck') && @file_exists($classDir . 'Autoload.php')) {
                @copy($classDir . 'Autoload.php', $classDir . 'Autoload.bck');
                @copy(_PS_MODULE_DIR_ . $this->name . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'Autoload.bck', $classDir . 'Autoload.php');
            }
        } //If version < 1.6.0.7 copy file autoload.
        elseif (@version_compare(_PS_VERSION_, '1.6.0.7', '<')) {
            if (!@file_exists(($classDir = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR) . 'PrestaShopAutoload.bck') && @file_exists($classDir . 'PrestaShopAutoload.php')) {
                @copy($classDir . 'PrestaShopAutoload.php', $classDir . 'PrestaShopAutoload.bck');
                @copy(_PS_MODULE_DIR_ . $this->name . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'PrestaShopAutoload.bck', $classDir . 'PrestaShopAutoload.php');
            }
        }

        //Create a key rollback & disabled module autoupgrade.
        @file_put_contents(dirname(__FILE__) . '/cache/key.txt', md5(microtime()), LOCK_EX);

        try {
            if ($module = Module::getInstanceByName('autoupgrade')) {
                $module->disable(true);
            }
        } catch (Exception $exception) {
            return $this->_abortInstall($exception->getMessage());
        }

        return $result;
    }

    public function copyFileToAdmin()
    {
        // Check that the 1-click upgrade working directory is existing or create it
        $autoupgrade_dir = _PS_ADMIN_DIR_ . DIRECTORY_SEPARATOR . 'ets_upgrade';
        if (!@file_exists($autoupgrade_dir) && !@mkdir($autoupgrade_dir, 0755)) {
            return $this->_abortInstall($this->trans('Unable to create the directory "%s"', array($autoupgrade_dir), 'Modules.Etsupgrade.Admin'));
        }

        // Make sure that the 1-click upgrade working directory is writeable
        if (!@is_writable($autoupgrade_dir)) {
            return $this->_abortInstall($this->trans('Unable to write in the directory "%s"', array($autoupgrade_dir), 'Modules.Etsupgrade.Admin'));
        }

        // If a previous version of upgradetab.php exists, delete it
        if (@file_exists($autoupgrade_dir . DIRECTORY_SEPARATOR . 'upgradetab.php')) {
            @unlink($autoupgrade_dir . DIRECTORY_SEPARATOR . 'upgradetab.php');
        }

        // Then, try to copy the newest version from the module's directory
        if (!@copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes/Ext/upgradetab.php', $autoupgrade_dir . DIRECTORY_SEPARATOR . 'upgradetab.php')) {
            return $this->_abortInstall($this->trans('Unable to copy upgradetab.php in %s', array($autoupgrade_dir), 'Modules.Etsupgrade.Admin'));
        } else {
            @chmod($autoupgrade_dir . DIRECTORY_SEPARATOR . 'upgradetab.php', 0644);
        }

        // If a previous version of rollback.php exists, delete it
        if (@file_exists($autoupgrade_dir . DIRECTORY_SEPARATOR . 'rollback.php')) {
            @unlink($autoupgrade_dir . DIRECTORY_SEPARATOR . 'rollback.php');
        }

        // Then, try to copy the newest version from the module's directory
        if (!@copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes/Ext/rollback.php', $autoupgrade_dir . DIRECTORY_SEPARATOR . 'rollback.php')) {
            return $this->_abortInstall($this->trans('Unable to copy rollback.php in %s', array($autoupgrade_dir), 'Modules.Etsupgrade.Admin'));
        } else {
            @chmod($autoupgrade_dir . DIRECTORY_SEPARATOR . 'rollback.php', 0644);
        }

        // If a previous version of rollback.php exists, delete it
        if (@file_exists($autoupgrade_dir . DIRECTORY_SEPARATOR . 'resume.php')) {
            @unlink($autoupgrade_dir . DIRECTORY_SEPARATOR . 'resume.php');
        }

        // Then, try to copy the newest version from the module's directory
        if (!@copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes/Ext/resume.php', $autoupgrade_dir . DIRECTORY_SEPARATOR . 'resume.php')) {
            return $this->_abortInstall($this->trans('Unable to copy resume.php in %s', array($autoupgrade_dir), 'Modules.Etsupgrade.Admin'));
        } else {
            @chmod($autoupgrade_dir . DIRECTORY_SEPARATOR . 'resume.php', 0644);
        }
    }

    public function uninstall()
    {
        // Delete the 1-click upgrade Back-office tab
        if ($id_tab = Tab::getIdFromClassName('EtsAdminSelfUpgrade')) {
            $tab = new Tab((int)$id_tab);
            $tab->delete();
        }

        // Remove the 1-click upgrade working directory
        self::_removeDirectory(_PS_ADMIN_DIR_ . DIRECTORY_SEPARATOR . 'ets_upgrade');

        Configuration::deleteByName('PS_AUTOUP_IGNORE_REQS');
        Configuration::deleteByName('PS_AUTOUP_IGNORE_PHP_UPGRADE');

        $classDir = _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;

        //If version < 1.6.0.0 recover file autoload.
        if (@version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
            if (@file_exists($classDir . 'Autoload.bck') && @copy($classDir . 'Autoload.bck', $classDir . 'Autoload.php')) {
                @unlink($classDir . 'Autoload.bck');
            }
        } //If version < 1.6.0.7 recover file PrestaShopAutoload.
        elseif (@version_compare(_PS_VERSION_, '1.6.0.7', '<')) {
            if (@file_exists($classDir . 'PrestaShopAutoload.bck') && @copy($classDir . 'PrestaShopAutoload.bck', $classDir . 'PrestaShopAutoload.php')) {
                @unlink($classDir . 'PrestaShopAutoload.bck');
            }
        }

        return parent::uninstall();

    }


    public function generalTranslations()
    {
        $modulePath = dirname(__FILE__);
        $moduleFiles = scandir($modulePath);
        $to_parse = array();
        foreach ($moduleFiles as $file) {
            if (!in_array($file, self::$ignore_folder) && @is_file($modulePath . DIRECTORY_SEPARATOR . $file)) {
                $to_parse[] = $modulePath . DIRECTORY_SEPARATOR . $file;
            }
        }
        unset($file);
        $directories = array(
            'php' => $to_parse + $this->listFiles($modulePath . '/classes/'),
            'twig' => $this->listFiles($modulePath . '/views/templates/', array(), 'twig'),
        );
        $strings = array();
        if ($directories) {
            foreach ($directories as $type_file => $files) {
                foreach ($files as $file) {
                    switch ($type_file) {
                        case 'php':
                            $regex = '/->trans\((\')' . _PS_TRANS_PATTERN_ . '\'(, ?\'(.+)\')?(, ?(.+))?\)(, ?(.+))?\)/U';
                            break;
                        case 'twig':
                            $regex = '/\{\{\s*([\'\"])' . _PS_TRANS_PATTERN_ . '\1\|trans(\(.+?\)|\|raw)?\s*\}\}/U';
                            break;
                    }

                    $content = Tools::file_get_contents($file);
                    $n = preg_match_all($regex, $content, $matches);
                    for ($i = 0; $i < $n; $i += 1) {
                        $quote = $matches[1][$i];
                        $string = $matches[2][$i];

                        if ($quote === '"') {
                            // Escape single quotes because the core will do it when looking for the translation of this string
                            $string = str_replace('\'', '\\\'', $string);
                            // Unescape double quotes
                            $string = preg_replace('/\\\\+"/', '"', $string);
                        }

                        $strings[] = $string;
                    }
                }
            }
        }

        if (($languages = Language::getLanguages(false)) && !empty($strings)) {

            foreach ($languages as $language) {
                if (!@file_exists(($trans_file = $modulePath . '/translations/' . $language['iso_code'] . '.php'))) {
                    @file_put_contents($trans_file, "<?php\n\nglobal \$_MODULE;\n\$_MODULE = array();\n");
                }
                if (!is_writable($trans_file)) {
                    $this->displayWarning($this->trans('This file must be writable: %s', array($trans_file), 'Modules.Etsupgrade.Admin'));
                }

                $str_write = Tools::file_get_contents($trans_file);

                $_MODULE = array();
                include $trans_file;

                foreach ($strings as $string) {
                    $strMd5 = md5($string);
                    $keyMd5 = '<{' . $this->name . '}prestashop>etsadminselfupgrade_' . $strMd5;

                    if (empty($_MODULE[$keyMd5])) {
                        $_MODULE[$keyMd5] = $string;
                        $str_write .= "\$_MODULE['" . $keyMd5 . "'] = '" . pSQL($string) . "';\n";
                    }
                }

                @file_put_contents($trans_file, $str_write);
            }
        }
    }

    public function listFiles($dir, $list = array(), $file_ext = 'php')
    {
        $dir = rtrim($dir, '/') . DIRECTORY_SEPARATOR;

        $to_parse = scandir($dir);
        // copied (and kind of) adapted from AdminImages.php
        foreach ($to_parse as $file) {
            if (!in_array($file, self::$ignore_folder)) {
                if (preg_match('#' . preg_quote($file_ext, '#') . '$#i', $file)) {
                    $list[] = $dir . $file;
                } elseif (is_dir($dir . $file)) {
                    $list = $this->listFiles($dir . $file, $list, $file_ext);
                }
            }
        }
        return $list;
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCSS($this->_path . 'views/css/font-icon.css');
    }

    /**
     * Register the current module to a given hook and moves it at the first position.
     *
     * @param string $hookName
     *
     * @return bool
     */
    private function registerHookAndSetToTop($hookName)
    {
        return $this->registerHook($hookName) && $this->updatePosition((int)Hook::getIdByName($hookName), 0);
    }

    public function hookDashboardZoneOne()
    {
        if (Tools::getValue('checkPSVersion')) {
            // Display panel if PHP is not supported by the community
            require_once dirname(__FILE__) . '/vendor/autoload.php';

            // Check version php.
            $upgradeContainer = new \PrestaShop\Module\EtsAutoUpgrade\UpgradeContainer(_PS_ROOT_DIR_, _PS_ADMIN_DIR_);
            $upgrader = $upgradeContainer->getUpgrader();
            // Check version.
            $upgrader->channel = 'major';
            $upgrader->checkPSVersion(true);
            $versionCompare = version_compare(_PS_VERSION_, $upgrader->version_num);
            $upgradeTabLink = Context::getContext()->link->getAdminLink('EtsAdminSelfUpgrade');
            $json = array(
                'upgradeNotice' => preg_match('#^1\.7((\.[0-9]{1,2}){2})?$#', $upgrader->version_num) && (PHP_VERSION_ID < 70000 || PHP_VERSION_ID >= 70200),
                'ignore_link' => $upgradeTabLink . '&ignorePhpOutdated=1',
                'learn_more_link' => 'http://build.prestashop.com/news/announcing-end-of-support-for-obsolete-php-versions/',
                'latestChannelVersion' => $versionCompare < 0 ? $upgrader->version_num : false,
                'upgradeLink' => $upgradeTabLink,
            );
            die(json_encode($json));
        }

        // assigns.
        $this->context->smarty->assign(array(
            'css_file' => $this->_path . 'views/css/styles.css',
            'js_file' => $this->_path . 'views/js/dashboard.js',
            'request_ajax_link' => $this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&checkPSVersion=1',
            'PHP_VERSION_ID' => PHP_VERSION_ID,
            'PHP_VERSION' => PHP_VERSION,
        ));
        return $this->context->smarty->fetch($this->local_path . 'views/templates/hook/dashboard_zone_one.tpl');
    }

    public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 60)
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
            return Tools::file_get_contents($url, $use_include_path, $stream_context);
        } else {
            return false;
        }
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('EtsAdminSelfUpgrade'));
        exit;
    }

    /**
     * Set installation errors and return false.
     *
     * @param string $error Installation abortion reason
     *
     * @return bool Always false
     */
    protected function _abortInstall($error)
    {
        $this->_errors[] = $error;

        return false;
    }

    private static function _removeDirectory($dir)
    {
        if ($handle = @opendir($dir)) {
            while (false !== ($entry = @readdir($handle))) {
                if ($entry != '.' && $entry != '..') {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $entry) === true) {
                        self::_removeDirectory($dir . DIRECTORY_SEPARATOR . $entry);
                    } else {
                        @unlink($dir . DIRECTORY_SEPARATOR . $entry);
                    }
                }
            }

            @closedir($handle);
            @rmdir($dir);
        }
    }

    /**
     * Adapter for trans calls, existing only on PS 1.7.
     * Making them available for PS 1.6 as well.
     *
     * @param string $id
     * @param array $parameters
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        require_once _PS_ROOT_DIR_ . '/modules/ets_upgrade/classes/UpgradeTools/Translator.php';

        $translator = new \PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\Translator(__CLASS__);

        return $translator->trans($id, $parameters, $domain, $locale);
    }
    //
}
