<?php
/**
 * 2007-2025 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2021 PrestaShop SA
 * @license   Academic Free License (AFL 3.0)
 * http://opensource.org/licenses/afl-3.0.php version 3.0
 *  International Registered Trademark & Property of PrestaShop SA
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class Tiktokforbusiness extends Module
{
    protected $config_form = false;
    public const TTCLID_COOKIE = 'ttclid';
    public const TTP_COOKIE = '_ttp';
    private static $events = [];

    public function __construct()
    {
        $this->name = 'tiktokforbusiness';
        $this->tab = 'social_networks';
        $this->version = '1.0.7';
        $this->author = 'TikTok';
        $this->need_instance = 0;
        $this->module_key = 'aa3d9aaba20ba0670a0ddb931ebe5952';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('TikTok for Business');
        $this->description = $this->l('The TikTok module provides merchants with an easy to set up solution that unlocks TikTok’s innovative social commerce features. Merchants can seamlessly sync their product catalog, customize Pixel event tracking, and unlock paid advertising and organic visibility from a single location.');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        $this->registerHook('displayProductExtraContent');
        $this->registerHook('actionCartSave');
        $this->registerHook('displayCheckoutSummaryTop');
        $this->registerHook('displayHome');
        $this->registerHook('displayHeader');

        return parent::install();
    }

    public function uninstall()
    {
        $curl = curl_init();
        $base_url = 'https://business-api.tiktok.com/tbp/v2.0/business_profile/disconnect';
        $external_data = Configuration::get('tt4b_external_data');
        $url = $base_url . '?external_data=' . $external_data;
        $headers = [
            'Content-Type:application/json',
        ];
        $external_business_id = Configuration::get('tt4b_external_business_id');
        $params = [
            'external_business_id' => $external_business_id,
            'business_platform' => 'PRESTA_SHOP',
        ];
        $data = json_encode($params);
        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        PrestaShopLogger::addLog("response from business_profile/disconnect=$result", 1, null, __CLASS__, 255611);

        Configuration::deleteByName('tt4b_app_id');
        Configuration::deleteByName('tt4b_secret');
        Configuration::deleteByName('tt4b_access_token');
        Configuration::deleteByName('tt4b_external_data_key');
        Configuration::deleteByName('tt4b_external_data');
        Configuration::deleteByName('tt4b_adv_id');
        Configuration::deleteByName('tt4b_bc_id');
        Configuration::deleteByName('tt4b_pixel_code');
        Configuration::deleteByName('tt4b_catalog_id');
        Configuration::deleteByName('tt4b_advanced_matching');
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $external_business_id = Configuration::get('tt4b_external_business_id');
        if ($external_business_id == false) {
            $external_business_id = uniqid($prefix = 'tt4b_prestashop');
            Configuration::updateValue('tt4b_external_business_id', $external_business_id);
        }
        $ssl = Configuration::get('PS_SSL_ENABLED');
        if ($ssl !== '1') {
            return $this->displayWarning('SSL is required for this module. Please enable SSL before proceeding');
        }

        $shop = Context::getContext()->shop;
        $shop_name = $shop->name;
        $shop_domain = 'https://' . Context::getContext()->shop->domain_ssl;
        $shop_url = $shop_domain . $shop->getBaseURI();
        $module_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $request_uri = $_SERVER['REQUEST_URI'];
        Configuration::updateValue('tt4b_module_url', $module_url);

        $app_id = Configuration::get('tt4b_app_id');
        $secret = Configuration::get('tt4b_secret');
        $external_data_key = Configuration::get('tt4b_external_data_key');
        if ($app_id == false || $secret == false || $external_data_key == false) {
            $cleaned_shop_url = $this->clean($shop_url);
            $smb_id = $external_business_id . $cleaned_shop_url;
            $open_source_app_raw_rsp = $this->createOpenSourceApp($smb_id, $shop_name, $shop_url);
            $open_source_app_rsp = json_decode($open_source_app_raw_rsp, true);
            $app_id = $open_source_app_rsp['data']['app_id'];
            $secret = $open_source_app_rsp['data']['app_secret'];
            $external_data_key = $open_source_app_rsp['data']['external_data_key'];
            $redirect_uri = $open_source_app_rsp['data']['redirect_uri'];
            if (is_null($app_id) || is_null($secret) || is_null($redirect_uri)) {
                return $this->displayWarning('An error occurred generating TT credentials. Please reach out to support');
            }

            Configuration::updateValue('tt4b_secret', $secret);
            Configuration::updateValue('tt4b_app_id', $app_id);
            Configuration::updateValue('tt4b_external_data_key', $external_data_key);
        }

        $locale = $this->context->language->iso_code;
        $email = Configuration::get('PS_SHOP_EMAIL');
        $phone = Configuration::get('PS_SHOP_PHONE');

        $address_1 = '';
        $address_2 = '';
        $zip_code = '';
        $city = '';
        $state = '';

        if (Configuration::get('PS_SHOP_ADDR1')) {
            $address_1 = Configuration::get('PS_SHOP_ADDR1');
        }
        if (Configuration::get('PS_SHOP_ADDR2')) {
            $address_2 = Configuration::get('PS_SHOP_ADDR2');
        }
        if (Configuration::get('PS_SHOP_CODE')) {
            $zip_code = Configuration::get('PS_SHOP_CODE');
        }
        if (Configuration::get('PS_SHOP_CITY')) {
            $city = Configuration::get('PS_SHOP_CITY');
        }
        if (Configuration::get('PS_SHOP_STATE')) {
            $state = Configuration::get('PS_SHOP_STATE');
        }

        $country_iso = Country::getIsoById(Configuration::get('PS_COUNTRY_DEFAULT'));
        $currency = Currency::getDefaultCurrency()->iso_code;
        $industry_id = '291408';
        $timezone = Configuration::get('PS_TIMEZONE');
        $target_time_zone = new DateTimeZone($timezone);
        $date_time = new DateTime('now', $target_time_zone);
        $gmtFormattedTimezone = 'GMT' . $date_time->format('P');

        $now = new DateTime();
        $time = $now->getTimestamp() * 1000;
        $timestamp = (string) $time;
        $version = '1.6';
        $business_platform = 'PRESTA_SHOP';
        $hmacStr = "version=$version&timestamp=$timestamp&locale=$locale&business_platform=$business_platform&external_business_id=$external_business_id";
        $hmac = hash_hmac('sha256', $hmacStr, $external_data_key);
        Configuration::updateValue('tt4b_external_business_id', $external_business_id);

        $obj = [
            'external_business_id' => $external_business_id,
            'business_platform' => $business_platform,
            'locale' => $locale,
            'version' => $version,
            'timestamp' => $timestamp,
            'timezone' => $gmtFormattedTimezone,
            'country_region' => $country_iso,
            'phone_number' => $phone,
            'email' => $email,
            'industry_id' => $industry_id,
            'store_name' => $shop_name,
            'currency' => $currency,
            'website_url' => $shop_url,
            'domain' => $shop_domain,
            'app_id' => $app_id,
            'redirect_uri' => $shop_url,
            'hmac' => $hmac,
            'close_method' => 'redirect_inside_tiktok',
            'is_email_verified' => true,
            'is_verified' => true,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zip_code,
        ];
        $external_data = base64_encode(json_encode($obj, JSON_UNESCAPED_SLASHES));
        Configuration::updateValue('tt4b_external_data', $external_data);
        PrestaShopLogger::addLog("external_data=$external_data", 1, null, __CLASS__, 40);

        $is_connected = false;
        $advertiser_id = '';
        $bc_id = '';
        $catalog_id = '';
        $pixel_code = '';
        $access_token = Configuration::get('tt4b_access_token');
        $advanced_matching = true;
        $processing = 0;
        $approved = 0;
        $rejected = 0;
        if ($access_token !== false) {
            $is_connected = true;
            $business_profile_rsp = $this->getBusinessProfile();
            $business_profile = json_decode($business_profile_rsp, true);
            if (!is_null($business_profile['data']['adv_id'])) {
                $advertiser_id = $business_profile['data']['adv_id'];
                Configuration::updateValue('tt4b_adv_id', $advertiser_id);
            }
            if (!is_null($business_profile['data']['bc_id'])) {
                $bc_id = $business_profile['data']['bc_id'];
                Configuration::updateValue('tt4b_bc_id', $bc_id);
            }
            if (!is_null($business_profile['data']['pixel_code'])) {
                $pixel_code = $business_profile['data']['pixel_code'];
                Configuration::updateValue('tt4b_pixel_code', $pixel_code);
            }
            if (!is_null($business_profile['data']['catalog_id'])) {
                $catalog_id = $business_profile['data']['catalog_id'];
                Configuration::updateValue('tt4b_catalog_id', $catalog_id);
            }
            if (!is_null($business_profile['data']['catalog_id']) && !is_null($business_profile['data']['bc_id'])) {
                $this->fullCatalogSync();
                $productReviewStatus = $this->getCatalogProcessingStatus($access_token, $bc_id, $catalog_id);
                $processing = $productReviewStatus['processing'];
                $approved = $productReviewStatus['approved'];
                $rejected = $productReviewStatus['rejected'];
            }
            if (is_null($advertiser_id) || is_null($pixel_code) || is_null($access_token)) {
                $advanced_matching = false;
                Configuration::updateValue('tt4b_advanced_matching', $advanced_matching);
            } else {
                $pixel_rsp = $this->getPixels($access_token, $advertiser_id, $pixel_code);
                $pixels = json_decode($pixel_rsp, true);
                $pixel = $pixels['data']['pixels'][0];
                $advanced_matching = $pixel['advanced_matching_fields']['email'];
                Configuration::updateValue('tt4b_advanced_matching', $advanced_matching);
            }
        }
        $this->context->controller->addCSS('https://sf16-scmcdn-va.ibytedtos.com/obj/static-us/tiktok-business-plugin/static/css/universal.d55f4fd8.chunk.css');
        $this->context->controller->addCSS('https://sf16-scmcdn-va.ibytedtos.com/obj/static-us/tiktok-business-plugin/static/css/bytedance.047a7574.chunk.css');
        $this->context->controller->addCSS('https://sf16-scmcdn-va.ibytedtos.com/obj/static-us/tiktok-business-plugin/static/css/vendors.cd3bbd1a.chunk.css');

        $this->smarty->assign(
            [
                'business_platform' => $business_platform,
                'external_business_id' => $external_business_id,
                'advertiser_id' => $advertiser_id,
                'bc_id' => $bc_id,
                'catalog_id' => $catalog_id,
                'pixel_code' => $pixel_code,
                'external_data' => $external_data,
                'is_connected' => $is_connected,
                'processing' => $processing,
                'approved' => $approved,
                'rejected' => $rejected,
                'advanced_matching' => $advanced_matching,
                'access_token' => $access_token,
                'store_name' => $shop_name,
                'shop_url' => $shop_url,
                'request_uri' => $request_uri,
            ]
        );
        return $this->display(__FILE__, 'views/templates/admin/plugin.tpl');
    }

    public function fullCatalogSync()
    {
        $business_profile_rsp = $this->getBusinessProfile();
        if ($business_profile_rsp == '') {
            PrestaShopLogger::addLog('full catalog sync error with biz profile', 1, null, __CLASS__, 255612);
            return;
        }
        $business_profile = json_decode($business_profile_rsp, true);
        if ($business_profile['message'] !== 'OK') {
            PrestaShopLogger::addLog('full catalog sync not OK from biz profile', 1, null, __CLASS__, 255612);
            return;
        }
        $catalog_id = $business_profile['data']['catalog_id'];
        $bc_id = $business_profile['data']['bc_id'];
        $store_name = $business_profile['data']['store_name'];
        if (is_null($catalog_id) || is_null($bc_id) || is_null($store_name)) {
            PrestaShopLogger::addLog(
                "full catalog null params bc_id: $bc_id, catalog_id: $catalog_id, store_name: $store_name",
                1,
                null,
                __CLASS__,
                255612
            );
            return;
        }
        $access_token = Configuration::get('tt4b_access_token');

        $id_lang = (int) Context::getContext()->language->id;
        $start = 0;
        $limit = 5000;
        $order_by = 'id_product';
        $order_way = 'DESC';
        $id_category = false;
        $only_active = true;
        $context = null;

        $products_base = Product::getProducts(
            $id_lang,
            $start,
            $limit,
            $order_by,
            $order_way,
            $id_category,
            $only_active,
            $context
        );
        $products = Product::getProductsProperties($this->context->language->id, $products_base);
        if (count($products) == 0) {
            PrestaShopLogger::addLog(
                'full catalog sync no products retrieved from Product::getProductsProperties',
                1,
                null,
                __CLASS__,
                255612
            );
        }

        $dpa_products = [];
        $count = 0;
        foreach ($products as $product) {
            $sku_id = (string) $product['id_product'];
            $title = $product['name'];
            $description = $product['description_short'];

            if ('' === $description) {
                $description = $title;
            }
            $description = strip_tags($description);

            $condition = Tools::strtoupper($product['condition']);
            $price = (string) $product['price'];
            $brand = $store_name;

            $availability = 'IN_STOCK';
            if ($product['available_for_order'] !== '1') {
                $availability = 'OUT_OF_STOCK';
            }

            $link = new Link();
            $product_url = $link->getProductLink((int) $product['id_product']);

            $image = Product::getCover((int) $product['id_product']);
            $image_url = $link->getImageLink($product['link_rewrite'] ?? $product['name'], (int) $image['id_image'], ImageType::getFormattedName('large'));
            if (Tools::substr($image_url, 0, 7) !== 'http://') {
                $image_url = 'http://' . $image_url;
            }

            $missing_fields = [];
            if ('' === $sku_id || false === $sku_id) {
                $missing_fields[] = 'sku_id';
            }
            if ('' === $title || false === $title) {
                $missing_fields[] = 'title';
            }
            if ('' === $image_url || false === $image_url) {
                $missing_fields[] = 'image_url';
            }
            if ('' === $price || '0' === $price) {
                $missing_fields[] = 'price';
            }
            if (count($missing_fields) > 0) {
                $debug_message = sprintf(
                    'sku_id: %s is missing the following fields for product sync: %s',
                    $sku_id,
                    join(',', $missing_fields)
                );
                PrestaShopLogger::addLog($debug_message, 1, null, __CLASS__, 255612);
                continue;
            }

            $dpa_product = [
                'sku_id' => $sku_id,
                'item_group_id' => $sku_id,
                'title' => $title,
                'availability' => $availability,
                'description' => $description,
                'image_link' => $image_url,
                'brand' => $brand,
                'profession' => [
                    'condition' => $condition,
                ],
                'price' => [
                    'price' => $price,
                ],
                'landing_url' => [
                    'link' => $product_url,
                ],
            ];
            array_push($dpa_products, $dpa_product);
            ++$count;
            if ($count == 400) {
                $curl = curl_init();
                $dpa_product_information = [
                    'bc_id' => $bc_id,
                    'catalog_id' => $catalog_id,
                    'dpa_products' => $dpa_products,
                ];
                $data = json_encode($dpa_product_information, JSON_UNESCAPED_SLASHES);
                $headers = [
                    'Content-Type:application/json',
                    "Access-Token:$access_token",
                ];
                $optArray = [
                    CURLOPT_POST => true,
                    CURLOPT_URL => 'https://business-api.tiktok.com/open_api/v1.2/catalog/product/upload/',
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                ];
                curl_setopt_array($curl, $optArray);
                curl_exec($curl);
                curl_close($curl);
                $count = 0;
                $dpa_products = [];
            }
        }

        $curl = curl_init();
        $dpa_product_information = [
            'bc_id' => $bc_id,
            'catalog_id' => $catalog_id,
            'dpa_products' => $dpa_products,
        ];
        $data = json_encode($dpa_product_information, JSON_UNESCAPED_SLASHES);
        $headers = [
            'Content-Type:application/json',
            "Access-Token:$access_token",
        ];
        $optArray = [
            CURLOPT_POST => true,
            CURLOPT_URL => 'https://business-api.tiktok.com/open_api/v1.2/catalog/product/upload/',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        PrestaShopLogger::addLog("response from FullCatalogSync=$result", 1, null, __CLASS__, 255611);
        curl_close($curl);
    }

    public function createOpenSourceApp($smb_id, $smb_name, $redirect_url)
    {
        $curl = curl_init();
        $url = 'https://ads.tiktok.com/marketing_api/api/developer/app/create_auto_approve/';
        $tt4b_prestashop_token = '244e1de7-8dad-4656-a859-8dc09eea299d';
        $params = [
            'business_platform' => 'PROD',
            'smb_id' => $smb_id,
            'smb_name' => $smb_name,
            'redirect_url' => $redirect_url,
        ];
        $data = json_encode($params, JSON_UNESCAPED_SLASHES);
        $headers = [
            'Content-Type:application/json',
            "Access-Token:$tt4b_prestashop_token",
            'Referer:https://ads.tiktok.com',
        ];

        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getAccessToken($app_id, $secret, $auth_code)
    {
        $curl = curl_init();
        $url = 'https://business-api.tiktok.com/open_api/v1.3/oauth2/access_token/';
        $params = [
            'app_id' => $app_id,
            'secret' => $secret,
            'auth_code' => $auth_code,
        ];

        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ];

        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        PrestaShopLogger::addLog("getAccessToken v1.3 new result: $result", 1, null, __CLASS__, 255611);
        curl_close($curl);
        return $result;
    }

    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function getBusinessProfile()
    {
        $curl = curl_init();
        $external_data = Configuration::get('tt4b_external_data');
        $external_business_id = Configuration::get('tt4b_external_business_id');
        if ($external_business_id == false || $external_data == false) {
            return '';
        }
        $base_url = 'https://business-api.tiktok.com/tbp/v2.0/business_profile/get';
        $url = $base_url . "?business_platform=PRESTA_SHOP&full_data=1&external_business_id=$external_business_id";
        $url = $url . "&external_data=$external_data";
        $headers = [
            'Content-Type:application/json',
        ];
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        PrestaShopLogger::addLog("response from business_profile=$result", 1, null, __CLASS__, 40);
        curl_close($curl);
        return $result;
    }

    public function getPixels($access_token, $advertiser_id, $pixel_code)
    {
        $curl = curl_init();
        $url = "https://business-api.tiktok.com/open_api/v1.2/pixel/list/?advertiser_id=$advertiser_id&code=$pixel_code";
        $headers = [
            'Content-Type:application/json',
            "Access-Token:$access_token",
        ];

        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function getCatalogProcessingStatus($access_token, $bc_id, $catalog_id)
    {
        $curl = curl_init();
        $url = "https://business-api.tiktok.com/open_api/v1.2/catalog/product/get/?page_size=500&bc_id=$bc_id&catalog_id=$catalog_id";
        $headers = [
            'Content-Type:application/json',
            "Access-Token:$access_token",
        ];

        $optArray = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => $headers,
        ];
        curl_setopt_array($curl, $optArray);
        $result = curl_exec($curl);
        curl_close($curl);
        $obj = json_decode($result, true);
        if ($obj['message'] !== 'OK') {
            return '';
        }
        $processing = 0;
        $approved = 0;
        $rejected = 0;
        foreach ($obj['data']['list'] as $product) {
            if ($product['audit']['audit_status'] == 'processing') {
                ++$processing;
            }
            if ($product['audit']['audit_status'] == 'approved') {
                ++$approved;
            }
            if ($product['audit']['audit_status'] == 'rejected') {
                ++$rejected;
            }
        }

        return [
            'processing' => $processing,
            'approved' => $approved,
            'rejected' => $rejected,
        ];
    }

    public function hookDisplayHome()
    {
        $app_id = Configuration::get('tt4b_app_id');
        $secret = Configuration::get('tt4b_secret');

        $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $splitUrl = explode('&', $url);
        foreach ($splitUrl as $url) {
            if (Tools::strpos($url, 'auth_code') !== false) {
                $auth_code = Tools::substr($url, Tools::strpos($url, '=') + 1);
                PrestaShopLogger::addLog("hookDisplayHome auth_code: $auth_code", 1, null, __CLASS__, 255611);
                PrestaShopLogger::addLog("hookDisplayHome app_id: $app_id", 1, null, __CLASS__, 255611);
                PrestaShopLogger::addLog("hookDisplayHome secret: $secret", 1, null, __CLASS__, 255611);
                if ($app_id !== false && $secret !== false) {
                    $access_token_rsp = $this->getAccessToken($app_id, $secret, $auth_code);
                    $results = json_decode($access_token_rsp, true);
                    if ($results['message'] == 'OK') {
                        $access_token = $results['data']['access_token'];
                        Configuration::updateValue('tt4b_access_token', $access_token);
                        Tools::redirectAdmin(Configuration::get('tt4b_module_url'));
                    }
                }
            }
        }
    }

    public function hookDisplayProductExtraContent()
    {
        $event = 'ViewContent';
        $pixelCode = Configuration::get('tt4b_pixel_code');
        if (!self::checkOnboarding()) {
            return;
        }

        $user = self::getUser();
        $page = self::getPage();
        $product_object = new Product(
            (int) Tools::getValue('id_product'),
            true,
            (int) Configuration::get('PS_LANG_DEFAULT')
        );
        $content_id = Tools::getValue('id_product');
        $event_id = self::getEventID($content_id);

        $content_type = 'product';
        $price = (float) $product_object->price;
        $content_name = $product_object->name;
        $currency = self::getCurrency();

        $contents = [
            'price' => number_format($price, 2),
            'quantity' => 1,
            'content_name' => $content_name,
            'content_id' => $content_id,
        ];

        $properties = [
            'contents' => [
                $contents,
            ],
            'content_type' => $content_type,
            'currency' => $currency,
            'value' => number_format($price, 2),
        ];

        $data = [
            [
                'event' => $event,
                'event_id' => $event_id,
                'event_time' => time(),
                'user' => $user,
                'properties' => $properties,
                'page' => $page,
            ],
        ];

        $jsEventData = [
            'price' => number_format($price, 2),
            'currency' => $currency,
            'content_name' => $content_name,
            'content_id' => $content_id,
            'content_type' => $content_type,
            'value' => number_format($price, 2),
        ];

        self::pixelEventTrack($data);
    }

    public function hookActionCartSave($params)
    {
        $event = 'AddToCart';
        self::trackEvent($event, $params);
    }

    public function hookDisplayCheckoutSummaryTop($params)
    {
        $event = 'InitiateCheckout';
        self::trackEvent($event, $params);
    }

    public function hookDisplayOrderConfirmation($params)
    {
        $event = 'Purchase';
        self::trackEvent($event, $params);
    }

    public function trackEvent($event, $params)
    {
        if (!self::checkOnboarding()) {
            return;
        }

        $user = self::getUser();
        $page = self::getPage();
        $event_id = self::getEventID('');
        if ('Purchase' === $event) {
            $properties = self::getOrderProperties($params);
        } else {
            $properties = self::getCartProperties($params);
        }

        $data = [
            [
                'event' => $event,
                'event_id' => $event_id,
                'event_time' => time(),
                'user' => $user,
                'properties' => $properties,
                'page' => $page,
            ],
        ];

        self::pixelEventTrack($data);
    }

    public function pixelEventTrack($data)
    {
        $curl = curl_init();
        $pixel_code = Configuration::get('tt4b_pixel_code');
        $access_token = Configuration::get('tt4b_access_token');
        $headers = [
            'Content-Type: application/json',
            "Access-Token: $access_token",
        ];

        $params = [
            'partner_name' => 'PrestaShop',
            'event_source' => 'web',
            'event_source_id' => $pixel_code,
            'data' => $data,
        ];

        $optArray = [
            CURLOPT_POST => true,
            CURLOPT_URL => 'https://business-api.tiktok.com/open_api/v1.3/event/track/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($params, JSON_UNESCAPED_SLASHES),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        curl_setopt_array($curl, $optArray);

        curl_exec($curl);
        curl_close($curl);
    }

    /**
     *  Gets the user param needed for view content, add to cart, start checkout, complete payment.
     */
    public function getUser()
    {
        $customer = $this->context->customer;
        $advanced_matching = Configuration::get('tt4b_advanced_matching');
        $hashed_email = '';
        if ($advanced_matching == '1') {
            $email = $customer->email;
            $hashed_email = hash('SHA256', Tools::strtolower($email));
        }

        $user_agent = '';
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $ipaddress = Tools::getRemoteAddr();
        $locale = strtok($this->context->language->iso_code, '_');

        $user = [
            'email' => $hashed_email,
            'ip' => $ipaddress,
            'user_agent' => $user_agent,
            'locale' => $locale,
        ];

        $cookie = new Cookie('ttclid');
        $ttclid = $cookie->ttclid;
        if ($cookie->ttclid) {
            $user['ttclid'] = $ttclid;
        }

        if ($this->context->cookie && $this->context->cookie->_ttp) {
            $user['ttp'] = $this->context->cookie->_ttp;
        }

        return $user;
    }

    /**
     *  Gets the page param needed for view content, add to cart, start checkout, complete payment.
     */
    public function getPage()
    {
        $url = '';
        if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
            $url = stripslashes($_SERVER['HTTP_HOST']) . stripslashes($_SERVER['REQUEST_URI']);
        }
        return [
            'url' => $url,
        ];
    }

    /**
     *  Gets the products contents of the cart needed for view content, add to cart, start checkout, complete payment.
     */
    public function getCartProperties($params)
    {
        $cart = $params['cart'];
        $value = (float) 0;
        $content_type = 'product';
        $contents = [];
        foreach ($cart->getProducts() as $product) {
            $content = [
                'content_id' => $product['id_product'],
                'quantity' => $product['quantity'],
                'price' => number_format((float) $product['price'], 2),
                'name' => Tools::replaceAccentedChars($product['name']),
                'brand' => (new Manufacturer($product['id_manufacturer']))->name,
            ];
            $value += (float) $product['price'] * (float) $product['cart_quantity'];
            $contents[] = $content;
        }

        return [
            'contents' => $contents,
            'content_type' => $content_type,
            'currency' => self::getCurrency(),
            'value' => number_format($value, 2),
        ];
    }

    /**
     *  Gets the products contents of the cart needed for view content, add to cart, start checkout, complete payment.
     */
    public function getOrderProperties($params)
    {
        $psVersion17 = (bool) version_compare(_PS_VERSION_, '1.7', '>=');
        $order = $psVersion17 ? $params['order'] : $params['objOrder'];
        $value = (float) 0;
        $content_type = 'product';
        $contents = [];
        foreach ($order->getCartProducts() as $product) {
            $content = [
                'content_id' => $product['id_product'],
                'quantity' => $product['quantity'],
                'price' => number_format((float) $product['price'], 2),
                'name' => Tools::replaceAccentedChars($product['product_name']),
                'brand' => (new Manufacturer($product['id_manufacturer']))->name,
            ];
            $value += (float) $product['price'] * (float) $product['cart_quantity'];
            $contents[] = $content;
        }
        return [
            'contents' => $contents,
            'content_type' => $content_type,
            'currency' => self::getCurrency(),
            'value' => number_format($value, 2),
        ];
    }

    public function getCurrency()
    {
        if (!empty($this->context->currency->iso_code)) {
            return Tools::strtolower($this->context->currency->iso_code);
        }
        if (!empty($this->context->cookie->id_currency)) {
            return Tools::strtolower((new Currency($this->context->cookie->id_currency))->iso_code);
        }

        return Tools::strtolower(Currency::getDefaultCurrency()->iso_code);
    }

    /**
     *  Grab ttclid from URL and set cookie for 30 days
     */
    public static function set_ttclid()
    {
        if (Tools::getIsset('ttclid')) {
            $cookie = new Cookie('ttclid');
            $cookie->setExpire(time() + 30 * 86400);
            $cookie->ttclid = Tools::getValue('ttclid');
            $cookie->write();
        }
        //        if (isset($_GET['ttclid'])) {
        //            $cookie = new Cookie('ttclid');
        //            $cookie->setExpire(time() + 30 * 86400);
        //            $cookie->ttclid = $_GET['ttclid'];
        //            $cookie->write();
        //        }
    }

    /**
     *  Loads the pixel base code into the site header
     */
    public function hookDisplayHeader($params)
    {
        $pixel_code = Configuration::get('tt4b_pixel_code');
        if (!self::checkOnboarding()) {
            return;
        }

        Media::addJsDef(
            [
                'tiktokforbusiness' => [
                    'pixel_code' => $pixel_code,
                ],
            ]
        );

        $path = $this->_path . 'views/js/baseCode.js';
        $this->context->controller->addJs($path);

        self::set_ttclid();
    }

    public static function getEventID($content_id)
    {
        $external_business_id = Configuration::get('tt4b_external_business_id');
        $unique_id = uniqid();
        if ('' !== $content_id) {
            return sprintf('%s_%s_%s', $unique_id, $external_business_id, $content_id);
        }

        return sprintf('%s_%s', $unique_id, $external_business_id);
    }

    /**
     *  Checks the current onboarding status for event tracking
     */
    public function checkOnboarding()
    {
        $advertiser_id = Configuration::get('tt4b_adv_id');
        $pixel_code = Configuration::get('tt4b_pixel_code');
        $access_token = Configuration::get('tt4b_access_token');
        if ($advertiser_id == false || $pixel_code == false || $access_token == false) {
            return false;
        }
        return true;
    }

    public static function addEvent($event, $pixelCode, $data, $hashedEmail, $hashedPhone, $eventID)
    {
        self::$events[self::prepareEventCode($event, $pixelCode, $data, $eventID)] = self::prepareAdvancedMatching($pixelCode, $hashedEmail, $hashedPhone);
    }

    /**
     *  Gets the event's JS code to be enqueued or printed
     */
    private static function prepareEventCode($event, $pixelCode, $data, $eventID)
    {
        $data_string = json_encode($data);
    }

    /**
     * Gets the AM to be enqueued or printed.
     */
    private static function prepareAdvancedMatching($pixelCode, $hashedEmail, $hashedPhone)
    {
    }
}
