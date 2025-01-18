<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
class AuthControllerCore extends FrontController
{
    public $ssl = true;
    public $php_self = 'authentication';
    public $auth = false;

    public function checkAccess()
    {
        if ($this->context->customer->isLogged() && !$this->ajax) {
            $this->redirect_after = ($this->authRedirection) ? urlencode($this->authRedirection) : 'my-account';
            $this->redirect();
        }

        return parent::checkAccess();
    }

    public function initContent()
    {
        $should_redirect = false;

        if (Tools::isSubmit('submitCreate') || Tools::isSubmit('create_account')) {
            $register_form = $this
                ->makeCustomerForm()
                ->setGuestAllowed(false)
                ->fillWith(Tools::getAllValues());

            if (Tools::isSubmit('submitCreate')) {
                $hookResult = array_reduce(
                    Hook::exec('actionSubmitAccountBefore', [], null, true),
                    function ($carry, $item) {
                        return $carry && $item;
                    },
                    true
                );
                if ($hookResult && $register_form->submit()) {
                    $should_redirect = true;
                }
            }

            $this->context->smarty->assign([
                'register_form' => $register_form->getProxy(),
                'hook_create_account_top' => Hook::exec('displayCustomerAccountFormTop'),
            ]);
            $this->setTemplate('customer/registration');
        } else {
            $login_form = $this->makeLoginForm()->fillWith(
                Tools::getAllValues()
            );

            if (Tools::isSubmit('submitLogin')) {
                if ($login_form->submit()) {
                    $should_redirect = true;
                }
            }

            // Assign social login URLs
            $google_login_url = $this->generateGoogleLoginUrl();
            $facebook_login_url = $this->generateFacebookLoginUrl();

            // Assign CSRF token for the login form
            $this->context->smarty->assign('csrf_token', Tools::getToken(false));

            $this->context->smarty->assign([
                'login_form' => $login_form->getProxy(),
                'urls' => [
                    'google_login_url' => $google_login_url,
                    'facebook_login_url' => $facebook_login_url,
                ],
            ]);
            $this->setTemplate('customer/authentication');
        }

        parent::initContent();

        if ($should_redirect && !$this->ajax) {
            $back = rawurldecode(Tools::getValue('back'));

            if (Tools::urlBelongsToShop($back)) {
                return $this->redirectWithNotifications($back);
            }

            if ($this->authRedirection) {
                return $this->redirectWithNotifications($this->authRedirection);
            }

            return $this->redirectWithNotifications(__PS_BASE_URI__);
        }
    }

    private function generateGoogleLoginUrl()
    {
        $redirectUri = 'https://gura.rw/module/ets_onepagecheckout/callback'; // Your Redirect URI
        $clientId = Configuration::get('ETS_GOOGLE_CLIENT_ID'); // Retrieve from module settings
        $scope = 'email profile';
        $state = md5(uniqid(rand(), true)); // Generate a unique state value for security

        return "https://accounts.google.com/o/oauth2/auth?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=$scope&state=$state";
    }

    private function generateFacebookLoginUrl()
    {
        $redirectUri = 'https://gura.rw/module/ets_onepagecheckout/callback'; // Your Redirect URI
        $clientId = Configuration::get('ETS_FACEBOOK_CLIENT_ID'); // Retrieve from module settings
        $state = md5(uniqid(rand(), true)); // Generate a unique state value for security

        return "https://www.facebook.com/v11.0/dialog/oauth?client_id=$clientId&redirect_uri=$redirectUri&state=$state";
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        if (Tools::isSubmit('submitCreate') || Tools::isSubmit('create_account')) {
            $breadcrumb['links'][] = [
                'title' => $this->trans('Create an account', [], 'Shop.Theme.Customeraccount'),
                'url' => $this->context->link->getPageLink('authentication'),
            ];
        } else {
            $breadcrumb['links'][] = [
                'title' => $this->trans('Log in to your account', [], 'Shop.Theme.Customeraccount'),
                'url' => $this->context->link->getPageLink('authentication'),
            ];
        }

        return $breadcrumb;
    }
}
