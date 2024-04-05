<?php
namespace Mage\Core;

use Magento\Framework\App\RequestInterface;

class Request
{
    public static $request = null;
    public static function getRequest()
    {
        if (static::$request === null) {
            static::$request = \Mage::get(RequestInterface::class);
        }
        return static::$request;
    }
}