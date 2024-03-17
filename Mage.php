<?php

/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

//namespace Mage\Mage;

include 'Logger/Log.php';
include 'Debug/Dump.php';
include 'Debug/Trace.php';
include 'Core/Regestry.php';

use \Mage\Mage\Logger\Log;
use \Mage\Mage\Debug\Dump;
use \Mage\Mage\Debug\Trace;
use \Mage\Mage\Core\Regestry;

use Magento\Framework\App\ObjectManager;

class Mage
{
    use Log;
    use Regestry;
    use Trace;
    use Dump;

    public static $objectManager = null;

    public static $classRegestry = [];

    public static function get(string $className, bool $new = false)
    {
        if ($new === false) {
            if (isset (self::$classRegestry[$className])) {
                return self::$classRegestry[$className];
            }
            if (!isset (self::$objectManager)) {
                self::$objectManager = ObjectManager::getInstance();
            }
            self::$classRegestry[$className] = self::$objectManager->get($className);
            return self::$classRegestry[$className];
        }

        return self::$objectManager->create($className);
    }

    static function getVersion($key = 'version')
    {
        $composerJson = json_decode(file_get_contents(BP . '/composer.json'));
        return $composerJson[$key];
    }

    static function getMediaURL()
    {
        if (!isset (self::$regestry['media_url'])) {
            $storeManager = Mage::get(\Magento\Store\Model\StoreManagerInterface::class);
            self::$regestry['media_url'] = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
        return self::$regestry['media_url'];
    }
}