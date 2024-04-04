<?php
namespace Mage\Mage\Order;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\OrderRepository;

class Order
{
    public static function getOrder($id)
    {
        if (gettype($id) === "string") {
            return \Mage::get(OrderInterface::class)->loadByIncrementId($id);
        }
        if (gettype($id) === "integer") {
            return \Mage::get(OrderRepository::class)->get($id);
        }
    }
}