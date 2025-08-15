<?php
/**
 * Laravel Query Builder Integration for Magento 2
 * 
 * This class integrates Laravel's Eloquent ORM and Query Builder with Magento 2,
 * providing a modern, expressive way to interact with the database.
 * 
 * @category   Mage
 * @package    Mage_DB
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\DB;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Container\Container;

/**
 * DB2 Class - Laravel Query Builder for Magento
 * 
 * Extends Laravel's Capsule Manager to provide seamless integration
 * with Magento's database configuration. Offers modern ORM capabilities
 * and fluent query building.
 * 
 * Features:
 * - Laravel Query Builder syntax
 * - Eloquent ORM support
 * - Automatic Magento configuration integration
 * - Connection pooling and management
 * 
 * @package Mage\DB
 * @since   1.0.0
 * 
 * @example
 * ```php
 * // Using Query Builder
 * $orders = DB2::table('sales_order')
 *     ->where('status', 'complete')
 *     ->orderBy('created_at', 'desc')
 *     ->get();
 * 
 * // Using Raw SQL
 * $results = DB2::select('SELECT * FROM sales_order WHERE status = ?', ['complete']);
 * ```
 */
class DB2 extends Capsule
{

    /**
     * Database connection instance
     * 
     * @var \Illuminate\Database\Capsule\Manager|null
     */
    public $connection = null;
    
    /**
     * Constructor - Initialize the database connection
     * 
     * Sets up Laravel's Capsule Manager with Magento's database configuration.
     */
    public function __construct()
    {
        parent::__construct();
        $this->connection = $this->connect();
    }

    /**
     * Default database connection parameters
     * 
     * @var array<string, string>
     */
    protected $baseParams = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ];


    /**
     * Get Magento configuration from env.php
     * 
     * @return array|false Magento configuration array or false on failure
     */
    private function getMageConfig()
    {
        $path = \BP . '/app/etc/env.php';
        if ($path !== false) {
            return include $path;
        }
        return false;
    }

    /**
     * Get Magento's PDO connection
     * 
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    private function getMagentoPDOConnection()
    {
        return \Mage::getDBConnection('default');
    }

    /**
     * Connect to the database using Laravel Capsule
     * 
     * Establishes database connection using Magento's configuration
     * merged with optional custom parameters.
     * 
     * @param array $params Additional connection parameters
     * 
     * @return \Illuminate\Database\Capsule\Manager The connected Capsule instance
     * 
     * @example
     * ```php
     * $db = new DB2();
     * $connection = $db->connect(['charset' => 'utf8mb4']);
     * ```
     */
    public function connect(array $params = [])
    {
        if ($this->connection !== null) {
            return $this->connection;
        }
        $envParams = $this->getMageConfig()['db']['connection']['default'];
        $envParams['database'] = $envParams['dbname'];
        $params = array_merge($envParams, $params);
        $params = array_merge($this->baseParams, $params);
        //$resource = \Mage::get('Magento\Framework\App\ResourceConnection')->getConnection('default');
        //$this->baseParams['pdo'] = $resource->getConnection();

        //$capsule = new Capsule();

        // You can also reuse old magento connection but it is another story;
        $this->addConnection($params);

        //$capsule->setEventDispatcher(new Dispatcher(new Container));

        $this->setAsGlobal();

        $this->bootEloquent();

        //if(isset($params['log'])) $capsule->getConnection()->enableQueryLog();

        return $this->connection = $this;
    }

    /**
     * Test the database connection
     * 
     * Performs a simple query to verify the connection is working.
     * 
     * @return array Query results
     * 
     * @example
     * ```php
     * $db = new DB2();
     * $result = $db->test();
     * ```
     */
    public function test()
    {
        return $this->connection::select('select * from core_config_data where path = "web/secure/base_url" and scope_id = 0');
    }

}