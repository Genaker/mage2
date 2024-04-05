<?php
namespace Mage\Core;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Setup
{
    
    public static function setup(Event $event)
    {
        echo "Setup Sript->\n";
        echo shell_exec("pwd");
        echo shell_exec("cp vendor/mage/mage/.psysh.php .");
        echo shell_exec("cp vendor/bin/psysh ./bin/");
    }

}