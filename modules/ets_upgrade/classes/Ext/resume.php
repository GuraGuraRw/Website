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

@ini_set('memory_limit', '1280M');
@ini_set('max_execution_time', '300');
@ini_set('upload_max_filesize', '128M');
@ini_set('post_max_size', '128M');
@ini_set('display_errors', 'off');

use PrestaShop\Module\EtsAutoUpgrade\BackupFinder;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;
use PrestaShop\Module\EtsAutoUpgrade\Tools14;

$adminDir = basename(realpath(dirname(__FILE__) . '/..'));
$_POST['dir'] = $adminDir;
/**
 * This file is the entrypoint for all ajax requests during a upgrade, rollback or configuration.
 * In order to get the admin context, this file is copied to the admin/ets_upgrade folder of your shop when the module configuration is reached.
 *
 * Calling it from the module/ets_upgrade folder will have unwanted consequences on the upgrade and your shop.
 */
require_once realpath(dirname(__FILE__) . '/../../modules/ets_upgrade') . '/classes/Ext/upgradetabconfig';
$container = autoupgrade_init_container(dirname(__FILE__));

(new \PrestaShop\Module\EtsAutoUpgrade\ErrorHandler($container->getLogger()))->enable();

$scriptName = $_SERVER['SCRIPT_NAME'];
if (!defined('_PS_BASE_URI_')) {
    define('_PS_BASE_URI_', Tools14::substr($scriptName, 0, strpos($scriptName, $adminDir)));
}
$translator = $container->getTranslator();
$ps_root_path = $container->getProperty($container::PS_ROOT_PATH);

// Twig var.
$https = !empty($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : (!empty($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO']: null));
$ssl = $https && (strcasecmp('on', $https) == 0 || strcasecmp('https', $https) == 0);
$currentFo = (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 || $ssl ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . (isset($_SERVER['HTTP_HOST']) && preg_match('#:\d+#', $_SERVER['HTTP_HOST']) ? ':' . $_SERVER['SERVER_PORT'] : '') . _PS_BASE_URI_;
$twig_vars = array(
    'psBaseUri' => _PS_BASE_URI_,
    'currentIndex' => ($linkBo = $currentFo . $adminDir) . '/ets_upgrade/',
    'pathImg' => rtrim(_PS_BASE_URI_, '/') . '/modules/ets_upgrade/views/img/',
    'md5KeyCheck' => @file_exists($keyFile = $ps_root_path . '/modules/ets_upgrade/cache/key.txt') ? $keyFile : false,
    'linkBo' => $linkBo,
    'linkFo' => $currentFo,
    'certificate' => ($certificate = Tools14::getValue('key')),
    'rollbackLink' => $linkBo . '/ets_upgrade/rollback.php',
    'upgradeLink' => $linkBo . '/index.php?controller=EtsAdminSelfUpgrade',
    'logLink' => @file_exists(($logLink = $linkBo . '/ets_upgrade/tmp/log.txt')) ? $logLink : false,
    'resumeLink' => $linkBo . '/ets_upgrade/resume.php',
    'rollbackKey' => $certificate,
    'PHP_VERSION' => phpversion(),
);

// Check & Validate MD5 key code.
if (Tools14::isSubmit('ets_autoup_submit')) {
    if (!$certificate) {
        $errorMessage = $translator->trans('Resume key is required.', array(), 'Module.Etsupgrade.Admin');
    } else {
        $keyCheckMD5 = trim(Tools14::file_get_contents($ps_root_path . '/modules/ets_upgrade/cache/key.txt'));
        if (!preg_match('/^[a-f0-9]{32}$/', $certificate) || !trim($keyCheckMD5) || $certificate !== $keyCheckMD5) {
            $errorMessage = $translator->trans('Resume key is invalid.', array(), 'Module.Etsupgrade.Admin');
        }
    }
}

if (isset($errorMessage) && $errorMessage) {
    $twig_vars['errorMessage'] = $errorMessage;
} elseif ($certificate) {
    $resumeNextParams = dirname(__FILE__) . DIRECTORY_SEPARATOR . UpgradeFileNames::NEXT_PARAMS_RESUME;
    $twig_vars = array_merge($twig_vars, array(
        'jsParams' => $container->getFileConfigurationStorage()->load(UpgradeFileNames::FILES_INIT_JS_PARAMS),
        'resumeNextParams' => @file_exists($resumeNextParams) ? ((time() - (int)@filectime($resumeNextParams)) >= 60 ? $container->getFileConfigurationStorage()->load(UpgradeFileNames::NEXT_PARAMS_RESUME) : -1) : array(),
        'availableBackups' => (new BackupFinder($container->getProperty($container::BACKUP_PATH)))->getAvailableBackups(),
    ));
}

// Display Resume Form.
$twig = $container->getTwig();
echo $twig->render('@ModuleAutoUpgrade/block/resume.twig', $twig_vars);