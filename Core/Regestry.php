<?php
namespace Mage\Mage\Core;

trait Regestry
{
    public static $regestry = [];

    public static function rset($key, $value)
    {
        return static::$regestry[$key] = $value;
    }

    public static function rget($key, $exception = true)
    {
        if (!isset(static::$regestry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the regestry");
            } else {
                return false;
            }
        }
        return static::$regestry[$key];
    }

    public static function rdel($key, $exception = true)
    {
        if (!isset(static::$regestry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the regestry");
            } else {
                return false;
            }
        }
        unset(static::$regestry[$key]);
    }


}