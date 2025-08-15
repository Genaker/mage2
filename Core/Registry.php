<?php
/**
 * Registry Trait - Simple key-value storage system
 * 
 * Provides a global registry for storing and retrieving arbitrary data
 * throughout the application lifecycle.
 * 
 * @category   Mage
 * @package    Mage_Core
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\Core;

/**
 * Registry Trait
 * 
 * Implements a simple registry pattern for storing and retrieving
 * key-value pairs in a static context.
 * 
 * @package Mage\Core
 * @since   1.0.0
 */
trait Registry
{
    /**
     * Static registry storage
     * 
     * @var array<string, mixed>
     */
    public static $registry = [];

    /**
     * Set a value in the registry
     * 
     * @param string $key The registry key
     * @param mixed $value The value to store
     * 
     * @return mixed The stored value
     * 
     * @example
     * ```php
     * Mage::rset('current_user', $user);
     * Mage::rset('config.cache_enabled', true);
     * ```
     */
    public static function rset($key, $value)
    {
        return static::$registry[$key] = $value;
    }

    /**
     * Get a value from the registry
     * 
     * @param string $key The registry key
     * @param bool $exception Whether to throw exception if key not found
     * 
     * @return mixed The stored value
     * 
     * @throws \Exception If key not found and $exception is true
     * 
     * @example
     * ```php
     * $user = Mage::rget('current_user');
     * $value = Mage::rget('optional_key', false); // Won't throw exception
     * ```
     */
    public static function rget($key, $exception = true)
    {
        if (!isset(static::$registry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the registry");
            } else {
                return false;
            }
        }
        return static::$registry[$key];
    }

    /**
     * Delete a value from the registry
     * 
     * @param string $key The registry key to delete
     * @param bool $exception Whether to throw exception if key not found
     * 
     * @return void
     * 
     * @throws \Exception If key not found and $exception is true
     * 
     * @example
     * ```php
     * Mage::rdel('temporary_data');
     * Mage::rdel('optional_key', false); // Won't throw exception
     * ```
     */
    public static function rdel($key, $exception = true)
    {
        if (!isset(static::$registry[$key])) {
            if ($exception) {
                throw new \Exception("No such key ($key) in the registry");
            } else {
                return false;
            }
        }
        unset(static::$registry[$key]);
    }

}