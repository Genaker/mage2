<?php

namespace Mage\DB;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Container\Container;

/**
 * Class DB
 */
class DB2 extends Capsule
{

    public $connection = null;
    public function __construct()
    {   
        parent::__construct();
        return $this->connection = $this->connect();
    }

    /**
     * @var array
     */
    protected $baseParams = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ];


    private function getMageConfig()
    {
        $path = \BP . '/app/etc/env.php';
        if ($path !== false) {
            return include $path;
        }
        return false;
    }

    private function getMagentoPDOConnection()
    {
        return \Mage::getDBConnection('default');
    }

    /**
     * @param array $params
     * @return \Illuminate\Database\Capsule\Manager
     */
    public function connect(array $params = [])
    {
        if ($this->connection !== null){
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

    public function test()
    {
        return $this->connection::select('select * from core_config_data where path = "web/secure/base_url" and scope_id = 0');
    }

}