<?php
/**
 * Database Trait - Magento database connection wrapper
 * 
 * Provides simplified access to Magento's database connections
 * with connection pooling and caching.
 * 
 * @category   Mage
 * @package    Mage_DB
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\DB;

/**
 * DB Trait
 * 
 * Wraps Magento's database connection functionality for easier access
 * and connection management.
 * 
 * @package Mage\DB
 * @since   1.0.0
 */
trait DB
{
    /**
     * Database connection storage
     * 
     * @var array<string, \Magento\Framework\DB\Adapter\AdapterInterface>|null
     */
    public static $connection = null;
    
    /**
     * Default connection name
     * 
     * @var string
     */
    const DEFAULT_CONNECTION = "default";
    /**
     * Get database connection by name
     * 
     * @param string $connectionName The connection name
     * 
     * @return \Magento\Framework\DB\Adapter\AdapterInterface|null
     * 
     * @example
     * ```php
     * $connection = Mage::getConnection();
     * $connection = Mage::getConnection('read');
     * ```
     */
    public static function getConnection($connectionName = self::DEFAULT_CONNECTION)
    {
        if (self::$connection[$connectionName] === null) {
            return self::$connection[$connectionName] = \Mage::getDBConnection($connectionName);
        }
    }

    /**
     * Get a select object for the default connection
     * 
     * @return \Magento\Framework\DB\Select
     * 
     * @example
     * ```php
     * $select = Mage::select()
     *     ->from('sales_order')
     *     ->where('status = ?', 'complete');
     * ```
     */
    public function select()
    {
        if (self::$connection[self::DEFAULT_CONNECTION] === null) {
            self::getConnection();
        }
        return self::$connection[self::DEFAULT_CONNECTION]->select();
    }
}