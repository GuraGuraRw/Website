<?php
/**
 * 2007-2025 Sendinblue
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@sendinblue.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    Sendinblue <contact@sendinblue.com>
 * @copyright 2007-2025 Sendinblue
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of Sendinblue
 */

use Sendinblue\Services\ConfigService;
use Sendinblue\Services\NewsletterRecipientService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class WebserviceSpecificManagementSendinbluenewsletterrecipients extends WebserviceSpecificManagementSendinblueAbstract
{
    const DEFAULT_LIMIT = 1000;
    const DEFAULT_OFFSET = 0;

    public function manage()
    {
        if (!Module::isEnabled('ps_emailsubscription')) {
            $this->response = [];
            return;
        }

        $limit = Tools::getValue('limit') ?: self::DEFAULT_LIMIT;
        $offset = Tools::getValue('offset') ?: self::DEFAULT_OFFSET;

        try {
            $subscriptionService = new NewsletterRecipientService();
            $this->response = $subscriptionService->getNewsletterRecipients($limit, $offset);
        } catch (PrestaShopException $e) {
            PrestaShopLogger::addLog($e->getMessage(), ConfigService::ERROR_LEVEL);
            $this->response = [];
        }
    }
}
