<?php
namespace Mage\Mage\Cart;

use Magento\Quote\Model\Quote;
use Mage\Mage\Product\Product;
use Magento\Checkout\Model\Session as CheckoutSession;

class Cart
{
    public static $cart = null;
    public static function addProducts(array|string|int|Product $productIdentifiers, int $qty = 1)
    {
        if (!is_array($productIdentifiers)) {
            $id = $productIdentifiers;
            $productIdentifiers = [];
            $productIdentifiers[] = $id;
        }

        try {
            /**
             * @var \Magento\Quote\Model\Quote
             */
            $cart = \Mage::get(CheckoutSession::class)->getQuote();

            foreach ($productIdentifiers as $productIdentifier) {
                if (gettype($productIdentifier) === 'integer') {
                    $product = Product::getById($productIdentifier);
                }
                if (gettype($productIdentifier) === 'string') {
                    $product = Product::getBySku($productIdentifier);
                }
                if ($productIdentifier instanceof \Magento\Catalog\Model\Product) {
                    $product = $productIdentifier;
                }
                $cart->addProduct($product, $qty);
            }
            return $cart->save();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getItems()
    {
        /**
         * @var \Magento\Quote\Model\Quote
         */
        $cart = \Mage::get(CheckoutSession::class)->getQuote();
        return $cart->getItems();
    }

    public static function getInstance()
    {
        return \Mage::get(CheckoutSession::class)->getQuote();
    }
}