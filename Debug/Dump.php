<?php
namespace Mage\Debug;

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