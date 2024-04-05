<?php
namespace Mage\DB;

trait DB
{
    public static $connection = null;
    const DEFAULT_CONNECION = "default";
    public static function getConnection($connectionName = self::DEFAULT_CONNECION)
    {
        if (self::$connection[$connectionName] === null) {
            return self::$connection[$connectionName] = \Mage::getDBConnection($connectionName);
        }
    }

    public function select()
    {
        if (self::$connection[self::DEFAULT_CONNECION] === null) {
            self::getConnection();
        }
        return self::$connection[self::DEFAULT_CONNECION]->select();
    }
}