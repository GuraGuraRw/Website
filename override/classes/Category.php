<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
class Category extends CategoryCore
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
    public function __construct($idCategory = null, $idLang = null, $idShop = null)
    {
        parent::__construct($idCategory, $idLang, $idShop);
        $ctrl = Context::getContext()->controller;
        if ($ctrl instanceof CategoryController && !CategoryController::$initialized && !$this->active && Tools::getIsset('id_employee') && Tools::getIsset('adtoken')) {
            $tab = 'AdminCategories';
            if (Tools::getAdminToken($tab . (int) Tab::getIdFromClassName($tab) . (int) Tools::getValue('id_employee')) == Tools::getValue('adtoken')) {
                $this->active = 1;
            }
        }
    }
}
