<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Mage_Mage', __DIR__);

if (!class_exists('Mage')) {
    include ('Mage.php');
}
