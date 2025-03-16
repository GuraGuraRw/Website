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

namespace PrestaShop\Module\EtsAutoUpgrade\Parameters;

use PrestaShop\Module\EtsAutoUpgrade\Tools14;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class used for management of to do files for upgrade tasks.
 * Load / Save / Delete etc.
*/
class FileConfigurationStorage
{
	/**
	 * @var string Location where all the configuration files are stored
	*/
	private $configPath;

	/**
	 * @var Filesystem
	*/
	private $filesystem;

	public function __construct($path)
	{
		$this->configPath = $path;
		$this->filesystem = new Filesystem();
	}

	/**
	 * UpgradeConfiguration loader.
	 *
	 * @param string $fileName File name to load
	 *
	 * @return mixed or array() as default value
	*/
	public function load($fileName = '')
	{
		$configFilePath = $this->configPath . $fileName;
		$config = array();

		if (file_exists($configFilePath)) {
			$config = @unserialize(call_user_func('base64_decode', Tools14::file_get_contents($configFilePath)));
		}

		return $config;
	}

	/**
	 * @param mixed $config
	 * @param string $fileName Destination name of the config file
	 *
	 * @return bool
	*/
	public function save($config, $fileName)
	{
		$configFilePath = $this->configPath . $fileName;
		try {
			$this->filesystem->dumpFile($configFilePath, call_user_func('base64_encode', serialize($config)));

			return true;
		} catch (IOException $e) {
			// TODO: $e needs to be logged
			return false;
		}
	}

	/**
	 * @return array Temporary files path & name
	*/
	public function getFilesList()
	{
		$files = array();
		foreach (UpgradeFileNames::$tmp_files as $file) {
			$files[$file] = $this->getFilePath(constant('PrestaShop\\Module\\EtsAutoUpgrade\\Parameters\\UpgradeFileNames::' . $file));
		}

		return $files;
	}

	/**
	 * Delete all temporary files in the config folder.
	*/
	public function cleanAll()
	{
		$this->filesystem->remove(self::getFilesList());
	}

	/**
	 * Delete a file from the filesystem.
	 *
	 * @param string $fileName
	*/
	public function clean($fileName)
	{
		$this->filesystem->remove($this->getFilePath($fileName));
	}

	/**
	 * Check if a file exists on the filesystem.
	 *
	 * @param string $fileName
	*/
	public function exists($fileName)
	{
		return $this->filesystem->exists($this->getFilePath($fileName));
	}

	/**
	 * Generate the complete path to a given file.
	 *
	 * @param string $file Name
	 *
	 * @return string Pgit gui&
	 *                ath
	*/
	private function getFilePath($file)
	{
		return $this->configPath . $file;
	}
}
