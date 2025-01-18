<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class Supplier extends SupplierCore
{
    /*
    * module: creativeelements
    * date: 2024-08-06 20:43:00
    * version: 2.10.1
    */
    const CE_OVERRIDE = true;
    /*
    * module: creativeelements
    * date: 2024-08-06 20:43:00
    * version: 2.10.1
    */
    public function __construct($id = null, $idLang = null)
    {
        parent::__construct($id, $idLang);
        $ctrl = Context::getContext()->controller;
        if ($ctrl instanceof SupplierController && !SupplierController::$initialized && !$this->active && Tools::getIsset('id_employee') && Tools::getIsset('adtoken')) {
            $tab = 'AdminSuppliers';
            if (Tools::getAdminToken($tab . (int) Tab::getIdFromClassName($tab) . (int) Tools::getValue('id_employee')) == Tools::getValue('adtoken')) {
                $this->active = 1;
            }
        }
    }
}
