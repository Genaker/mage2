<?php
namespace Mage\Core;

trait Registry
{
    public static $registry = [];

    public static function rset($key, $value)
    {
        return static::$registry[$key] = $value;
    }

    public static function rget($key, $exception = true)
    {
        if (!isset(static::$registry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the registry");
            } else {
                return false;
            }
        }
        return static::$registry[$key];
    }

    public static function rdel($key, $exception = true)
    {
        if (!isset(static::$registry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the registry");
            } else {
                return false;
            }
        }
        unset(static::$registry[$key]);
    }

}