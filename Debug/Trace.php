<?php
/**
 * Debug Trace Trait - Debugging and backtrace functionality
 * 
 * Provides comprehensive debugging capabilities using Kint library
 * for better development experience.
 * 
 * @category   Mage
 * @package    Mage_Debug
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\Debug;

use Kint\Kint;

/**
 * Trace Trait
 * 
 * Provides debugging and tracing functionality powered by Kint library.
 * Includes backtrace, variable dumping, and performance monitoring.
 * 
 * @package Mage\Debug
 * @since   1.0.0
 */
trait Trace
{
    /**
     * Trace storage
     * 
     * @var mixed
     */
    public $trace = null;

    /**
     * Default Kint theme
     * 
     * @var string
     */
    public static $defaultTheme = 'aante-dark.css';

    /**
     * Available Kint themes
     * 
     * @var array<string>
     */
    public static $allThemes = [
        'original.css',
        'solarized.css',
        'solarized-dark.css',
        'aante-light.css',
        'aante-dark.css'
    ];

    /**
     * Default depth limit for Kint output
     * 
     * @var int
     */
    public static $depth_limit = 3;
    /**
     * Display backtrace using Kint
     * 
     * @param int|null $level Depth limit for backtrace (null for default)
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::backtrace(); // Use default depth
     * Mage::backtrace(5); // Limit to 5 levels
     * ```
     */
    static function backtrace($level = null)
    {
        if ($level === null) {
            Kint::$depth_limit = self::$depth_limit;
        } else {
            Kint::$depth_limit = $level;
        }
        Kint::trace();
    }
    /**
     * Alias for backtrace method
     * 
     * @param int|null $level Depth limit for backtrace
     * 
     * @return void
     * 
     * @see self::backtrace()
     */
    static function trace($level = null)
    {
        self::backtrace($level = null);
    }
    /**
     * Display backtrace and die
     * 
     * Useful for debugging - shows backtrace and stops execution.
     * 
     * @param int|null $level Depth limit for backtrace
     * 
     * @return void This method terminates execution
     * 
     * @example
     * ```php
     * Mage::btd(); // Show backtrace and stop
     * ```
     */
    static function btd($level = null)
    {
        if ($level === null) {
            Kint::$depth_limit = self::$depth_limit;
        } else {
            Kint::$depth_limit = $level;
        }
        Kint::trace();
        die ("Die After Backtrace");
    }

    /**
     * Dump current microtime with optional message
     * 
     * @param string|null $message Optional message to display with microtime
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::microtime('Before processing');
     * // ... processing ...
     * Mage::microtime('After processing');
     * ```
     */
    static function microtime($message = null)
    {
        Kint::dump(microtime(), $message);
    }

    /**
     * Dump variable using Kint
     * 
     * @param mixed $var Variable to dump
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::d($complexArray);
     * Mage::d($object);
     * ```
     */
    static function d($var)
    {
        Kint::$depth_limit = self::$depth_limit;
        Kint::dump($var);
    }

    /**
     * Disable Kint output
     * 
     * @return void
     */
    static function disableKint()
    {
        Kint::$enabled_mode = false;
    }

    /**
     * Enable Kint output
     * 
     * @return void
     */
    static function enableKint()
    {
        Kint::$enabled_mode = true;
    }

    /**
     * Get Kint settings and configuration
     * 
     * @return void
     */
    static function settingsKint()
    {
        Kint::getStatics();
    }
}
