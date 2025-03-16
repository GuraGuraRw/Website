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

use PrestaShop\Module\EtsAutoUpgrade\UpgradeException as UpgradeException;

class XmlUtils
{
    private function __construct()
    {
    }

    /**
     * Parses an XML string.
     *
     * @param string $content An XML string
     * @param string|callable|null $schemaOrCallable An XSD schema file path, a callable, or null to disable validation
     *
     * @return \DOMDocument
     * @throws \PrestaShop\Module\EtsAutoUpgrade\UpgradeException
     */
    public static function parse($content, $schemaOrCallable = null)
    {
        if (!\extension_loaded('dom')) {
            //throw new \RuntimeException('Extension DOM is required.');
            throw (new UpgradeException())->setQuickInfos('Extension DOM is required.')->setSeverity(UpgradeException::SEVERITY_ERROR);
        }

        $internalErrors = libxml_use_internal_errors(true);
        if (\LIBXML_VERSION < 20900) {
            $disableEntities = call_user_func('libxml_disable_entity_loader', true);
        }
        libxml_clear_errors();

        $dom = new \DOMDocument();
        $dom->validateOnParse = true;
        if (!$dom->loadXML($content, LIBXML_NONET | (\defined('LIBXML_COMPACT') ? LIBXML_COMPACT : 0))) {
            if (\LIBXML_VERSION < 20900) {
                call_user_func('libxml_disable_entity_loader', $disableEntities);
            }

            throw (new UpgradeException())->setQuickInfos(implode("\n", static::getXmlErrors($internalErrors)))->setSeverity(UpgradeException::SEVERITY_ERROR);
        }

        $dom->normalizeDocument();

        libxml_use_internal_errors($internalErrors);
        if (\LIBXML_VERSION < 20900) {
            call_user_func('libxml_disable_entity_loader', $disableEntities);
        }

        foreach ($dom->childNodes as $child) {
            if (XML_DOCUMENT_TYPE_NODE === $child->nodeType) {
                throw (new UpgradeException())->setQuickInfos('Document types are not allowed.')->setSeverity(UpgradeException::SEVERITY_ERROR);
            }
        }

        if (null !== $schemaOrCallable) {
            $internalErrors = libxml_use_internal_errors(true);
            libxml_clear_errors();

            $e = null;
            if (\is_callable($schemaOrCallable)) {
                try {
                    $valid = \call_user_func($schemaOrCallable, $dom, $internalErrors);
                } catch (\Exception $e) {
                    $valid = false;
                }
            } elseif (!\is_array($schemaOrCallable) && is_file((string)$schemaOrCallable)) {
                $schemaSource = \Tools::file_get_contents((string)$schemaOrCallable);
                $valid = @$dom->schemaValidateSource($schemaSource);
            } else {
                libxml_use_internal_errors($internalErrors);

                throw (new UpgradeException())->setQuickInfos('The schemaOrCallable argument has to be a valid path to XSD file or callable.')->setSeverity(UpgradeException::SEVERITY_ERROR);
            }

            if (!$valid) {
                $messages = static::getXmlErrors($internalErrors);
                if (empty($messages)) {
                    throw (new UpgradeException())->setQuickInfos('The XML is not valid.')->setSeverity(UpgradeException::SEVERITY_ERROR);
                }
                throw (new UpgradeException())->setQuickInfos(implode("\n", $messages))->setSeverity(UpgradeException::SEVERITY_ERROR);
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $dom;
    }

    /**
     * Loads an XML file.
     *
     * @param string $file An XML file path
     * @param string|callable|null $schemaOrCallable An XSD schema file path, a callable, or null to disable validation
     *
     * @return \DOMDocument
     *
     * @throws \PrestaShop\Module\EtsAutoUpgrade\UpgradeException
     */
    public static function loadFile($file, $schemaOrCallable = null)
    {
        $content = \Tools::file_get_contents($file);
        if ('' === trim($content)) {
            throw (new UpgradeException())->setQuickInfos(sprintf('File %s does not contain valid XML, it is empty.', $file))->setSeverity(UpgradeException::SEVERITY_ERROR);
        }

        try {
            return static::parse($content, $schemaOrCallable);
        } catch (UpgradeException $e) {
            throw $e->setQuickInfos(sprintf('The XML file "%s" is not valid.', $file))->setSeverity(UpgradeException::SEVERITY_ERROR);
        }
    }

    protected static function getXmlErrors($internalErrors)
    {
        $errors = [];
        foreach (libxml_get_errors() as $error) {
            $errors[] = sprintf('[%s %s] %s (in %s - line %d, column %d)',
                LIBXML_ERR_WARNING == $error->level ? 'WARNING' : 'ERROR',
                $error->code,
                trim($error->message),
                $error->file ?: 'n/a',
                $error->line,
                $error->column
            );
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $errors;
    }
}