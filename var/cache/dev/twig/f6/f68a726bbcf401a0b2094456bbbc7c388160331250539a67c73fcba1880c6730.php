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

/* __string_template__ef64602f05cebe8f8a66ecd8aafe02d7990ce9243052e9880dfbccc5c75c5477 */
class __TwigTemplate_dd3b0b221e56c6c8f8e38082e9b79aedfa933ad2dde80cd1d3ea4a8488800d9c extends \Twig\Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "__string_template__ef64602f05cebe8f8a66ecd8aafe02d7990ce9243052e9880dfbccc5c75c5477"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "__string_template__ef64602f05cebe8f8a66ecd8aafe02d7990ce9243052e9880dfbccc5c75c5477"));

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

<title>Module manager • PrestaShop</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminModulesManage';
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
    var token = '9f0a5d17d97fa23806fd9a23e242b49f';
    var token_admin_orders = tokenAdminOrders = '82cb2448d9979613a4ebc415b8446fdc';
    var token_admin_customers = '6c823d98e3386a625d7d088c8102bf95';
    var token_admin_customer_threads = tokenAdminCustomerThreads = 'ed8ba1fb3804a966913f9201773d91d2';
    var currentIndex = 'index.php?controller=AdminModulesManage';
    var employee_token = '64f18f7de30037933a6376f21d629ccb';
    var choose_language_translate = 'Choose language:';
    var default_language = '1';
    var admin_modules_link = '/admin1157/index.php/improve/modules/catalog/recommended?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM';
    var admin_notification_get_link = '/admin1157/index.php/common/notifications?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM';
    var admin_notificat";
        // line 43
        echo "ion_push_link = adminNotificationPushLink = '/admin1157/index.php/common/notifications/ack?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM';
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
      <link href=\"/modules/ps_mbo/views/css/module-catalog.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/connection-toolbar.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_facebook/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/psxmarketingwithgoogle/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/admin1157\\/\";
var baseDir = \"\\/\";
var changeFormLanguageUrl = \"\\/admin1157\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":null};
var currency_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"EUR\",\"currencySym";
        // line 67
        echo "bol\":\"\\u20ac\",\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"\\u00a4#,##0.00\",\"negativePattern\":\"-\\u00a4#,##0.00\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":true};
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
<script type=\"text/javascript\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin1157/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_mbo/views/js/recommended-modules.js?v=3.1.3\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/growl/jquery.growl.js?v=3.1.3\"></script>
<script type=\"text/javascript\" src=\"https://assets.prestashop3.com/dst/mbo/v1/mbo-cdc.umd.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconno";
        // line 88
        echo "tificationbo/views/js/favico.js\"></script>
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
<script>
  if (undefined !== ps_faviconnotificationbo) {
    ps_faviconnotificationbo.initialize({
      backgroundColor: '#DF0067',
      textColor: '#FFFFFF',
      notificationGetUrl: '/admin1157/index.php/common/notifications?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM',
      CHECKBOX_ORDER: 1,
      CHECKBOX_CUSTOMER: 1,
      CHECKBOX_MESSAGE: 1,
      timer: 120000, // Refresh every 2 minutes
    });
  }
</script>
<script>
            var admin_gamification_ajax_url = \"https:\\/\\/gura.rw\\/admin1157\\/index.php?controller=AdminGamification&token=3913ecfc84521adcb6fb471fcd39ffbc\";
            var current_id_tab = 45;
        </script>

";
        // line 142
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>";
        echo "

<body
  class=\"lang-en adminmodulesmanage\"
  data-base-url=\"/admin1157/index.php\"  data-token=\"w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">

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
         href=\"https://gura.rw/admin1157/index.php?cont";
        // line 180
        echo "roller=AdminCartRules&amp;addcart_rule&amp;token=8c1164f7ace79cb876083d9cc60695de\"
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
        data-rand=\"124\"
        data-icon=\"icon-AdminModulesSf\"
        data-method=\"add\"
        data-url=\"index.php/improve/modules/manage?-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
        data-post-link=\"https://gura.rw/admin1157/index.php?controller=AdminQuickAccesses&token=e255bf5a6bc05d0187c5260841a4f82f\"
        data-prompt-text=\"Please name this shortcut:\"
        data-link=\"Modules - List\"
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
      <button type=\"button\" class=\"btn btn-o";
        // line 219
        echo "utline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
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

<scri";
        // line 238
        echo "pt type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

              <div class=\"component hide-mobile-sm\" id=\"header-debug-mode-container\">
          <a class=\"link shop-state\"
             id=\"debug-mode\"
             data-toggle=\"pstooltip\"
             data-placement=\"bottom\"
             data-html=\"true\"
             title=\"<p class='text-left'><strong>Your shop is in debug mode.</strong></p><p class='text-left'>All the PHP errors and messages are displayed. When you no longer need it, <strong>turn off</strong> this mode.</p>\"
             href=\"/admin1157/index.php/configure/advanced/performance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
          >
            <i class=\"material-icons\">bug_report</i>
            <span>Debug mode</span>
          </a>
        </div>
      
              <div class=\"component hide-mobile-sm\" id=\"header-maintenance-mode-container\">
          <a class=\"link shop-state\"
             id=\"maintenance-mode\"
             data-toggle=\"pstooltip\"
             data-placement=\"bottom\"
             data-html=\"true\"
             title=\"<p class='text-left'><strong>Your shop is in maintenance.</strong></p><p class='text-left'>Your visitors and customers cannot access your shop while in maintenance mode.<br /> To manage the maintenance settings, go to Shop Parameters &gt; Maintenance tab.</p>\" href=\"/admin1157/index.php/configure/shop/maintenance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
          >
            <i class=\"material-icons\">build</i>
            <span>Maintenance mode</span>
          </a>
        </div>
      
              <div class=\"component\" id=\"header-shop-list-container\">
            <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"https://gura.rw/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      <span>View my store</span>
";
        // line 279
        echo "    </a>
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
              href=\"#messages-notifications\"
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
   ";
        // line 334
        echo "           Have you checked your <strong><a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=a8877d2c1d17bd62a4363d6b64d6a3a5\">abandoned carts</a></strong>?<br>Your next order could be hiding there!
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
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registered <strong>_date_add_</strong>
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
      
      <div class=\"component\" id=\"h";
        // line 381
        echo "eader-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">

      <span class=\"employee-avatar\"><img class=\"avatar rounded-circle\" src=\"https://gura.rw/img/pr/default.jpg\" /></span>
      <span class=\"employee_profile\">Welcome back Gura Gura</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/admin1157/index.php/configure/advanced/employees/1/edit?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">
      <i class=\"material-icons\">edit</i>
      <span>Your profile</span>
    </a>
    </div>

    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">book</i> Resources</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">school</i> Training</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">person_pin_circle</i> Find an Expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">extension</i> PrestaShop Marketplace</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&";
        // line 402
        echo "amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">help</i> Help Center</a>
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
  <span class=\"menu-collapse\" data-toggle-url=\"/admin1157/index.php/configure/advanced/employees/toggle-navigation?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">
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

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/admin1157/index.php/sell/orders/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
           ";
        // line 448
        echo "           <span>
                      Orders
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                                <a href=\"/admin1157/index.php/sell/orders/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Orders
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                                <a href=\"/admin1157/index.php/sell/orders/invoices/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Invoices
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                                <a href=\"/admin1157/index.php/sell/orders/credit-slips/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Credit Slips
                                </a>
                              </li>

                                          ";
        // line 480
        echo "                                        
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/admin1157/index.php/sell/orders/delivery-slips/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Delivery Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&amp;token=a8877d2c1d17bd62a4363d6b64d6a3a5\" class=\"link\"> Shopping Carts
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                    <a href=\"/admin1157/index.php/sell/catalog/products?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-store\">store</i>
                      <span>
                      Catalog
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                         ";
        // line 512
        echo "     <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                                <a href=\"/admin1157/index.php/sell/catalog/products?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Products
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                                <a href=\"/admin1157/index.php/sell/catalog/categories?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Categories
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                                <a href=\"/admin1157/index.php/sell/catalog/monitoring/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Monitoring
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminAttributesGroups&amp;token=72b9fdb2d8b8e5e68e081b2";
        // line 541
        echo "bf14f28ea\" class=\"link\"> Attributes &amp; Features
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/admin1157/index.php/sell/catalog/brands/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Brands &amp; Suppliers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                                <a href=\"/admin1157/index.php/sell/attachments/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Files
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCartRules&amp;token=8c1164f7ace79cb876083d9cc60695de\" class=\"link\"> Discounts
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                          ";
        // line 573
        echo "      <a href=\"/admin1157/index.php/sell/stocks/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Stock
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/admin1157/index.php/sell/customers/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/sell/customers/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Customers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"26\"";
        // line 605
        echo " id=\"subtab-AdminAddresses\">
                                <a href=\"/admin1157/index.php/sell/addresses/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Addresses
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
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCustomerThreads&amp;token=ed8ba1fb3804a966913f9201773d91d2\" class=\"link\"> Customer Service
                                </a>
                              </li>

                                                                               ";
        // line 635
        echo "   
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/admin1157/index.php/sell/customer-service/order-messages/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Order Messages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminReturn&amp;token=9670bdbde70fe20b144d8364c18879cd\" class=\"link\"> Merchandise Returns
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                    <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-assessment\">assessment</i>
                      <span>
                      Stats
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                             ";
        // line 667
        echo " <ul id=\"collapse-32\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"145\" id=\"subtab-AdminMetricsLegacyStatsController\">
                                <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Stats
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"146\" id=\"subtab-AdminMetricsController\">
                                <a href=\"/admin1157/index.php/modules/metrics?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> PrestaShop Metrics
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title link-active\" data-submenu=\"42\" id=\"tab-IMPROVE\">
                <span class=\"title\">Improve</span>
            </li>

                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu link-active open ul-open\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons";
        // line 702
        echo " mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"48\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Marketplace
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo link-active\" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Module Manager
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"176\" id=\"subtab-AdminParentCEContent\">
                    <a";
        // line 734
        echo " href=\"https://gura.rw/admin1157/index.php?controller=AdminCEThemes&amp;token=1a50fc33781adda97d32f4954c23e8a1\" class=\"link\">
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
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"179\" id=\"subtab-AdminCETemplates\">
           ";
        // line 764
        echo "                     <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCETemplates&amp;token=0e6c2911a66f869da9802c4a3b1f0281\" class=\"link\"> Saved Templates
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
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"52\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                  ";
        // line 794
        echo "    Design
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-52\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"140\" id=\"subtab-AdminPsMboTheme\">
                                <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Theme Catalog
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"130\" id=\"subtab-AdminThemesParent\">
                                <a href=\"/admin1157/index.php/improve/design/themes/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Theme &amp; Logo
                                </a>
                              </li>

                                                                                                                                        
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"55\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/admin1157/index.php/improve/design/mail_theme/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Email Theme
                                </a>
   ";
        // line 823
        echo "                           </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"57\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/admin1157/index.php/improve/design/cms-pages/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"58\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/admin1157/index.php/improve/design/modules/positions/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"59\" id=\"subtab-AdminImages\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminImages&amp;token=875b9ab6964e8f5e60c1ddbf0e1cf057\" class=\"link\"> Image Settings
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"60\" id=\"subtab-AdminParentShipping\">
                    <a hre";
        // line 856
        echo "f=\"https://gura.rw/admin1157/index.php?controller=AdminCarriers&amp;token=095923502a3f216d70dca02b64fbf33a\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/improve/shipping/preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class";
        // line 888
        echo "=\"link-levelone has_submenu\" data-submenu=\"63\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/admin1157/index.php/improve/payment/payment_methods?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/improve/payment/payment_methods?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Payment Methods
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"65\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/admin1157/index.php/improve/payment/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                ";
        // line 918
        echo "  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"66\" id=\"subtab-AdminInternational\">
                    <a href=\"/admin1157/index.php/improve/international/localization/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-66\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"67\" id=\"subtab-AdminParentLocalization\">
                                <a href=\"/admin1157/index.php/improve/international/localization/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Localization
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"72\" id=\"subtab-AdminParentCountries\">
                                <a href=\"/admin1157/index.php/improve/international/zones/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Locations
                                </a>
                              </li>

                                                                     ";
        // line 948
        echo "             
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"76\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/admin1157/index.php/improve/international/taxes/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"79\" id=\"subtab-AdminTranslations\">
                                <a href=\"/admin1157/index.php/improve/international/translations/settings?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Translations
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
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
                              ";
        // line 980
        echo "                <ul id=\"collapse-147\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"148\" id=\"subtab-AdminPsfacebookModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsfacebookModule&amp;token=f400c09ea6dce28804234e7a6b4310f6\" class=\"link\"> Facebook &amp; Instagram
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"150\" id=\"subtab-AdminPsxMktgWithGoogleModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsxMktgWithGoogleModule&amp;token=59c5474c428dfe67ac3e80bde0922f6a\" class=\"link\"> Google
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"80\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configure</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"81\" id=\"subtab-ShopParameters\">
                    <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-settings";
        // line 1015
        echo "\">settings</i>
                      <span>
                      Shop Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-81\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"82\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> General
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"85\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/order-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Order Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"88\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/product-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Pr";
        // line 1044
        echo "oduct Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"89\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/customer-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Customer Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"93\" id=\"subtab-AdminParentStores\">
                                <a href=\"/admin1157/index.php/configure/shop/contacts/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"96\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/admin1157/index.php/configure/shop/seo-urls/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Traffic &amp; SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"100\" id=\"subtab-AdminParentSearchConf\">
                                <a hre";
        // line 1076
        echo "f=\"https://gura.rw/admin1157/index.php?controller=AdminSearchConf&amp;token=cf935b1c83fe2594a8212e19bbe7afc4\" class=\"link\"> Search
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"134\" id=\"subtab-AdminGamification\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminGamification&amp;token=3913ecfc84521adcb6fb471fcd39ffbc\" class=\"link\"> Merchant Expertise
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"103\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Advanced Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-103\" class=\"submenu panel-collapse\">
                                                      
                              
                                      ";
        // line 1107
        echo "                      
                              <li class=\"link-leveltwo\" data-submenu=\"104\" id=\"subtab-AdminInformation\">
                                <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Information
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"105\" id=\"subtab-AdminPerformance\">
                                <a href=\"/admin1157/index.php/configure/advanced/performance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Performance
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"106\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/admin1157/index.php/configure/advanced/administration/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Administration
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"107\" id=\"subtab-AdminEmails\">
                                <a href=\"/admin1157/index.php/configure/advanced/emails/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> E-mail
                                </a>
                              </li>

                                             ";
        // line 1137
        echo "                                     
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"108\" id=\"subtab-AdminImport\">
                                <a href=\"/admin1157/index.php/configure/advanced/import/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Import
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"109\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/admin1157/index.php/configure/advanced/employees/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Team
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"113\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/admin1157/index.php/configure/advanced/sql-requests/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Database
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"116\" id=\"subtab-AdminLogs\">
                                <a href=\"/admin1157/index.php/configure/advanced/logs/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Logs
                                </a>
                ";
        // line 1167
        echo "              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"117\" id=\"subtab-AdminWebservice\">
                                <a href=\"/admin1157/index.php/configure/advanced/webservice-keys/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                              
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"120\" id=\"subtab-AdminFeatureFlag\">
                                <a href=\"/admin1157/index.php/configure/advanced/feature-flags/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Experimental Features
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
                             ";
        // line 1198
        echo "                                       keyboard_arrow_down
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
                      <li class=\"breadcrumb-item\">Module Manager</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" aria-current=\"page\">Modules</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            Module manager          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                          <a
                  class=\"btn btn-primary pointer\"                  id=\"page-header-desc-configuration-add_module\"
                  href=\"#\"                  title=\"Upload a module\"                  data-toggle=\"pstooltip\"
                  data-placement=\"bottom\"                >
                  <i class=\"material-icons\">cloud_upload</i>                  Upload a module
                </a>
                                                                        <a
                  class=\"btn btn-primary pointer\"                  id=\"page-header-desc-configuration-addons_logout\"
                  href=\"#\"                  title=\"Synchronized with Addons marketplace!\"                  data-toggle=\"pstooltip\"
                  data-placement=\"bottom\"                >
                  <i class=\"material-icons\">exit_to_app</i>                  
                </a>
                                   ";
        // line 1248
        echo "   
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Help\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminModules%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesManage\" class=\"nav-link tab active current\" data-submenu=\"45\">
                      Modules
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
     ";
        // line 1278
        echo "               <a href=\"/admin1157/index.php/modules/addons/modules/uninstalled?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminPsMboUninstalledModules\" class=\"nav-link tab \" data-submenu=\"141\">
                      Uninstalled modules
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/alerts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesNotifications\" class=\"nav-link tab \" data-submenu=\"46\">
                      Alerts
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/updates?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesUpdates\" class=\"nav-link tab \" data-submenu=\"47\">
                      Updates
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ";
        // line 1301
        echo "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </ul>
    </div>
  
  <div class=\"btn-floating\">
    <button class=\"btn btn-primary collapsed\" data-toggle=\"collapse\" data-target=\".btn-floating-container\" aria-expanded=\"false\">
      <i class=\"material-icons\">add</i>
    </button>
    <div class=\"btn-floating-container collapse\">
      <div class=\"btn-floating-menu\">
        
                              <a
              class=\"btn btn-floating-item  pointer\"              id=\"page-header-desc-floating-configuration-add_module\"
              href=\"#\"              title=\"Upload a module\"              data-toggle=\"pstooltip\"
              data-placement=\"bottom\"            >
              Upload a module
              <i class=\"material-icons\">cloud_upload</i>            </a>
                                        <a
              class=\"btn btn-floating-item  pointer\"              id=\"page-header-desc-floating-configuration-addons_logout\"
              href=\"#\"              title=\"Synchronized with Addons marketplace!\"              data-toggle=\"pstooltip\"
              data-placement=\"bottom\"            >
              
              <i class=\"material-icons\">exit_to_app</i>            </a>
                  
                              <a class=\"btn b";
        // line 1324
        echo "tn-floating-item btn-help btn-sidebar\" href=\"#\"
               title=\"Help\"
               data-toggle=\"sidebar\"
               data-target=\"#right-sidebar\"
               data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminModules%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
            >
              Help
            </a>
                        </div>
    </div>
  </div>
  <!-- begin /home/xbxgxbq/www/modules/ps_mbo/views/templates/hook/recommended-modules.tpl -->
<script>
  if (undefined !== mbo) {
    mbo.initialize({
      translations: {
        'Recommended Modules and Services': 'Recommended modules',
        'description': \"Here\\'s a selection of modules,<\\strong> compatible with your store<\\/strong>, to help you achieve your goals\",
        'Close': 'Close',
      },
      recommendedModulesUrl: '/admin1157/index.php/modules/addons/modules/recommended?tabClassName=AdminModulesManage&_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM',
      shouldAttachRecommendedModulesAfterContent: 0,
      shouldAttachRecommendedModulesButton: 0,
      shouldUseLegacyTheme: 0,
    });
  }
</script>

<script>
\$(document).ready( function () {
  if (typeof window.mboCdc !== undefined && typeof window.mboCdc !== \"undefined\") {
    const targetDiv = \$('#main-div .content-div').first()

    const divModuleManagerMessage = document.createElement(\"div\");
    divModuleManagerMessage.setAttribute(\"id\", \"module-manager-message-cdc-container\");

    divModuleManagerMessage.classList.add('module-manager-message-wrapper');
    divModuleManagerMessage.classList.add('cdc-container');

    targetDiv.prepend(divModuleManagerMessage)
    const renderModulesManagerMessage = window.mboCdc.renderModulesManagerMessage

    const context = {\"currency\":\"EUR\",\"iso_lang\":\"en\",\"iso_code\":\"rw\",\"shop_version\":\"1.7.8.7\",\"shop_url\":\"https:\\/\\/gura.rw\",\"shop_uuid\":\"b43637d4-d582-4ad3-b1a1-";
        // line 1366
        echo "fbc49c2cfb89\",\"mbo_token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzaG9wX3VybCI6Imh0dHBzOi8vZ3VyYS5ydyIsInNob3BfdXVpZCI6ImI0MzYzN2Q0LWQ1ODItNGFkMy1iMWExLWZiYzQ5YzJjZmI4OSJ9.hdqjPPWUsTFIFkngBeH4cUCOK0i9qlrFa4BO10hREHI\",\"mbo_version\":\"3.1.3\",\"mbo_reset_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/reset\\/ps_mbo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"user_id\":\"1\",\"admin_token\":\"w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"refresh_url\":\"\\/admin1157\\/index.php\\/modules\\/mbo\\/me?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"installed_modules\":[{\"id\":22320,\"name\":\"ps_imageslider\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_imageslider?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15265,\"name\":\"statsbestcustomers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null},{\"id\":0,\"name\":\"zonecolorsfonts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonecolorsfonts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15271,\"name\":\"statscatalog\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":22317,\"name\":\"ps_customtext\",\"status\":\"disabled__mobile_disabled\",\"version\":\"4.2.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_customtext?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":50291,\"name\":\"ps_facebook\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.37.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_facebook?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonethememanager\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonethememanager?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\"";
        echo ":24674,\"name\":\"ps_viewedproduct\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.2.4\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_viewedproduct?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24360,\"name\":\"ps_linklist\",\"status\":\"disabled__mobile_disabled\",\"version\":\"5.0.4\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_linklist?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15280,\"name\":\"statsproduct\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":22318,\"name\":\"ps_emailsubscription\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.8.2\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_emailsubscription?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15277,\"name\":\"statsnewsletter\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null},{\"id\":22385,\"name\":\"welcome\",\"status\":\"enabled__mobile_enabled\",\"version\":\"6.0.7\",\"config_url\":null},{\"id\":15266,\"name\":\"statsbestmanufacturers\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":23871,\"name\":\"ps_wirepayment\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_wirepayment?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonepopupnewsletter\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonepopupnewsletter?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15279,\"name\":\"statspersonalinfos\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":null},{\"id\":15269,\"name\":\"statsbestvouchers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":24671,\"name\":\"ps_newproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.4\",\"config_url\":\"\\/admin1157\\/index.php\\/imp";
        echo "rove\\/modules\\/manage\\/action\\/configure\\/ps_newproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15275,\"name\":\"statsforecast\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/statsforecast?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15283,\"name\":\"statssearch\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":44064,\"name\":\"creativeelements\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.10.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/creativeelements?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15282,\"name\":\"statssales\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":24672,\"name\":\"ps_specials\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.2\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_specials?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonebrandlogo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonebrandlogo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24696,\"name\":\"ps_crossselling\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_crossselling?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"psaddonsconnect\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":32577,\"name\":\"ps_themecusto\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.2.4\",\"config_url\":null},{\"id\":23870,\"name\":\"ps_shoppingcart\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.5\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_shoppingcart?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22314,\"name\":\"ps_categorytre";
        echo "e\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_categorytree?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23835,\"name\":\"contactform\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.3.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/contactform?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":5496,\"name\":\"autoupgrade\",\"status\":\"enabled__mobile_enabled\",\"version\":\"6.2.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/autoupgrade?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22313,\"name\":\"ps_banner\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.1.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_banner?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15255,\"name\":\"gridhtml\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":9144,\"name\":\"productcomments\",\"status\":\"enabled__mobile_enabled\",\"version\":\"5.0.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/productcomments?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15250,\"name\":\"dashactivity\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":15267,\"name\":\"statsbestproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":49648,\"name\":\"ps_accounts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"7.0.2\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_accounts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"ps_checkout\",\"status\":\"enabled__mobile_enabled\",\"version\":\"7.3.6.3\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_checkout?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zoneproductadditional\",\"status\":\"enabled__mobile_en";
        echo "abled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zoneproductadditional?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23866,\"name\":\"ps_customeraccountlinks\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.1\",\"config_url\":null},{\"id\":41965,\"name\":\"ps_faviconnotificationbo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_faviconnotificationbo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"doofinder\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.11.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/doofinder?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":48891,\"name\":\"ets_onepagecheckout\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.8.5\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ets_onepagecheckout?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":42674,\"name\":\"ps_buybuttonlite\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_buybuttonlite?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":39574,\"name\":\"ps_mbo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.3\",\"config_url\":null},{\"id\":15264,\"name\":\"statsbestcategories\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":0,\"name\":\"zoneslideshow\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zoneslideshow?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22312,\"name\":\"blockreassurance\",\"status\":\"enabled__mobile_enabled\",\"version\":\"5.1.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/blockreassurance?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22315,\"name\":\"ps_conta";
        echo "ctinfo\",\"status\":\"disabled__mobile_disabled\",\"version\":\"3.3.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_contactinfo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24697,\"name\":\"ps_dataprivacy\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_dataprivacy?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23869,\"name\":\"ps_searchbar\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.3\",\"config_url\":null},{\"id\":23865,\"name\":\"ps_currencyselector\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":9131,\"name\":\"blockwishlist\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/blockwishlist?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23868,\"name\":\"ps_languageselector\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":0,\"name\":\"zonehomeblocks\",\"status\":\"disabled__mobile_disabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonehomeblocks?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15252,\"name\":\"dashproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":0,\"name\":\"zonefeaturedcategories\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonefeaturedcategories?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22323,\"name\":\"ps_socialfollow\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.2.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_socialfollow?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22322,\"name\":\"ps_sharebuttons\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/";
        echo "modules\\/manage\\/action\\/configure\\/ps_sharebuttons?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15258,\"name\":\"pagesnotfound\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":24588,\"name\":\"ps_categoryproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.7\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_categoryproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22319,\"name\":\"ps_featuredproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.2\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_featuredproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonemegamenu\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonemegamenu?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23867,\"name\":\"ps_facetedsearch\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.16.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_facetedsearch?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15284,\"name\":\"statsstock\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":15251,\"name\":\"dashgoals\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":24566,\"name\":\"ps_bestsellers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.6\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_bestsellers?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15281,\"name\":\"statsregistrations\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":85751,\"name\":\"psxmarketingwithgoogle\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.74.8\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/psxmarketingwithgoogle?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgn";
        echo "rM\"},{\"id\":15254,\"name\":\"graphnvd3\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":7501,\"name\":\"gsitemap\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.2.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/gsitemap?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22321,\"name\":\"ps_mainmenu\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.3.4\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_mainmenu?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15273,\"name\":\"statsdata\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/statsdata?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":39324,\"name\":\"psgdpr\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.4.3\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/psgdpr?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"gamification\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.5.1\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/gamification?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22316,\"name\":\"ps_customersignin\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":null},{\"id\":15268,\"name\":\"statsbestsuppliers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":15272,\"name\":\"statscheckup\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":23864,\"name\":\"ps_checkpayment\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.5\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_checkpayment?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15270,\"name\":\"statscarrier\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":49583,\"name\":\"ps_metrics\",\"status\":\"enabled__mobile_enabled\",\"";
        echo "version\":\"4.0.5\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/ps_metrics?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonecolumnblocks\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\/admin1157\\/index.php\\/improve\\/modules\\/manage\\/action\\/configure\\/zonecolumnblocks?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15253,\"name\":\"dashtrends\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null}],\"accounts_user_id\":\"ALyJK0Ll6EXZ9LtC70itQ3gYWLu2\",\"accounts_shop_id\":\"ba5a862a-5f2e-4ec9-a005-7ebe58cdf1c9\",\"accounts_token\":\"eyJhbGciOiJSUzI1NiIsImtpZCI6IjBhYmQzYTQzMTc4YzE0MjlkNWE0NDBiYWUzNzM1NDRjMDlmNGUzODciLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoiR3VyYSBSVyIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS9BQ2c4b2NLc0o1SlRTUzNFbGoyUVRILXV6eXJfX1JXNEliVF8xZEQ1ZVlhWDV2VFk9czk2LWMiLCJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vcHJlc3Rhc2hvcC1uZXdzc28tcHJvZHVjdGlvbiIsImF1ZCI6InByZXN0YXNob3AtbmV3c3NvLXByb2R1Y3Rpb24iLCJhdXRoX3RpbWUiOjE3MzcyMTM3MTIsInVzZXJfaWQiOiJBTHlKSzBMbDZFWFo5THRDNzBpdFEzZ1lXTHUyIiwic3ViIjoiQUx5SkswTGw2RVhaOUx0QzcwaXRRM2dZV0x1MiIsImlhdCI6MTczNzIxMzcxMiwiZXhwIjoxNzM3MjE3MzEyLCJlbWFpbCI6Imd1cmFndXJhcndAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZ29vZ2xlLmNvbSI6WyIxMDU3ODc0MDYxMTgxODU0Mjg1MzgiXSwiZW1haWwiOlsiZ3VyYWd1cmFyd0BnbWFpbC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJjdXN0b20ifX0.ESdeA3QJHpRjgYi6hAkX3LBxVvwpG9f4A6XDwOnf9h5PW-K9X5lmz8Wj8Hwf2dS2HqhOCLcsnSUmp5Ey9UwnY4kZ5SW4oNMXT2UhHs8Ui2XhIOfrBpihD6xpRSHG5v7jMQY5FwnBltRW8Azk_OYUKAlUvNW1rZ1XBCtHQprKX69wjYXqiNh6pRT33lkz8PP1EFBOMHlDfKpdbVyyNb8gkN958NVFn9cdSHI7o3Sv9UdOQTfWC1wufX9Ee-dV6r1q2rk8MQbaE4e8Z1B6_M7yDzHQResQU0DfvsqRLRTqRE2MIhCbeCm_4Ar-ovY8jvblHBU2tYJTi0orGG_P8mUjLg\",\"accounts_component_loaded\":false,\"module_catalog_url\":\"\\/admin1157\\/index.php\\/modules\\/addons\\/modules\\/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"theme_catalog_url\":\"\\/admin";
        echo "1157\\/index.php\\/modules\\/addons\\/themes\\/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"php_version\":\"7.4.33\",\"shop_creation_date\":\"2024-05-28\",\"shop_business_sector_id\":null,\"shop_business_sector\":null,\"prestaShop_controller_class_name\":\"AdminModulesManage\"};

    renderModulesManagerMessage(context, '#module-manager-message-cdc-container')
  }
})
</script>
<!-- end /home/xbxgxbq/www/modules/ps_mbo/views/templates/hook/recommended-modules.tpl -->
</div>

<div id=\"main-div\">
          
      <div class=\"content-div  with-tabs\">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1387
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
        // line 1438
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
        // line 1477
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
        // line 1495
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>";
        echo "
</html>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 142
    public function block_stylesheets($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "extra_stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "extra_stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1387
    public function block_content_header($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_header"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_header"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_content($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_content_footer($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_footer"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_sidebar_right($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "sidebar_right"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "sidebar_right"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1495
    public function block_javascripts($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "extra_javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "extra_javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "translate_javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "translate_javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "__string_template__ef64602f05cebe8f8a66ecd8aafe02d7990ce9243052e9880dfbccc5c75c5477";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1758 => 1495,  1693 => 1387,  1660 => 142,  1645 => 1495,  1625 => 1477,  1584 => 1438,  1527 => 1387,  1495 => 1366,  1451 => 1324,  1426 => 1301,  1401 => 1278,  1369 => 1248,  1317 => 1198,  1284 => 1167,  1252 => 1137,  1220 => 1107,  1187 => 1076,  1153 => 1044,  1122 => 1015,  1085 => 980,  1051 => 948,  1019 => 918,  987 => 888,  953 => 856,  918 => 823,  887 => 794,  855 => 764,  823 => 734,  789 => 702,  752 => 667,  718 => 635,  686 => 605,  652 => 573,  618 => 541,  587 => 512,  553 => 480,  519 => 448,  471 => 402,  448 => 381,  399 => 334,  342 => 279,  299 => 238,  278 => 219,  237 => 180,  194 => 142,  138 => 88,  115 => 67,  89 => 43,  45 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{{ '<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>Module manager • PrestaShop</title>

  <script type=\"text/javascript\">
    var help_class_name = \\'AdminModulesManage\\';
    var iso_user = \\'en\\';
    var lang_is_rtl = \\'0\\';
    var full_language_code = \\'en-us\\';
    var full_cldr_language_code = \\'en-US\\';
    var country_iso_code = \\'RW\\';
    var _PS_VERSION_ = \\'1.7.8.7\\';
    var roundMode = 2;
    var youEditFieldFor = \\'\\';
        var new_order_msg = \\'A new order has been placed on your shop.\\';
    var order_number_msg = \\'Order number: \\';
    var total_msg = \\'Total: \\';
    var from_msg = \\'From: \\';
    var see_order_msg = \\'View this order\\';
    var new_customer_msg = \\'A new customer registered on your shop.\\';
    var customer_name_msg = \\'Customer name: \\';
    var new_msg = \\'A new message was posted on your shop.\\';
    var see_msg = \\'Read this message\\';
    var token = \\'9f0a5d17d97fa23806fd9a23e242b49f\\';
    var token_admin_orders = tokenAdminOrders = \\'82cb2448d9979613a4ebc415b8446fdc\\';
    var token_admin_customers = \\'6c823d98e3386a625d7d088c8102bf95\\';
    var token_admin_customer_threads = tokenAdminCustomerThreads = \\'ed8ba1fb3804a966913f9201773d91d2\\';
    var currentIndex = \\'index.php?controller=AdminModulesManage\\';
    var employee_token = \\'64f18f7de30037933a6376f21d629ccb\\';
    var choose_language_translate = \\'Choose language:\\';
    var default_language = \\'1\\';
    var admin_modules_link = \\'/admin1157/index.php/improve/modules/catalog/recommended?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\\';
    var admin_notification_get_link = \\'/admin1157/index.php/common/notifications?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\\';
    var admin_notificat' | raw }}{{ 'ion_push_link = adminNotificationPushLink = \\'/admin1157/index.php/common/notifications/ack?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\\';
    var tab_modules_list = \\'\\';
    var update_success_msg = \\'Update successful\\';
    var errorLogin = \\'PrestaShop was unable to log in to Addons. Please check your credentials and your Internet connection.\\';
    var search_product_msg = \\'Search for a product\\';
  </script>

      <link href=\"/admin1157/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/blockwishlist/public/backoffice.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/admin1157/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/gamification/views/css/gamification.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/catalog.css?v=3.1.3\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/module-catalog.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/connection-toolbar.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_facebook/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/psxmarketingwithgoogle/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\\\/admin1157\\\\/\";
var baseDir = \"\\\\/\";
var changeFormLanguageUrl = \"\\\\/admin1157\\\\/index.php\\\\/configure\\\\/advanced\\\\/employees\\\\/change-form-language?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\\\u20ac\",\"name\":\"Euro\",\"format\":null};
var currency_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\\\u00d7\",\"\\\\u2030\",\"\\\\u221e\",\"NaN\"],\"currencyCode\":\"EUR\",\"currencySym' | raw }}{{ 'bol\":\"\\\\u20ac\",\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\\\u00d7\",\"\\\\u2030\",\"\\\\u221e\",\"NaN\"],\"positivePattern\":\"\\\\u00a4#,##0.00\",\"negativePattern\":\"-\\\\u00a4#,##0.00\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\\\u00d7\",\"\\\\u2030\",\"\\\\u221e\",\"NaN\"],\"numberSymbols\":[\".\",\",\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\\\u00d7\",\"\\\\u2030\",\"\\\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":true};
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
<script type=\"text/javascript\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin1157/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_mbo/views/js/recommended-modules.js?v=3.1.3\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/growl/jquery.growl.js?v=3.1.3\"></script>
<script type=\"text/javascript\" src=\"https://assets.prestashop3.com/dst/mbo/v1/mbo-cdc.umd.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconno' | raw }}{{ 'tificationbo/views/js/favico.js\"></script>
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
\tcontent: \\'\\';
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
<script>
  if (undefined !== ps_faviconnotificationbo) {
    ps_faviconnotificationbo.initialize({
      backgroundColor: \\'#DF0067\\',
      textColor: \\'#FFFFFF\\',
      notificationGetUrl: \\'/admin1157/index.php/common/notifications?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\\',
      CHECKBOX_ORDER: 1,
      CHECKBOX_CUSTOMER: 1,
      CHECKBOX_MESSAGE: 1,
      timer: 120000, // Refresh every 2 minutes
    });
  }
</script>
<script>
            var admin_gamification_ajax_url = \"https:\\\\/\\\\/gura.rw\\\\/admin1157\\\\/index.php?controller=AdminGamification&token=3913ecfc84521adcb6fb471fcd39ffbc\";
            var current_id_tab = 45;
        </script>

' | raw }}{% block stylesheets %}{% endblock %}{% block extra_stylesheets %}{% endblock %}</head>{{ '

<body
  class=\"lang-en adminmodulesmanage\"
  data-base-url=\"/admin1157/index.php\"  data-token=\"w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">

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
         href=\"https://gura.rw/admin1157/index.php?cont' | raw }}{{ 'roller=AdminCartRules&amp;addcart_rule&amp;token=8c1164f7ace79cb876083d9cc60695de\"
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
        data-rand=\"124\"
        data-icon=\"icon-AdminModulesSf\"
        data-method=\"add\"
        data-url=\"index.php/improve/modules/manage?-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
        data-post-link=\"https://gura.rw/admin1157/index.php?controller=AdminQuickAccesses&token=e255bf5a6bc05d0187c5260841a4f82f\"
        data-prompt-text=\"Please name this shortcut:\"
        data-link=\"Modules - List\"
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
      <button type=\"button\" class=\"btn btn-o' | raw }}{{ 'utline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
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

<scri' | raw }}{{ 'pt type=\"text/javascript\">
 \$(document).ready(function(){
    \$(\\'#bo_query\\').one(\\'click\\', function() {
    \$(this).closest(\\'form\\').removeClass(\\'collapsed\\');
  });
});
</script>
      </div>

              <div class=\"component hide-mobile-sm\" id=\"header-debug-mode-container\">
          <a class=\"link shop-state\"
             id=\"debug-mode\"
             data-toggle=\"pstooltip\"
             data-placement=\"bottom\"
             data-html=\"true\"
             title=\"<p class=\\'text-left\\'><strong>Your shop is in debug mode.</strong></p><p class=\\'text-left\\'>All the PHP errors and messages are displayed. When you no longer need it, <strong>turn off</strong> this mode.</p>\"
             href=\"/admin1157/index.php/configure/advanced/performance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
          >
            <i class=\"material-icons\">bug_report</i>
            <span>Debug mode</span>
          </a>
        </div>
      
              <div class=\"component hide-mobile-sm\" id=\"header-maintenance-mode-container\">
          <a class=\"link shop-state\"
             id=\"maintenance-mode\"
             data-toggle=\"pstooltip\"
             data-placement=\"bottom\"
             data-html=\"true\"
             title=\"<p class=\\'text-left\\'><strong>Your shop is in maintenance.</strong></p><p class=\\'text-left\\'>Your visitors and customers cannot access your shop while in maintenance mode.<br /> To manage the maintenance settings, go to Shop Parameters &gt; Maintenance tab.</p>\" href=\"/admin1157/index.php/configure/shop/maintenance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
          >
            <i class=\"material-icons\">build</i>
            <span>Maintenance mode</span>
          </a>
        </div>
      
              <div class=\"component\" id=\"header-shop-list-container\">
            <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"https://gura.rw/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      <span>View my store</span>
' | raw }}{{ '    </a>
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
              href=\"#messages-notifications\"
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
   ' | raw }}{{ '           Have you checked your <strong><a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=a8877d2c1d17bd62a4363d6b64d6a3a5\">abandoned carts</a></strong>?<br>Your next order could be hiding there!
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
    <a class=\"notif\" href=\\'order_url\\'>
      #_id_order_ -
      from <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href=\\'customer_url\\'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registered <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href=\\'message_url\\'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
        </div>
      
      <div class=\"component\" id=\"h' | raw }}{{ 'eader-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">

      <span class=\"employee-avatar\"><img class=\"avatar rounded-circle\" src=\"https://gura.rw/img/pr/default.jpg\" /></span>
      <span class=\"employee_profile\">Welcome back Gura Gura</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/admin1157/index.php/configure/advanced/employees/1/edit?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">
      <i class=\"material-icons\">edit</i>
      <span>Your profile</span>
    </a>
    </div>

    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">book</i> Resources</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">school</i> Training</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">person_pin_circle</i> Find an Expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">extension</i> PrestaShop Marketplace</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&' | raw }}{{ 'amp;utm_content=download17\" target=\"_blank\" rel=\"noreferrer\"><i class=\"material-icons\">help</i> Help Center</a>
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
  <span class=\"menu-collapse\" data-toggle-url=\"/admin1157/index.php/configure/advanced/employees/toggle-navigation?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\">
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

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/admin1157/index.php/sell/orders/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
           ' | raw }}{{ '           <span>
                      Orders
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                                <a href=\"/admin1157/index.php/sell/orders/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Orders
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                                <a href=\"/admin1157/index.php/sell/orders/invoices/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Invoices
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                                <a href=\"/admin1157/index.php/sell/orders/credit-slips/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Credit Slips
                                </a>
                              </li>

                                          ' | raw }}{{ '                                        
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/admin1157/index.php/sell/orders/delivery-slips/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Delivery Slips
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCarts&amp;token=a8877d2c1d17bd62a4363d6b64d6a3a5\" class=\"link\"> Shopping Carts
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                    <a href=\"/admin1157/index.php/sell/catalog/products?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-store\">store</i>
                      <span>
                      Catalog
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                         ' | raw }}{{ '     <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                                <a href=\"/admin1157/index.php/sell/catalog/products?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Products
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                                <a href=\"/admin1157/index.php/sell/catalog/categories?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Categories
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                                <a href=\"/admin1157/index.php/sell/catalog/monitoring/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Monitoring
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminAttributesGroups&amp;token=72b9fdb2d8b8e5e68e081b2' | raw }}{{ 'bf14f28ea\" class=\"link\"> Attributes &amp; Features
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/admin1157/index.php/sell/catalog/brands/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Brands &amp; Suppliers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                                <a href=\"/admin1157/index.php/sell/attachments/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Files
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCartRules&amp;token=8c1164f7ace79cb876083d9cc60695de\" class=\"link\"> Discounts
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                          ' | raw }}{{ '      <a href=\"/admin1157/index.php/sell/stocks/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Stock
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/admin1157/index.php/sell/customers/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/sell/customers/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Customers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"26\"' | raw }}{{ ' id=\"subtab-AdminAddresses\">
                                <a href=\"/admin1157/index.php/sell/addresses/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Addresses
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
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCustomerThreads&amp;token=ed8ba1fb3804a966913f9201773d91d2\" class=\"link\"> Customer Service
                                </a>
                              </li>

                                                                               ' | raw }}{{ '   
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/admin1157/index.php/sell/customer-service/order-messages/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Order Messages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminReturn&amp;token=9670bdbde70fe20b144d8364c18879cd\" class=\"link\"> Merchandise Returns
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                    <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-assessment\">assessment</i>
                      <span>
                      Stats
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                             ' | raw }}{{ ' <ul id=\"collapse-32\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"145\" id=\"subtab-AdminMetricsLegacyStatsController\">
                                <a href=\"/admin1157/index.php/modules/metrics/legacy/stats?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Stats
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"146\" id=\"subtab-AdminMetricsController\">
                                <a href=\"/admin1157/index.php/modules/metrics?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> PrestaShop Metrics
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title link-active\" data-submenu=\"42\" id=\"tab-IMPROVE\">
                <span class=\"title\">Improve</span>
            </li>

                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu link-active open ul-open\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons' | raw }}{{ ' mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"48\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/admin1157/index.php/modules/addons/modules/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Marketplace
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo link-active\" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Module Manager
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"176\" id=\"subtab-AdminParentCEContent\">
                    <a' | raw }}{{ ' href=\"https://gura.rw/admin1157/index.php?controller=AdminCEThemes&amp;token=1a50fc33781adda97d32f4954c23e8a1\" class=\"link\">
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
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"179\" id=\"subtab-AdminCETemplates\">
           ' | raw }}{{ '                     <a href=\"https://gura.rw/admin1157/index.php?controller=AdminCETemplates&amp;token=0e6c2911a66f869da9802c4a3b1f0281\" class=\"link\"> Saved Templates
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
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"52\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                  ' | raw }}{{ '    Design
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-52\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"140\" id=\"subtab-AdminPsMboTheme\">
                                <a href=\"/admin1157/index.php/modules/addons/themes/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Theme Catalog
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"130\" id=\"subtab-AdminThemesParent\">
                                <a href=\"/admin1157/index.php/improve/design/themes/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Theme &amp; Logo
                                </a>
                              </li>

                                                                                                                                        
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"55\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/admin1157/index.php/improve/design/mail_theme/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Email Theme
                                </a>
   ' | raw }}{{ '                           </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"57\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/admin1157/index.php/improve/design/cms-pages/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"58\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/admin1157/index.php/improve/design/modules/positions/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"59\" id=\"subtab-AdminImages\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminImages&amp;token=875b9ab6964e8f5e60c1ddbf0e1cf057\" class=\"link\"> Image Settings
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"60\" id=\"subtab-AdminParentShipping\">
                    <a hre' | raw }}{{ 'f=\"https://gura.rw/admin1157/index.php?controller=AdminCarriers&amp;token=095923502a3f216d70dca02b64fbf33a\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/improve/shipping/preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class' | raw }}{{ '=\"link-levelone has_submenu\" data-submenu=\"63\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/admin1157/index.php/improve/payment/payment_methods?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
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
                                <a href=\"/admin1157/index.php/improve/payment/payment_methods?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Payment Methods
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"65\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/admin1157/index.php/improve/payment/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Preferences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                ' | raw }}{{ '  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"66\" id=\"subtab-AdminInternational\">
                    <a href=\"/admin1157/index.php/improve/international/localization/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-66\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"67\" id=\"subtab-AdminParentLocalization\">
                                <a href=\"/admin1157/index.php/improve/international/localization/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Localization
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"72\" id=\"subtab-AdminParentCountries\">
                                <a href=\"/admin1157/index.php/improve/international/zones/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Locations
                                </a>
                              </li>

                                                                     ' | raw }}{{ '             
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"76\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/admin1157/index.php/improve/international/taxes/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"79\" id=\"subtab-AdminTranslations\">
                                <a href=\"/admin1157/index.php/improve/international/translations/settings?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Translations
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
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
                              ' | raw }}{{ '                <ul id=\"collapse-147\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"148\" id=\"subtab-AdminPsfacebookModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsfacebookModule&amp;token=f400c09ea6dce28804234e7a6b4310f6\" class=\"link\"> Facebook &amp; Instagram
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"150\" id=\"subtab-AdminPsxMktgWithGoogleModule\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminPsxMktgWithGoogleModule&amp;token=59c5474c428dfe67ac3e80bde0922f6a\" class=\"link\"> Google
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title\" data-submenu=\"80\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configure</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"81\" id=\"subtab-ShopParameters\">
                    <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-settings' | raw }}{{ '\">settings</i>
                      <span>
                      Shop Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-81\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"82\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/preferences/preferences?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> General
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"85\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/order-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Order Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"88\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/product-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Pr' | raw }}{{ 'oduct Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"89\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/admin1157/index.php/configure/shop/customer-preferences/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Customer Settings
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"93\" id=\"subtab-AdminParentStores\">
                                <a href=\"/admin1157/index.php/configure/shop/contacts/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"96\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/admin1157/index.php/configure/shop/seo-urls/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Traffic &amp; SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"100\" id=\"subtab-AdminParentSearchConf\">
                                <a hre' | raw }}{{ 'f=\"https://gura.rw/admin1157/index.php?controller=AdminSearchConf&amp;token=cf935b1c83fe2594a8212e19bbe7afc4\" class=\"link\"> Search
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"134\" id=\"subtab-AdminGamification\">
                                <a href=\"https://gura.rw/admin1157/index.php?controller=AdminGamification&amp;token=3913ecfc84521adcb6fb471fcd39ffbc\" class=\"link\"> Merchant Expertise
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"103\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Advanced Parameters
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-103\" class=\"submenu panel-collapse\">
                                                      
                              
                                      ' | raw }}{{ '                      
                              <li class=\"link-leveltwo\" data-submenu=\"104\" id=\"subtab-AdminInformation\">
                                <a href=\"/admin1157/index.php/configure/advanced/system-information/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Information
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"105\" id=\"subtab-AdminPerformance\">
                                <a href=\"/admin1157/index.php/configure/advanced/performance/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Performance
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"106\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/admin1157/index.php/configure/advanced/administration/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Administration
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"107\" id=\"subtab-AdminEmails\">
                                <a href=\"/admin1157/index.php/configure/advanced/emails/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> E-mail
                                </a>
                              </li>

                                             ' | raw }}{{ '                                     
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"108\" id=\"subtab-AdminImport\">
                                <a href=\"/admin1157/index.php/configure/advanced/import/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Import
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"109\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/admin1157/index.php/configure/advanced/employees/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Team
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"113\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/admin1157/index.php/configure/advanced/sql-requests/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Database
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"116\" id=\"subtab-AdminLogs\">
                                <a href=\"/admin1157/index.php/configure/advanced/logs/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Logs
                                </a>
                ' | raw }}{{ '              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"117\" id=\"subtab-AdminWebservice\">
                                <a href=\"/admin1157/index.php/configure/advanced/webservice-keys/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                              
                              
                                                            
                              <li class=\"link-leveltwo\" data-submenu=\"120\" id=\"subtab-AdminFeatureFlag\">
                                <a href=\"/admin1157/index.php/configure/advanced/feature-flags/?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" class=\"link\"> Experimental Features
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
                             ' | raw }}{{ '                                       keyboard_arrow_down
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
                      <li class=\"breadcrumb-item\">Module Manager</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" aria-current=\"page\">Modules</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            Module manager          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                          <a
                  class=\"btn btn-primary pointer\"                  id=\"page-header-desc-configuration-add_module\"
                  href=\"#\"                  title=\"Upload a module\"                  data-toggle=\"pstooltip\"
                  data-placement=\"bottom\"                >
                  <i class=\"material-icons\">cloud_upload</i>                  Upload a module
                </a>
                                                                        <a
                  class=\"btn btn-primary pointer\"                  id=\"page-header-desc-configuration-addons_logout\"
                  href=\"#\"                  title=\"Synchronized with Addons marketplace!\"                  data-toggle=\"pstooltip\"
                  data-placement=\"bottom\"                >
                  <i class=\"material-icons\">exit_to_app</i>                  
                </a>
                                   ' | raw }}{{ '   
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Help\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminModules%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/manage?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesManage\" class=\"nav-link tab active current\" data-submenu=\"45\">
                      Modules
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
     ' | raw }}{{ '               <a href=\"/admin1157/index.php/modules/addons/modules/uninstalled?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminPsMboUninstalledModules\" class=\"nav-link tab \" data-submenu=\"141\">
                      Uninstalled modules
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/alerts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesNotifications\" class=\"nav-link tab \" data-submenu=\"46\">
                      Alerts
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"/admin1157/index.php/improve/modules/updates?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\" id=\"subtab-AdminModulesUpdates\" class=\"nav-link tab \" data-submenu=\"47\">
                      Updates
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ' | raw }}{{ '                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </ul>
    </div>
  
  <div class=\"btn-floating\">
    <button class=\"btn btn-primary collapsed\" data-toggle=\"collapse\" data-target=\".btn-floating-container\" aria-expanded=\"false\">
      <i class=\"material-icons\">add</i>
    </button>
    <div class=\"btn-floating-container collapse\">
      <div class=\"btn-floating-menu\">
        
                              <a
              class=\"btn btn-floating-item  pointer\"              id=\"page-header-desc-floating-configuration-add_module\"
              href=\"#\"              title=\"Upload a module\"              data-toggle=\"pstooltip\"
              data-placement=\"bottom\"            >
              Upload a module
              <i class=\"material-icons\">cloud_upload</i>            </a>
                                        <a
              class=\"btn btn-floating-item  pointer\"              id=\"page-header-desc-floating-configuration-addons_logout\"
              href=\"#\"              title=\"Synchronized with Addons marketplace!\"              data-toggle=\"pstooltip\"
              data-placement=\"bottom\"            >
              
              <i class=\"material-icons\">exit_to_app</i>            </a>
                  
                              <a class=\"btn b' | raw }}{{ 'tn-floating-item btn-help btn-sidebar\" href=\"#\"
               title=\"Help\"
               data-toggle=\"sidebar\"
               data-target=\"#right-sidebar\"
               data-url=\"/admin1157/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fen%252Fdoc%252FAdminModules%253Fversion%253D1.7.8.7%2526country%253Den/Help?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"
            >
              Help
            </a>
                        </div>
    </div>
  </div>
  <!-- begin /home/xbxgxbq/www/modules/ps_mbo/views/templates/hook/recommended-modules.tpl -->
<script>
  if (undefined !== mbo) {
    mbo.initialize({
      translations: {
        \\'Recommended Modules and Services\\': \\'Recommended modules\\',
        \\'description\\': \"Here\\\\\\'s a selection of modules,<\\\\strong> compatible with your store<\\\\/strong>, to help you achieve your goals\",
        \\'Close\\': \\'Close\\',
      },
      recommendedModulesUrl: \\'/admin1157/index.php/modules/addons/modules/recommended?tabClassName=AdminModulesManage&_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\\',
      shouldAttachRecommendedModulesAfterContent: 0,
      shouldAttachRecommendedModulesButton: 0,
      shouldUseLegacyTheme: 0,
    });
  }
</script>

<script>
\$(document).ready( function () {
  if (typeof window.mboCdc !== undefined && typeof window.mboCdc !== \"undefined\") {
    const targetDiv = \$(\\'#main-div .content-div\\').first()

    const divModuleManagerMessage = document.createElement(\"div\");
    divModuleManagerMessage.setAttribute(\"id\", \"module-manager-message-cdc-container\");

    divModuleManagerMessage.classList.add(\\'module-manager-message-wrapper\\');
    divModuleManagerMessage.classList.add(\\'cdc-container\\');

    targetDiv.prepend(divModuleManagerMessage)
    const renderModulesManagerMessage = window.mboCdc.renderModulesManagerMessage

    const context = {\"currency\":\"EUR\",\"iso_lang\":\"en\",\"iso_code\":\"rw\",\"shop_version\":\"1.7.8.7\",\"shop_url\":\"https:\\\\/\\\\/gura.rw\",\"shop_uuid\":\"b43637d4-d582-4ad3-b1a1-' | raw }}{{ 'fbc49c2cfb89\",\"mbo_token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzaG9wX3VybCI6Imh0dHBzOi8vZ3VyYS5ydyIsInNob3BfdXVpZCI6ImI0MzYzN2Q0LWQ1ODItNGFkMy1iMWExLWZiYzQ5YzJjZmI4OSJ9.hdqjPPWUsTFIFkngBeH4cUCOK0i9qlrFa4BO10hREHI\",\"mbo_version\":\"3.1.3\",\"mbo_reset_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/reset\\\\/ps_mbo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"user_id\":\"1\",\"admin_token\":\"w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"refresh_url\":\"\\\\/admin1157\\\\/index.php\\\\/modules\\\\/mbo\\\\/me?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"installed_modules\":[{\"id\":22320,\"name\":\"ps_imageslider\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_imageslider?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15265,\"name\":\"statsbestcustomers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null},{\"id\":0,\"name\":\"zonecolorsfonts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonecolorsfonts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15271,\"name\":\"statscatalog\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":22317,\"name\":\"ps_customtext\",\"status\":\"disabled__mobile_disabled\",\"version\":\"4.2.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_customtext?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":50291,\"name\":\"ps_facebook\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.37.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_facebook?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonethememanager\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonethememanager?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\"' | raw }}{{ ':24674,\"name\":\"ps_viewedproduct\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.2.4\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_viewedproduct?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24360,\"name\":\"ps_linklist\",\"status\":\"disabled__mobile_disabled\",\"version\":\"5.0.4\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_linklist?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15280,\"name\":\"statsproduct\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":22318,\"name\":\"ps_emailsubscription\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.8.2\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_emailsubscription?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15277,\"name\":\"statsnewsletter\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null},{\"id\":22385,\"name\":\"welcome\",\"status\":\"enabled__mobile_enabled\",\"version\":\"6.0.7\",\"config_url\":null},{\"id\":15266,\"name\":\"statsbestmanufacturers\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":23871,\"name\":\"ps_wirepayment\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_wirepayment?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonepopupnewsletter\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonepopupnewsletter?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15279,\"name\":\"statspersonalinfos\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":null},{\"id\":15269,\"name\":\"statsbestvouchers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":24671,\"name\":\"ps_newproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.4\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/imp' | raw }}{{ 'rove\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_newproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15275,\"name\":\"statsforecast\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/statsforecast?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15283,\"name\":\"statssearch\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":44064,\"name\":\"creativeelements\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.10.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/creativeelements?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15282,\"name\":\"statssales\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":24672,\"name\":\"ps_specials\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.2\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_specials?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonebrandlogo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonebrandlogo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24696,\"name\":\"ps_crossselling\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_crossselling?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"psaddonsconnect\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":32577,\"name\":\"ps_themecusto\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.2.4\",\"config_url\":null},{\"id\":23870,\"name\":\"ps_shoppingcart\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.5\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_shoppingcart?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22314,\"name\":\"ps_categorytre' | raw }}{{ 'e\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_categorytree?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23835,\"name\":\"contactform\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.3.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/contactform?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":5496,\"name\":\"autoupgrade\",\"status\":\"enabled__mobile_enabled\",\"version\":\"6.2.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/autoupgrade?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22313,\"name\":\"ps_banner\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.1.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_banner?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15255,\"name\":\"gridhtml\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":9144,\"name\":\"productcomments\",\"status\":\"enabled__mobile_enabled\",\"version\":\"5.0.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/productcomments?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15250,\"name\":\"dashactivity\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":15267,\"name\":\"statsbestproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":49648,\"name\":\"ps_accounts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"7.0.2\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_accounts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"ps_checkout\",\"status\":\"enabled__mobile_enabled\",\"version\":\"7.3.6.3\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_checkout?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zoneproductadditional\",\"status\":\"enabled__mobile_en' | raw }}{{ 'abled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zoneproductadditional?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23866,\"name\":\"ps_customeraccountlinks\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.1\",\"config_url\":null},{\"id\":41965,\"name\":\"ps_faviconnotificationbo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_faviconnotificationbo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"doofinder\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.11.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/doofinder?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":48891,\"name\":\"ets_onepagecheckout\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.8.5\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ets_onepagecheckout?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":42674,\"name\":\"ps_buybuttonlite\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_buybuttonlite?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":39574,\"name\":\"ps_mbo\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.1.3\",\"config_url\":null},{\"id\":15264,\"name\":\"statsbestcategories\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":0,\"name\":\"zoneslideshow\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zoneslideshow?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22312,\"name\":\"blockreassurance\",\"status\":\"enabled__mobile_enabled\",\"version\":\"5.1.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/blockreassurance?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22315,\"name\":\"ps_conta' | raw }}{{ 'ctinfo\",\"status\":\"disabled__mobile_disabled\",\"version\":\"3.3.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_contactinfo?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":24697,\"name\":\"ps_dataprivacy\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_dataprivacy?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23869,\"name\":\"ps_searchbar\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.3\",\"config_url\":null},{\"id\":23865,\"name\":\"ps_currencyselector\",\"status\":\"disabled__mobile_disabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":9131,\"name\":\"blockwishlist\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/blockwishlist?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23868,\"name\":\"ps_languageselector\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":null},{\"id\":0,\"name\":\"zonehomeblocks\",\"status\":\"disabled__mobile_disabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonehomeblocks?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15252,\"name\":\"dashproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":null},{\"id\":0,\"name\":\"zonefeaturedcategories\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonefeaturedcategories?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22323,\"name\":\"ps_socialfollow\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.2.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_socialfollow?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22322,\"name\":\"ps_sharebuttons\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/' | raw }}{{ 'modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_sharebuttons?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15258,\"name\":\"pagesnotfound\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":24588,\"name\":\"ps_categoryproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.7\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_categoryproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22319,\"name\":\"ps_featuredproducts\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.2\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_featuredproducts?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonemegamenu\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonemegamenu?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":23867,\"name\":\"ps_facetedsearch\",\"status\":\"enabled__mobile_enabled\",\"version\":\"3.16.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_facetedsearch?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15284,\"name\":\"statsstock\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":15251,\"name\":\"dashgoals\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":24566,\"name\":\"ps_bestsellers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.6\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_bestsellers?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15281,\"name\":\"statsregistrations\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":85751,\"name\":\"psxmarketingwithgoogle\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.74.8\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/psxmarketingwithgoogle?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgn' | raw }}{{ 'rM\"},{\"id\":15254,\"name\":\"graphnvd3\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":7501,\"name\":\"gsitemap\",\"status\":\"enabled__mobile_enabled\",\"version\":\"4.2.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/gsitemap?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22321,\"name\":\"ps_mainmenu\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.3.4\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_mainmenu?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15273,\"name\":\"statsdata\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.1.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/statsdata?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":39324,\"name\":\"psgdpr\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.4.3\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/psgdpr?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"gamification\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.5.1\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/gamification?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":22316,\"name\":\"ps_customersignin\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.4\",\"config_url\":null},{\"id\":15268,\"name\":\"statsbestsuppliers\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.0\",\"config_url\":null},{\"id\":15272,\"name\":\"statscheckup\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.2\",\"config_url\":null},{\"id\":23864,\"name\":\"ps_checkpayment\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.5\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_checkpayment?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15270,\"name\":\"statscarrier\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.1\",\"config_url\":null},{\"id\":49583,\"name\":\"ps_metrics\",\"status\":\"enabled__mobile_enabled\",\"' | raw }}{{ 'version\":\"4.0.5\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/ps_metrics?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":0,\"name\":\"zonecolumnblocks\",\"status\":\"enabled__mobile_enabled\",\"version\":\"1.0.0\",\"config_url\":\"\\\\/admin1157\\\\/index.php\\\\/improve\\\\/modules\\\\/manage\\\\/action\\\\/configure\\\\/zonecolumnblocks?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\"},{\"id\":15253,\"name\":\"dashtrends\",\"status\":\"enabled__mobile_enabled\",\"version\":\"2.0.3\",\"config_url\":null}],\"accounts_user_id\":\"ALyJK0Ll6EXZ9LtC70itQ3gYWLu2\",\"accounts_shop_id\":\"ba5a862a-5f2e-4ec9-a005-7ebe58cdf1c9\",\"accounts_token\":\"eyJhbGciOiJSUzI1NiIsImtpZCI6IjBhYmQzYTQzMTc4YzE0MjlkNWE0NDBiYWUzNzM1NDRjMDlmNGUzODciLCJ0eXAiOiJKV1QifQ.eyJuYW1lIjoiR3VyYSBSVyIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS9BQ2c4b2NLc0o1SlRTUzNFbGoyUVRILXV6eXJfX1JXNEliVF8xZEQ1ZVlhWDV2VFk9czk2LWMiLCJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vcHJlc3Rhc2hvcC1uZXdzc28tcHJvZHVjdGlvbiIsImF1ZCI6InByZXN0YXNob3AtbmV3c3NvLXByb2R1Y3Rpb24iLCJhdXRoX3RpbWUiOjE3MzcyMTM3MTIsInVzZXJfaWQiOiJBTHlKSzBMbDZFWFo5THRDNzBpdFEzZ1lXTHUyIiwic3ViIjoiQUx5SkswTGw2RVhaOUx0QzcwaXRRM2dZV0x1MiIsImlhdCI6MTczNzIxMzcxMiwiZXhwIjoxNzM3MjE3MzEyLCJlbWFpbCI6Imd1cmFndXJhcndAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImZpcmViYXNlIjp7ImlkZW50aXRpZXMiOnsiZ29vZ2xlLmNvbSI6WyIxMDU3ODc0MDYxMTgxODU0Mjg1MzgiXSwiZW1haWwiOlsiZ3VyYWd1cmFyd0BnbWFpbC5jb20iXX0sInNpZ25faW5fcHJvdmlkZXIiOiJjdXN0b20ifX0.ESdeA3QJHpRjgYi6hAkX3LBxVvwpG9f4A6XDwOnf9h5PW-K9X5lmz8Wj8Hwf2dS2HqhOCLcsnSUmp5Ey9UwnY4kZ5SW4oNMXT2UhHs8Ui2XhIOfrBpihD6xpRSHG5v7jMQY5FwnBltRW8Azk_OYUKAlUvNW1rZ1XBCtHQprKX69wjYXqiNh6pRT33lkz8PP1EFBOMHlDfKpdbVyyNb8gkN958NVFn9cdSHI7o3Sv9UdOQTfWC1wufX9Ee-dV6r1q2rk8MQbaE4e8Z1B6_M7yDzHQResQU0DfvsqRLRTqRE2MIhCbeCm_4Ar-ovY8jvblHBU2tYJTi0orGG_P8mUjLg\",\"accounts_component_loaded\":false,\"module_catalog_url\":\"\\\\/admin1157\\\\/index.php\\\\/modules\\\\/addons\\\\/modules\\\\/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"theme_catalog_url\":\"\\\\/admin' | raw }}{{ '1157\\\\/index.php\\\\/modules\\\\/addons\\\\/themes\\\\/catalog?_token=w-DlzOzPY_6chBjJQXR4sc_eWHOZHsa7d9KJAeBgnrM\",\"php_version\":\"7.4.33\",\"shop_creation_date\":\"2024-05-28\",\"shop_business_sector_id\":null,\"shop_business_sector\":null,\"prestaShop_controller_class_name\":\"AdminModulesManage\"};

    renderModulesManagerMessage(context, \\'#module-manager-message-cdc-container\\')
  }
})
</script>
<!-- end /home/xbxgxbq/www/modules/ps_mbo/views/templates/hook/recommended-modules.tpl -->
</div>

<div id=\"main-div\">
          
      <div class=\"content-div  with-tabs\">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ' | raw }}{% block content_header %}{% endblock %}{% block content %}{% endblock %}{% block content_footer %}{% endblock %}{% block sidebar_right %}{% endblock %}{{ '

            
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
\t\t\t\t\t<h3 class=\"text-center\">Connect your shop to PrestaShop\\'s marketplace in order to automatically import all your Addons purchases.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Don\\'t have ' | raw }}{{ 'an account?</h4>
\t\t\t\t\t\t<p class=\\'text-justify\\'>Discover the Power of PrestaShop Addons! Explore the PrestaShop Official Marketplace and find over 3 500 innovative modules and themes that optimize conversion rates, increase traffic, build customer loyalty and maximize your productivity</p>
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
\t\t\t\t\t\t\t</button>' | raw }}{{ '
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
  
' | raw }}{% block javascripts %}{% endblock %}{% block extra_javascripts %}{% endblock %}{% block translate_javascripts %}{% endblock %}</body>{{ '
</html>' | raw }}", "__string_template__ef64602f05cebe8f8a66ecd8aafe02d7990ce9243052e9880dfbccc5c75c5477", "");
    }
}
