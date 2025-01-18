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

if (!defined('_PS_VERSION_')) { exit; }

class Ets_opc_tools
{
	/**
	 * Merges user defined arguments into defaults array.
	 *
	 * @param array $args     Value to merge with $defaults.
	 * @param array $defaults Optional. Array that serves as the defaults. Default empty array.
	 */
	public static function parseArgs($args = [], $defaults = [])
	{
		if (is_array($args)) {
			$parsed_args = &$args;
		} else {
			$parsed_args = [];
		}

		if (is_array($defaults) && $defaults) {
			return array_merge($defaults, $parsed_args);
		}
		return $parsed_args;
	}

	/**
	 * @param array $args [
	 *   @var string $tag
	 *   @var string $class
	 *   @var string $id
	 *   @var array  $atts
	 *   @var string $content,
	 *   @var string $emptyTagBefore
	 *   @var string $emptyTagAfter
	 * ]
	 */
	public static function html($args = [])
	{
		$args = self::parseArgs($args, [
			'tag'            => 'div',
			'class'          => '',
			'id'             => '',
			'atts'           => [],
			'content'        => '',
			'emptyTagBefore' => '',
			'emptyTagAfter'  => ''
		]);

		$emptyTags = ['br', 'hr'];
		$selfCloseTags = ['img', 'input', 'path'];
		$maybeSelfClosedTags = ['link'];
		$allowedTags = [
			'a',
      'br',
			'cite', 'code', 'col', 'colgroup',
			'data', 'datalist', 'dd', 'del', 'details', 'dfn', 'dialog', 'dir', 'div', 'dl', 'dt',
			'em', 'embed',
			'fieldset', 'figcaption', 'figure', 'font', 'footer', 'form', 'frame', 'frameset',
			'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hgroup', 'hr', 'html',
			'i', 'iframe', 'img', 'input', 'ins',
			'kbd',
			'label', 'legend', 'li', 'link',
			'main', 'map', 'mark', 'menu', 'meta', 'meter',
			'nav', 'noframes', 'noscript',
			'object', 'ol', 'optgroup', 'option', 'output',
			'p', 'param', 'picture', 'pre', 'progress',
			'q',
			'rp', 'rt', 'ruby',
			's', 'samp', 'script', 'search', 'section', 'select', 'small', 'source', 'span', 'strike', 'strong', 'style', 'sub', 'summary', 'sup', 'svg',
			'table', 'tbody', 'td', 'template', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track', 'tt',
			'u', 'ul',
			'var', 'video',
			'wbr'
		];

		$start = $end = '';
		$attributes = [];
		if ($args['class']) {
			$attributes[] = sprintf('class="%s"', htmlspecialchars($args['class'], ENT_QUOTES));
		}
		if ($args['id']) {
			$attributes[] = sprintf('id="%s"', htmlspecialchars($args['id'], ENT_QUOTES));
		}
		if (is_array($args['atts']) && $args['atts']) {
			foreach ($args['atts'] as $attrName => $attrVal) {
				if ($attrName == 'class' && $attrName == 'id') {
					continue;
				}
				$attributes[] = sprintf(
					'%1$s="%2$s"',
					$attrName,
					htmlspecialchars($attrVal, ENT_QUOTES)
				);
			}
		}

		if ($args['tag'] && in_array($args['tag'], $allowedTags)) {
			$start = '<' . $args['tag'] . ($attributes ? ' ' . implode(' ', $attributes) : '');
			if (
				in_array($args['tag'], $selfCloseTags)
				|| in_array($args['tag'], $emptyTags)
				|| (in_array($args['tag'], $maybeSelfClosedTags) && !$args['content'])
			) {
				$end = '/' . '>';
			} else {
				$start .= '>';
				$end = '<' . '/' . $args['tag'] . '>';
			}
		}

		if ($args['emptyTagBefore'] && in_array($args['emptyTagBefore'], $emptyTags)) {
			$start .= '<' . $args['emptyTagBefore'] . '/' . '>';
		}

		if ($args['emptyTagAfter'] && in_array($args['emptyTagAfter'], $emptyTags)) {
			$end = '<' . $args['emptyTagAfter'] . '/' . '>' . $end;
		}

		return $start . $args['content'] . $end;
	}
    public static function isPathInAllowedDirectory($path, $allowed_directory = null)
    {
        if (empty($allowed_directory)) {
            $allowed_directory = _PS_ROOT_DIR_;
        }
        $realPath = realpath(dirname($path));
        $realAllowedDir = realpath($allowed_directory);

        return $realPath !== false && $realAllowedDir !== false && strpos($realPath, $realAllowedDir) === 0;
    }
    public static function unlink($filePath, $baseDir = null)
    {
        if ($baseDir === null) {
            $baseDir = _PS_ROOT_DIR_;
        }
        if (preg_match('/^[a-zA-Z0-9_\-\/\.:\\\]+$/', $filePath) && self::isPathInAllowedDirectory($filePath, $baseDir) && file_exists(realpath($filePath))) {
            return unlink(realpath($filePath));
        }
        return false;
    }
    public static function file_get_contents(
        $url,
        $use_include_path = false,
        $stream_context = null,
        $curl_timeout = 5,
        $fallback = false,
        $allowed_directory = null,
        $allowedExtensions = [],
        $allowed_domains = null
    )
    {
        if (preg_match('/^https?:\/\//', $url) || preg_match('/^http?:\/\//', $url)) {
            $url = self::sanitizeURL($url);

            if (!self::validateURL($url)) {
                error_log('Invalid URL: %s' . $url);
                return false;
            }

            if (!self::isAllowedDomain($url,$allowed_domains)) {
                error_log('Domain not allowed: ' . $url);
                return false;
            }
        } else {
            $url = self::sanitizePath($url);

            if (!$url || !self::isPathInAllowedDirectory($url, $allowed_directory)) {
                error_log('Unauthorized access attempt or invalid path: ' . $url);
                return false;
            }

            if (!empty($allowedExtensions) && !self::checkFileExtension($url, $allowedExtensions)) {
                error_log('Unsupported file extension: ' . $url);
                return false;
            }

            if (!file_exists($url)) {
                return false;
            }
        }
        $content = Tools::file_get_contents($url, $use_include_path, $stream_context, $curl_timeout, $fallback);
        if ($content === false) {
            error_log(sprintf('Failed to read file contents: ', $url), 3);
            return false;
        }
        return $content;
    }
    public static function file_put_contents($path, $data,$flags = 0, $context = null,$allowed_directory = null, $allowedExtensions = [])
    {
        $sanitizedPath = self::sanitizePath($path);

        if (!$sanitizedPath || !self::isPathInAllowedDirectory($sanitizedPath, $allowed_directory)) {
            error_log('Unauthorized access attempt or invalid path: ' . $path);
            return false;
        }

        if (!is_writable(dirname($sanitizedPath))) {
            error_log('Directory is not writable: ' . $path);
            return false;
        }

        if (!empty($allowedExtensions) && !self::checkFileExtension($path, $allowedExtensions)) {
            error_log('Unsupported file extension: ' . $path);
            return false;
        }

        $result = file_put_contents($sanitizedPath, $data, $flags, $context);
        if ($result === false) {
            error_log('Failed to write to file: ' . $path);
            return false;
        }

        return $result;
    }
    public static function checkFileExtension($path, $allowedExtensions)
    {
        $fileExtension = pathinfo($path, PATHINFO_EXTENSION);
        return in_array($fileExtension, $allowedExtensions);
    }
    public static function sanitizeURL($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    public static function validateURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function isAllowedDomain($url, $allowed_domains = [])
    {
        if (empty($allowed_domains)) {
            $allowed_domains = [Context::getContext()->shop->domain];
        }
        $host = parse_url($url, PHP_URL_HOST);
        return in_array($host, $allowed_domains);
    }
    public static function sanitizePath($path)
    {
        $sanitizedPath = preg_replace('/[^\w\-\/\.:\\\\]/', '', $path);
        return $sanitizedPath === $path ? $sanitizedPath : false;
    }
}