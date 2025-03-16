<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class Manufacturer extends ManufacturerCore
{
    /*
    * module: creativeelements
    * date: 2025-02-18 11:57:46
    * version: 2.10.1
    */
    const CE_OVERRIDE = true;
    /*
    * module: creativeelements
    * date: 2025-02-18 11:57:46
    * version: 2.10.1
    */
    public function __construct($id = null, $idLang = null)
    {
        parent::__construct($id, $idLang);
        $ctrl = Context::getContext()->controller;
        if ($ctrl instanceof ManufacturerController && !ManufacturerController::$initialized && !$this->active && Tools::getIsset('id_employee') && Tools::getIsset('adtoken')) {
            $tab = 'AdminManufacturers';
            if (Tools::getAdminToken($tab . (int) Tab::getIdFromClassName($tab) . (int) Tools::getValue('id_employee')) == Tools::getValue('adtoken')) {
                $this->active = 1;
            }
        }
    }
}
