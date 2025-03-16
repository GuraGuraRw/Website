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

use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use PrestaShop\Module\EtsAutoUpgrade\UpgradeException;
use PrestaShop\Module\EtsAutoUpgrade\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use PrestaShop\Module\EtsAutoUpgrade\LoggedEvent;

class SettingsFileWriter
{
    private $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function migrateSettingsFile(LoggerInterface $logger, $prestaShopBundle = false)
    {
        if ($prestaShopBundle && !class_exists('\PrestaShopBundle\Install\Upgrade'))
            require_once realpath(__DIR__ . '/../') . '/Upgrade.php';
        if (class_exists('\PrestaShopBundle\Install\Upgrade')) {
            \PrestaShopBundle\Install\Upgrade::migrateSettingsFile(new LoggedEvent($logger));
        }
    }

    /**
     * @param string $filePath
     * @param array $data
     *
     * @throws UpgradeException
     */
    public function writeSettingsFile($filePath, $data)
    {
        if (!is_writable($filePath)) {
            throw new UpgradeException($this->translator->trans('Error when opening settings.inc.php file in write mode', array(), 'Modules.Etsupgrade.Admin'));
        }

        // Create backup file
        $filesystem = new Filesystem();
        $filesystem->copy($filePath, $filePath . '.bck');

        $fd = fopen($filePath, 'w');
        fwrite($fd, '<?php' . PHP_EOL);
        foreach ($data as $name => $value) {
            if (false === fwrite($fd, "define('$name', '{$this->checkString($value)}');" . PHP_EOL)) {
                throw new UpgradeException($this->translator->trans('Error when generating new settings.inc.php file.', array(), 'Modules.Etsupgrade.Admin'));
            }
        }
        fclose($fd);
    }

    public function checkString($string)
    {
        /*if (call_user_func('get_magic_quotes_gpc')) {
            $string = Tools14::stripslashes($string);
        }*/
        if (!is_numeric($string)) {
            $string = addslashes($string);
            $string = str_replace(array("\n", "\r"), '', $string);
        }

        return $string;
    }
}
