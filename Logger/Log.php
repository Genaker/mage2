<?php
namespace Mage\Mage\Logger;


use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// Create the logger

trait Log
{
    public static $logger = null;
    public static $logBuffer = [];
    public static $logPath = '/var/log/';
    public static $logFile = 'my-error.log';

    public static $logFilePath = null;

    public static function Init($file = self::$logPath . '/mage.log')
    {
        self::$logger = new Logger('mage_logger');

        self::$logFilePath = BP . $file;
        // Now add some handlers
        self::$logger->pushHandler(new StreamHandler(self::$logFilePath));

    }

    public static function debbug($message, array $context = []): void
    {
        if (self::$logger === null) {
            self::Init();
        }
        self::$logger->debbug($message, $context);
    }

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

    public static function writeBuffer($file = '')
    {
        if ($file === '' || $file === false) {
            $file = self::$logFile;
        }
        error_log(print_r(self::writeBuffer(), TRUE), 3, BP . $file);
    }
}