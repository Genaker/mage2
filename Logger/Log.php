<?php
namespace Mage\Mage\Logger;
trait Log
{
    public static $logBuffer = [];
    public static $logPath = '/var/log/';
    public static $logFile = 'my-error.log';

    public static function log($log, $file = '', $buffer = false)
    {
        if ($buffer) {
            self::$logBuffer[] = $log;
        }
        if ($file === '' || $file === false){
            $file = self::$logPath . self::$logFile;
        } else {
            $file = self::$logPath . $file;
        }

        if (is_string($log)) {
            error_log('['. date("Y-m-d h:i:sa") . '] ' . $log . PHP_EOL, 3, BP . $file);
        } else {
            error_log('['. date("Y-m-d h:i:sa") . '] ' . print_r($log, TRUE) . PHP_EOL, 3, BP . $file);
        }
    }

    static function dd($message){
        die($message);
    }

    public static function writeBuffer($file = ''){
        if($file === '' || $file === false){
            $file = self::$logFile;
        }
        error_log(print_r(self::writeBuffer(), TRUE), 3, BP . $file);
    }
}