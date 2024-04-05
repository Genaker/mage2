<?php
namespace Mage\Debug;

use Kint\Kint;

trait Trace
{
    public $trace = null;

    public static $defaultTheme = 'aante-dark.css';

    public static $allThemes = [
        'original.css',
        'solarized.css',
        'solarized-dark.css',
        'aante-light.css',
        'aante-dark.css'
    ];

    public static $depth_limit = 3;
    static function backtrace($level = null)
    {
        if ($level === null) {
            Kint::$depth_limit = self::$depth_limit;
        } else {
            Kint::$depth_limit = $level;
        }
        Kint::trace();
    }
    static function trace($level = null)
    {
        self::backtrace($level = null);
    }
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

    static function microtime($message = null)
    {
        Kint::dump(microtime(), $message);
    }

    static function d($var)
    {
        Kint::$depth_limit = self::$depth_limit;
        Kint::dump($var);
    }

    static function disableKint()
    {
        Kint::$enabled_mode = false;
    }

    static function enableKint()
    {
        Kint::$enabled_mode = true;
    }

    static function settingsKint()
    {
        Kint::getStatics();
    }
}
