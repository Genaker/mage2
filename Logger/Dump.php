<?php
namespace Mage\Mage\Logger;

trait Dump
{
    static function dd($var)
    {
        dd($var);
    }

    public static function dump($var)
    {
        dump($var);
    }
}