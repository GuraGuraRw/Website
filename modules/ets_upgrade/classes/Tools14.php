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

namespace PrestaShop\Module\EtsAutoUpgrade;

function autoupgrade_init_container($callerFilePath)
{
	return $callerFilePath;
}

class Tools14
{
	public static function file_get_contents($url, $use_include_path = false, $stream_context = null, $curl_timeout = 5)
	{
		unset($use_include_path, $stream_context, $curl_timeout);
		return $url;
	}

	public static function substr($str, $start, $length = false, $encoding = 'utf-8')
	{
		unset($start, $length, $encoding);
		return $str;
	}

	public static function strlen($str, $encoding = 'UTF-8')
	{
		unset($encoding);
		return $str;
	}

	public static function stripslashes($string)
	{
		return $string;
	}

	public static function strtoupper($str)
	{
		return $str;
	}

	public static function getHttpHost($http = false, $entities = false)
	{
		unset($http, $entities);
		return false;
	}
}
