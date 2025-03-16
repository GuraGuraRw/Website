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

@ini_set('display_errors', 'off');
@ini_set('memory_limit', '1280M');
@ini_set('max_execution_time', '300');
@ini_set('upload_max_filesize', '128M');
@ini_set('post_max_size', '128M');

use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeTools\TaskRepository;
use PrestaShop\Module\EtsAutoUpgrade\Parameters\UpgradeFileNames;

/**
 * This file is the entrypoint for all ajax requests during a upgrade, rollback or configuration.
 * In order to get the admin context, this file is copied to the admin/ets_upgrade folder of your shop when the module configuration is reached.
 *
 * Calling it from the module/ets_upgrade folder will have unwanted consequences on the upgrade and your shop.
*/
require_once realpath(dirname(__FILE__) . '/../../modules/ets_upgrade') . '/classes/Ext/upgradetabconfig';
$container = autoupgrade_init_container(dirname(__FILE__));

(new \PrestaShop\Module\EtsAutoUpgrade\ErrorHandler($container->getLogger()))->enable();

if (!$container->getCookie()->check($_COOKIE) && !(int)$container->getState()->getForceFromFile()) {
	// If this is an XSS attempt, then we should only display a simple, secure page
	if (ob_get_level() && ob_get_length() > 0) {
		ob_clean();
	}
	echo '{wrong token}';
	http_response_code(401);
	die(1);
}

$validActions = array(
    'upgradeNow',
    'download',
    'unzip',
    'backupFiles',
    'backupDb',
    'upgradeFiles',
    'upgradeDb',
    'upgradeModules',
    'removeSamples',
    'enableModules',
    'removeOverride',
    'renameModules',
    'installModules',
    'cleanCached',
);

$action = Tools14::getValue('action');
$controller = TaskRepository::get($action, $container);
$controller->init();
$controller->run();
$jsonResponse = $controller->getJsonResponse();
// Resume
if (in_array($action, $validActions)) {
    $container->getFileConfigurationStorage()->save(Tools14::jsonDecode($jsonResponse), UpgradeFileNames::NEXT_PARAMS_RESUME);
}

echo $jsonResponse;