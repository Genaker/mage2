<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Mage_Mage', __DIR__);

if (!class_exists('Mage')) {
    require_once __DIR__ . '/../../../app/autoload.php';
    //include ('Mage.php');
}

class_alias('Mage\Controller\Index\Index', 'Mage\Mage\Controller\Index\Index');
class_alias('Mage\Core\Request', 'Mage\Request');
class_alias('Mage\Core\Cache', 'Mage\Cache');

