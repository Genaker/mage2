<?php
namespace Mage\Core;

use Magento\Framework\App\CacheInterface;

class Cache
{
    public static $cache = null;
    public static $inMemoryStorege = null;

    public static function save($value, $key, $tags = [], $ttl = 3600)
    {
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->save($value, $key, $tags, $ttl);
    }

    /**
     * Alias to save
     */
    public static function set($key, $value, $tags = [], $ttl = 3600)
    {
       return self::save($value, $key);
    }
    public static function load($key)
    {
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->load($key);
    }

    /**
     * Alias to load
     */
    public static function get($key)
    {
       return self::load($key);
    }
    public static function test($key)
    {
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->load($key);
    }

    public static function remove($key){
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->remove($key);
    }

    public static function getInstance(){
        if (!self::$cache) {
           return self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache;
    }
}