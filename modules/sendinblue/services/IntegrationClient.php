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

namespace Sendinblue\Services;

if (!defined('_PS_VERSION_')) {
    exit;
}

class IntegrationClient
{
    const ORDER_CREATED_URI = '/events/%s/order_created';
    const DISABLE_SMTP_URI = '/events/%s/disable_smtp';
    const DELETE_USER_CONNECTION = '/events/%s/reset_api_key';
    const PLUGIN_UPDATED = '/events/%s/plugin_updated';

    /**
     * @var ConfigService
     */
    private $configService;

    public function __construct()
    {
        $this->configService = new ConfigService();
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $data
     * @param array $headers
     *
     * @return array
     */
    public function makeHttpRequest($url, $method = 'GET', $data = [], $headers = [])
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
            ]);

            if (empty($headers)) {
                $headers = [
                    'Content-Type: application/json',
                    sprintf('x-sib-shop-version: %s', _PS_VERSION_),
                    sprintf('x-sib-plugin-version: %s', $this->getPluginVersion()),
                ];
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $response = [
                'success' => true,
                'data' => curl_exec($curl),
            ];

            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                $response = [
                    'success' => false,
                    'error' => $error,
                ];
            }
        } catch (\Exception $exception) {
            $response = [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * @return string
     */
    private function getPluginVersion()
    {
        return \Module::getInstanceByName('sendinblue')->version;
    }

    /**
     * @param string
     * @return string
     */
    public function getConnectionUri($path)
    {
        return ConfigService::SIB_INTEGRATIONS_API_URL . sprintf(
            $path,
            $this->configService->getSibConfig(ConfigService::CONFIG_USER_CONNECTION_ID)
        );
    }

    /**
     * @param array $contact
     */
    public function createOrder($contact)
    {
        $this->makeHttpRequest($this->getConnectionUri(self::ORDER_CREATED_URI), 'POST', $contact);
    }

    public function updatePluginVersion($data)
    {
        $this->makeHttpRequest($this->getConnectionUri(self::PLUGIN_UPDATED), 'POST', $data);
    }

    /**
     * @param array $data
     */
    public function disableSmtp()
    {
        $this->makeHttpRequest(
            $this->getConnectionUri(self::DISABLE_SMTP_URI),
            'POST',
            [
                ConfigService::WEBSERVICE_API_KEY => $this->configService->getSibConfig(
                    ConfigService::CONFIG_SENDINBLUE_WEBSERVICE_KEY
                ),
            ]
        );
    }

    public function deleteUserConnection()
    {
        $this->makeHttpRequest(
            $this->getConnectionUri(self::DELETE_USER_CONNECTION),
            'POST',
            [
                ConfigService::WEBSERVICE_API_KEY => $this->configService->getSibConfig(
                    ConfigService::CONFIG_SENDINBLUE_WEBSERVICE_KEY
                ),
            ]
        );
    }
}
