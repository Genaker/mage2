<?php
/**
 * Logger Trait - Advanced logging functionality
 * 
 * Provides comprehensive logging capabilities using Monolog library
 * with support for multiple handlers and log levels.
 * 
 * @category   Mage
 * @package    Mage_Logger
 * @author     Mage Development Team
 * @copyright  Copyright © All rights reserved.
 * @license    GPL-3.0
 * @since      1.0.0
 */

namespace Mage\Logger;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Log Trait
 * 
 * Provides logging functionality using Monolog with multiple handlers
 * and PSR-3 compatible logging methods.
 * 
 * Features:
 * - Multiple log levels (debug, info, warning, error, etc.)
 * - File and FirePHP handlers
 * - Log buffering
 * - Automatic logger initialization
 * 
 * @package Mage\Logger
 * @since   1.0.0
 */
trait Log
{
    /**
     * Monolog Logger instance
     * 
     * @var Logger|null
     */
    public static $logger = null;
    
    /**
     * Log buffer for batched logging
     * 
     * @var array<mixed>
     */
    public static $logBuffer = [];
    
    /**
     * Default log directory path
     * 
     * @var string
     */
    public static $logPath = '/var/log/';
    
    /**
     * Default log file name
     * 
     * @var string
     */
    public static $logFile = 'mage-log.log';
    
    /**
     * Full path to log file
     * 
     * @var string|null
     */
    public static $logFilePath = null;

    /**
     * Initialize the logger
     * 
     * Sets up Monolog logger with stream handler for file logging.
     * 
     * @param string|null $file Custom log file name
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::Init(); // Use default log file
     * Mage::Init('custom.log'); // Use custom log file
     * ```
     */
    public static function Init($file = null)
    {
        self::$logger = new Logger('mage_logger');

        if ($file === null) {
            self::$logFilePath = BP . '/' . self::$logPath . '/' . self::$logFile;
        } else {
            self::$logFilePath = BP . '/' . self::$file;
        }
        // Now add some handlers
        self::$logger->pushHandler(new StreamHandler(self::$logFilePath));

    }

    /**
     * Enable FirePHP logging handler
     * 
     * Adds FirePHP handler to send logs to browser console.
     * 
     * @return void
     */
    public static function enableFirePHP(){
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->pushHandler(new FirePHPHandler());
    }

    /**
     * Add a debug level log entry
     * 
     * @param string $message Log message
     * @param array $context Additional context data
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::debug('Processing order', ['order_id' => 123]);
     * ```
     */
    public static function debug($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->debug($message, $context);
    }

    /**
     * Add an info level log entry
     * 
     * @param string $message Log message
     * @param array $context Additional context data
     * 
     * @return void
     */
    public static function info($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->info($message, $context);
    }


    public static function alert($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->alert($message, $context);
    }

    public static function critical($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->critical($message, $context);
    }

    /**
     * Add an error level log entry
     * 
     * @param string $message Log message
     * @param array $context Additional context data
     * 
     * @return void
     */
    public static function error($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->error($message, $context);
    }

    public static function warning($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->warning($message, $context);
    }

    /**
     * Generic log method with custom file and buffer options
     * 
     * @param mixed $log Log data (string or any variable)
     * @param string $file Custom log file name
     * @param bool $buffer Whether to buffer the log entry
     * 
     * @return void
     * 
     * @example
     * ```php
     * Mage::log('Simple message');
     * Mage::log($complexData, 'debug.log', true);
     * ```
     */
    public static function log($log, $file = '', $buffer = false)
    {
        if ($buffer) {
            self::$logBuffer[] = $log;
        }
        if ($file === '' || $file === false) {
            $file = self::$logPath . self::$logFile;
        } else {
            $file = self::$logPath . $file;
        }

        if (is_string($log)) {
            error_log('[' . date("Y-m-d h:i:sa") . '] ' . $log . PHP_EOL, 3, BP . $file);
        } else {
            error_log('[' . date("Y-m-d h:i:sa") . '] ' . print_r($log, TRUE) . PHP_EOL, 3, BP . $file);
        }
    }

    /**
     * Write buffered log entries to file
     * 
     * @param string $file Log file name (empty for default)
     * 
     * @return void
     */
    public static function writeBuffer($file = '')
    {
        if ($file === '' || $file === false) {
            $file = self::$logFile;
        }
        error_log(print_r(self::$logBuffer, TRUE), 3, BP . $file);
    }
}