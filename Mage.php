<?php

/**
 * Mage Facade - Main entry point for Magento 2 simplified development
 * 
 * This file provides a facade pattern implementation that simplifies interaction
 * with Magento 2's complex dependency injection system and object manager.
 * 
 * @category   Mage
 * @package    Mage_Core
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @version    1.0.0
 * @link       https://github.com/genaker/magento2-mage
 * @since      1.0.0
 */

declare(strict_types=1);

use \Mage\Logger\Log;
use \Mage\Debug\Dump;
use \Mage\Debug\Trace;
use \Mage\DB\DB;
use \Mage\DB\DB2;
use \Mage\Core\Registry;

\Kint\Renderer\RichRenderer::$theme = 'aante-dark.css';
\Kint\Renderer\RichRenderer::$folder = true;
((new DB2()));

use Magento\Framework\App\ObjectManager;

/**
 * Mage Facade Class
 * 
 * Provides a simplified static interface to Magento 2 core functionality.
 * This facade serves as a "static proxy" to underlying classes in Magento's
 * service container, providing expressive syntax while maintaining flexibility.
 * 
 * Features:
 * - Fast, accessible Object Manager operations
 * - Registry pattern for object caching
 * - Debug and logging capabilities
 * - Database abstraction layer
 * - Configuration management
 * - URL generation
 * - Event dispatching
 * 
 * @category   Mage
 * @package    Mage_Core
 * @author     Mage Development Team
 * @since      1.0.0
 * 
 * @method static void debug(string $message, array $context = []) Debug logging
 * @method static void info(string $message, array $context = []) Info logging
 * @method static void error(string $message, array $context = []) Error logging
 * @method static void warning(string $message, array $context = []) Warning logging
 * @method static void dump(mixed $var) Dump variable using Symfony VarDumper
 * @method static void dd(mixed $var) Dump and die
 * @method static void backtrace(?int $level = null) Display backtrace
 * @method static mixed rget(string $key, bool $exception = true) Get registry value
 * @method static mixed rset(string $key, mixed $value) Set registry value
 * @method static void rdel(string $key, bool $exception = true) Delete registry value
 */
class Mage
{
    use Log;
    use Registry;
    use Trace;
    use Dump;
    use DB;

    /**
     * Magento Object Manager instance
     * 
     * @var ObjectManager|null
     */
    public static $objectManager = null;

    /**
     * Object Manager alias for shorter access
     * 
     * @var ObjectManager|null
     */
    public static $om = null;

    /**
     * Class registry for singleton pattern implementation
     * 
     * @var array<string, object>
     */
    public static $classRegistry = [];

    /**
     * Get or create an instance of a class using Magento's Object Manager
     * 
     * This method implements a singleton pattern with optional forced creation.
     * When $new is false, it will return cached instances for better performance.
     * 
     * @param string $className The fully qualified class name to instantiate
     * @param bool $new Whether to force creation of a new instance (default: false)
     * 
     * @return object The requested class instance
     * 
     * @throws \Exception If class cannot be instantiated
     * 
     * @example
     * ```php
     * // Get singleton instance
     * $storeManager = Mage::get(\Magento\Store\Model\StoreManagerInterface::class);
     * 
     * // Force new instance
     * $newProduct = Mage::get(\Magento\Catalog\Model\Product::class, true);
     * ```
     */
    public static function get(string $className, bool $new = false)
    {
        if ($new === false) {
            if (isset(self::$classRegistry[$className])) {
                return self::$classRegistry[$className];
            }
            if (!isset(self::$objectManager)) {
                self::omInit();
            }
            self::$classRegistry[$className] = self::$objectManager->get($className);
            return self::$classRegistry[$className];
        }

        return self::$objectManager->create($className);
    }

    /**
     * Initialize the Object Manager
     * 
     * Initializes Magento's Object Manager if not already set and creates
     * an alias for easier access.
     * 
     * @return ObjectManager The Object Manager instance
     * 
     * @since 1.0.0
     */
    public static function omInit()
    {
        if (!isset(self::$objectManager)) {
            self::$objectManager = ObjectManager::getInstance();
            self::$om = self::$objectManager;
        }
        return self::$om;
    }

    /**
     * Alias function for get() method
     * 
     * Provides shorter syntax for object instantiation.
     * 
     * @param string $className The fully qualified class name
     * @param bool $new Whether to force creation of new instance
     * 
     * @return object The requested class instance
     * 
     * @see self::get()
     */
    public static function om(string $className, bool $new = false)
    {
        return self::get($className, $new);
    }

    /**
     * Create a new instance of the specified class
     * 
     * Always creates a new instance, bypassing the singleton registry.
     * 
     * @param string $className The fully qualified class name
     * 
     * @return object New instance of the specified class
     * 
     * @example
     * ```php
     * $product = Mage::create(\Magento\Catalog\Model\Product::class);
     * ```
     */
    public static function create(string $className)
    {
        return self::get($className, true);
    }

    /**
     * Get version information from Magento's composer.json
     * 
     * @param string $key The key to retrieve from composer.json (default: 'version')
     * 
     * @return string|array|null The requested value from composer.json
     * 
     * @throws \Exception If composer.json cannot be read
     */
    static function getVersion($key = 'version')
    {
        $composerJson = json_decode(file_get_contents(BP . '/composer.json'), true);
        return $composerJson[$key];
    }

    /**
     * Get the media URL for the current store
     * 
     * Returns the base media URL with caching for performance.
     * 
     * @return string The media URL
     * 
     * @example
     * ```php
     * $mediaUrl = Mage::getMediaURL();
     * // Returns: https://example.com/pub/media/
     * ```
     */
    static function getMediaURL()
    {
        if (!isset(self::$registry['media_url'])) {
            $storeManager = Mage::get(\Magento\Store\Model\StoreManagerInterface::class);
            self::$registry['media_url'] = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
        return self::$registry['media_url'];
    }
    /**
     * Get Magento's base path
     * 
     * @return string The absolute path to Magento installation
     */
    static function getBasePath()
    {
        return BP;
    }

    /**
     * Generate URL for the given path
     * 
     * @param string $path The URL path (default: '/')
     * 
     * @return string The complete URL
     * 
     * @example
     * ```php
     * $homeUrl = Mage::getUrl();
     * $productUrl = Mage::getUrl('catalog/product/view/id/1');
     * ```
     */
    public static function getUrl($path = '/')
    {
        return self::get('\Magento\Framework\UrlInterface')->getUrl($path);
    }

    /**
     * Dispatch a Magento event
     * 
     * @param string $eventName The name of the event to dispatch
     * @param array $data Event data to pass to observers
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::dispatchEvent('custom_event', ['product' => $product]);
     * ```
     */
    public static function dispatchEvent($eventName, $data = [])
    {
        self::get('Magento\Framework\Event\Manager')->dispatch($eventName, $data);
    }


    /**
     * Get database connection by name
     * 
     * @param string $connectionName The connection name (default: 'default')
     * 
     * @return \Magento\Framework\DB\Adapter\AdapterInterface Database connection
     * 
     * @example
     * ```php
     * $connection = Mage::getDBConnection();
     * $select = $connection->select()->from('sales_order');
     * ```
     */
    public static function getDBConnection($connectionName = 'default')
    {
        return self::get('\Magento\Framework\App\ResourceConnection')->getConnection($connectionName);
    }

    /**
     * Get Magento application mode
     * 
     * @return string The current application mode (developer, production, default)
     */
    public static function getMode()
    {
        return self::get('\Magento\Framework\App\State')->getMode();
    }

    /**
     * Get the Object Manager instance
     * 
     * @return ObjectManager The Object Manager instance
     * 
     * @see self::omInit()
     */
    public static function getObjectManager()
    {
        return self::omInit();
    }

    /**
     * Get the Object Manager instance (alias)
     * 
     * @return ObjectManager The Object Manager instance
     * 
     * @see self::getObjectManager()
     */
    public static function getOM()
    {
        return self::getObjectManager();
    }
    /**
     * Retrieve configuration value for store by path
     * 
     * @param string $path The configuration path (e.g., 'web/secure/base_url')
     * @param int|null $storeId The store ID (null for current store)
     * 
     * @return string|null The configuration value
     * 
     * @example
     * ```php
     * $baseUrl = Mage::getConfigValue('web/secure/base_url');
     * $storeName = Mage::getConfigValue('general/store_information/name', 1);
     * ```
     */
    public static function getConfigValue($path, $storeId = null)
    {
        return self::get('\Magento\Framework\App\Config\ScopeConfigInterface')->getValue($path, '\Magento\Store\Model\ScopeInterface::SCOPE_STORE', $storeId);
    }
}