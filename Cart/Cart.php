<?php
namespace Mage\Mage\Cart;

use Magento\Quote\Model\Quote;
use Mage\Mage\Product\Product;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\QuoteRepository;
use Magento\Customer\Api\CustomerRepositoryInterface as Customer;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use Magento\Quote\Model\QuoteManagement;

class Cart
{
    public static $cart = null;

    public static function getById($id)
    {
        if (gettype($id) === 'string') {
            $id = static::getQuoteIdFromMaskedHash($id);
        }
        return \Mage::get(QuoteRepository::class)->get($id);
    }

    public static function getQuoteIdFromMaskedHash($mask)
    {
        try {
            return \Mage::get(MaskedQuoteIdToQuoteIdInterface::class)->execute($mask);
        } catch (\Exception $e) {
            throw new \Exception('Could not find a cart with ID :' . $mask);
        }
    }
    public static function addProducts(array|string|int|Product $productIdentifiers, int $qty = 1, $storeId = null)
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
                $cart->addProduct($product, $qty, $storeId);
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

    public static function getCart(string|int $id = null)
    {
        if ($id === null)
            return \Mage::get(CheckoutSession::class)->getQuote();
        else
            return self::getById($id);
    }

    //TODO:refactor
    public static function submit($cartData = null)
    {
        // $customer = \Mage::get(Customer::class)->getById($customerId);
        $cart = static::getCart();
        // Assign the customer to the quote
        // $cart->assignCustomer($customer);

        $billingAddress = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johnm@test.com',
            'street' => '123 Main St',
            'city' => 'Anytown',
            'country_id' => 'US',
            'region' => 'NY',
            'postcode' => '12345',
            'telephone' => '1234567890',
            'save_in_address_book' => 0
        ];

        $cart->getBillingAddress()->addData($billingAddress);

        $shippingAddress = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@test.com',
            'street' => '123 Main St',
            'city' => 'Anytown',
            'country_id' => 'US',
            'region' => 'NY',
            'postcode' => '12345',
            'telephone' => '1234567890',
            'save_in_address_book' => 0
        ];

        $cart->getShippingAddress()->addData($shippingAddress);

        $shippingAddress = $cart->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('freeshipping_freeshipping'); // For Free Shipping

        /*$payment = array(
            'cc_owner' => 'ffffffffff',
            'cc_type' => 'VI',
            'cc_number' => 1234567890123456,
            'cc_exp_month' => 11,
            'cc_exp_year' => 2015,
            'cc_cid' => 123
        );
        $cart->getPayment()->addData($payment);
        $cart->setPaymentData($payment);*/

        $cart->setPaymentMethod('checkmo'); // For Check / Money order
        $cart->setInventoryProcessed(false); // Prevents inventory decrement

        $cart->getPayment()->importData(['method' => 'checkmo']);

        // Attempt to save the quote and create an order from it
        $cart->collectTotals()->save();

        return \Mage::get(QuoteManagement::class)->submit($cart);
    }

    public static function placeOrder($cartId, $paymentMethod = null)
    {
        return \Mage::get(QuoteManagement::class)->placeOrder($cartId);
    }
}