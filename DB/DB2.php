<?php

namespace Mage\Mage\DB2;

use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Contracts\Events\Dispatcher;
use \Illuminate\Container\Container;

/**
 * Class DB
 */
class DB2
{
    public function _construct()
    {
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

    public $connection = null;


    private function getMageConfig()
    {
        $path = BP . '\app\etc.php';
        if ($path !== false) {
            return include($path)['db']['config']['default'];
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

        $params = array_merge($this->baseParams, $params);
        //$resource = \Mage::get('Magento\Framework\App\ResourceConnection')->getConnection('default');
        //$this->baseParams['pdo'] = $resource->getConnection();

        $capsule = new Capsule();

        $capsule->addConnection($params);

        //$capsule->setEventDispatcher(new Dispatcher(new Container));

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        //if(isset($params['log'])) $capsule->getConnection()->enableQueryLog();

        return $this->connection = $capsule;
    }

    public function test()
    {
        $this->connection::select('select 0 + 1');
    }

}