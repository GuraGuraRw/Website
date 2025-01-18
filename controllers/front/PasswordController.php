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

use PrestaShop\PrestaShop\Core\Util\InternationalizedDomainNameConverter;

class PasswordControllerCore extends FrontController
{
    public $php_self = 'password';
    public $auth = false;
    public $ssl = true;

    private $IDNConverter;

    public function __construct()
    {
        parent::__construct();
        $this->IDNConverter = new InternationalizedDomainNameConverter();
    }

    public function postProcess()
    {
        // Assign the body class for password-infos
        $this->context->smarty->assign('page_name', 'password-infos');

        // Ensure $errors and $success are always initialized
        $this->context->smarty->assign([
            'errors' => $this->errors ?? [],
            'success' => $this->success ?? [],
        ]);

        $this->setTemplate('customer/password-email');

        if (Tools::isSubmit('email')) {
            $this->sendRenewPasswordLink();
        } elseif (Tools::getValue('token') && ($id_customer = (int) Tools::getValue('id_customer'))) {
            $this->changePassword();
        } elseif (Tools::getValue('token') || Tools::getValue('id_customer')) {
            $this->errors[] = $this->trans('We cannot regenerate your password with the data you\'ve submitted', [], 'Shop.Notifications.Error');
        }
    }

    protected function sendRenewPasswordLink()
    {
        if (!($email = $this->IDNConverter->emailToUtf8(trim(Tools::getValue('email')))) || !Validate::isEmail($email)) {
            $this->errors[] = $this->trans('Invalid email address.', [], 'Shop.Notifications.Error');
        } else {
            $customer = new Customer();
            $customer->getByEmail($email);
            if (null === $customer->email) {
                $customer->email = Tools::getValue('email');
            }

            if (!Validate::isLoadedObject($customer)) {
                $this->success[] = $this->trans(
                    'If this email address has been registered in our shop, you will receive a link to reset your password at %email%.',
                    ['%email%' => $customer->email],
                    'Shop.Notifications.Success'
                );
                $this->setTemplate('customer/password-infos');
            } elseif (!$customer->active) {
                $this->errors[] = $this->trans('You cannot regenerate the password for this account.', [], 'Shop.Notifications.Error');
            } elseif ((strtotime($customer->last_passwd_gen . '+' . ($minTime = (int) Configuration::get('PS_PASSWD_TIME_FRONT')) . ' minutes') - time()) > 0) {
                $this->errors[] = $this->trans('You can regenerate your password only every %d minute(s)', [(int) $minTime], 'Shop.Notifications.Error');
            } else {
                if (!$customer->hasRecentResetPasswordToken()) {
                    $customer->stampResetPasswordToken();
                    $customer->update();
                }

                $mailParams = [
                    '{email}' => $customer->email,
                    '{lastname}' => $customer->lastname,
                    '{firstname}' => $customer->firstname,
                    '{url}' => $this->context->link->getPageLink('password', true, null, 'token=' . $customer->secure_key . '&id_customer=' . (int) $customer->id . '&reset_token=' . $customer->reset_password_token),
                ];

                if (
                    Mail::Send(
                        $this->context->language->id,
                        'password_query',
                        $this->trans(
                            'Password query confirmation',
                            [],
                            'Emails.Subject'
                        ),
                        $mailParams,
                        $customer->email,
                        $customer->firstname . ' ' . $customer->lastname
                    )
                ) {
                    $this->success[] = $this->trans('If this email address has been registered in our shop, you will receive a link to reset your password at %email%.', ['%email%' => $customer->email], 'Shop.Notifications.Success');
                    $this->setTemplate('customer/password-infos');
                } else {
                    $this->errors[] = $this->trans('An error occurred while sending the email.', [], 'Shop.Notifications.Error');
                }
            }
        }

        // Ensure errors and success are passed to the template
        $this->context->smarty->assign([
            'errors' => $this->errors ?? [],
            'success' => $this->success ?? [],
        ]);
    }
}
