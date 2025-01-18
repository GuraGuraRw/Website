<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */
use PrestaShop\PrestaShop\Core\Util\InternationalizedDomainNameConverter;
use Symfony\Component\Translation\TranslatorInterface;

class CustomerLoginFormCore extends AbstractForm
{
    private $context;
    private $urls;

    protected $template = 'customer/_partials/login-form.tpl';

    /**
     * @var InternationalizedDomainNameConverter
     */
    private $IDNConverter;

    public function __construct(
        Smarty $smarty,
        Context $context,
        TranslatorInterface $translator,
        CustomerLoginFormatter $formatter,
        array $urls
    ) {
        parent::__construct($smarty, $translator, $formatter);
        $this->context = $context;
        $this->translator = $translator;
        $this->formatter = $formatter;
        $this->urls = $urls;
        $this->constraintTranslator = new ValidateConstraintTranslator($this->translator);
        $this->IDNConverter = new InternationalizedDomainNameConverter();
    }

    public function submit()
    {
        if ($this->validate()) {
            Hook::exec('actionAuthenticationBefore');

            $customer = new Customer();
            $email = $this->getValue('email');
            $password = $this->getValue('password');

            // Log inputs for debugging
            error_log('Login Attempt - Email: ' . $email);
            error_log('Login Attempt - Password: ' . $password);

            $authentication = $customer->getByEmail($email, $password);

            // Log authentication result for debugging
            error_log('Authentication Result: ' . print_r($authentication, true));

            if (isset($authentication->active) && !$authentication->active) {
                $this->errors[''][] = $this->translator->trans(
                    'Your account isn\'t available at this time, please contact us',
                    [],
                    'Shop.Notifications.Error'
                );
            } elseif (!$authentication || !$customer->id || $customer->is_guest) {
                $this->errors[''][] = $this->translator->trans(
                    'Authentication failed.',
                    [],
                    'Shop.Notifications.Error'
                );
            } else {
                // Successful authentication
                $this->context->updateCustomer($customer);

                Hook::exec('actionAuthentication', ['customer' => $this->context->customer]);

                // Update cart rules
                CartRule::autoRemoveFromCart($this->context);
                CartRule::autoAddToCart($this->context);
            }
        }

        return !$this->hasErrors();
    }

    public function fillWith(array $params = [])
    {
        if (!empty($params['email'])) {
            // Convert email from punycode back to UTF-8
            $params['email'] = $this->IDNConverter->emailToUtf8($params['email']);
        }

        return parent::fillWith($params);
    }

    public function getTemplateVariables()
    {
        if (!$this->formFields) {
            $this->formFields = $this->formatter->getFormat();
        }

        return [
            'action' => $this->action,
            'urls' => $this->urls,
            'formFields' => array_map(
                function (FormField $field) {
                    return $field->toArray();
                },
                $this->formFields
            ),
            'errors' => $this->getErrors(),
        ];
    }
}
