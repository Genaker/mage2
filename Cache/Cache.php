<?php
namespace Mage\Mage\Cache;

use Magento\Framework\App\CacheInterface;

class Cache
{
    public static $cache = null;
    public static $inMemoryStorege = null;

    public static function load($value, $key, $tags = [], $ttl = 3600)
    {
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->save($value, $key, $tags, $ttl);
    }
    public static function save($key)
    {
        if (!self::$cache) {
            self::$cache = \Mage::get(CacheInterface::class);
        }
        return self::$cache->load($key);
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

}