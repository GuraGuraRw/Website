<?php
/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*/

namespace PrestaShop\Module\EtsAutoUpgrade\UpgradeTools;

use Db;

class Database
{
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getAllTables()
    {
        $tables = $this->db->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . '%"', true, false);

        $all_tables = array();
        foreach ($tables as $v) {
            $table = array_shift($v);
            $all_tables[$table] = $table;
        }

        return $all_tables;
    }

    /**
     * ToDo: Send tables list instead.
    */
    public function cleanTablesAfterBackup(array $tablesToClean)
    {
        foreach ($tablesToClean as $table) {
            $this->db->execute('DROP TABLE IF EXISTS `' . bqSql($table) . '`');
            $this->db->execute('DROP VIEW IF EXISTS `' . bqSql($table) . '`');
        }
        $this->db->execute('SET FOREIGN_KEY_CHECKS=1');
    }
}
