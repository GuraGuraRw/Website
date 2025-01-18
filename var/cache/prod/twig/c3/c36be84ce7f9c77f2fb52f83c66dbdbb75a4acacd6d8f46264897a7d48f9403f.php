<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__d89ece7f3fc329fe495f2cc36d2ddea55dd438cf9e598e9b8d88084742ef1a4f */
class __TwigTemplate_180c4832f935dc90209327d076d5bde156a9a244542c1be2b5de7f78a294b0ea extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'extra_stylesheets' => [$this, 'block_extra_stylesheets'],
            'content_header' => [$this, 'block_content_header'],
            'content' => [$this, 'block_content'],
            'content_footer' => [$this, 'block_content_footer'],
            'sidebar_right' => [$this, 'block_sidebar_right'],
            'javascripts' => [$this, 'block_javascripts'],
            'extra_javascripts' => [$this, 'block_extra_javascripts'],
            'translate_javascripts' => [$this, 'block_translate_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>Maintenance • PrestaShop</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminMaintenance';
    var iso_user = 'en';
    var lang_is_rtl = '0';
    var full_language_code = 'en-us';
    var full_cldr_language_code = 'en-US';
    var country_iso_code = 'RW';
    var _PS_VERSION_ = '1.7.8.7';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'A new order has been placed on your shop.';
    var order_number_msg = 'Order number: ';
    var total_msg = 'Total: ';
    var from_msg = 'From: ';
    var see_order_msg = 'View this order';
    var new_customer_msg = 'A new customer registered on your shop.';
    var customer_name_msg = 'Customer name: ';
    var new_msg = 'A new message was posted on your shop.';
    var see_msg = 'Read this message';
    var token = '65ddd25cf1ff971c53cef64ca533d003';
    var token_admin_orders = tokenAdminOrders = '82cb2448d9979613a4ebc415b8446fdc';
    var token_admin_customers = '6c823d98e3386a625d7d088c8102bf95';
    var token_admin_customer_threads = tokenAdminCustomerThreads = 'ed8ba1fb3804a966913f9201773d91d2';
    var currentIndex = 'index.php?controller=AdminMaintenance';
    var employee_token = '64f18f7de30037933a6376f21d629ccb';
    var choose_language_translate = 'Choose language:';
    var default_language = '1';
    var admin_modules_link = '/admin1157/index.php/improve/modules/catalog/recommended?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I';
    var admin_notification_get_link = '/admin1157/index.php/common/notifications?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I';
    var admin_notification_pus";
        // line 43
        echo "h_link = adminNotificationPushLink = '/admin1157/index.php/common/notifications/ack?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I';
    var tab_modules_list = '';
    var update_success_msg = 'Update successful';
    var errorLogin = 'PrestaShop was unable to log in to Addons. Please check your credentials and your Internet connection.';
    var search_product_msg = 'Search for a product';
  </script>

      <link href=\"/admin1157/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/blockwishlist/public/backoffice.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/admin1157/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/gamification/views/css/gamification.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/catalog.css?v=3.1.3\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/connection-toolbar.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/creativeelements/views/css/admin-ce.css?v=2.10.1\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_facebook/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/psxmarketingwithgoogle/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/admin1157\\/\";
var baseDir = \"\\/\";
var ceAdmin = {\"uid\":\"1020001\",\"hideEditor\":[1],\"footerProduct\":\"\",\"i18n\":{\"edit\":\"Edit with Creative Elements\",\"save\":\"Please save the form before editing with Creative Elements\"},\"editorUrl\":\"https:\\/\\/gura.rw\\/admin1157\\/index.php?controller=AdminCEEditor&amp;token=658618518b02926d3e4e5fe8ec755a73&amp;uid=\",\"languages\":[{\"id_lang\":\"1\",\"name\":\"English (English)\",\"";
        // line 65
        echo "active\":\"1\",\"iso_code\":\"en\",\"language_code\":\"en-us\",\"locale\":\"en-US\",\"date_format_lite\":\"m\\/d\\/Y\",\"date_format_full\":\"m\\/d\\/Y H:i:s\",\"is_rtl\":\"0\",\"id_shop\":\"1\",\"shops\":{\"1\":true}}],\"editSuppliers\":0,\"editManufacturers\":0};
var changeFormLanguageUrl = \"\\/admin1157\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":null};
var currency_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"EUR\",\"currencySymbol\":\"\\u20ac\",\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"\\u00a4#,##0.00\",\"negativePattern\":\"-\\u00a4#,##0.00\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":false};
var show_new_customers = \"1\";
var show_new_messages = \"1\";
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/admin1157/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/js/admin.js?v=1.7.8.7\"></script>
<script type=\"text/javascript\" src=\"/admin1157/themes/new-theme/public/cldr.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/tools.js?v=1.7.8.7\"></script>
<script type=\"text/javascript\" src=\"/modules/blockwishlist/public/vendors.js\"></script>
<script type=\"text/javascr";
        // line 83
        echo "ipt\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin1157/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_mbo/views/js/recommended-modules.js?v=3.1.3\"></script>
<script type=\"text/javascript\" src=\"/modules/creativeelements/views/js/admin-ce.js?v=2.10.1\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconnotificationbo/views/js/favico.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconnotificationbo/views/js/ps_faviconnotificationbo.js\"></script>

  <style>
i.mi-ce {
\tfont-size: 14px !important;
}
i.icon-AdminParentCEContent, i.mi-ce {
\tposition: relative;
\theight: 1em;
\twidth: 1.2857em;
}
i.icon-AdminParentCEContent:before, i.mi-ce:before,
i.icon-AdminParentCEContent:after, i.mi-ce:after {
\tcontent: '';
\tposition: absolute;
\tmargin: 0;
\tleft: .2143em;
\ttop: 0;
\twidth: .9286em;
\theight: .6428em;
\tborder-width: .2143em 0;
\tborder-style: solid;
\tborder-color: currentColor;
\tbox-sizing: content-box;
}
i.icon-AdminParentCEContent:after, i.mi-ce:after {
\ttop: .4286em;
\twidth: .6428em;
\theight: 0;
\tborder-width: .2143em 0 0;
}
#maintab-AdminParentCreativeElements, #subtab-AdminParentCreativeElements {
\tdisplay: none;
}
</style>
<script type=\"text/html\" id=\"tmpl-btn-back-to-ps\">
    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEEditor&amp;token=658618518b02926d3e4e5fe8ec755a73&amp;action=backToPsEditor\" class=\"btn btn-default btn-back-to-ps\"><i class=\"material-icons\">navigate_before</i> Back to PrestaShop Editor</a>
</script>
<script type=\"text/html\" id=\"tmpl-btn-edit-with-ce\">
    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEEditor&amp;token=658618518b02926d3e4e5fe8ec755a73\" class=\"btn pointer btn-edit-with-ce\"><i class=\"material-icons mi-ce\"></i> Edit with Creative Elements</a>
</script>
<script>
  if (undefined !== ps_faviconnot";
        // line 131
        echo "ificationbo) {
    ps_faviconnotificationbo.initialize({
      backgroundColor: '#DF0067',
      textColor: '#FFFFFF',
      notificationGetUrl: '/admin1157/index.php/common/notifications?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I',
      CHECKBOX_ORDER: 1,
      CHECKBOX_CUSTOMER: 1,
      CHECKBOX_MESSAGE: 1,
      timer: 120000, // Refresh every 2 minutes
    });
  }
</script>
<script>
            var admin_gamification_ajax_url = \"https:\\/\\/gura.rw\\/admin1157\\/index.php?controller=AdminGamification&token=3913ecfc84521adcb6fb471fcd39ffbc\";
            var current_id_tab = 84;
        </script><style>
i.mi-crisp {
\tfont-size: 14px !important;
}
i.icon-AdminParentCEContent, i.mi-crisp {
\tposition: relative;
\theight: 16px;
\twidth: 1.2857em;
}
i.icon-AdminParentCEContent:after, i.mi-crisp:after {
\tcontent: '';
\tposition: absolute;
\tmargin: 0;
\tleft: .2143em;
\ttop: 0;
\twidth: 16px;
\theight: 16px;
\tbox-sizing: content-box;
    background: url('data:image/svg+xml,<svg width=\"16\" height=\"16\" viewBox=\"0 0 16 16\" xmlns=\"http://www.w3.org/2000/svg\"><defs><linearGradient x1=\"56.322%\" y1=\"-3.436%\" x2=\"56.322%\" y2=\"125.636%\" id=\"a\"><stop stop-color=\"%232ACDFC\" offset=\"0%\"/><stop stop-color=\"%230051D7\" offset=\"100%\"/></linearGradient></defs><g fill=\"none\" fill-rule=\"evenodd\"><path fill=\"url(%23a)\" d=\"M0 0h16v16H0z\"/><path d=\"m12.012 4.484.482 5.25-2.99.33-1.124 1.818-1.445-1.534-3.076.34-.482-5.25 8.634-.953Z\" fill=\"%23FFF\"/></g></svg>');
}
</style>


";
        // line 169
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>";
        echo "

<body
  class=\"lang-en adminmaintenance\"
  data-base-url=\"/admin1157/index.php\"  data-token=\"hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\">

  <header id=\"header\" class=\"d-print-none\">

    <nav id=\"header_infos\" class=\"main-header\">
      <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

            <i class=\"material-icons js-mobile-menu\">menu</i>
      <a id=\"header_logo\" class=\"logo float-left\" href=\"https://gura.rw/admin1157/index.php?controller=AdminDashboard&amp;token=da40ce7c4fe43674277d99da3f5722c1\"></a>
      <span id=\"shop_version\">1.7.8.7</span>

      <div class=\"component\" id=\"quick-access-container\">
        <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Quick Access
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=0f494cde21a09b291b2c8c7ec0d5683b\"
                 data-item=\"Catalog evaluation\"
      >Catalog evaluation</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php/improve/modules/manage?token=ba51b7767d42885e6265c5108ce70e2a\"
                 data-item=\"Installed modules\"
      >Installed modules</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php/sell/catalog/categories/new?token=ba51b7767d42885e6265c5108ce70e2a\"
                 data-item=\"New category\"
      >New category</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php/sell/catalog/products/new?token=ba51b7767d42885e6265c5108ce70e2a\"
                 data-item=\"New product\"
      >New product</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php?contro";
        // line 207
        echo "ller=AdminCartRules&amp;addcart_rule&amp;token=8c1164f7ace79cb876083d9cc60695de\"
                 data-item=\"New voucher\"
      >New voucher</a>
          <a class=\"dropdown-item quick-row-link\"
         href=\"https://gura.rw/admin1157/index.php?controller=AdminOrders&amp;token=82cb2448d9979613a4ebc415b8446fdc\"
                 data-item=\"Orders\"
      >Orders</a>
        <div class=\"dropdown-divider\"></div>
          <a id=\"quick-add-link\"
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"184\"
        data-icon=\"icon-AdminParentPreferences\"
        data-method=\"add\"
        data-url=\"index.php/configure/shop/maintenance\"
        data-post-link=\"https://gura.rw/admin1157/index.php?controller=AdminQuickAccesses&token=e255bf5a6bc05d0187c5260841a4f82f\"
        data-prompt-text=\"Please name this shortcut:\"
        data-link=\"Maintenance - List\"
      >
        <i class=\"material-icons\">add_circle</i>
        Add current page to Quick Access
      </a>
        <a id=\"quick-manage-link\" class=\"dropdown-item\" href=\"https://gura.rw/admin1157/index.php?controller=AdminQuickAccesses&token=e255bf5a6bc05d0187c5260841a4f82f\">
      <i class=\"material-icons\">settings</i>
      Manage your quick accesses
    </a>
  </div>
</div>
      </div>
      <div class=\"component\" id=\"header-search-container\">
        <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/admin1157/index.php?controller=AdminSearch&amp;token=eef9c22a333a81bc999f8fd07844b921\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Search (e.g.: product reference, customer name…)\" aria-label=\"Searchbar\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-tog";
        // line 246
        echo "gle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Everywhere
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Everywhere\" href=\"#\" data-value=\"0\" data-placeholder=\"What are you looking for?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Everywhere</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalog\" href=\"#\" data-value=\"1\" data-placeholder=\"Product name, reference, etc.\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalog</a>
        <a class=\"dropdown-item\" data-item=\"Customers by name\" href=\"#\" data-value=\"2\" data-placeholder=\"Name\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Customers by name</a>
        <a class=\"dropdown-item\" data-item=\"Customers by ip address\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Customers by IP address</a>
        <a class=\"dropdown-item\" data-item=\"Orders\" href=\"#\" data-value=\"3\" data-placeholder=\"Order ID\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Orders</a>
        <a class=\"dropdown-item\" data-item=\"Invoices\" href=\"#\" data-value=\"4\" data-placeholder=\"Invoice number\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i> Invoices</a>
        <a class=\"dropdown-item\" data-item=\"Carts\" href=\"#\" data-value=\"5\" data-placeholder=\"Cart ID\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carts</a>
        <a class=\"dropdown-item\" data-item=\"Modules\" href=\"#\" data-value=\"7\" data-placeholder=\"Module name\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Modules</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">SEARCH</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$";
        // line 266
        echo "(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

      
      
              <div class=\"component\" id=\"header-shop-list-container\">
            <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"https://gura.rw/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      <span>View my store</span>
    </a>
  </div>
        </div>
                    <div class=\"component header-right-component\" id=\"header-notifications-container\">
          <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Orders<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Customers<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
        ";
        // line 323
        echo "      href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messages<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new order for now :(<br>
              Have you checked your <strong><a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=a8877d2c1d17bd62a4363d6b64d6a3a5\">abandoned carts</a></strong>?<br>Your next order could be hiding there!
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new customer for now :(<br>
              Are you active on social media these days?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              No new message for now.<br>
              Seems like all your customers are happy :)
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a class=\"notif\" href='order_url'>
      #_id_order_ -
      from <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registered <strong>_date_add_</strong>";
        // line 369
        echo "
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
        </div>
      
      <div class=\"component\" id=\"header-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">

      <span class=\"employee-avatar\"><img class=\"avatar rounded-circle\" src=\"https://gura.rw/img/pr/default.jpg\" /></span>
      <span class=\"employee_profile\">Welcome back Gura Gura</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/admin1157/index.php/configure/advanced/employees/1/edit?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\">
      <i class=\"material-icons\">edit</i>
      <span>Your profile</span>
    </a>
    </div>

    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">book</i> Resources</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">school</i> Training</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">person_pin_ci";
        // line 402
        echo "rcle</i> Find an Expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">extension</i> PrestaShop Marketplace</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">help</i> Help Center</a>
    <p class=\"divider\"></p>
    <a class=\"dropdown-item employee-link text-center\" id=\"header_logout\" href=\"https://gura.rw/admin1157/index.php?controller=AdminLogin&amp;logout=1&amp;token=5fc64c12d0cbde0f60e66462b37ce041\">
      <i class=\"material-icons d-lg-none\">power_settings_new</i>
      <span>Sign out</span>
    </a>
  </div>
</div>
      </div>
          </nav>
  </header>

  <nav class=\"nav-bar d-none d-print-none d-md-block\">
  <span class=\"menu-collapse\" data-toggle-url=\"/admin1157/index.php/configure/advanced/employees/toggle-navigation?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <div class=\"nav-bar-overflow\">
      <ul class=\"main-menu\">
              
                    
                    
          
            <li class=\"link-levelone\" data-submenu=\"1\" id=\"tab-AdminDashboard\">
              <a href=\"https://gura.rw/admin1157/index.php?controller=AdminDashboard&amp;token=da40ce7c4fe43674277d99da3f5722c1\" class=\"link\" >
                <i class=\"material-icons\">trending_up</i> <span>Dashboard</span>
              </a>
            </li>

          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"2\" id=\"tab-SELL\">
                <span class=\"title\">Sell</span>
            </li>

          ";
        // line 443
        echo "                    
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/admin1157/index.php/sell/orders/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                      <span>
                      Orders
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                                <a href=\"/admin1157/index.php/sell/orders/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Orders
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                                <a href=\"/admin1157/index.php/sell/orders/invoices/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Invoices
                                </a>
                              </li>

                                                                                  
                          ";
        // line 475
        echo "    
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                                <a href=\"/admin1157/index.php/sell/orders/credit-slips/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Credit Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/admin1157/index.php/sell/orders/delivery-slips/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Delivery Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&amp;token=a8877d2c1d17bd62a4363d6b64d6a3a5\" class=\"link\"> Shopping Carts
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                    <a href=\"/admin1157/index.php/sell/catalog/products?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons m";
        // line 506
        echo "i-store\">store</i>
                      <span>
                      Catalog
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                                <a href=\"/admin1157/index.php/sell/catalog/products?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Products
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                                <a href=\"/admin1157/index.php/sell/catalog/categories?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Categories
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                                <a href=\"/admin1157/index.php/sell/catalog/monitoring/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Monitoring
                                </a>
                         ";
        // line 537
        echo "     </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminAttributesGroups&amp;token=72b9fdb2d8b8e5e68e081b2bf14f28ea\" class=\"link\"> Attributes &amp; Features
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/admin1157/index.php/sell/catalog/brands/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Brands &amp; Suppliers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                                <a href=\"/admin1157/index.php/sell/attachments/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Files
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCartRules&amp;to";
        // line 567
        echo "ken=8c1164f7ace79cb876083d9cc60695de\" class=\"link\"> Discounts
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                                <a href=\"/admin1157/index.php/sell/stocks/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Stock
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/admin1157/index.php/sell/customers/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-account_circle\">account_circle</i>
                      <span>
                      Customers
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-24\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"25\" id=\"subtab-AdminCustomers\">
                               ";
        // line 600
        echo " <a href=\"/admin1157/index.php/sell/customers/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Customers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"26\" id=\"subtab-AdminAddresses\">
                                <a href=\"/admin1157/index.php/sell/addresses/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Addresses
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"28\" id=\"subtab-AdminParentCustomerThreads\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCustomerThreads&amp;token=ed8ba1fb3804a966913f9201773d91d2\" class=\"link\">
                      <i class=\"material-icons mi-chat\">chat</i>
                      <span>
                      Customer Service
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-28\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
";
        // line 632
        echo "                              <li class=\"link-leveltwo\" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCustomerThreads&amp;token=ed8ba1fb3804a966913f9201773d91d2\" class=\"link\"> Customer Service
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/admin1157/index.php/sell/customer-service/order-messages/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Order Messages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminReturn&amp;token=9670bdbde70fe20b144d8364c18879cd\" class=\"link\"> Merchandise Returns
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                    <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-assessment";
        // line 661
        echo "\">assessment</i>
                      <span>
                      Stats
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-32\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"145\" id=\"subtab-AdminMetricsLegacyStatsController\">
                                <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Stats
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"146\" id=\"subtab-AdminMetricsController\">
                                <a href=\"/admin1157/index.php/modules/metrics?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> PrestaShop Metrics
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"42\" id=\"tab-IMPROVE\">
                <span class=\"title\">Improve</span>
            </li>

                              
                  
       ";
        // line 700
        echo "                                               
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"48\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Marketplace
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/admin1157/index.php/improve/modules/manage?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Module Manager
                                </a>
                              </li>

                                                                                                 ";
        // line 729
        echo "                                   </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"176\" id=\"subtab-AdminParentCEContent\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEThemes&amp;token=1a50fc33781adda97d32f4954c23e8a1\" class=\"link\">
                      <i class=\"material-icons mi-ce\">ce</i>
                      <span>
                      Creative Elements
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-176\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"177\" id=\"subtab-AdminCEThemes\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEThemes&amp;token=1a50fc33781adda97d32f4954c23e8a1\" class=\"link\"> Theme Builder
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"178\" id=\"subtab-AdminCEContent\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEContent&amp;token=bec9669b73f5f347c4c2c93019c7bbc3\" class=\"link\"> Content Anywhere
       ";
        // line 759
        echo "                         </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"179\" id=\"subtab-AdminCETemplates\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCETemplates&amp;token=0e6c2911a66f869da9802c4a3b1f0281\" class=\"link\"> Saved Templates
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"180\" id=\"subtab-AdminParentCEFonts\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCEFonts&amp;token=a1872c2d4d4fcc77ff4cd4389c9d4c34\" class=\"link\"> Fonts &amp; Icons
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"183\" id=\"subtab-AdminCESettings\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCESettings&amp;token=fa5e9547192f659e7d575d075a82d8a1\" class=\"link\"> Settings
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <";
        // line 792
        echo "li class=\"link-levelone has_submenu\" data-submenu=\"52\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                      Design
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-52\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"140\" id=\"subtab-AdminPsMboTheme\">
                                <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Theme Catalog
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"130\" id=\"subtab-AdminThemesParent\">
                                <a href=\"/admin1157/index.php/improve/design/themes/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Theme &amp; Logo
                                </a>
                              </li>

                                                                                                                                        
                              
                  ";
        // line 821
        echo "                                          
                              <li class=\"link-leveltwo\" data-submenu=\"55\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/admin1157/index.php/improve/design/mail_theme/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Email Theme
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"57\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/admin1157/index.php/improve/design/cms-pages/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"58\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/admin1157/index.php/improve/design/modules/positions/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"59\" id=\"subtab-AdminImages\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminImages&amp;token=875b9ab6964e8f5e60c1ddbf0e1cf057\" class=\"link\"> Image Settings
                                </a>
                              </li>

                                             ";
        // line 851
        echo "                                 </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"60\" id=\"subtab-AdminParentShipping\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarriers&amp;token=095923502a3f216d70dca02b64fbf33a\" class=\"link\">
                      <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                      <span>
                      Shipping
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-60\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"61\" id=\"subtab-AdminCarriers\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarriers&amp;token=095923502a3f216d70dca02b64fbf33a\" class=\"link\"> Carriers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"62\" id=\"subtab-AdminShipping\">
                                <a href=\"/admin1157/index.php/improve/shipping/preferences/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Preferences
             ";
        // line 881
        echo "                   </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"189\" id=\"subtab-Packlink\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=Packlink&amp;token=4b4bc5e96ad4b600b41bb525bf2fa851\" class=\"link\"> Packlink PRO
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"63\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/admin1157/index.php/improve/payment/payment_methods?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-payment\">payment</i>
                      <span>
                      Payment
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-63\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"64\" id=\"subtab-AdminPayment\">
                                <a href=\"/admin1157/index.php/improve/payment/payment_methods?_toke";
        // line 913
        echo "n=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Payment Methods
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"65\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/admin1157/index.php/improve/payment/preferences?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"66\" id=\"subtab-AdminInternational\">
                    <a href=\"/admin1157/index.php/improve/international/localization/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-66\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"67\" id=\"subta";
        // line 945
        echo "b-AdminParentLocalization\">
                                <a href=\"/admin1157/index.php/improve/international/localization/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Localization
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"72\" id=\"subtab-AdminParentCountries\">
                                <a href=\"/admin1157/index.php/improve/international/zones/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Locations
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"76\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/admin1157/index.php/improve/international/taxes/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"79\" id=\"subtab-AdminTranslations\">
                                <a href=\"/admin1157/index.php/improve/international/translations/settings?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Translations
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
            ";
        // line 976
        echo "                                  
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"147\" id=\"subtab-Marketing\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsfacebookModule&amp;token=f400c09ea6dce28804234e7a6b4310f6\" class=\"link\">
                      <i class=\"material-icons mi-campaign\">campaign</i>
                      <span>
                      Marketing
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-147\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"148\" id=\"subtab-AdminPsfacebookModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsfacebookModule&amp;token=f400c09ea6dce28804234e7a6b4310f6\" class=\"link\"> Facebook &amp; Instagram
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"150\" id=\"subtab-AdminPsxMktgWithGoogleModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsxMktgWithGoogleModule&amp;token=59c5474c428dfe67ac3e80bde0922f6a\" class=\"link\"> Google
                                </a>
                       ";
        // line 1005
        echo "       </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title link-active\" data-submenu=\"80\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configure</span>
            </li>

                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu link-active open ul-open\" data-submenu=\"81\" id=\"subtab-ShopParameters\">
                    <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-settings\">settings</i>
                      <span>
                      Shop Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-81\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo link-active\" data-submenu=\"82\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> General
                                </a>
                              </li>

                            ";
        // line 1042
        echo "                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"85\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/order-preferences/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Order Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"88\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/product-preferences/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Product Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"89\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/customer-preferences/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Customer Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"93\" id=\"subtab-AdminParentStores\">
                                <a href=\"/admin1157/index.php/configure/shop/contacts/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrE";
        // line 1070
        echo "HqIAKxUriLUti_I\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"96\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/admin1157/index.php/configure/shop/seo-urls/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Traffic &amp; SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"100\" id=\"subtab-AdminParentSearchConf\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminSearchConf&amp;token=cf935b1c83fe2594a8212e19bbe7afc4\" class=\"link\"> Search
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"134\" id=\"subtab-AdminGamification\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminGamification&amp;token=3913ecfc84521adcb6fb471fcd39ffbc\" class=\"link\"> Merchant Expertise
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=";
        // line 1104
        echo "\"link-levelone has_submenu\" data-submenu=\"103\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Advanced Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-103\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"104\" id=\"subtab-AdminInformation\">
                                <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Information
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"105\" id=\"subtab-AdminPerformance\">
                                <a href=\"/admin1157/index.php/configure/advanced/performance/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Performance
                                </a>
                              </li>

                                                                                  
                              
                    ";
        // line 1133
        echo "                                        
                              <li class=\"link-leveltwo\" data-submenu=\"106\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/admin1157/index.php/configure/advanced/administration/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Administration
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"107\" id=\"subtab-AdminEmails\">
                                <a href=\"/admin1157/index.php/configure/advanced/emails/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> E-mail
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"108\" id=\"subtab-AdminImport\">
                                <a href=\"/admin1157/index.php/configure/advanced/import/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Import
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"109\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/admin1157/index.php/configure/advanced/employees/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Team
                                </a>
                              </li>

                                                      ";
        // line 1163
        echo "                            
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"113\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/admin1157/index.php/configure/advanced/sql-requests/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Database
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"116\" id=\"subtab-AdminLogs\">
                                <a href=\"/admin1157/index.php/configure/advanced/logs/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Logs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"117\" id=\"subtab-AdminWebservice\">
                                <a href=\"/admin1157/index.php/configure/advanced/webservice-keys/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                              
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"120\" id=\"subtab-AdminFeatureFlag\">
                                <a href=\"/admin1157/index.php/configure/advanced/feature-flags/?_token=h";
        // line 1191
        echo "MKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" class=\"link\"> Experimental Features
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"185\" id=\"subtab-AdminSelfUpgrade\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminSelfUpgrade&amp;token=e68386a2df6d392ea691de9fc21b3663\" class=\"link\">
                      <i class=\"material-icons mi-upgrade\">upgrade</i>
                      <span>
                      1-Click Upgrade
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"187\" id=\"subtab-SendinblueTab\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=SendinblueTab&amp;token=4ed004dde33ae580319c8aeba20bdf0b\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Brevo
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                   ";
        // line 1225
        echo "         </a>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"122\" id=\"tab-DEFAULT\">
                <span class=\"title\">More</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"188\" id=\"subtab-AdminCrisp\">
                    <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCrisp&amp;token=460ea598ba576a5e749c868bf610f537\" class=\"link\">
                      <i class=\"material-icons mi-crisp\">crisp</i>
                      <span>
                      Crisp
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                                </ul>
  </div>
  
</nav>


<div class=\"header-toolbar d-print-none\">
    
  <div class=\"container-fluid\">

    
      <nav aria-label=\"Breadcrumb\">
        <ol class=\"breadcrumb\">
                      <li class=\"breadcrumb-item\">General</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/admin1157/index.php/configure/shop/maintenance/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" aria-current=\"page\">Maintenance</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            Maintenance          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            ";
        // line 1285
        echo "
                        
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Help\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminMaintenance%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\"
                   id=\"product_form_open_help\"
                >
                  Help
                </a>
                                    </div>
        </div>

      
    </div>
  </div>

  
      <div class=\"page-head-tabs\" id=\"head_tabs\">
      <ul class=\"nav nav-pills\">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ";
        // line 1307
        echo "                                                                                                                                                                                  <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" id=\"subtab-AdminPreferences\" class=\"nav-link tab \" data-submenu=\"83\">
                      General
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/configure/shop/maintenance/?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\" id=\"subtab-AdminMaintenance\" class=\"nav-link tab active current\" data-submenu=\"84\">
                      Maintenance
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </ul>
    </div>
  
  <div class=\"btn-floating\">
    <button class=\"btn btn-primary collapsed\" data-toggle=\"collapse\" data-target=\".btn-floating-container\" aria-expanded=\"false\">
      <i";
        // line 1328
        echo " class=\"material-icons\">add</i>
    </button>
    <div class=\"btn-floating-container collapse\">
      <div class=\"btn-floating-menu\">
        
        
                              <a class=\"btn btn-floating-item btn-help btn-sidebar\" href=\"#\"
               title=\"Help\"
               data-toggle=\"sidebar\"
               data-target=\"#right-sidebar\"
               data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminMaintenance%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I\"
            >
              Help
            </a>
                        </div>
    </div>
  </div>
  <script>
  if (undefined !== mbo) {
    mbo.initialize({
      translations: {
        'Recommended Modules and Services': 'Recommended modules',
        'description': \"Here\\'s a selection of modules,<\\strong> compatible with your store<\\/strong>, to help you achieve your goals\",
        'Close': 'Close',
      },
      recommendedModulesUrl: '/admin1157/index.php/modules/addons/modules/recommended?tabClassName=AdminMaintenance&_token=hMKlMjZ5SiRi2Yun4ei38rWRzLrEHqIAKxUriLUti_I',
      shouldAttachRecommendedModulesAfterContent: 0,
      shouldAttachRecommendedModulesButton: 0,
      shouldUseLegacyTheme: 0,
    });
  }
</script>


</div>

<div id=\"main-div\">
          
      <div class=\"content-div  with-tabs\">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1376
        $this->displayBlock('content_header', $context, $blocks);
        $this->displayBlock('content', $context, $blocks);
        $this->displayBlock('content_footer', $context, $blocks);
        $this->displayBlock('sidebar_right', $context, $blocks);
        echo "

            
          </div>
        </div>

      </div>
    </div>

  <div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh no!</h1>
  <p class=\"mt-3\">
    The mobile version of this page is not available yet.
  </p>
  <p class=\"mt-2\">
    Please use a desktop computer to access this page, until is adapted to mobile.
  </p>
  <p class=\"mt-2\">
    Thank you.
  </p>
  <a href=\"https://gura.rw/admin1157/index.php?controller=AdminDashboard&amp;token=da40ce7c4fe43674277d99da3f5722c1\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Back
  </a>
</div>
  <div class=\"mobile-layer\"></div>

      <div id=\"footer\" class=\"bootstrap\">
    
</div>
  

      <div class=\"bootstrap\">
      <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-EN&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/en/login?email=guragurarw%40gmail.com&amp;firstname=Gura+Gura&amp;lastname=Rw&amp;website=http%3A%2F%2Fgura.rw%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/admin1157/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Connect your shop to PrestaShop's marketplace in order to automatically import all your Addons purchases.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Don't have ";
        // line 1427
        echo "an account?</h4>
\t\t\t\t\t\t<p class='text-justify'>Discover the Power of PrestaShop Addons! Explore the PrestaShop Official Marketplace and find over 3 500 innovative modules and themes that optimize conversion rates, increase traffic, build customer loyalty and maximize your productivity</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Connect to PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/en/forgot-your-password\">I forgot my password</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/en/login?email=guragurarw%40gmail.com&amp;firstname=Gura+Gura&amp;lastname=Rw&amp;website=http%3A%2F%2Fgura.rw%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-EN&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCreate an Account
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Sign in
\t\t\t\t\t\t\t</button>";
        // line 1466
        echo "
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

    </div>
  
";
        // line 1484
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>";
        echo "
</html>";
    }

    // line 169
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
    }

    // line 1376
    public function block_content_header($context, array $blocks = [])
    {
    }

    public function block_content($context, array $blocks = [])
    {
    }

    public function block_content_footer($context, array $blocks = [])
    {
    }

    public function block_sidebar_right($context, array $blocks = [])
    {
    }

    // line 1484
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "__string_template__d89ece7f3fc329fe495f2cc36d2ddea55dd438cf9e598e9b8d88084742ef1a4f";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1652 => 1484,  1635 => 1376,  1626 => 169,  1617 => 1484,  1597 => 1466,  1556 => 1427,  1499 => 1376,  1449 => 1328,  1426 => 1307,  1402 => 1285,  1340 => 1225,  1304 => 1191,  1274 => 1163,  1242 => 1133,  1211 => 1104,  1175 => 1070,  1145 => 1042,  1106 => 1005,  1075 => 976,  1042 => 945,  1008 => 913,  974 => 881,  942 => 851,  910 => 821,  879 => 792,  844 => 759,  812 => 729,  781 => 700,  740 => 661,  709 => 632,  675 => 600,  640 => 567,  608 => 537,  575 => 506,  542 => 475,  508 => 443,  465 => 402,  430 => 369,  382 => 323,  323 => 266,  301 => 246,  260 => 207,  217 => 169,  177 => 131,  127 => 83,  107 => 65,  83 => 43,  39 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__d89ece7f3fc329fe495f2cc36d2ddea55dd438cf9e598e9b8d88084742ef1a4f", "");
    }
}
