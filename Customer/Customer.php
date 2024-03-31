<?php
namespace Mage\Mage\Customer;

use Magento\Customer\API\CustomerRepositoryInterface;

class Customer
{
    public static function getByEmail($email, $websiteId = 1)
    {
        return \Mage::get(CustomerRepositoryInterface::class)->get($email, $websiteId);
    }
}