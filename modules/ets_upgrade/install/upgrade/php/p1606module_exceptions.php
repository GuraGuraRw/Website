<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
function p1606module_exceptions()
{
    $modules_dir = scandir(_PS_MODULE_DIR_, SCANDIR_SORT_NONE);
    $modules_controllers = $core_controllers = [];
    $core_controllers = [];

    foreach ($modules_dir as $module_dir) {
        $module_path = _PS_MODULE_DIR_ . $module_dir;

        if ($module_dir[0] == '.' || $module_dir == 'index.php') {
            continue;
        }

        if (file_exists($module_path . '/controllers/') && is_dir($module_path . '/controllers/')) {
            $module_path_admin = $module_path . '/controllers/admin/';
            if (file_exists($module_path_admin) && is_dir($module_path_admin)) {
                $admin = scandir($module_path_admin, SCANDIR_SORT_NONE);
                foreach ($admin as $a_controller) {
                    if ($a_controller[0] == '.' || $a_controller == 'index.php') {
                        continue;
                    }
                    if (isset($modules_controllers[$module_dir])) {
                        $modules_controllers[$module_dir][] = str_replace('.php', '', $a_controller);
                    } else {
                        $modules_controllers[$module_dir] = [str_replace('.php', '', $a_controller)];
                    }
                }
            }

            $module_path_front = $module_path . '/controllers/front/';
            if (file_exists($module_path_front) && is_dir($module_path_front)) {
                $front = scandir($module_path_front, SCANDIR_SORT_NONE);
                foreach ($front as $f_controller) {
                    if ($f_controller[0] == '.' || $f_controller == 'index.php') {
                        continue;
                    }
                    if (isset($modules_controllers[$module_dir])) {
                        $modules_controllers[$module_dir][] = str_replace('.php', '', $f_controller);
                    } else {
                        $modules_controllers[$module_dir] = [str_replace('.php', '', $f_controller)];
                    }
                }
            }
        }
    }

    $controller_dir = _PS_ROOT_DIR_ . '/controllers/front/';

    if (file_exists($controller_dir) && is_dir($controller_dir)) {
        $front_controllers = scandir($controller_dir, SCANDIR_SORT_NONE);

        foreach ($front_controllers as $controller) {
            if ($controller[0] == '.' || $controller == 'index.php') {
                continue;
            }
            $core_controllers[] = strtolower(str_replace('Controller.php', '', $controller));
        }
    }

    $hook_module_exceptions = Db::getInstance()->executeS('SELECT * FROM `' . _DB_PREFIX_ . 'hook_module_exceptions`');
    if ($hook_module_exceptions) {
        $sql_insert = '';
        $sql_delete = '';
        foreach ($hook_module_exceptions as $exception) {
            foreach ($modules_controllers as $module => $controllers) {
                if (in_array($exception['file_name'], $controllers) && !in_array($exception['file_name'], $core_controllers)) {
                    $sql_delete .= ' `id_hook_module_exceptions` = ' . (int)$exception['id_hook_module_exceptions'] . ' AND';
                    foreach ($controllers as $cont) {
                        if ($exception['file_name'] == $cont) {
                            $sql_insert .= '(null, ' . (int)$exception['id_shop'] . ', ' . (int)$exception['id_module'] . ', ' . (int)$exception['id_hook'] . ', \'module-' . pSQL($module) . '-' . pSQL($exception['file_name']) . '\'),';
                        }
                    }
                }
            }
        }
        if ($sql_insert !== '')
            Db::getInstance()->execute('INSERT INTO `' . _DB_PREFIX_ . 'hook_module_exceptions` (`id_hook_module_exceptions`, `id_shop`, `id_module`, `id_hook`, `file_name`) VALUES ' . trim($sql_insert, ','));
        if ($sql_delete !== '')
            Db::getInstance()->execute('DELETE FROM `' . _DB_PREFIX_ . 'hook_module_exceptions` WHERE ' . $sql_delete . ' 1');
    }
}
